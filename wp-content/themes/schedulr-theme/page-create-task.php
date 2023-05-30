<?php

/**
 * 
 * Template Name: Create Task Template
 */
get_header();
?>


<?php
global $form_error;

$t_project_id = 1;
if (isset($_POST['create_task'])) {
    // wp_remote_post()
}

?>



<form action="" method="post">
    <input type="hidden" name="t_project_id" value="<?php echo $t_project_id ?>">
    <div class="page-create-task">

        <div class="inner-form">
            <h2>Create Task</h2>

            <p class="error"><?php echo $form_error; ?></p>

            <?php echo do_shortcode("[input_tag name='t_name' label='Project Task' placeholder='Enter the task name']") ?>

            <button class="custom-btn" type="submit" name="create_task">Create</button>
        </div>
    </div>
</form>
<?php get_footer() ?>