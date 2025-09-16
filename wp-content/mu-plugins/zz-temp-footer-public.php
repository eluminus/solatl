<?php
/*
Plugin Name: Temp Footer Bypass (Public Only)
*/
add_action('init', function () {
    if (!is_user_logged_in() && !is_admin()) {
        remove_all_actions('wp_footer');
        add_action('wp_footer', function(){}, 9999);
    }
}, 1);
