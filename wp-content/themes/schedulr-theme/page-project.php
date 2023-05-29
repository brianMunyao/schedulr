<?php

/**
 * 
 * Template Name: Project Template
 */
get_header();
?>

<?php

if (isset($_POST['delete-project'])) {
    //call delete api here
}
if (isset($_POST['delete-task'])) {
    //call delete api here
}

?>

<?php
$project = [
    'title' => 'Plana - Event Management System',
    'description' => 'An event management system is a comprehensive software solution designed to facilitate the planning, organization, and execution of events. It serves as a central hub that streamlines various aspects of event management, providing a range of features and functionalities to enhance efficiency and effectiveness.',
    'assigned_to' => 'John D',
    'due_date' => 'Jul 23',
    'tags' => 'WordPress, plugins',
    'category' => 'Web App'
];
$tasks = array_fill(0, 3, [
    'title' => 'Implement payment gateway integration',
    'done' => 0
    // 'due_date' => 'Jul 23',
    // 'tags' => 'WordPress, plugins',
]);
$completed_tasks = array_fill(0, 3, [
    'title' => 'Implement payment gateway integration',
    'done' => 1
    // 'due_date' => 'Jul 23',
    // 'tags' => 'WordPress, plugins',
]);

?>

<div class="page-project">

    <div class="section-header">
        <h4><?php echo $project['title'] ?></h4>
        <div class="project-options">
            <span><ion-icon name="checkmark-circle-outline"></ion-icon>
                Mark As Complete</span>
            <a href="<?php echo site_url('/projects/update-project?id=1') ?>">
                <span class="color-blue"><ion-icon name="create"></ion-icon>
                    Update</span>
            </a>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo 1 ?>">
                <span class="color-danger normal-text"><ion-icon name="trash-outline"></ion-icon>
                    <input type="submit" name="delete-project" value="Delete"></span>
            </form>
        </div>
    </div>

    <p class="project-desc">
        <?php echo $project['description'] ?>
    </p>

    <div class="project-tasks-con">
        <div class="section-header header-bg">
            <h4 class="active-tasks color-success">Active Tasks</h4>

            <a href="<?php echo site_url("/projects/project/create-task?id=1") ?>"><span class="span-icon"><ion-icon name='add'></ion-icon>Add Task</span></a>
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
        foreach ($tasks as $task) {
        ?>
            <div class="project-task list-border">
                <ion-icon name="ellipse-outline"></ion-icon>
                <p class="project-task-title"><?php echo $task['title'] ?></p>

                <div class="project-tasks-options">
                    <a href="<?php echo site_url("/projects/project/update-task?id=1") ?>">
                        <span class="span-icon color-info"><ion-icon name='create'></ion-icon>Update</span>
                    </a>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo 1; ?>">
                        <!-- TODO: change this to actual id  -->
                        <span class="span-icon color-danger normal-text"><ion-icon name='trash'></ion-icon>
                            <input type="submit" name="delete-task" value="Delete"></span>
                    </form>
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
                <ion-icon name="checkmark-circle-outline"></ion-icon>
                <p class="project-task-title"><?php echo $task['title'] ?></p>

                <div class="project-tasks-options">
                    <a href="<?php echo site_url("/projects/project/update-task?id=1") ?>">
                        <span class="span-icon color-info"><ion-icon name='create'></ion-icon>Update</span>
                    </a>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo 1; ?>">
                        <!-- TODO: change this to actual id  -->
                        <span class="span-icon color-danger normal-text"><ion-icon name='trash'></ion-icon>
                            <input type="submit" name="delete-task" value="Delete"></span>
                    </form>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

</div>

<?php get_footer() ?>