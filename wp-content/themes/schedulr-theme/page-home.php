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
        <div class="employees-con">
            <div class="section-header">
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
                            <a href="<?php echo site_url('/update-employee?id=' . $employee['id']) ?>"><ion-icon name='create' class="edit"></ion-icon></a>
                            <ion-icon name='trash' class="delete"></ion-icon>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    <?php
    } // else 
    ?>

    <div class="projects-con">
        <div class="section-header">
            <h3>Projects</h3>
            <a href="<?php echo site_url('/create-project') ?>"> <button class="custom-btn secondary"><ion-icon name='add'></ion-icon>Add Project</button></a>
        </div>

        <div class="projects-section">
            <h4 class="projects-section-h active">
                Active Projects (3)
            </h4>

            <div class="projects-list">
                <?php
                $projects = array_fill(0, 4, [
                    'title' => 'Plana - Event Management System',
                    'progress' => '75%',
                    'assigned_to' => 'John D',
                    'due_date' => 'Jul 23'
                ]);

                foreach ($projects as $project) {
                ?>
                    <div class="project">
                        <p class="p-title"><?php echo $project['title'] ?></p>

                        <div class="progress-con">
                            <div class="progress-top">
                                <span class="pt-left">Project Progress</span>
                                <span class="pt-right"><?php echo $project['progress'] ?></span>
                            </div>

                            <div class="progress-bottom">
                                <div class="pb-bar" style="width:<?php echo $project['progress']; ?>"></div>
                            </div>
                        </div>

                        <div class="p-bottom">
                            <div class="p-assignee">
                                <ion-icon name='person-circle'></ion-icon>
                                <?php echo $project['assigned_to']; ?>
                            </div>

                            <div class="p-duedate">
                                <ion-icon name='calendar-outline'></ion-icon>
                                Due: <?php echo $project['due_date']; ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>


        <div class="projects-section">
            <h4 class="projects-section-h completed">
                Completed Projects (3)
            </h4>

            <div class="projects-list">
                <?php
                $projects = array_fill(0, 3, [
                    'title' => 'Plana - Event Management System',
                    'progress' => '100%',
                    'assigned_to' => 'John D',
                    'due_date' => 'Jul 23'
                ]);

                foreach ($projects as $project) {
                ?>
                    <div class="project">
                        <p class="p-title"><?php echo $project['title'] ?></p>

                        <div class="progress-con">
                            <div class="progress-top">
                                <span class="pt-left">Project Progress</span>
                                <span class="pt-right"><?php echo $project['progress'] ?></span>
                            </div>

                            <div class="progress-bottom">
                                <div class="pb-bar" style="width:<?php echo $project['progress']; ?>"></div>
                            </div>
                        </div>

                        <div class="p-bottom">
                            <div class="p-assignee">
                                <ion-icon name='person-circle'></ion-icon>
                                <?php echo $project['assigned_to']; ?>
                            </div>

                            <div class="p-duedate">
                                <ion-icon name='calendar-outline'></ion-icon>
                                Due: <?php echo $project['due_date']; ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>

<?php get_footer() ?>