<?php
//creating the class to handle all tasks endpoints and callbacks

class TasksRestRoutes
{
    public function register_tasks_routes()
    {
        // register_rest_route('api/v1', '/tasks/', array(
        //     'methods' => 'GET',
        //     'callback' => array($this, 'get_tasks'),
        //     'permission_callback' => function(){
        //         return current_user_can('read');
        //     }
        // ));

        register_rest_route('api/v1', '/tasks/(?P<t_project_id>[\d]+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_tasks'),
            'permission_callback' => function () {
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/tasks/single/(?P<id>[\d]+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'single_task'),
            'permission_callback' => function () {
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/tasks/', array(
            'methods' => 'POST',
            'callback' => array($this, 'post_task'),
            'permission_callback' => function () {
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/tasks/(?P<id>[\d]+)', array(
            'methods' => 'PUT',
            'callback' => array($this, 'update_task'),
            'permission_callback' => function () {
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/tasks/(?P<id>[\d]+)', array(
            'methods' => 'DELETE',
            'callback' => array($this, 'delete_task'),
            'permission_callback' => function () {
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/tasks/(?P<id>[\d]+)/complete', array(
            'methods' => 'POST',
            'callback' => array($this, 'complete_task'),
            'permission_callback' => function () {
                return current_user_can('read');
            }
        ));

        register_rest_route('api/v1', '/tasks/(?P<id>[\d]+)/uncomplete', array(
            'methods' => 'POST',
            'callback' => array($this, 'uncomplete_task'),
            'permission_callback' => function () {
                return current_user_can('read');
            }
        ));
    }
    // Call for the get_tasks route
    public function get_tasks($request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tasks';
        $query = "SELECT * FROM $table_name WHERE t_project_id = $request[t_project_id]";
        $tasks = $wpdb->get_results($query);

        return $tasks;
    }

    // Call for the single_task route
    public function single_task($request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tasks';
        $query = "SELECT * FROM $table_name WHERE t_id = $request[id]";
        $task = $wpdb->get_results($query);

        if (empty($task)) {
            return new WP_Error('task_not_found', 'Task not found', ['status' => 404]);
        }

        return $task[0];
    }

    // Call for the post_task route
    public function post_task($request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tasks';
        $rows = $wpdb->insert($table_name, array(
            't_name' => $request['t_name'],
            // 't_done' => $request['t_done'],
            't_project_id' => $request['t_project_id']
        ));

        if ($rows === false) {
            return new WP_Error('task_creation_failed', 'Task creation failed', ['status' => 500]);
        } else {
            return 'Task created successfully';
        }
    }

    // Call for the update_task route
    public function update_task($request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tasks';
        $rows = $wpdb->update($table_name, array(
            't_name' => $request['t_name'],
            // 't_project_id' => $request['t_project_id']
        ), array(
            't_id' => $request['id']
        ));

        if ($rows == false) {
            return new WP_Error('task_update_failed', 'Task update failed', ['status' => 500]);
        } else {
            return 'Task updated successfully';
        }
    }

    // Call for the delete_task route
    public function delete_task($request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tasks';
        $rows = $wpdb->delete($table_name, array('t_id' => $request['id']));

        if ($rows == false) {
            return new WP_Error('task_deletion_failed', 'Task deletion failed', ['status' => 500]);
        } else {
            return 'Task deleted successfully';
        }
    }

    public function complete_task($request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tasks';
        $rows = $wpdb->update($table_name, array(
            't_done' => 1
        ), array(
            't_id' => $request['id']
        ));

        if ($rows == false) {
            return new WP_Error('task_completion_failed', 'Task completion failed', ['status' => 500]);
        } else {
            return 'Task completed successfully';
        }
    }

    public function uncomplete_task($request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tasks';
        $rows = $wpdb->update($table_name, array(
            't_done' => 0
        ), array(
            't_id' => $request['id']
        ));

        if ($rows == false) {
            return new WP_Error('task_uncompletion_failed', 'Task uncompletion failed', ['status' => 500]);
        } else {
            return 'Task uncompleted successfully';
        }
    }
}
