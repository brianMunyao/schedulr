<?php if (!is_user_logged_in()) wp_redirect(site_url('/login')) ?>

<?php

/**
 * 
 * Template Name: Home template
 */
get_header();
?>

<div class="page-home">
    <h1>Home</h1>

</div>

<?php get_footer() ?>