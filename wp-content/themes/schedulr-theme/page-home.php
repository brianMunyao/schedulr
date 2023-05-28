<?php if (!is_user_logged_in()) wp_redirect(site_url('/login')) ?>

<?php

/**
 * 
 * Template Name: Home template
 */
get_header();
?>

<div class="page-home">


    <?php
    // show admin employees not projects
    if (is_user_in_role(wp_get_current_user(), 'administrator')) {

        $employees = [
            [
                'fullname' => 'John Smith',
                'email' => 'john.smith@example.com',
                'role' => 'Project Manager'
            ],
            [
                'fullname' => 'Jane Doe',
                'email' => 'jane.doe@example.com',
                'role' => 'Employee'
            ],
            [
                'fullname' => 'Michael Johnson',
                'email' => 'michael.johnson@example.com',
                'role' => 'Employee'
            ]
        ];


    ?>
        <div class="employees-con">
            <div class="e-header">
                <h3>Employees</h3>
                <a href="<?php echo site_url('/create-employee') ?>"> <button class="custom-btn secondary"><ion-icon name='add'></ion-icon>Add Employee</button></a>
            </div>
            <div class="e-list">
                <div class="employee-h">
                    <div class="e-index">No.</div>
                    <div class="e-fullname">Fullname</div>
                    <div class="e-role">Role</div>

                    <div class="e-options">
                        Options
                    </div>
                </div>
                <?php
                $i = 0;
                foreach ($employees as $employee) {
                ?>
                    <div class="employee-d">
                        <div class="e-index"><?php echo ++$i; ?>.</div>
                        <div class="e-fullname"><?php echo $employee['fullname'] ?></div>
                        <!-- <div class="e-email"><?php // echo $employee['email'] 
                                                    ?></div> -->
                        <div class="e-role"><?php echo $employee['role'] ?></div>

                        <div class="e-options">
                            <ion-icon name='create' class="edit"></ion-icon>
                            <ion-icon name='trash' class="delete"></ion-icon>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    <?php

    } ?>

</div>

<?php get_footer() ?>