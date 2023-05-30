<?php
class UserRoles{
    public function add_role(){
        add_role('ProjectManager', 'Project Manager', array(
            'read' => true,
            'edit_posts' => true,
            'delete_posts' => true,
        ));

        add_role('Employee', 'Employee', array(
            'read' => true,
            'edit_posts' => true,
            'delete_posts' => false,
        ));
    }
}
?>