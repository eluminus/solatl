<?php
if (!defined('ABSPATH')) exit;
function mpceVideoAddonInitGlobalSettings() {
	static $inited = false;
	if (!$inited) {
		$inited = true;
		global $wp_version, $plugin;

		define('MPCE_VIDEO_ADDON_PLUGIN_NAME', 'mpce-video-addon');
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		$pluginData = get_plugin_data(MPCE_VIDEO_ADDON_PLUGIN_FILE, false, false);
//
		define('MPCE_VIDEO_ADDON_PLUGIN_SHORT_NAME', 'mpce-video-addon');
		define('MPCE_VIDEO_ADDON_PLUGIN_DIR_NAME', basename(dirname(MPCE_VIDEO_ADDON_PLUGIN_FILE)));
		define('MPCE_VIDEO_ADDON_PLUGIN_SYMLINK_DIR_NAME', isset($plugin) ? basename(dirname($plugin)) : MPCE_VIDEO_ADDON_PLUGIN_DIR_NAME);
		if (version_compare($wp_version, '3.9', '<')) {
			define('MPCE_VIDEO_ADDON_PLUGIN_DIR_URL', plugin_dir_url(MPCE_VIDEO_ADDON_PLUGIN_SYMLINK_DIR_NAME . '/' . basename(MPCE_VIDEO_ADDON_PLUGIN_FILE)));
		} else {
			define('MPCE_VIDEO_ADDON_PLUGIN_DIR_URL', plugin_dir_url(MPCE_VIDEO_ADDON_PLUGIN_FILE));
		}
		define('MPCE_VIDEO_ADDON_VERSION', $pluginData['Version']);
		define('MPCE_VIDEO_ADDON_AUTHOR', $pluginData['Author']);
//		define('MPCE_VIDEO_ADDON_LICENSE_TYPE', 'Personal');
		define('MPCE_VIDEO_ADDON_EDD_STORE_URL', $pluginData['PluginURI']);
		define('MPCE_VIDEO_ADDON_EDD_ITEM_NAME', $pluginData['Name']/* . ' ' . MPCE_VIDEO_ADDON_LICENSE_TYPE*/);
		define('MPCE_VIDEO_ADDON_EDD_ITEM_ID', 189966);
		define('MPCE_VIDEO_ADDON_RENEW_URL', $pluginData['PluginURI'] . 'buy/');
        global $videoAddonLicense;
        $videoAddonLicense = new videoAddonLicense();
	}
}
mpceVideoAddonInitGlobalSettings();
