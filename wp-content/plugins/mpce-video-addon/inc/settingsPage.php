<?php
if (!defined('ABSPATH')) exit;

function mpcevaLicenseTab($tabs) {
    global $videoAddonLicense;
	$tabs[MPCE_VIDEO_ADDON_PLUGIN_SHORT_NAME] = array(
		'label' => __('Video Addon', 'mpce-video-addon'),
		'priority' => 10,
        'callback' => array(&$videoAddonLicense, 'renderPage')
	);
	return $tabs;
}