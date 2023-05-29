<?php

/**
 * 
 * Template Name: Update Task Template
 */
get_header();
?>


<?php
global $form_error;

if (isset($_POST['create-task'])) {
}

?>



<form action="" method="post">
    <div class="page-update-task">

        <div class="inner-form">
            <h2>Update Task</h2>

            <p class="error"><?php echo $form_error; ?></p>

            <?php echo do_shortcode("[input_tag name='t_name' label='Project Task' placeholder='Enter the task name']") ?>

            <button class="custom-btn" type="submit" name="update-task">Update</button>
        </div>
    </div>
</form>
<?php get_footer() ?>