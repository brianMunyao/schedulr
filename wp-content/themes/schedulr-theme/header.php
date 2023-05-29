<?php if (isset($_POST['logout'])) wp_logout(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo bloginfo('name') ?></title>
    <?php wp_head() ?>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <?php
    $slug = basename(get_permalink());

    $home_routes = ['schedulr'];
    $employee_routes = ['employees', 'update-employee', 'create-employee'];
    $project_routes = ['projects', 'project', 'update-project', 'create-project', 'update-task', 'create-task'];
    ?>

    <div class="app-body">
        <nav class="<?php echo is_user_logged_in() ? 'nav-loggedin' : 'nav-loggedout' ?>">

            <?php the_custom_logo(); ?>

            <?php
            if (is_user_logged_in()) {
            ?>
                <div class="nav-links">
                    <a href="<?php echo home_url(); ?>">
                        <div class="nav-link <?php echo in_array($slug, $home_routes) ? 'active-tab' : ''; ?>">
                            <div></div>
                            Home
                            <div class='bt'></div>
                        </div>
                    </a>
                    <a href="<?php echo site_url('/projects'); ?>">
                        <div class="nav-link <?php echo in_array($slug, $project_routes) ? 'active-tab' : ''; ?>">
                            <div></div>
                            Projects
                            <div class='bt'></div>
                        </div>
                    </a>
                    <?php if (is_user_in_role(wp_get_current_user(), 'administrator')) {
                    ?>
                        <a href="<?php echo site_url('/employees'); ?>">
                            <div class="nav-link <?php echo in_array($slug, $employee_routes) ? 'active-tab' : ''; ?>">
                                <div></div>
                                Employees
                                <div class='bt'></div>
                            </div>
                        </a>
                    <?php } ?>
                </div>


                <form action="" method="post">
                    <span class="logged-user">
                        <ion-icon name='person-outline'></ion-icon>
                        <?php

                        $name = custom_get_user_meta(get_current_user_id());
                        echo $name != '' ? $name : get_userdata(get_current_user_id())->user_login;
                        ?>

                        <div>
                            <button class="custom-btn" name="logout" type="submit">Logout</button>
                        </div>
                    </span>
                </form>

            <?php
            }
            ?>

            <span class="burger"><ion-icon name="menu"></ion-icon>
                <div class="mob-nav-link">
                    <?php
                    if (is_user_logged_in()) {
                    ?>
                        <a href="<?php echo home_url() ?>">Home</a>
                        <a href="<?php echo site_url('/projects'); ?>">Projects</a>
                        <?php
                        if (is_user_in_role(wp_get_current_user(), 'administrator')) {
                        ?>
                            <a href="<?php echo site_url('/employees'); ?>">Employees</a>
                        <?php
                        }
                        ?>

                        <span class="logged-user">
                            <ion-icon name='person-outline'></ion-icon>
                            <a href="">
                                <?php
                                $name = custom_get_user_meta(get_current_user_id());
                                echo $name != '' ? $name : get_userdata(get_current_user_id())->user_login;
                                ?>
                            </a>
                        </span>

                        <form action="" method="post">
                            <button class="custom-btn" name="logout" type="submit">Logout</button>
                        </form>
                    <?php
                    }
                    ?>
                </div>
            </span>
        </nav>

        <div class="app-container">