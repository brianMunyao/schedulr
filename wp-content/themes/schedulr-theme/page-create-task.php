<?php
require('wp-load.php');
if (!isset($_GET['id'])) wp_redirect(site_url('/projects'));
/**
 * 
 * Template Name: Create Task Template
 */
get_header();
?>


<?php
$id = $_GET['id'];

global $form_error;
global $form_success;

if (isset($_POST['create_task'])) {
    $data = [
        't_name' => $_POST['t_name'],
        't_project_id' => $id,
    ];

    $res = wp_remote_post('http://localhost/schedulr/wp-json/api/v1/tasks/', [
        'method' => 'POST',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token'], 'Content-Type' => 'application/json'],
        'body' => json_encode($data),
        'data_format' => 'body'
    ]);
    $res = wp_remote_retrieve_body($res);


    if (!is_wp_error($res)) {
        $form_success = 'Task created successfully';
    } else {
        $form_error = 'Task not created';
    }
}

?>



<form action="" method="post">

    <div style="padding: 10px 50px;width:60%; color:dodgerblue" class="span-icon"><ion-icon name='arrow-back'></ion-icon><a href="<?php echo site_url('projects/project/?id=') . $id ?>"> Back to project</a></div>
    <div class="page-create-task">

        <div class="inner-form">
            <h2>Create Task</h2>

            <p class="error"><?php echo $form_error; ?></p>
            <p class="success"><?php echo $form_success; ?></p>

            <?php echo do_shortcode("[input_tag name='t_name' label='Project Task' placeholder='Enter the task name']") ?>

            <button class="custom-btn" type="submit" name="create_task">Create</button>
        </div>
    </div>
</form>
<?php get_footer() ?>