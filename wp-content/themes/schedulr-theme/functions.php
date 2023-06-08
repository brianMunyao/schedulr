<?php

global $base_api;
$base_api = 'http://localhost/schedulr/wp-json/';


function custom_enqueue_scripts()
{
    wp_enqueue_style('mainstyle', get_template_directory_uri() . '/style.css', [], '1.0.0', 'all');
}

add_action('wp_enqueue_scripts', 'custom_enqueue_scripts');

add_theme_support('custom-logo');


function redirect_on_login()
{
    wp_redirect(home_url());
    exit();
}
add_action('wp_login', 'redirect_on_login');

function redirect_on_logout()
{
    wp_redirect(site_url('/login'));
    exit();
}
add_action('wp_logout', 'redirect_on_logout');

function is_user_in_role($user, $role)
{
    // pass the role you want to check and user object from wp_get_current_user()
    return in_array($role, $user->roles);
}

function shorten_string($string, $max_length)
{
    $short_string = substr($string, 0, $max_length);

    if (strlen($string) > strlen($short_string)) {
        $short_string .= '...';
    }

    return $short_string;
}

function custom_get_user_meta($user_id, $key = 'fullname')
{
    return get_user_meta($user_id, $key, true);
}

function input_short_code($attrs)
{
    $a = shortcode_atts([
        'label' => 'Name',
        'value' => '',
        'name' => '',
        'input_type' => 'text',
        'placeholder' => ''
    ], $attrs);

    return "
        <div class='input-con'>
            <label for='{$a['name']}'>{$a['label']}</label>
            <input id='{$a['name']}' name='{$a['name']}' value='{$a['value']}' type='{$a['input_type']}' placeholder='{$a['placeholder']}' required/>
        </div>
    ";
}
add_shortcode('input_tag', 'input_short_code');

function login_page_shortcode($attrs)
{

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

    get_header();

    $output = "";

    $output .= "
    <form action='' method='post'>
        <div class='page-login'>
        
            <div class='inner-form'>
                <h2>Welcome Back</h2>
                <p class='subtext'>Welcome back! Please enter your details </p>

                <p class='error'><?php echo $form_error; ?></p>
               ";

    $output .= do_shortcode("[input_tag name='email_username' label='Email Address' placeholder='Enter your email address']");
    $output .= do_shortcode("[input_tag name='password' label='Password' input_type='password' placeholder='Enter your password']");

    $output .= "
                <button class='custom-btn' type='submit' name='login-submit'>Login</button>
            </div>
        </div>
    </form>    
    ";

    return $output;
}
add_shortcode('login_page', 'login_page_shortcode');

/**
 * 
 * 
 * Routes
 * 
 * 
 */

function get_token($email, $password)
{

    global $base_api;
    $res = wp_remote_post($base_api . 'jwt-auth/v1/token', [
        'body' => [
            'username' => $email,
            'password' => $password
        ]
    ]);

    $token = json_decode($res['body'])->token;

    return $token;
}


function get_all_projects()
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/projects', [
        'method' => 'GET',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token']]
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}


function get_pm_projects($pm_id)
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/projects/project_manager/' . $pm_id, [
        'method' => 'GET',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token']]
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}
function get_assignee_projects($a_id)
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/projects/assignee/' . $a_id, [
        'method' => 'GET',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token']]
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}

function get_single_project($id)
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/projects/' . $id, [
        'method' => 'GET',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token']]
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}

// function create_project($p)
// {
// }
function update_project($p)
{
    global $base_api;

    $data = [
        'p_id' => $p['p_id'],
        'p_name' => $p['p_name'],
        'p_category' => $p['p_category'],
        'p_excerpt' => $p['p_excerpt'],
        'p_description' => $p['p_description'],
        'p_assigned_to' => $p['p_assigned_to'],
        'p_due_date' => $p['p_due_date'],
    ];

    $res = wp_remote_get($base_api . 'api/v1/projects/' . $p['p_id'], [
        'method' => 'PUT',
        'body' => $data,
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token']]
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}

function get_project_tasks($p_id)
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/tasks/' . $p_id, [
        'method' => 'GET',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token']]
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}
function complete_project($id)
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/projects/' . $id . "/complete", [
        'method' => 'POST',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token'], 'Content-Type' => 'application/json'],
        'data_format' => 'body'
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}

function delete_project($id)
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/projects/' . $id, [
        'method' => 'DELETE',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token'], 'Content-Type' => 'application/json'],
        'data_format' => 'body'
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}

function get_single_task($id)
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/tasks/single/' . $id, [
        'method' => 'GET',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token']]
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}

function complete_task($id)
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/tasks/' . $id . "/complete", [
        'method' => 'POST',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token'], 'Content-Type' => 'application/json'],
        'data_format' => 'body'
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}
function uncomplete_task($id)
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/tasks/' . $id . "/uncomplete", [
        'method' => 'POST',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token'], 'Content-Type' => 'application/json'],
        'data_format' => 'body'
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}
function delete_task($id)
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/tasks/' . $id, [
        'method' => 'DELETE',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token'], 'Content-Type' => 'application/json'],
        'data_format' => 'body'
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}

function mark_task_complete($id)
{
    global $base_api;

    $res = wp_remote_get($base_api . "api/v1/tasks/$id/complete", [
        'method' => 'POST',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token']]
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}
function mark_task_uncomplete($id)
{
    global $base_api;

    $res = wp_remote_get($base_api . "api/v1/tasks/$id/uncomplete", [
        'method' => 'POST',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token']]
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}

function get_employees()
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/users', [
        'method' => 'GET',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token']]
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}
function get_unassigned_employees()
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/projects/unassigned', [
        'method' => 'GET',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token']]
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}

function get_single_employee($id)
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/users/' . $id, [
        'method' => 'GET',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token']]
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}
function delete_employee($id)
{
    global $base_api;

    $res = wp_remote_get($base_api . 'api/v1/users/' . $id, [
        'method' => 'DELETE',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token'], 'Content-Type' => 'application/json'],
        'data_format' => 'body'
    ]);
    $res = wp_remote_retrieve_body($res);
    return json_decode($res);
}


function calculate_completion_percentage($arr1, $arr2)
{
    $res = "100% 0%";
    if (count($arr2) > 0) {

        $ongoing_percentage = (count($arr1) / count(array_merge($arr1, $arr2))) * 100;
        $completed_percentage = 100 - $ongoing_percentage;

        $res  = "{$ongoing_percentage}% {$completed_percentage}%";
    }
    return $res;
}

function calculate_completion_percentage_alt($arr1, $total)
{
    $res = "0%";
    if (count($total) > 0) {

        $percentage = (count($arr1) / count($total)) * 100;

        $res = ceil($percentage) . "%";
    }
    return $res;
}


function get_fullname_from_users($id, $users)
{
    $found = array_filter($users, function ($user) use ($id) {
        return $id == $user->ID;
    });


    return reset($found)->fullname;
}

function style_date($raw_date)
{
    return date('M j', strtotime($raw_date));
}

function secret_login_url()
{
    if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php')) {
        wp_redirect(home_url('404.php'));
        exit();
    }
}
add_action('init', 'secret_login_url');

function restrict_dashboard_access()
{
    if (!current_user_can('manage_options') && is_admin() && !wp_doing_ajax()) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('admin_init', 'restrict_dashboard_access');



global $allowed_attempts;
$allowed_attempts = 3; //5;

global $time_blocked;
$time_blocked = 2 * 60; // 2 mins (180 seconds) blocked

global $transient_name;
$transient_name = 'attempts';

global $trials;
$trials = 'trials';


// function check_attempts($user)
// {
//     global $transient_name;
//     global $trials;
//     global $allowed_attempts;
//     global $time_blocked;

//     $transient = get_transient($transient_name);
//     // var_dump($transient);
//     if ($transient) {
//         $user_trials = $transient[$trials];
//         if ($user_trials >= $allowed_attempts) {
//             // $time_blocked = get_option('_transient_timeout_' . 'attempted_login');
//             // $time = time_to_go($time_blocked);

//             return new WP_Error('login_error', "Too many attempts. Try again in " . convert_seconds($time_blocked));
//         }
//         return new WP('login_error', (string)$user_trials);
//     }

//     return $user;
// }

// add_filter('authenticate', 'check_attempts', 30, 3);


// function login_failure()
// {
//     global $allowed_attempts;
//     global $time_blocked;
//     global $transient_name;
//     global $trials;

//     $transient = get_transient($transient_name);


//     if ($transient) {
//         $transient_data = $transient;
//         $transient_data[$trials]++;

//         if ($transient_data[$trials] <= $allowed_attempts) {
//             set_transient($transient_name, $transient_data, $time_blocked);
//         }
//     } else {
//         $transient_data = [$trials => 1];
//         set_transient($transient_name, $transient_data, $time_blocked);
//     }
// }

// add_action('wp_login_failed', 'login_failure', 10, 1);

// function convert_seconds($seconds)
// {
//     if ($seconds < 60) {
//         return $seconds . " seconds";
//     } else {
//         $minutes = floor($seconds / 60);
//         $remaining_seconds = $seconds % 60;

//         return $minutes . " minutes " . ($remaining_seconds > 0 ? " and " . $remaining_seconds . " seconds" : "");
//     }
// }

function check_attempts($user, $username, $password)
{
    $attempted_login = get_transient('attempted_login');

    if ($attempted_login && $attempted_login['tried'] >= 3) {
        $until = get_option('_transient_timeout_attempted_login');
        $time = time_to_go($until);

        return new WP_Error(
            'too_many_tried',
            sprintf(
                __('<strong>ERROR</strong>: You have reached the authentication limit. Please try again after %1$s.'),
                $time
            )
        );
    }

    return $user;
}
add_filter('authenticate', 'check_attempts', 30, 3);

function login_failure($username)
{
    $attempted_login = get_transient('attempted_login') ?: ['tried' => 0];
    $attempted_login['tried']++;
    if ($attempted_login['tried'] <= 3) set_transient('attempted_login', $attempted_login, 60);
}

add_action('wp_login_failed', 'login_failure', 10, 1);

function time_to_go($timestamp)
{
    $periods = ["second", "minute", "hour", "day", "week", "month", "year"];
    $lengths = [60, 60, 24, 7, 4.35, 12];

    $current_timestamp = time();
    $difference = abs($current_timestamp - $timestamp);

    for ($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i++) {
        $difference /= $lengths[$i];
    }

    $difference = round($difference);

    if (isset($difference) && $difference != 1) {
        $periods[$i] .= "s";
    }

    return isset($difference) ? "$difference $periods[$i]" : null;
}
