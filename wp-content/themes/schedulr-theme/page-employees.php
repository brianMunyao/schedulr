<?php
if (!is_user_logged_in()) wp_redirect(site_url('/login'));

if (!is_user_in_role(wp_get_current_user(), 'administrator')) wp_redirect(home_url());
?>

<?php

/**
 * 
 * Template Name: Employees Template
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
?>

<div class="page-employees">

    <div class="overview-card">
        <p class="overview-title">Employees Overview</p>
        <p class="overview-total">52</p>
        <div class="overview-percent-con" style="grid-template-columns: 30% 70%;">
            <div></div>
            <div></div>
        </div>

        <div class="overview-labels">
            <div>
                <div class="ol-title">Project Managers</div>
                <div class="ol-val">9</div>
            </div>
            <div>
                <div class="ol-title">Regular</div>
                <div class="ol-val">43</div>
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
                    <div class="e-fullname"><?php echo $employee['fullname'] ?></div>
                    <div class="e-role"><?php echo $employee['role'] ?></div>

                    <div class="e-options">
                        <a href="<?php echo site_url('/update-employee?id=' . $employee['id']) ?>"><ion-icon name='create' class="edit"></ion-icon></a>
                        <ion-icon name='trash' class="delete"></ion-icon>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>


</div>

<?php get_footer() ?>