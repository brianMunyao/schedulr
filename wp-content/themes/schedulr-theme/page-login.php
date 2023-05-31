<?php if (is_user_logged_in()) wp_redirect(home_url()) ?>

<?php
global $form_error;

if (isset($_POST['login-submit'])) {
    $email_username = $_POST['email_username'];
    $password = $_POST['password'];

    $user = wp_signon([
        'user_login' => $email_username,
        'user_password' => $password
    ]);

    if (is_wp_error($user)) {
        $form_error =  $user->get_error_message();
    } else {
        // get_token($email_username, $password);
        // $GLOBALS['token'] =  get_token($email_username, $password);
    }
}
?>


<?php

/**
 * 
 * Template Name: Login Template
 */
get_header();
?>

<form action="" method="post">
    <div class="page-login">
        <div class="inner-form">
            <h2>Welcome Back</h2>
            <p class="subtext">Welcome back! Please enter your details </p>

            <p class="error"><?php echo $form_error; ?></p>

            <?php echo do_shortcode("[input_tag name='email_username' label='Email or username' placeholder='Enter your email or username']") ?>
            <?php echo do_shortcode("[input_tag name='password' label='Password' input_type='password' placeholder='Enter your password']") ?>

            <button class="custom-btn" type="submit" name="login-submit">Login</button>
        </div>
    </div>
</form>

<?php get_footer() ?>