<?php
/*
Plugin Name: MotoPress Video Addon
Plugin URI: https://motopress.com/
Description: Video Lightbox and Slider for MotoPress Content Editor.
Version: 1.3.1
Author: MotoPress
Author URI: https://motopress.com/
Text Domain: mpce-video-addon
License: GPL2 or later
*/

global $wp_version;
if (version_compare($wp_version, '3.9', '<') && isset($network_plugin)) {
	$mpceva_plugin_file = $network_plugin;
} else {
	$mpceva_plugin_file = __FILE__;
}
define('MPCE_VIDEO_ADDON_PLUGIN_DIR', plugin_dir_path($mpceva_plugin_file));
define('MPCE_VIDEO_ADDON_PLUGIN_FILE', $mpceva_plugin_file);

require_once ABSPATH . 'wp-admin/includes/plugin.php';
require_once MPCE_VIDEO_ADDON_PLUGIN_DIR . 'inc/license.php';
require_once MPCE_VIDEO_ADDON_PLUGIN_DIR . 'inc/settings.php';
require_once MPCE_VIDEO_ADDON_PLUGIN_DIR . 'inc/translations.php';
require_once MPCE_VIDEO_ADDON_PLUGIN_DIR . 'inc/mpLibrary.php';
require_once MPCE_VIDEO_ADDON_PLUGIN_DIR . 'inc/shortcodes.php';
require_once MPCE_VIDEO_ADDON_PLUGIN_DIR . 'inc/simpleShortcodes.php';
require_once MPCE_VIDEO_ADDON_PLUGIN_DIR . 'inc/settingsPage.php';
require_once MPCE_VIDEO_ADDON_PLUGIN_DIR . 'inc/EDD_MPCEVA_Plugin_Updater.php';

function mpcevaLoadTextdomain() {
    load_plugin_textdomain('mpce-video-addon', FALSE, MPCE_VIDEO_ADDON_PLUGIN_NAME . '/lang/');
}
add_action('plugins_loaded', 'mpcevaLoadTextdomain');

function mpceVideoAddonAdminInit() {
	new EDD_MPCEVA_Plugin_Updater(MPCE_VIDEO_ADDON_EDD_STORE_URL, MPCE_VIDEO_ADDON_PLUGIN_FILE, array(
		'version' => MPCE_VIDEO_ADDON_VERSION,                       // current version number
		'license' => get_option('edd_mpce_video_addon_license_key'), // license key (used get_option above to retrieve from DB)
		'item_id' => MPCE_VIDEO_ADDON_EDD_ITEM_ID,                   // name of this plugin
		'author'  => MPCE_VIDEO_ADDON_AUTHOR                         // author of this plugin
	));
}
add_action('admin_init', 'mpceVideoAddonAdminInit');

function mpcevaLicenseInit($hookSuffix) {
    global $videoAddonLicense;
	add_filter('admin_mpce_license_tabs', 'mpcevaLicenseTab');
	add_action('admin_mpce_license_save-' . MPCE_VIDEO_ADDON_PLUGIN_SHORT_NAME, array(&$videoAddonLicense, 'save'));
}
add_action('admin_mpce_license_init', 'mpcevaLicenseInit');

function mpcevaEnqueueScripts() {
	$mpceActive = is_plugin_active('motopress-content-editor/motopress-content-editor.php') || is_plugin_active('motopress-content-editor-lite/motopress-content-editor.php');
	$isEditor = $mpceActive && method_exists('MPCEShortcode', 'isContentEditor') && MPCEShortcode::isContentEditor();

	wp_register_style('mpceva-style', MPCE_VIDEO_ADDON_PLUGIN_DIR_URL . 'assets/css/style.css', array(), MPCE_VIDEO_ADDON_VERSION);
    wp_register_script('mpceva-script', MPCE_VIDEO_ADDON_PLUGIN_DIR_URL . 'assets/js/script.js', array('jquery', 'mpce-magnific-popup', 'mpce-flexslider'), MPCE_VIDEO_ADDON_VERSION, true);
	if ($isEditor) {
		wp_enqueue_style('mpceva-style');
		wp_enqueue_script('mpceva-script');
	}
	
	$jsVars = array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'lang' => mpceVideoAddonGetLangStrings(),
        'nonces' => array(),
		'isEditor' => $isEditor
	);
	wp_localize_script('mpceva-script', 'MPCE_VIDEO_ADDON', $jsVars);
}
add_action('wp_enqueue_scripts', 'mpcevaEnqueueScripts');

function mpcevaInstall($network_wide) {
    $autoLicenseKey = apply_filters('va_auto_license_key', false);        
    if ($autoLicenseKey) {          
        videoAddonLicense::setAndActivateLicenseKey($autoLicenseKey);
    }
}
register_activation_hook($mpceva_plugin_file, 'mpcevaInstall');
