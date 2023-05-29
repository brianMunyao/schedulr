<?php

class ProjectManagerRestRoutes {
    function is_user_in_role($user, $role)
    {
        // pass the role you want to check and user object from wp_get_current_user()
        return in_array($role, $user->roles);
    }

    public function register_routes() {
        register_rest_route('project-manager/v1', '/projects/', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_projects'),
            'permission_callback' => function() {
                // return $this->is_user_in_role($request->get_user(), 'ProjectManager');
                return current_user_can('read');
            }
        ));

        register_rest_route('project-manager/v1', '/projects/(?P<id>[\d]+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_project'),
            'permission_callback' => function() {
                return current_user_can('read');
            }
        ));

        register_rest_route('project-manager/v1', '/projects/', array(
            'methods' => 'POST',
            'callback' => array($this, 'post_project'),
            'permission_callback' => function() {
                return current_user_can('manage_options');
            }
        ));

        //is it really a put or patch...?hmm
        register_rest_route('project-manager/v1', '/projects/(?P<id>[\d]+)', array(
            'methods' => 'PUT',
            'callback' => array($this, 'update_project'),
            'permission_callback' => function() {
                // return $this->is_user_in_role($request->get_user(), 'ProjectManager');
                return current_user_can('manage_options');
            }
        ));

        // wait I can delete'cha
        register_rest_route('project-manager/v1', '/projects/(?P<id>[\d]+)', array(
            'methods' => 'DELETE',
            'callback' => array($this, 'delete_project'),
            'permission_callback' => function() {
                // return $this->is_user_in_role($request->get_user(), 'ProjectManager');
                return current_user_can('manage_options');
            }
        ));

    }

    //call for the get_projects route
    public function get_projects($request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $query = "SELECT * FROM $table_name";
        $projects = $wpdb->get_results($query);
        
        return $projects;
    }

    //call for the get_project route
    public function get_project($request) {
        $id = $request['id'];
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $query = "SELECT * FROM $table_name WHERE p_id = $id";
        $projects = $wpdb->get_results($query);
        
        return $projects[0];
    }

    //call for the post_projects route
    public function post_project($request){
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $rows = $wpdb->insert($table_name, array(
            'p_name' => $request['p_name'],
            'p_excerpt' => $request['p_excerpt'],
            'p_description' => $request['p_description'],
            'p_assigned_to' => $request['p_assigned_to'],
            'p_due_date' => $request['p_due_date'],
            'p_done' => (int)$request['p_done']
        ));
        if ($rows == 1) {
            return 'Project created successfully';
        } else {
            return 'Project creation failed';
        }
        
    }


    //call for the update_projects route
    public function update_project($request){
        $id = $request['id'];
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $rows = $wpdb->update($table_name, array(
            'p_name' => $request['p_name'],
            'p_excerpt' => $request['p_excerpt'],
            'p_description' => $request['p_description'],
            'p_assigned_to' => $request['p_assigned_to'],
            'p_due_date' => $request['p_due_date'],
            'p_done' => $request['p_done']
        ), array('p_id' => $id));
        if ($rows == 1) {
            return 'Project updated successfully';
        } else {
            return 'Project update failed';
        }
        
    }

    //call for the delete_projects route
    public function delete_project($request){
        $id = $request['id'];
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $rows = $wpdb->delete($table_name, array('p_id' => $id));
        if ($rows == 1) {
            return 'Project deleted successfully';
        } else {
            return 'Project deletion failed';
        }
        
    }
    
}
