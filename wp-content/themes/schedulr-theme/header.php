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
    <div class="app-body">
        <nav class="<?php echo is_user_logged_in() ? 'nav-loggedin' : 'nav-loggedout' ?>">

            <?php the_custom_logo(); ?>

            <?php
            if (is_user_logged_in()) {
            ?>
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
        </nav>

        <div class="app-container">