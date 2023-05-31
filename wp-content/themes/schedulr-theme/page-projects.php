<?php

/**
 * 
 * Template Name: Projects Template
 */
get_header();
?>

<?php
$employees = get_employees();
$projects = [];
if (is_user_in_role(wp_get_current_user(), 'administrator')) {
    $projects = get_all_projects();
} else if (is_user_in_role(wp_get_current_user(), 'ProjectManager')) {
    $projects = get_pm_projects(get_current_user_id());
} else {
    $projects = get_assignee_projects(get_current_user_id());
}

$ongoing = array_filter($projects, function ($project) {
    return $project->p_done == 0;
});
$completed = array_filter($projects, function ($project) {
    return $project->p_done == 1;
});
?>

<div class="page-projects">
    <div class="projects-con">
        <div class="section-header">
            <h3>Projects</h3>
            <?php
            if (is_user_in_role(wp_get_current_user(), 'ProjectManager')) {
            ?>
                <a href="<?php echo site_url('/create-project') ?>"> <button class="custom-btn secondary"><ion-icon name='add'></ion-icon>Add Project</button></a>
            <?php
            }
            ?>
        </div>

        <div class="projects-section">
            <h4 class="projects-section-h active  header-bg">
                Active Projects (<?php echo count($ongoing) ?>)
            </h4>

            <div class="projects-list">
                <?php
                if (count($ongoing) === 0) {
                ?>
                    <div class="project-task list-border list-empty">
                        No Active Projects
                    </div>
                <?php
                }
                ?>
                <?php
                foreach ($ongoing as $project) {
                    $tasks = get_project_tasks($project->p_id);
                    $completed_tasks = array_filter($tasks, function ($tasks) {
                        return $tasks->t_done == 1;
                    });
                ?>
                    <a href="<?php echo site_url('/project?id=' . $project->p_id) ?>">
                        <div class="project">
                            <p class="p-category"><?php echo $project->p_category ?></p>
                            <p class="p-title"><?php echo $project->p_name ?></p>

                            <p class="p-tags"><?php echo $project->p_excerpt ?></p>

                            <div class="progress-con">
                                <div class="progress-top">
                                    <span class="pt-left">Project Progress</span>
                                    <span class="pt-right"><?php echo calculate_completion_percentage_alt($completed_tasks, $tasks) ?></span>
                                </div>

                                <div class="progress-bottom">
                                    <div class="pb-bar" style="width:<?php echo calculate_completion_percentage_alt($completed_tasks, $tasks); ?>"></div>
                                </div>
                            </div>

                            <div class="p-bottom">
                                <div class="p-assignee">
                                    <ion-icon name='person-circle'></ion-icon>
                                    <?php
                                    echo shorten_string(get_fullname_from_users($project->p_assigned_to, $employees), 10)
                                    ?>
                                </div>

                                <div class="p-duedate">
                                    <ion-icon name='calendar-outline'></ion-icon>
                                    Due: <?php echo style_date($project->p_due_date) ?>
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
            <h4 class="projects-section-h completed  header-bg">
                Completed Projects (<?php echo count($completed) ?>)
            </h4>

            <div class="projects-list">
                <?php
                if (count($completed) === 0) {
                ?>
                    <div class="project-task list-border list-empty">
                        No Completed Projects
                    </div>
                <?php
                }
                ?>
                <?php
                foreach ($completed as $project) {
                    $tasks = get_project_tasks($project->p_id);
                    $completed_tasks = array_filter($tasks, function ($tasks) {
                        return $tasks->t_done == 1;
                    });
                ?>
                    <a href="<?php echo site_url('/project?id=') . $project->p_id ?>">
                        <div class="project">
                            <p class="p-category"><?php echo $project->p_category ?></p>
                            <p class="p-title"><?php echo $project->p_name ?></p>

                            <p class="p-tags"><?php echo $project->p_excerpt ?></p>

                            <div class="progress-con">
                                <div class="progress-top">
                                    <span class="pt-left">Project Progress</span>
                                    <span class="pt-right"><?php echo count($tasks) > 0 ? calculate_completion_percentage_alt($completed_tasks, $tasks) : '100%' ?></span>
                                </div>

                                <div class="progress-bottom">
                                    <div class="pb-bar" style="width:<?php echo count($tasks) > 0 ? calculate_completion_percentage_alt($completed_tasks, $tasks) : '100%'; ?>"></div>
                                </div>
                            </div>

                            <div class="p-bottom">
                                <div class="p-assignee">
                                    <ion-icon name='person-circle'></ion-icon>
                                    <?php echo shorten_string(get_fullname_from_users($project->p_assigned_to, $employees), 10) ?>
                                </div>

                                <div class="p-duedate">
                                    <ion-icon name='calendar-outline'></ion-icon>
                                    Due: <?php echo style_date($project->p_due_date) ?>
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