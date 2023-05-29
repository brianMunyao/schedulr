<?php
//creating the class to handle all tasks endpoints and callbacks

class TasksRestRoutes{
    public function register_tasks_routes(){
        register_rest_route('api/v1', '/tasks/', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_tasks'),
            'permission_callback' => function(){
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/tasks/', array(
            'methods' => 'POST',
            'callback' => array($this, 'post_task'),
            'permission_callback' => function(){
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('api/v1', '/tasks/(?P<id>[\d]+)', array(
            'method' => 'PUT',
            'callback' => array($this, 'update_task'),
            'permission_callback' => function(){
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('api/v1', '/tasks/(?P<id>[\d]+)', array(
            'method' => 'DELETE',
            'callback' => array($this, 'delete_task'),
            'permission_callback' => function(){
                return current_user_can('manage_options');
            }
        ));
    }

    public function get_tasks($request){
        global $wpdb;
        $table_name = $wpdb->prefix . 'tasks';
        $query = "SELECT * FROM $table_name";
        $tasks = $wpdb->get_results($query);

        return $tasks;
    }

    public function post_task($request){
        global $wpdb;
        $table_name = $wpdb->prefix. 'tasks';
        $rows = $wpdb->insert($table_name, array(
            't_name' => $request['t_name'],
            't_done' => $request['t_done'],
            't_project_id' => $request['t_project_id']
        ));
        if ($rows == 1){
            return 'Task created successfully';
        } else {
            return 'Task creation failed';
        }
    }
}


?>