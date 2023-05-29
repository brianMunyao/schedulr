<?php
// Creating administrator only endpoint to create users and givre em roles

class RestUserReg{
    public function register_users_route(){
        register_rest_route('user-reg/v1', '/users/', array(
            'methods' => 'GET',
            'callback' => array($this, 'all_users'),
            'permission_callback' => function (){
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('user-reg/v1', '/users/(?P<id>[\d]+)', array(
            'methods' => 'GET',
            'callback'=> array($this, 'single_user'),
            'permission_callback' => function(){
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('user-reg/v1', '/user/', array(
            'methods' => 'POST',
            'callback' => array($this, 'create_user'),
            'permission_callback' => function(){
                return current_user_can('manage_options');
            }
        ));
    }

    public function all_users() {
        $users = get_users(['fields' => ['ID', 'display_name', 'user_email']]);
        
        foreach ($users as &$user) {
            $user_roles = get_userdata($user->ID)->roles;
            $user->roles = $user_roles;
        }
        
        return $users;
    }

    public function single_user($request){
        $user_id = $request['id'];
        $user = get_user_by('ID', $user_id);
        if (!$user) {
            return new WP_Error('user_not_found', 'User not found', ['status' => 404]);
        }
        $user_data = [
            'ID' => $user->ID,
            'display_name' => $user->display_name,
            'user_email' => $user->user_email,
            'roles' => $user->roles
        ];
        return $user_data;
    
    }
    
    public function create_user($request){
        $user_data = $request->get_json_params();

        $username = $user_data['username'];
        $email = $user_data['email'];
        $role = $user_data['role'];
        $password = $user_data['password'];

        $user_id = wp_create_user($username, $password, $email);
        if (is_wp_error($user_id)) {
            return new WP_Error('create_failed', $user_id->get_error_message(), ['status' => 500]);
        }

        $user = new WP_User($user_id);
        $user->set_role($role);

        return 'User created successfully';
    }
}

?>