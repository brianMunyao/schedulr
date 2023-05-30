<?php if (!is_user_logged_in()) wp_redirect(site_url('/login')) ?>

<?php

if (isset($_POST['update-employee-submit'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $role = $_POST['role'];


    // PUT REQUEST HERE
}

?>

<?php

/**
 * 
 * Template Name: Update Employee Template
 */
get_header();
?>

<?php
$employees = [
    [
        'id' => 1,
        'fullname' => 'John Smith',
        'email' => 'john.smith@example.com',
        'role' => 'Project Manager'
    ],
    [
        'id' => 2,
        'fullname' => 'Jane Doe',
        'email' => 'jane.doe@example.com',
        'role' => 'Employee'
    ],
    [
        'id' => 3,
        'fullname' => 'Michael Johnson',
        'email' => 'michael.johnson@example.com',
        'role' => 'Employee'
    ]
];


$id = $_GET['id'];

$found_users = array_filter($employees, function ($empl) {
    return $empl['id'] == $_GET['id'];
});

$user = $found_users[0];


global $form_error;
?>


<form action="" method="post">
    <div class="page-update-employee">
        <div class="inner-form">
            <h2>Update Employee Information</h2>

            <p class="error"><?php echo $form_error; ?></p>

            <?php echo do_shortcode("[input_tag value='{$user['fullname']}' name='fullname' label='Fullname' placeholder='Enter their fullname']") ?>
            <?php echo do_shortcode("[input_tag value='{$user['email']}' name='email' label='Email Address' input_type='email' placeholder='Enter their email address']") ?>
            <?php echo do_shortcode("[input_tag value='{$user['password']}' name='password' label='Password' input_type='password' placeholder='Enter their password']")
            ?>

            <div class="input-con-radio">
                <label for="">Role</label>

                <div class="radios">
                    <input type="radio" name="role" id="project-manager" value="Project Manager" <?php echo $user['role'] == 'Project Manager' ? 'checked' : ''; ?> required>
                    <label for="project-manager">
                        Project Manager
                    </label>
                    <input type="radio" name="role" id="employee" value="Employee" <?php echo $user['role'] == 'Employee' ? 'checked' : ''; ?> required>
                    <label for="employee">
                        Employee
                    </label>
                </div>
            </div>

            <button class="custom-btn" type="submit" name="update-employee-submit">Update</button>
        </div>
    </div>
</form>

<?php get_footer() ?>