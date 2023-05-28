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


class ProjectManager{

    public function activate(){
        $this->create_projects_table();
        $this->create_tasks_table();
    }

    public function create_projects_table(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $sql = "CREATE TABLE $table_name (
            p_id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            p_name varchar(100) NOT NULL,
            p_excerpt varchar(100) NOT NULL,
            P_description text NOT NULL,
            p_assigned_to mediumint(9) NOT NULL,
            p_due_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            p_done integer default 0
        )";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    //tasks
    //t_project_id, t_id, t_name, t_done,
    public function create_tasks_table(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'tasks';
        $sql = "CREATE TABLE $table_name (
            t_id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            t_name text NOT NULL,
            t_done integer default 0,
            t_project_id INTEGER NOT NULL
        )";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
$project_manager = new ProjectManager();

register_activation_hook(__FILE__, [$project_manager, 'activate']);

