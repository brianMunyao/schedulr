<?php
/**
 * @package project-manager
 */

/*
    Plugin Name: Project Manager
    Plugin URI: http://www.project-manager.com 
    Author: John Doe
    Description: This is a plugin for managing projects
    Version: 1.0.0
    License: GPLv2 or later
    Text Domain: project-manager
*/

defined('ABSPATH') or die('Hey, hacker! you are the one pwned');

require_once(dirname(__FILE__) . '/projects_routes.php');
require_once(dirname(__FILE__) . '/tasks_routes.php');
require_once(plugin_dir_path(__FILE__) . 'users_routes.php');
require_once(plugin_dir_path(__FILE__) . 'user_roles.php');

global $namespace;
$namespace = '/api/v1';

class ProjectManager {

    public function activate() {
        $this->create_projects_table();
        $this->create_tasks_table();
    }
    public function create_projects_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
    
        $sql = "CREATE TABLE $table_name (
            p_id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            p_name varchar(100) NOT NULL,
            p_category varchar(100) NOT NULL,
            p_excerpt varchar(100) NOT NULL,
            p_description text NOT NULL,
            p_assigned_to mediumint(9) NOT NULL,
            p_created_by mediumint(9) NOT NULL,
            p_created_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            p_due_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            p_done integer default 0
        )";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    

    public function create_tasks_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tasks';
        $sql = "CREATE TABLE $table_name (
            t_id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            t_name text NOT NULL,
            t_done integer default 0,
            t_due_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            t_project_id INTEGER NOT NULL
        )";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
     
}

$project_manager = new ProjectManager();
register_activation_hook(__FILE__, [$project_manager, 'activate']);


$user_roles = new UserRoles();
$user_roles->add_role();

add_action('rest_api_init', 'register_my_routes');
function register_my_routes() {
    $rest_routes = new ProjectManagerRestRoutes();
    $rest_routes->register_routes();
    $tasks_routes = new TasksRestRoutes();
    $tasks_routes->register_tasks_routes();
    $rest_users = new RestUserReg();
    $rest_users->register_users_route();
}
