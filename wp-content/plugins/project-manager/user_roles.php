<?php
class UserRoles{
    public function add_role(){
        add_role('ProjectManager', 'Project Manager', array(
            'read' => true,
            'edit_posts' => false,
            'delete_posts' => false,
        ));
    }
}
?>