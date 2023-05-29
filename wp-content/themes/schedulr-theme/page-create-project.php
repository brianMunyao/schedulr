<?php

/**
 * 
 * Template Name: Create Project Template
 */
get_header();
?>

<?php
global $form_error;

if (isset($_POST['create-project'])) {
    // $email_username = $_POST['email_username'];
    // $password = $_POST['password'];

    // $user = wp_signon([
    //     'user_login' => $email_username,
    //     'user_password' => $password
    // ]);

    // if (is_wp_error($user)) {
    //     $form_error =  $user->get_error_message();
    // }
}

$users = [
    [
        'id' => 1,
        'email' => 'brian@gmail.com'
    ]
];
?>

<form action="" method="post">
    <div class="page-create-project">

        <div class="inner-form">
            <h2>Create Project</h2>

            <p class="error"><?php echo $form_error; ?></p>

            <?php echo do_shortcode("[input_tag name='name' label='Project Name' placeholder='Enter the project name']") ?>
            <?php echo do_shortcode("[input_tag name='category' label='Project Category' placeholder='e.g. Mobile App, Web App']") ?>

            <div class="input-con">
                <label for="desc">Project Description</label>
                <textarea name="desc" id="desc" placeholder="Briefly explain this project"></textarea>
            </div>

            <?php echo do_shortcode("[input_tag name='duedate' input_type='date' label='Project Due Date']") ?>

            <div class="input-con">
                <label for="assigned_to">Assign Project To </label>
                <select name="assigned_to" id="assigned_to">
                    <option value="" selected disabled hidden>Assign to a employee</option>
                    <?php
                    foreach ($users as $user) {
                    ?>
                        <option value="<?php echo $user['id'] ?>"><?php echo $user['email'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <button class="custom-btn" type="submit" name="create-project">Create</button>
        </div>
    </div>
</form>
<?php get_footer() ?>