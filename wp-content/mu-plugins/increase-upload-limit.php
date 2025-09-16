<?php
/**
 * Plugin Name: Increase Upload Limit
 * Description: Increases upload limits for large file imports
 * Version: 1.0
 */

// Increase upload limits
@ini_set('upload_max_filesize', '2048M');
@ini_set('post_max_size', '2048M');
@ini_set('memory_limit', '512M');
@ini_set('max_execution_time', 300);
@ini_set('max_input_time', 300);

// Specific filter for All-in-One WP Migration
add_filter('ai1wm_max_file_size', function() {
    return 2147483648; // 2GB in bytes
});

// WordPress upload size filter
add_filter('upload_size_limit', function() {
    return 2147483648; // 2GB in bytes
});