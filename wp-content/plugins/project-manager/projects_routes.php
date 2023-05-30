<?php

class ProjectManagerRestRoutes {
    function is_user_in_role($user, $role)
    {
        // pass the role you want to check and user object from wp_get_current_user()
        return in_array($role, $user->roles);
    }

    public function register_routes() {
        register_rest_route('api/v1', '/projects/', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_projects'),
            'permission_callback' => function() {
                // return $this->is_user_in_role($request->get_user(), 'ProjectManager');
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/projects/(?P<id>[\d]+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_project'),
            'permission_callback' => function() {
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/projects/', array(
            'methods' => 'POST',
            'callback' => array($this, 'post_project'),
            'permission_callback' => function() {
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/projects/(?P<id>[\d]+)', array(
            'methods' => 'PUT',
            'callback' => array($this, 'update_project'),
            'permission_callback' => function() {
                // return $this->is_user_in_role($request->get_user(), 'ProjectManager');
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/projects/(?P<id>[\d]+)', array(
            'methods' => 'DELETE',
            'callback' => array($this, 'delete_project'),
            'permission_callback' => function() {
                // return $this->is_user_in_role($request->get_user(), 'ProjectManager');
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/projects/project_manager/(?P<id>[\d]+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_project_manager_projects'),
            'permission_callback' => function() {
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/projects/assignee/(?P<id>[\d]+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_assignee_projects'),
            'permission_callback' => function() {
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/projects/(?P<id>[\d]+)/complete', array(
            'methods' => 'POST',
            'callback' => array($this, 'complete_project'),
            'permission_callback' => function() {
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/projects/unassigned/', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_unassigned_users'),
            'permission_callback' => function() {
                return current_user_can('read');
            }
        ));

    }
    public function get_projects($request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $query = "SELECT * FROM $table_name";
        $projects = $wpdb->get_results($query);

        return $projects;
    }

    // Call for the single_project route
    public function get_project($request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $query = "SELECT * FROM $table_name WHERE p_id = $request[id]";
        $project = $wpdb->get_results($query);

        return $project;
    }

    // Call for the post_projects route
    public function post_project($request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $rows = $wpdb->insert($table_name, array(
            'p_name' => $request['p_name'],
            'p_category' => $request['p_category'],
            'p_excerpt' => $request['p_excerpt'],
            'p_description' => $request['p_description'],
            'p_assigned_to' => $request['p_assigned_to'],
            'p_created_by' => $request['p_created_by'],
            'p_created_date' => current_time('mysql'),
            'p_due_date' => $request['p_due_date'],
            
        ));

        if ($rows == 1) {
            return 'Project created successfully';
        } else {
            return 'Project creation failed';
        }
    }

    // Call for the update_projects route
    public function update_project($request) {
        $id = $request['p_id'];
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $rows = $wpdb->update($table_name, array(
            'p_name' => $request['p_name'],
            'p_category' => $request['p_category'],
            'p_excerpt' => $request['p_excerpt'],
            'p_description' => $request['p_description'],
            'p_assigned_to' => $request['p_assigned_to'],
            'p_due_date' => $request['p_due_date'],
        ), array('p_id' => $id));

        if ($rows === false) {
            return 'Project update failed';
        } else {
            return 'Project updated successfully';
        }
    }

    // Call for the delete_projects route
    public function delete_project($request) {
        $id = $request['id'];
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $rows = $wpdb->delete($table_name, array('p_id' => $id));

        if ($rows === false) {
            return 'Project deletion failed';
        } else {
            return 'Project deleted successfully';
        }
    }

    //project manager projects
    public function get_project_manager_projects($request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $query = "SELECT * FROM $table_name WHERE p_created_by = $request[id]";
        $projects = $wpdb->get_results($query);

        return $projects;
    }

    public function get_assignee_projects($request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $query = "SELECT * FROM $table_name WHERE p_assigned_to = $request[id]";
        $projects = $wpdb->get_results($query);

        return $projects;
    }

    public function complete_project($request) {
        $id = $request['id'];
        global $wpdb;
        $tasks_table = $wpdb->prefix . 'tasks';
        $project_table = $wpdb->prefix . 'projects';
    
        // Update all tasks associated with the project
        $rows = $wpdb->update($tasks_table, array(
            't_done' => 1
        ), array(
            't_project_id' => $id
        ));
    
        if ($rows === false) {
            return 'Task completion failed';
        }
    
        // Update the project as well
        $rows = $wpdb->update($project_table, array(
            'p_done' => 1
        ), array(
            'p_id' => $id
        ));
    
        if ($rows === false) {
            return 'Project completion failed';
        } else {
            return 'Project completed successfully';
        }
    }
    
    public function get_unassigned_users($request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'users';
        $query = "SELECT ID, user_nicename, user_email FROM $table_name WHERE ID NOT IN (SELECT p_assigned_to FROM wp_projects)";
        $users = $wpdb->get_results($query);

        $modified_users = array_map(function($user){
            $user->fullname = $user->user_nicename;
            $user->email = $user->user_email;
            $user->id = $user->ID;
            
            unset($user->user_nicename);
            unset($user->user_email);
            unset($user->ID);
            return $user;
        }, $users);
    
        return $modified_users;
    }
}