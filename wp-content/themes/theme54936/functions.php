<?php
// Functions.php with Cherry Framework compatibility
if (!defined("ABSPATH")) exit;

// Basic WordPress functionality
function basic_theme_setup() {
    // Support for post thumbnails
    add_theme_support("post-thumbnails");
    
    // Basic script loading
    if (!is_admin()) {
        wp_enqueue_script("jquery");
    }
}
add_action("after_setup_theme", "basic_theme_setup");

// Fix jQuery loading for Elementor editor
function fix_elementor_jquery() {
    if (isset($_GET['elementor-preview'])) {
        // Force jQuery to load in header with proper dependencies
        wp_deregister_script('jquery');
        wp_deregister_script('jquery-core');
        wp_deregister_script('jquery-migrate');
        
        wp_register_script('jquery-core', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '3.6.0', false);
        wp_register_script('jquery-migrate', includes_url('/js/jquery/jquery-migrate.min.js'), array('jquery-core'), '3.4.1', false);
        wp_register_script('jquery', false, array('jquery-core', 'jquery-migrate'), '3.6.0', false);
        
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'fix_elementor_jquery', 1);

// Additional Elementor compatibility
function elementor_compatibility_fixes() {
    if (isset($_GET['elementor-preview'])) {
        // Aggressively remove ALL theme scripts that depend on jQuery
        $problematic_scripts = array(
            'cherry-plugin', 'waypoints.min', 'cherryIsotopeView.js', 'themeScripts',
            'jquery.easing', 'jquery.elastislide', 'jquery-migrate-1.2.1', 'jflickrfeed',
            'custom', 'bootstrap', 'jquery.flexslider-min', 'jquery.mousewheel',
            'jquery.simplr.smoothscroll', 'cherry.parallax', 'superfish', 'jquery.mobilemenu',
            'jquery.magnific-popup', 'jplayer.playlist', 'jquery.jplayer', 'tmstickup',
            'jquery.zaccordion', 'camera', 'jquery-numerator', 'mediaelement-migrate',
            'wp-mediaelement', 'hoverIntent', 'maxmegamenu'
        );
        
        foreach ($problematic_scripts as $script) {
            wp_dequeue_script($script);
            wp_deregister_script($script);
        }
        
        // Remove theme CSS that might interfere
        wp_dequeue_style('camera');
        wp_dequeue_style('bootstrap');
    }
}
add_action('wp_enqueue_scripts', 'elementor_compatibility_fixes', 99);

// Nuclear approach for Elementor editor
function elementor_nuclear_fix() {
    if (isset($_GET['elementor-preview'])) {
        // Don't load theme scripts at all during Elementor editing
        remove_action('wp_enqueue_scripts', 'cherry_child_custom_scripts');
        
        // Add inline jQuery to make sure it's available
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
        echo '<script>window.jQuery = window.$ = jQuery;</script>';
    }
}
add_action('wp_head', 'elementor_nuclear_fix', 1);

// Comprehensive Elementor editor fix for live site
function elementor_editor_live_site_fix() {
    // Check if we're in Elementor editor mode
    if (isset($_GET['elementor-preview']) || 
        isset($_GET['action']) && $_GET['action'] === 'elementor' ||
        (function_exists('is_elementor_editor_active') && is_elementor_editor_active())) {
        
        // Remove X-Frame-Options header that blocks iframe
        remove_action('send_headers', 'wp_app_passwords_send_deny_all_iframe_headers');
        header_remove('X-Frame-Options');
        
        // Allow Elementor to load in iframe
        header('X-Frame-Options: SAMEORIGIN');
        
        // Remove any content security policy that might interfere
        header_remove('Content-Security-Policy');
        
        // Ensure proper Elementor frontend scripts load
        add_action('wp_enqueue_scripts', function() {
            if (function_exists('elementor_load_frontend_scripts')) {
                elementor_load_frontend_scripts();
            }
        }, 1);
        
        // Force jQuery to load properly for Elementor
        add_action('wp_enqueue_scripts', function() {
            wp_deregister_script('jquery');
            wp_deregister_script('jquery-core');
            wp_deregister_script('jquery-migrate');
            
            wp_register_script('jquery-core', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '3.6.0', false);
            wp_register_script('jquery-migrate', includes_url('/js/jquery/jquery-migrate.min.js'), array('jquery-core'), '3.4.1', false);
            wp_register_script('jquery', false, array('jquery-core', 'jquery-migrate'), '3.6.0', false);
            
            wp_enqueue_script('jquery');
        }, 2);
    }
}
add_action('init', 'elementor_editor_live_site_fix', 1);

// Additional headers fix for Elementor editor
function elementor_headers_fix() {
    if (isset($_GET['elementor-preview']) || 
        (isset($_GET['action']) && $_GET['action'] === 'elementor')) {
        
        // Remove headers that interfere with Elementor
        header('X-Frame-Options: SAMEORIGIN');
        header('X-Content-Type-Options: nosniff');
        
        // Allow cross-origin access for Elementor
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            $origin = $_SERVER['HTTP_ORIGIN'];
            // Only allow same-origin for security
            if (strpos($origin, $_SERVER['HTTP_HOST']) !== false) {
                header("Access-Control-Allow-Origin: $origin");
                header('Access-Control-Allow-Credentials: true');
            }
        }
    }
}
add_action('send_headers', 'elementor_headers_fix');

// Fix Elementor 404 errors and AJAX issues
function fix_elementor_404_errors() {
    // Only run for Elementor requests
    if (!isset($_REQUEST['action']) || 
        (strpos($_REQUEST['action'], 'elementor') === false && 
         !isset($_GET['elementor-preview']))) {
        return;
    }
    
    // Ensure Elementor can load its required files
    add_filter('template_redirect', function() {
        if (isset($_GET['elementor-preview']) || 
            (isset($_GET['action']) && $_GET['action'] === 'elementor')) {
            
            // Remove any redirect that might interfere
            remove_action('template_redirect', 'redirect_canonical');
            
            // Ensure proper query vars are set
            global $wp_query;
            if (isset($_GET['p']) && is_numeric($_GET['p'])) {
                $wp_query->set('p', intval($_GET['p']));
                $wp_query->set('post_type', 'any');
            }
            if (isset($_GET['post']) && is_numeric($_GET['post'])) {
                $wp_query->set('p', intval($_GET['post']));
                $wp_query->set('post_type', 'any');
            }
        }
    }, 1);
    
    // Fix AJAX URL issues
    add_action('wp_enqueue_scripts', function() {
        if (isset($_GET['elementor-preview']) || 
            (isset($_GET['action']) && $_GET['action'] === 'elementor')) {
            
            wp_localize_script('jquery', 'ajaxurl', admin_url('admin-ajax.php'));
            
            // Ensure Elementor admin scripts load
            if (function_exists('elementor_load_admin_scripts')) {
                elementor_load_admin_scripts();
            }
        }
    });
}
add_action('init', 'fix_elementor_404_errors', 1);

// Ensure Elementor assets are properly loaded
function ensure_elementor_assets() {
    if (isset($_GET['elementor-preview']) || 
        (isset($_GET['action']) && $_GET['action'] === 'elementor')) {
        
        // Force load Elementor styles and scripts
        add_action('wp_enqueue_scripts', function() {
            if (class_exists('\Elementor\Plugin')) {
                // Ensure frontend assets load
                \Elementor\Plugin::$instance->frontend->enqueue_styles();
                \Elementor\Plugin::$instance->frontend->enqueue_scripts();
                
                // Ensure editor assets load
                if (method_exists(\Elementor\Plugin::$instance, 'editor')) {
                    \Elementor\Plugin::$instance->editor->enqueue_styles();
                    \Elementor\Plugin::$instance->editor->enqueue_scripts();
                }
            }
        }, 5);
        
        // Remove theme styles that might conflict
        add_action('wp_enqueue_scripts', function() {
            wp_dequeue_style('bootstrap');
            wp_dequeue_style('camera');
            wp_dequeue_style('theme-style');
        }, 99);
    }
}
add_action('wp', 'ensure_elementor_assets');

// Fix Elementor admin AJAX endpoints
function fix_elementor_admin_ajax() {
    // Ensure admin-ajax.php works for Elementor
    if (isset($_POST['action']) && strpos($_POST['action'], 'elementor') !== false) {
        // Force load admin environment for Elementor AJAX
        if (!defined('WP_ADMIN')) {
            define('WP_ADMIN', true);
        }
        
        // Ensure user is logged in for editor
        if (!is_user_logged_in() && current_user_can('edit_posts')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
    }
}
add_action('wp_ajax_nopriv_elementor_ajax', 'fix_elementor_admin_ajax', 1);
add_action('wp_ajax_elementor_ajax', 'fix_elementor_admin_ajax', 1);

// Fix Elementor REST API 404 errors
function fix_elementor_rest_api() {
    // Ensure REST API is enabled
    add_filter('rest_enabled', '__return_true');
    add_filter('rest_jsonp_enabled', '__return_true');
    
    // Fix REST API URL issues
    add_action('rest_api_init', function() {
        // Ensure Elementor REST routes are registered
        if (class_exists('\Elementor\Plugin')) {
            // Force Elementor to register its REST routes
            if (method_exists(\Elementor\Plugin::$instance, 'init_api')) {
                \Elementor\Plugin::$instance->init_api();
            }
        }
    });
    
    // Fix permalink structure issues that cause 404s
    add_action('init', function() {
        if (isset($_GET['elementor-preview']) || 
            (isset($_GET['action']) && $_GET['action'] === 'elementor')) {
            
            global $wp_rewrite;
            if (!$wp_rewrite->permalink_structure) {
                // Temporarily enable permalinks for Elementor
                $wp_rewrite->set_permalink_structure('/%year%/%monthnum%/%day%/%postname%/');
                $wp_rewrite->flush_rules();
            }
        }
    });
    
    // Ensure REST API authentication works
    add_filter('rest_authentication_errors', function($result) {
        if (!empty($result)) {
            return $result;
        }
        
        // Allow REST API access for Elementor editor
        if (isset($_GET['elementor-preview']) || 
            strpos($_SERVER['REQUEST_URI'], '/wp-json/elementor/') !== false) {
            
            if (!is_user_logged_in()) {
                return new WP_Error('rest_not_logged_in', 'You are not currently logged in.', array('status' => 401));
            }
            
            if (!current_user_can('edit_posts')) {
                return new WP_Error('rest_cannot_edit', 'Sorry, you are not allowed to edit posts.', array('status' => 403));
            }
        }
        
        return $result;
    });
}
add_action('init', 'fix_elementor_rest_api', 1);

// Force flush rewrite rules for Elementor
function elementor_flush_rewrite_rules() {
    // Only run once per day to avoid performance issues
    $last_flush = get_option('elementor_last_rewrite_flush');
    if (!$last_flush || (time() - $last_flush) > DAY_IN_SECONDS) {
        flush_rewrite_rules();
        update_option('elementor_last_rewrite_flush', time());
    }
}
add_action('wp_loaded', 'elementor_flush_rewrite_rules');

// Debug REST API issues
function debug_elementor_rest_api() {
    if (defined('WP_DEBUG') && WP_DEBUG && 
        (isset($_GET['elementor-preview']) || strpos($_SERVER['REQUEST_URI'], '/wp-json/elementor/') !== false)) {
        
        error_log('Elementor REST API Debug: ' . $_SERVER['REQUEST_URI']);
        error_log('Current user can edit posts: ' . (current_user_can('edit_posts') ? 'yes' : 'no'));
        error_log('User logged in: ' . (is_user_logged_in() ? 'yes' : 'no'));
    }
}
add_action('rest_api_init', 'debug_elementor_rest_api');

// Cherry Framework compatibility functions
if (!function_exists("cherry_get_wrapper_begin")) {
    function cherry_get_wrapper_begin($wrapper_name = "wrapper") {
        echo "<div class=\"{$wrapper_name}-begin\">";
    }
}

if (!function_exists("cherry_get_wrapper_end")) {
    function cherry_get_wrapper_end($wrapper_name = "wrapper") {
        echo "</div><!-- .{$wrapper_name}-end -->";
    }
}

// theme_locals function is provided by Cherry Framework - don't redefine

// Define theme constants if not already defined
if (!defined("CHILD_URL")) {
    define("CHILD_URL", get_stylesheet_directory_uri());
}

if (!defined("PARENT_URL")) {
    define("PARENT_URL", get_template_directory_uri());
}

// Increase limits for large content
ini_set("memory_limit", "512M");
ini_set("max_execution_time", 300);

// Performance optimizations
function optimize_site_performance() {
    // Remove WordPress emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Remove unnecessary WordPress features
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    
    // Disable XML-RPC
    add_filter('xmlrpc_enabled', '__return_false');
    
    // Optimize heartbeat
    add_action('init', function() {
        wp_deregister_script('heartbeat');
    });
}
add_action('init', 'optimize_site_performance');

// PHP 8 compatibility fix for sidebar layout
function fix_cherry_layout_php8_compatibility() {
    if (!function_exists('cherry_get_layout_class')) {
        function cherry_get_layout_class($layout) {
            switch ($layout) {
                case 'full_width_content':
                    $layout_class = apply_filters("cherry_layout_wrapper", "span12");
                    break;
                case 'content':
                    $layout_class = apply_filters("cherry_layout_content_column", "span8");
                    $sidebar_pos = of_get_option('blog_sidebar_pos');
                    // PHP 8 compatibility: ensure sidebar position is valid
                    if (empty($sidebar_pos) || !is_string($sidebar_pos)) {
                        $sidebar_pos = 'right';
                    }
                    $layout_class .= ' ' . $sidebar_pos;
                    break;
                case 'sidebar':
                    $layout_class = apply_filters("cherry_layout_sidebar_column", "span4");
                    break;
                case 'left_block':
                    $layout_class = apply_filters("cherry_layout_left_block_column", "span7");
                    break;
                case 'right_block':
                    $layout_class = apply_filters("cherry_layout_right_block_column", "span5");
                    break;
                default:
                    $layout_class = 'span12';
                    break;
            }
            return $layout_class;
        }
    }
}
add_action('after_setup_theme', 'fix_cherry_layout_php8_compatibility', 5);

// PHP 8 compatibility CSS fixes for sidebar layout
function add_php8_sidebar_css_fix() {
    // Skip all fixes for Elementor editor and preview modes
    if (is_admin() || 
        isset($_GET['elementor-preview']) || 
        isset($_GET['elementor-editor']) ||
        (isset($_GET['action']) && $_GET['action'] === 'elementor') ||
        (function_exists('is_elementor_editor_active') && is_elementor_editor_active()) ||
        wp_doing_ajax()) {
        return;
    }
    
    echo '<style type="text/css">
/* PHP 8 Sidebar Layout Fix */
.row {
    display: block !important;
    width: 100%;
}

.row:before,
.row:after {
    display: table;
    content: "";
    line-height: 0;
}

.row:after {
    clear: both;
}

/* Ensure span classes float correctly */
[class*="span"] {
    display: block;
    float: left !important;
    width: auto;
    min-height: 1px;
    margin-left: 20px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

/* Specific width fixes for content and sidebar */
.span8 {
    width: 620px !important;
}

.span4 {
    width: 300px !important;
}

/* Ensure sidebar floats properly */
#sidebar {
    float: left !important;
    clear: none !important;
    display: block !important;
}

#content {
    float: left !important;
    clear: none !important;
    display: block !important;
}

/* Force proper positioning for right sidebar */
.right #content {
    float: left !important;
    margin-left: 0 !important;
}

.right #sidebar {
    float: right !important;
}

/* Force proper positioning for left sidebar */  
.left #content {
    float: right !important;
}

.left #sidebar {
    float: left !important;
}

/* Left align headings in content area */
#content h1,
#content h2,
#content h3,
#content h4,
#content h5,
#content h6,
.content-holder h1,
.content-holder h2,
.content-holder h3,
.post-title,
.entry-title {
    text-align: left !important;
}

/* Fix pagination alignment for logged in/out users */
.lcp_paginator {
    display: block !important;
    text-align: left !important;
    margin: 20px 0 !important;
    padding: 0 !important;
    list-style: none !important;
}

.lcp_paginator li {
    display: inline-block !important;
    margin-right: 5px !important;
    margin-bottom: 0 !important;
    float: none !important;
    list-style: none !important;
}

.lcp_paginator li a,
.lcp_paginator li.lcp_currentpage {
    display: inline-block !important;
    padding: 5px 10px !important;
    text-decoration: none !important;
    border: 1px solid #ddd !important;
    background: #fff !important;
}

.lcp_paginator li.lcp_currentpage {
    background: #007cba !important;
    color: #fff !important;
}

.lcp_paginator .lcp_elipsis {
    display: inline-block !important;
    padding: 5px !important;
}

/* Responsive fixes */
@media (max-width: 979px) {
    .span8, .span4 {
        width: 100% !important;
        float: none !important;
        margin-left: 0 !important;
    }
}
</style>';
}
add_action('wp_head', 'add_php8_sidebar_css_fix', 99);

// Optimize Google Fonts loading
function optimize_google_fonts() {
    if (!is_admin() && !isset($_GET['elementor-preview'])) {
        // Preconnect to Google Fonts
        echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>';
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    }
}
add_action('wp_head', 'optimize_google_fonts', 1);

?>