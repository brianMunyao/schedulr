<?php if (is_user_logged_in()) wp_redirect(home_url()) ?>

<?php

/**
 * 
 * Template Name: Login Template
 */

?>


<?php
if (have_posts()) {
    while (have_posts()) : the_post();
        the_content();
    endwhile;
}
?>


<?php get_footer() ?>