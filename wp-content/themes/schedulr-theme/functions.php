<?php

function custom_enqueue_scripts()
{
    wp_enqueue_style('mainstyle', get_template_directory_uri() . '/style.css', [], '1.0.0', 'all');
}

add_action('wp_enqueue_scripts', 'custom_enqueue_scripts');

add_theme_support('custom-logo');
