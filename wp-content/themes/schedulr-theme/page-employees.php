<?php
if (!is_user_logged_in()) wp_redirect(site_url('/login'));

if (!is_user_in_role(wp_get_current_user(), 'administrator')) wp_redirect(home_url());
?>

<?php

require('wp-load.php');

/**
 * 
 * Template Name: Employees Template
 */
get_header();
?>

<?php
$employees = get_employees();
$regulars = array_filter($employees, function ($employee) {
    return  is_user_in_role($employee, 'Employee');
});
$projectmanagers = array_filter($employees, function ($employee) {
    return  is_user_in_role($employee, 'ProjectManager');
});


global $form_error;
global $form_success;

if (isset($_POST['delete-employee'])) {
    $id = $_POST['delete-id'];

    $res = delete_employee($id);

    if (!is_wp_error($res)) {
        $form_success = 'Employee Deleted successfully';
        $employees = get_employees();
        $regulars = array_filter($employees, function ($employee) {
            return  is_user_in_role($employee, 'Employee');
        });
        $projectmanagers = array_filter($employees, function ($employee) {
            return  is_user_in_role($employee, 'ProjectManager');
        });
    } else {
        $form_error = "Error deleting employee";
    }
}


?>

<div class="page-employees">
    <p class="error"><?php echo $form_error; ?></p>
    <p class="success"><?php echo $form_success; ?></p>

    <div class="overview-card">
        <p class="overview-title">Employees Overview</p>
        <p class="overview-total"><?php echo count($employees) ?></p>
        <div class="overview-percent-con" style='grid-template-columns: <?php echo calculate_completion_percentage($projectmanagers, $regulars) ?>;'>
            <div></div>
            <div></div>
        </div>

        <div class="overview-labels">
            <div>
                <div class="ol-title">Project Managers</div>
                <div class="ol-val"><?php echo count($projectmanagers) ?></div>
            </div>
            <div>
                <div class="ol-title">Regular</div>
                <div class="ol-val"><?php echo count($regulars) ?></div>
            </div>
        </div>
    </div>

    <div class="employees-con">
        <div class="section-header">
            <h3>Employees</h3>
            <a href="<?php echo site_url('/create-employee') ?>"> <button class="custom-btn secondary"><ion-icon name='add'></ion-icon>Add Employee</button></a>
        </div>
        <div class="e-list">
            <div class="employee-h">
                <div class="table-h e-index">No.</div>
                <div class="table-h e-fullname">Fullname</div>
                <div class="table-h e-role">Role</div>

                <div class="table-h e-options">Options</div>
            </div>
            <?php
            $i = 0;
            foreach ($employees as $employee) {
            ?>
                <div class="employee-d">
                    <div class="e-index"><?php echo ++$i; ?>.</div>
                    <div class="e-fullname"><?php echo $employee->fullname ?></div>
                    <div class="e-role"><?php echo $employee->roles[0] ?></div>

                    <div class="e-options">
                        <?php
                        if (!is_user_in_role($employee, 'administrator')) {
                        ?>
                            <a href="<?php echo site_url('/update-employee?id=' . $employee->id) ?>"><ion-icon name='create' class="edit"></ion-icon></a>

                            <form action="" method="post">
                                <input type="hidden" name="delete-id" value="<?php echo $employee->id ?>">
                                <button type="submit" name="delete-employee">
                                    <ion-icon name='trash' class="delete"></ion-icon>
                                </button>
                            </form>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>


</div>

<?php get_footer() ?>