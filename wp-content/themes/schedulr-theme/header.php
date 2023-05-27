<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo bloginfo('name') ?></title>
    <?php wp_head() ?>
</head>

<body>
    <div class="app-body">
        <nav>
            <?php
            // if (function_exists('the_custom_logo')) {
            the_custom_logo();
            // }
            ?>
        </nav>

        <div class="app-container">