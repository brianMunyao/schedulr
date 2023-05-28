<?php

class ProjectManagerRestRoutes {
    public function register_routes() {
        register_rest_route('project-manager/v1', '/projects/', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_projects'),
            'permission_callback' => function() {
                return current_user_can('edit_others_posts');
            }
        ));

        register_rest_route('project-manager/v1', '/projects/', array(
            'methods' => 'POST',
            'callback' => array($this, 'post_projects'),
            'permission_callback' => function() {
                return current_user_can('manage_options');
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

    public function post_projects($request){
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $rows = $wpdb->insert($table_name, array(
            'p_name' => $request['p_name'],
            'p_excerpt' => $request['p_excerpt'],
            'p_description' => $request['p_description'],
            'p_assigned_to' => $request['p_assigned_to'],
            'p_due_date' => $request['p_due_date'],
            'p_done' => $request['p_done']
        ));
        if ($rows == 1) {
            return 'Project created successfully';
        } else {
            return 'Project creation failed';
        }
        
    }
    
}
