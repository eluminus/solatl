<?php
/*
Plugin Name: ZZ Legacy JS Guard (v2)
Description: Removes hard-coded legacy jQuery and inline mobileMenu calls from final HTML, forces WP core jQuery, and temp-disables Google Maps until keyed.
Author: ChatGPT
Version: 2.0
*/

if (!defined('ABSPATH')) exit;

// 1) Force WP’s core jQuery (so themes don't rely on old copies)
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('jquery');
}, 1);

// 2) Strip legacy <script> tags and inline mobileMenu() calls from the final HTML output
add_action('template_redirect', function () {
    ob_start(function ($html) {
        // Remove any script tag that loads jquery-1.x.*.min.js
        $html = preg_replace('~<script[^>]+jquery-1\.[0-9.]+\.min\.js[^>]*>\s*</script>~i', '', $html);

        // Remove inline jQuery(...).mobileMenu(...) calls (defensive)
        $html = preg_replace('~jQuery\s*\([^)]*\)\s*\.mobileMenu\s*\([^)]*\)\s*;~i', '', $html);

        // Also remove window.onload/mobileMenu initialisers written without jQuery alias
        $html = preg_replace('~\$\([^)]*\)\s*\.mobileMenu\s*\([^)]*\)\s*;~i', '', $html);

        return $html;
    });
});

// 3) Stub mobileMenu so residual calls cannot throw
add_action('wp_enqueue_scripts', function () {
    if (is_admin()) return;
    wp_add_inline_script('jquery', "jQuery(function($){ if(!$.fn.mobileMenu){ $.fn.mobileMenu = function(){ return this; }; } });", 'after');
}, 100);

// 4) Disable Google Maps script on front until an API key + async loader are added
add_filter('elementor/frontend/print_google_maps_script', '__return_false');

// 5) Keep desktop layout while stabilising (optional)
add_action('wp_enqueue_scripts', function () {
    $css = 'body{min-width:1024px} .menu-text,.menu-title{display:none!important}';
    wp_register_style('zz-legacy-guard-v2', false);
    wp_enqueue_style('zz-legacy-guard-v2');
    wp_add_inline_style('zz-legacy-guard-v2', $css);
}, 50);
