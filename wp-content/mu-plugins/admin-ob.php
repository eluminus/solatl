<?php
/*
Plugin Name: Admin Output Buffer
*/
add_action('admin_init', function () {
    if (!ob_get_level()) { ob_start(); }
});
