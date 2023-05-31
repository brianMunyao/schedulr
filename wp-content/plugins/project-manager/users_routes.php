<?php
// Creating administrator only endpoint to create users and givre em roles
class RestUserReg
{
    public function register_users_route()
    {
        register_rest_route('api/v1', '/users/', array(
            'methods' => 'GET',
            'callback' => array($this, 'all_users'),
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('api/v1', '/users/(?P<id>[\d]+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'single_user'),
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('api/v1', '/users/', array(
            'methods' => 'POST',
            'callback' => array($this, 'create_user'),
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('api/v1', '/users/(?P<id>[\d]+)', array(
            'methods' => 'PUT',
            'callback' => array($this, 'update_user'),
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('api/v1', '/users/(?P<id>[\d]+)', array(
            'methods' => 'DELETE',
            'callback' => array($this, 'delete_user'),
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ));
    }

    public function all_users()
    {
        $users = get_users(['fields' => ['ID', 'user_nicename', 'user_email', 'role']]);

        $modified_users = array_map(function ($user) {
            $user->fullname = $user->user_nicename;
            $user->email = $user->user_email;

            unset($user->user_nicename);
            unset($user->user_email);
            return $user;
        }, $users);

        foreach ($users as &$user) {
            $user_roles = get_userdata($user->ID)->roles;
            $user->roles = $user_roles;
        }

        return $modified_users;
    }

    public function single_user($request)
    {
        $user_id = $request['id'];
        $user = get_user_by('ID', $user_id);
        if (!$user) {
            return new WP_Error('user_not_found', 'User not found', ['status' => 404]);
        }
        $user_data = [
            'ID' => $user->ID,
            'fullname' => $user->user_nicename,
            'email' => $user->user_email,
            'roles' => $user->roles
        ];
        return $user_data;
    }

    public function create_user($request)
    {
        $user_data = $request->get_json_params();

        $fullname = $user_data['fullname'];
        $email = $user_data['email'];
        $role = $user_data['role'];
        $password = $user_data['password'];

        // $user_id = wp_create_user($fullname, $password, $email);
        $user_id = wp_insert_user([
            'user_nicename' => $fullname,
            'user_login' => $email,
            'user_pass' => $password,
            'user_email' => $email,
            'role' => $role,
        ]);
        return $user_data;
        if (is_wp_error($user_id)) {
            return new WP_Error('create_failed', $user_id->get_error_message(), ['status' => 500]);
        }
        return 'User created successfully';
    }

    public function update_user($request)
    {
        $user_data = $request->get_json_params();

        $user_id = $user_data['id'];
        $fullname = $user_data['fullname'];
        $email = $user_data['email'];
        $role = $user_data['role'];
        $password = $user_data['password'];

        $user = wp_update_user(
            [
                'ID' => $user_id,
                'user_nicename' => $fullname,
                'user_login' => $email,
                'user_pass' => $password,
                'user_email' => $email,
                'role' => $role,
            ]
        );
        if (is_wp_error($user)) {
            return new WP_Error('user update failed', 'User not found', ['status' => 404]);
        }

        return 'User updated successfully';
    }

    public function delete_user($request)
    {
        require_once(ABSPATH . 'wp-admin/includes/user.php');
        $user_id = $request['id'];
        $user = get_user_by('ID', $user_id);
        if (is_wp_error($user)) {
            return new WP_Error('user_not_found', 'User not found', ['status' => 404]);
        }
        $is_deleted = wp_delete_user($user_id);
        if (!$is_deleted) {
            return new WP_Error('delete_failed', 'User not deleted', ['status' => 500]);
        }
        return 'User deleted successfully';
    }
}
