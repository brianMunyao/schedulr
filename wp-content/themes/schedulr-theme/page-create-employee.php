<?php if (!is_user_logged_in()) wp_redirect(site_url('/login')) ?>

<?php

/**
 * 
 * Template Name: Create Employee Template
 */
get_header();
?>

<?php


global $form_error;
?>


<form action="" method="post">
    <div class="page-create-employee">
        <div class="inner-form">
            <h2>Create Employee</h2>

            <p class="error"><?php echo $form_error; ?></p>

            <?php echo do_shortcode("[input_tag name='fullname' label='Fullname' placeholder='Enter their fullname']") ?>
            <?php echo do_shortcode("[input_tag name='email' label='Email Address' input_type='email' placeholder='Enter their email address']") ?>
            <?php echo do_shortcode("[input_tag name='password' label='Password' input_type='password' placeholder='Enter their password']") ?>

            <div class="input-con-radio">
                <label for="">Role</label>

                <div class="radios">
                    <input type="radio" name="role" id="project-manager" value="Project Manager" required>
                    <label for="project-manager">
                        Project Manager
                    </label>
                    <input type="radio" name="role" id="employee" value="Employee" checked required>
                    <label for="employee">
                        Employee
                    </label>
                </div>
            </div>

            <button class="custom-btn" type="submit" name="create-employee-submit">Create</button>
        </div>
    </div>
</form>

<?php get_footer() ?>