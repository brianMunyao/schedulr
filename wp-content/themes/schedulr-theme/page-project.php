<?php
global $form_error;
global $form_success;

require('wp-load.php');
if (!isset($_GET['id'])) wp_redirect(site_url('/projects'));

/**
 * 
 * Template Name: Project Template
 */
get_header();
?>



<?php
$id = $_GET['id'];

$project = get_single_project($id);
$project = reset($project);

$tasks = get_project_tasks($id);
$ongoing_tasks = array_filter($tasks, function ($tasks) {
    return $tasks->t_done == 0;
});
$completed_tasks = array_filter($tasks, function ($tasks) {
    return $tasks->t_done == 1;
});


if (isset($_POST['delete-project'])) {
    $res = delete_project($id);
    if (!is_wp_error($res)) {
        $form_success = 'Project deleted successfully';
        exit(wp_redirect(site_url('/projects')));
    } else {
        $form_error = 'Project not deleted';
    }
}
if (isset($_POST['delete-task'])) {
    $t_id = $_POST['t_id'];
    $res = delete_task($t_id);

    if (!is_wp_error($res)) {
        $form_success = 'Task deleted successfully';
        $tasks = get_project_tasks($id);
        $ongoing_tasks = array_filter($tasks, function ($tasks) {
            return $tasks->t_done == 0;
        });
        $completed_tasks = array_filter($tasks, function ($tasks) {
            return $tasks->t_done == 1;
        });
    } else {
        $form_error = 'Task not deleted';
    }
}

if (isset($_POST['complete_project'])) {
    $res = complete_project($id);
    if (!is_wp_error($res)) {
        $form_success = 'Project completed successfully';
        $project = get_single_project($id);
        $project = reset($project);
    } else {
        $form_error = 'Project not completed';
    }
}
if (isset($_POST['complete_task'])) {
    $res = complete_task($_POST['t_id']);
    $tasks = get_project_tasks($id);
    $ongoing_tasks = array_filter($tasks, function ($tasks) {
        return $tasks->t_done == 0;
    });
    $completed_tasks = array_filter($tasks, function ($tasks) {
        return $tasks->t_done == 1;
    });
}

if (isset($_POST['uncomplete_task'])) {
    $res = uncomplete_task($_POST['t_id']);
    $tasks = get_project_tasks($id);
    $ongoing_tasks = array_filter($tasks, function ($tasks) {
        return $tasks->t_done == 0;
    });
    $completed_tasks = array_filter($tasks, function ($tasks) {
        return $tasks->t_done == 1;
    });
}

?>


<div style="padding: 10px 50px;width:60%; color:dodgerblue" class="span-icon"><ion-icon name='arrow-back'></ion-icon><a href="<?php echo site_url('projects') ?>"> Back to projects</a></div>
<div class="page-project">

    <div class="section-header">
        <h4><?php echo $project->p_name ?></h4>
        <div class="project-options">
            <?php
            if ($project->p_done == 0) {
            ?><form action="" method="post">
                    <button type="submit" name="complete_project" class="remove-btn" style="font-size: inherit;"><span><ion-icon name="checkmark-circle-outline"></ion-icon>
                            <span>Mark As Complete</span></span></button>
                </form>
            <?php
            } else {
            ?>
                <span>
                    <span>Project Completed</span></span>
            <?php
            }
            ?>
            <?php if (!is_user_in_role(wp_get_current_user(), 'Employee')) { ?>
                <a href="<?php echo site_url('/projects/update-project?id=' . $project->p_id) ?>">
                    <span class="color-blue"><ion-icon name="create"></ion-icon>
                        <span>Update</span></span>
                </a>
                <form action="" method="post">
                    <label for="delete-task">
                        <span class="color-danger normal-text"><ion-icon name="trash-outline"></ion-icon>
                            <input type="submit" name="delete-project" value="Delete"></span>
                    </label>
                </form>
            <?php } ?>
        </div>
    </div>

    <p class="project-desc">
        <?php echo $project->p_description ?>
    </p>

    <p class="error"><?php echo $form_error ?></p>
    <p class="success"><?php echo $form_success ?></p>

    <div class="project-tasks-con">
        <div class="section-header header-bg">
            <h4 class="active-tasks color-success">Active Tasks</h4>

            <?php

            if ($project->p_done == 0 && is_user_in_role(wp_get_current_user(), 'Employee')) {
            ?>
                <a href="<?php echo site_url("/projects/project/create-task?id=" . $project->p_id) ?>"><span class="span-icon"><ion-icon name='add'></ion-icon>Add Task</span></a>
            <?php
            }

            ?>
        </div>

        <?php
        if (count($tasks) === 0) {
        ?>
            <div class="project-task list-border list-empty">
                No Active Tasks
            </div>
        <?php
        }
        ?>

        <?php
        foreach ($ongoing_tasks as $task) {
        ?>
            <div class="project-task list-border">
                <?php
                if (is_user_in_role(wp_get_current_user(), 'Employee')) {
                ?>
                    <form action="" method="post">
                        <input type="hidden" name="t_id" value="<?php echo $task->t_id ?>">
                        <button type="submit" name="complete_task" class="remove-btn"><ion-icon name="ellipse-outline"></ion-icon></button>
                    </form>
                <?php
                }
                ?>

                <p class="project-task-title"><?php echo $task->t_name ?></p>


                <div class="project-tasks-options">
                    <?php
                    if (is_user_in_role(wp_get_current_user(), 'Employee')) {
                    ?>

                        <a href="<?php echo site_url("/projects/project/update-task?id=" . $task->t_id) ?>">
                            <span class="span-icon color-info"><ion-icon name='create'></ion-icon><span>Update</span></span>
                        </a>
                        <form action="" method="post">
                            <input type="hidden" name="t_id" value="<?php echo $task->t_id; ?>">
                            <label for="delete-task">
                                <span class="span-icon color-danger normal-text"><ion-icon name='trash'></ion-icon>
                                    <input type="submit" name="delete-task" value="Delete"></span>
                            </label>
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


    <div class="project-tasks-con">
        <div class="section-header header-bg">
            <h4 class="active-tasks color-danger">Completed Tasks</h4>

            <span></span>
        </div>

        <?php
        if (count($completed_tasks) === 0) {
        ?>
            <div class="project-task list-border list-empty">
                No Completed Tasks
            </div>
        <?php
        }
        ?>

        <?php
        foreach ($completed_tasks as $task) {
        ?>
            <div class="project-task list-border">
                <?php
                if (is_user_in_role(wp_get_current_user(), 'Employee')) {
                ?>
                    <form action="" method="post">
                        <input type="hidden" name="t_id" value="<?php echo $task->t_id ?>">
                        <button type="submit" name="uncomplete_task" class="remove-btn"><ion-icon name="checkmark-circle-outline"></ion-icon></button>
                    </form>
                <?php
                }
                ?>

                <p class="project-task-title"><?php echo $task->t_name ?></p>

                <div class="project-tasks-options">
                    <?php
                    if (is_user_in_role(wp_get_current_user(), 'Employee')) {
                    ?>
                        <a href="<?php echo site_url("/projects/project/update-task?id=" . $task->t_id) ?>">
                            <span class="span-icon color-info"><ion-icon name='create'></ion-icon><span>Update</span></span>
                        </a>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $task->t_id; ?>">
                            <label for="delete-task">
                                <span class="span-icon color-danger normal-text"><ion-icon name='trash'></ion-icon>
                                    <input type="submit" id="delete-task" name="delete-task" value="Delete"></span>
                            </label>
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

<?php get_footer() ?>