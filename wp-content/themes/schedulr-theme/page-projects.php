<?php

/**
 * 
 * Template Name: Projects Template
 */
get_header();
?>

<div class="page-projects">
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
                    'due_date' => 'Jul 23',
                    'tags' => 'WordPress, plugins',
                    'category' => 'Web App'
                ]);

                foreach ($projects as $project) {
                ?>
                    <a href="<?php echo site_url('/project?id=1') ?>">
                        <div class="project">
                            <p class="p-category"><?php echo $project['category'] ?></p>
                            <p class="p-title"><?php echo $project['title'] ?></p>

                            <p class="p-tags"><?php echo $project['tags'] ?></p>

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
                    </a>
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
                $projects = array_fill(0, 2, [
                    'title' => 'Plana - Event Management System',
                    'progress' => '100%',
                    'assigned_to' => 'John D',
                    'due_date' => 'Jul 23',
                    'tags' => 'WordPress, plugins',
                    'category' => 'Web App'
                ]);

                foreach ($projects as $project) {
                ?>
                    <a href="<?php echo site_url('/project?id=1') ?>">
                        <div class="project">
                            <p class="p-category"><?php echo $project['category'] ?></p>
                            <p class="p-title"><?php echo $project['title'] ?></p>

                            <p class="p-tags"><?php echo $project['tags'] ?></p>

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
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>

<?php get_footer() ?>