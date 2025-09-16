<?php
/*
Plugin Name: Cherry LESS Bypass (Temp)
*/
add_action('after_setup_theme', function () {
    // If Cherry hooks exist, unhook them
    remove_all_actions('cherry_enqueue_less');
    remove_all_actions('cherry_compile_less');
}, 99);

// Ensure a stylesheet is still enqueued on the front-end
add_action('wp_enqueue_scripts', function () {
    if (!is_admin()) {
        // Prefer your theme’s compiled CSS path if it has one:
        // wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/style.min.css', [], null);
        wp_enqueue_style('theme-style', get_stylesheet_uri(), [], null);
    }
}, 20);
