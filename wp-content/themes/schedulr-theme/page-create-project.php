<?php

/**
 * 
 * Template Name: Create Project Template
 */
get_header();
?>

<?php
global $form_error;
global $form_success;

$user_id = get_current_user_id();

$unassigned_employees = get_unassigned_employees();
$unassigned_employees = array_filter($unassigned_employees, function ($ue) {
    return $ue->id != 1;
});


if (isset($_POST['create-project'])) {
    require('wp-load.php');
    $data = [
        'p_name' => $_POST['p_name'],
        'p_category' => $_POST['p_category'],
        'p_excerpt' => $_POST['p_excerpt'],
        'p_description' => $_POST['p_description'],
        'p_created_by' => $_POST['p_created_by'],
        'p_assigned_to' => $_POST['p_assigned_to'],
        'p_due_date' => $_POST['p_due_date'],
        // 'p_done' => $_POST['p_done'],
    ];

    $res = wp_remote_post('http://localhost/schedulr/wp-json/api/v1/projects/', [
        'method' => 'POST',
        'headers' => ['Authorization' => 'Bearer ' . $GLOBALS['token'], 'Content-Type' => 'application/json'],
        'body' => json_encode($data),
        'data_format' => 'body'
    ]);
    $res = wp_remote_retrieve_body($res);


    if (!is_wp_error($res)) {
        $form_success = 'Project created successfully';
    } else {
        $form_error = 'Project not created';
    }
}

?>

<form action="" method="post">
    <input type="hidden" name="p_created_by" value="<?php echo get_current_user_id() ?>">
    <div style="padding: 10px 50px;width:60%; color:dodgerblue" class="span-icon"><ion-icon name='arrow-back'></ion-icon><a href="<?php echo site_url('projects') ?>"> Back to projects</a></div>
    <div class="page-create-project">

        <div class="inner-form">
            <h2>Create Project</h2>

            <p class="error"><?php echo $form_error; ?></p>
            <p class="success"><?php echo $form_success; ?></p>

            <?php echo do_shortcode("[input_tag name='p_name' label='Project Name' placeholder='Enter the project name']") ?>
            <?php echo do_shortcode("[input_tag name='p_category' label='Project Category' placeholder='e.g. Mobile App, Web App']") ?>
            <?php echo do_shortcode("[input_tag name='p_excerpt' label='Project Tags' placeholder='e.g. wordpress, angular, react']") ?>

            <div class="input-con">
                <label for="p_description">Project Description</label>
                <textarea name="p_description" id="p_description" placeholder="Briefly explain this project"></textarea>
            </div>

            <?php echo do_shortcode("[input_tag name='p_due_date' input_type='date' label='Project Due Date']") ?>

            <div class="input-con">
                <label for="p_assigned_to">Assign Project To </label>
                <select name="p_assigned_to" id="p_assigned_to">
                    <option value="" selected disabled hidden>Assign to a employee</option>
                    <?php
                    foreach ($unassigned_employees as $user) {
                    ?>
                        <option value="<?php echo $user->id ?>"><?php echo $user->email ?></option>
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