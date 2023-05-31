<?php if (!is_user_logged_in()) wp_redirect(site_url('/login')) ?>



<?php
require('wp-load.php');
/**
 * 
 * Template Name: Create Employee Template
 */
get_header();
?>

<?php


global $form_error;
global $form_success;

if (isset($_POST['create-employee-submit'])) {

    $data = [
        'fullname' => $_POST['fullname'],
        'email' => $_POST['email'],
        'role' => $_POST['role'],
        'password' => $_POST['password'],
    ];

    $res = wp_remote_post('http://localhost/schedulr/wp-json/api/v1/users/', [
        'method' => 'POST',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token'], 'Content-Type' => 'application/json'],
        'body' => json_encode($data),
        'data_format' => 'body'
    ]);
    $res = wp_remote_retrieve_body($res);


    if (!is_wp_error($res)) {
        $form_success = 'Employee created successfully';
    }
}

?>


<form action="" method="post">
    <div style="padding: 10px 50px;width:60%; color:dodgerblue" class="span-icon"><ion-icon name='arrow-back'></ion-icon><a href="<?php echo site_url('/employees') ?>"> Back to employees</a></div>
    <div class="page-create-employee">
        <div class="inner-form">
            <h2>Create Employee</h2>

            <p class="error"><?php echo $form_error; ?></p>
            <p class="success"><?php echo $form_success; ?></p>

            <?php echo do_shortcode("[input_tag name='fullname' label='Fullname' placeholder='Enter their fullname']") ?>
            <?php echo do_shortcode("[input_tag name='email' label='Email Address' input_type='email' placeholder='Enter their email address']") ?>
            <?php echo do_shortcode("[input_tag name='password' label='Password' input_type='password' placeholder='Enter their password']") ?>

            <div class="input-con-radio">
                <label for="">Role</label>

                <div class="radios">
                    <input type="radio" name="role" id="project-manager" value="ProjectManager" required>
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