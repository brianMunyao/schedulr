<?php if (!is_user_logged_in()) wp_redirect(site_url('/login')) ?>
<?php if (is_user_in_role(wp_get_current_user(), 'Employee')) wp_redirect(site_url('/projects')) ?>

<?php

/**
 * 
 * Template Name: Home template
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

if (is_user_in_role(wp_get_current_user(), 'administrator')) {
    $projects = get_all_projects();
    $ongoing = array_filter($projects, function ($project) {
        return $project->p_done == 0;
    });
    $completed = array_filter($projects, function ($project) {
        return $project->p_done == 1;
    });
} else if (is_user_in_role(wp_get_current_user(), 'ProjectManager')) {
    $projects = get_pm_projects(get_current_user_id());
    $ongoing = array_filter($projects, function ($project) {
        return $project->p_done == 0;
    });
    $completed = array_filter($projects, function ($project) {
        return $project->p_done == 1;
    });
} else {
    $projects = get_assignee_projects(get_current_user_id());
    $my_tasks = [];

    foreach ($projects as $project) {
        $p_tasks = get_project_tasks($project->p_id);
        $my_tasks = array_merge($my_tasks, $p_tasks);
    }
    var_dump($my_tasks);
    $my_ongoing_tasks = array_filter($my_tasks, function ($task) {
        return $task->t_done == 0;
    });
    $my_completed_tasks = array_filter($my_tasks, function ($task) {
        return $task->t_done == 1;
    });
}

?>

<div class="page-home">
    <div class="top-cards-con">
        <div class="overview-card">
            <p class="overview-title"><?php echo is_user_in_role(wp_get_current_user(), 'Employee') ? 'Tasks Overview' : 'Projects Overview' ?></p>
            <p class="overview-total"><?php echo count($projects) ?></p>
            <div class="overview-percent-con" style="grid-template-columns: <?php echo calculate_completion_percentage($ongoing, $completed) ?>;">
                <div></div>
                <div></div>
            </div>

            <div class="overview-labels">

                <div>
                    <div class="ol-title">Active</div>
                    <div class="ol-val"><?php echo is_user_in_role(wp_get_current_user(), 'Employee') ? count($my_ongoing_tasks) : count($ongoing); ?></div>
                </div>
                <div>
                    <div class="ol-title">Completed</div>
                    <div class="ol-val"><?php echo  is_user_in_role(wp_get_current_user(), 'Employee') ? count($my_completed_tasks) : count($completed); ?></div>
                </div>
            </div>
        </div>

        <div class="brief-info-card">
            <div class="icon">
                <ion-icon name='people-outline'></ion-icon>
            </div>

            <div class="bi-right">
                <p>Project Managers</p>
                <span><?php echo count($projectmanagers)
                        ?></span>
            </div>
        </div>
        <div class="brief-info-card">
            <div class="icon">
                <ion-icon name='people-outline'></ion-icon>
            </div>

            <div class="bi-right">
                <p>Regular Employees</p>
                <span><?php echo count($regulars); ?></span>
            </div>
        </div>
    </div>


    <div class="project-summary-con">
        <div class="section-header">
            <h3>Projects Summary</h3>
            <a href="<?php echo site_url('/projects') ?>">View All</a>
        </div>

        <div class="project-summary-list">
            <div class="project-summary-h">
                <span class="ps-name">Project Name</span>
                <span class="ps-duedate">Due Date</span>
                <span class="ps-status">Status</span>
                <span class="ps-assignee">Assignee</span>
                <span class="ps-detail">Project Detail</span>
                <span class="ps-progress">Progress</span>
            </div>

            <?php
            if (count($projects) === 0) {
            ?>
                <div class="project-task list-border list-empty">
                    No Projects Added
                </div>
            <?php
            }
            ?>

            <?php
            foreach ($projects as $project) {
                $tasks = get_project_tasks($project->p_id);
                $completed_tasks = array_filter($tasks, function ($tasks) {
                    return $tasks->t_done == 1;
                });
            ?>
                <div class="project-summary-d">
                    <span class="ps-name"><?php echo $project->p_name ?></span>
                    <span class="ps-duedate"><?php echo style_date($project->p_due_date) ?></span>
                    <span class="ps-status"><span><?php echo $project->p_done == 0 ? "Ongoing" : 'Completed' ?></span></span>
                    <span class="ps-assignee"><?php echo get_fullname_from_users($project->p_assigned_to, $employees) ?></span>
                    <div class="ps-detail">
                        <span><?php echo $project->p_category ?></span>
                        <span><?php echo $project->p_excerpt ?></span>
                    </div>
                    <span class="ps-progress">
                        <div class="progress">
                            <div class="progress-bar" style="width: <?php echo calculate_completion_percentage_alt($completed_tasks, $tasks)
                                                                    ?>"></div>
                        </div>
                    </span>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php get_footer() ?>