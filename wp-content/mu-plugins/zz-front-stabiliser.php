<?php
/*
Plugin Name: Front Stabiliser (Home only)
*/
if (!defined('ABSPATH')) exit;

// 1) For public users on the HOME page, neuter footer hooks temporarily
add_action('template_redirect', function () {
    if (is_user_logged_in() || is_admin()) return;
    if (!is_front_page()) return;
    remove_all_actions('wp_footer');
    add_action('wp_footer', function(){}, 9999);
}, 1);

// 2) Guard the common mobileMenu JS call so it can't throw
add_action('wp_enqueue_scripts', function () {
    if (is_admin()) return;
    wp_enqueue_script('jquery');
    $guard = <<<JS
    jQuery(function($){
      if (!$.fn.mobileMenu) { $.fn.mobileMenu = function(){ return this; }; }
    });
    JS;
    wp_add_inline_script('jquery', $guard, 'after');
}, 100);

// 3) Keep legacy/theme scripts out of admin/Elementor to avoid editor hangs
add_action('admin_enqueue_scripts', function () {
    foreach (['meanmenu','slicknav','mobile-menu','theme-main-js','theme-main-css'] as $h) {
        wp_dequeue_script($h); wp_deregister_script($h);
        wp_dequeue_style($h);  wp_deregister_style($h);
    }
}, 99);
