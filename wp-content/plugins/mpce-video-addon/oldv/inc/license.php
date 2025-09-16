<?php
class videoAddonLicense {
    public function __construct(){
    }
    function renderPage() {
        $license = get_option('edd_mpce_video_addon_license_key');
        if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
            add_settings_error(
                'videoAddonLicense',
                esc_attr('settings_updated'),
                __('Settings saved.', 'mpce-video-addon'),
                'updated'
            );
        }
        if ($license) {
            $licenseData = $this->checkLicense($license);
        }
        ?>
        <div class="wrap">
            <?php screen_icon('options-general'); ?>
            <h2><?php _e('Video Addon License', 'mpce-video-addon'); ?></h2>
            <i><?php printf( __('The License Key is required in order to get automatic plugin updates and support. You can manage your License Key in your personal account. <a %s>Learn more</a>.', 'mpce-video-addon'),
                    'href="https://motopress.zendesk.com/hc/en-us/articles/202812996-How-to-use-your-personal-MotoPress-account" target="_blank"'); ?></i>
            <?php settings_errors('videoAddonLicense', false); ?>
            <form action="" method="POST" autocomplete="off">
                <?php wp_nonce_field('edd_mpce_video_addon_nonce', 'edd_mpce_video_addon_nonce'); ?>
                <table class="form-table">
                    <tbody>
                    <tr valign="top">
                        <th scope="row" valign="top">
                            <?php echo __('License Key', 'mpce-video-addon'); ?>
                        </th>
                        <td>
                            <input id="edd_mpce_video_addon_license_key" name="edd_mpce_video_addon_license_key" type="password"
                                   class="regular-text" value="<?php esc_attr_e($license); ?>"/>
                            <?php if ($license) { ?>
                                <i style="display:block;"><?php echo str_repeat("&#8226;", 20) . substr($license, -7); ?></i>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php if ($license) { ?>
                        <tr valign="top">
                            <th scope="row" valign="top">
                                <?php _e('Status', 'mpce-video-addon'); ?>
                            </th>
                            <td>
                                <?php
                                if ($licenseData) {
                                    switch($licenseData->license) {
                                        case 'inactive' : 
                                        case 'site_inactive' :
                                            _e('Inactive', 'mpce-video-addon');
                                            break;
                                        case 'valid' :
                                            if ($licenseData->expires !== 'lifetime') {
                                                $date = ($licenseData->expires) ? new DateTime($licenseData->expires) : false;
                                                $expires = ($date) ? ' ' . $date->format('d.m.Y') : '';
                                                echo __('Valid until', 'mpce-video-addon') . $expires;
                                            } else {
                                                echo __('Valid', 'mpce-video-addon');
                                            }
                                            break;
                                        case 'disabled' :
                                            _e('Disabled', 'mpce-video-addon');
                                            break;
                                        case 'expired' :
                                            _e('Expired', 'mpce-video-addon');
                                            break;
                                        case 'invalid' : 
                                            _e('Invalid', 'mpce-video-addon');
                                            break;
                                        case 'item_name_mismatch' :                                             
                                           printf( __('Your License Key does not match the installed plugin. <a %s>How to fix this.</a>', 'mpce-video-addon'),
                                           'href="https://motopress.zendesk.com/hc/en-us/articles/202957243-What-to-do-if-the-license-key-doesn-t-correspond-with-the-plugin-license" target="_blank"');
                                            break;
                                        case 'invalid_item_id' :
		                                    _e('Product ID is not valid', 'mpce-video-addon');
		                                    break;
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <?php if (isset($licenseData->license) && in_array($licenseData->license, array('inactive', 'site_inactive', 'valid', 'expired'))) { ?>
                        <tr valign="top">
                            <th scope="row" valign="top">
                                <?php _e('Action', 'mpce-video-addon'); ?>
                            </th>
                            <td>
                                <?php
                                if ($licenseData) {
                                    if ($licenseData->license === 'inactive' || $licenseData->license === 'site_inactive') {
                                        wp_nonce_field('edd_mpce_video_addon_nonce', 'edd_mpce_video_addon_nonce'); ?>
                                        <input type="submit" class="button-secondary" name="edd_license_activate"
                                               value="<?php _e('Activate License', 'mpce-video-addon'); ?>"/>
                                    <?php
                                    } elseif ($licenseData->license === 'valid') {
                                        wp_nonce_field('edd_mpce_video_addon_nonce', 'edd_mpce_video_addon_nonce'); ?>
                                        <input type="submit" class="button-secondary" name="edd_license_deactivate"
                                               value="<?php _e('Deactivate License', 'mpce-video-addon'); ?>"/>
                                    <?php
                                    } elseif ($licenseData->license === 'expired') { ?>
                                        <a href="<?php echo MPCE_VIDEO_ADDON_RENEW_URL; ?>"
                                           class="button-secondary"
                                           target="_blank"><?php _e('Renew License', 'mpce-video-addon'); ?></a>
                                    <?php
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
                <?php submit_button(__('Save', 'mpce-video-addon')); ?>
            </form>
        </div>
    <?php
    }
    // check a license key
    private function checkLicense($license) {
        $apiParams = array(
	        'edd_action' => 'check_license',
	        'license'    => $license,
	        'item_id'    => MPCE_VIDEO_ADDON_EDD_ITEM_ID,
	        'url'        => home_url(),
        );
        // Call the custom API.
        $response = wp_remote_get(add_query_arg($apiParams, MPCE_VIDEO_ADDON_EDD_STORE_URL), array('timeout' => 15, 'sslverify' => false));
        if (is_wp_error($response)) {
            return false;
        }
        $licenseData = json_decode(wp_remote_retrieve_body($response));
        return $licenseData;
    }
    public function save() {
        if (!empty($_POST)) {
            $queryArgs = array('page' => $_GET['page'], 'plugin' => MPCE_VIDEO_ADDON_PLUGIN_SHORT_NAME);
            if (isset($_POST['edd_mpce_video_addon_license_key'])) {
                if (!check_admin_referer('edd_mpce_video_addon_nonce', 'edd_mpce_video_addon_nonce')) {
                    return;
                }
                $licenseKey = trim($_POST['edd_mpce_video_addon_license_key']);
                self::setLicenseKey($licenseKey);
            }
            //activate
            if (isset($_POST['edd_license_activate'])) {
                if (!check_admin_referer('edd_mpce_video_addon_nonce', 'edd_mpce_video_addon_nonce')) {
                    return; // get out if we didn't click the Activate button
                }                
                $licenseData = self::activateLicense();      
                
                if ($licenseData === false) 
                    return false;
                
                if (!$licenseData->success && $licenseData->error === 'item_name_mismatch') {
                    $queryArgs['item-name-mismatch'] = 'true';
                }
            }
            //deactivate
            if (isset($_POST['edd_license_deactivate'])) {
                // run a quick security check
                if (!check_admin_referer('edd_mpce_video_addon_nonce', 'edd_mpce_video_addon_nonce')) {
                    return; // get out if we didn't click the Activate button
                }
                // retrieve the license from the database                     
                $licenseData = self::deactivateLicense();
                
                if ($licenseData === false) 
                    return false;
            }
            $queryArgs['settings-updated'] = 'true';
            wp_redirect(add_query_arg($queryArgs, get_admin_url() . 'admin.php'));
        }
    }
    
    static public function setLicenseKey($licenseKey){
        $oldLicenseKey = get_option('edd_mpce_video_addon_license_key');
        if ($oldLicenseKey && $oldLicenseKey !== $licenseKey) {
            delete_option('edd_mpce_video_addon_license_status'); // new license has been entered, so must reactivate
        }
        if (!empty($licenseKey)) {
            update_option('edd_mpce_video_addon_license_key', $licenseKey);
        } else {
            delete_option('edd_mpce_video_addon_license_key');
        }
    }
    
    static public function activateLicense() {
        $licenseKey = get_option('edd_mpce_video_addon_license_key');
        
        // data to send in our API request
	    $apiParams = array(
		    'edd_action' => 'activate_license',
		    'license'    => $licenseKey,
		    'item_id'    => MPCE_VIDEO_ADDON_EDD_ITEM_ID,
		    'url'        => home_url(),
	    );
        // Call the custom API.
        $response = wp_remote_get(add_query_arg($apiParams, MPCE_VIDEO_ADDON_EDD_STORE_URL), array('timeout' => 15, 'sslverify' => false));
        // make sure the response came back okay
        if (is_wp_error($response)) {
            return false;
        }
        // decode the license data
        $licenseData = json_decode(wp_remote_retrieve_body($response));        
        // $licenseData->license will be either "active" or "inactive"
        update_option('edd_mpce_video_addon_license_status', $licenseData->license);
        
        return $licenseData;
    }
    
    static public function deactivateLicense() {
        $licenseKey = get_option('edd_mpce_video_addon_license_key');
        
        // data to send in our API request
        $apiParams = array(
	        'edd_action' => 'deactivate_license',
	        'license'    => $licenseKey,
	        'item_id'    => MPCE_VIDEO_ADDON_EDD_ITEM_ID,
	        'url'        => home_url(),
        );
        // Call the custom API.
        $response = wp_remote_get(add_query_arg($apiParams, MPCE_VIDEO_ADDON_EDD_STORE_URL), array('timeout' => 15, 'sslverify' => false));
        // make sure the response came back okay
        if (is_wp_error($response)) {
            return false;
        }
        // decode the license data
        $licenseData = json_decode(wp_remote_retrieve_body($response));
        // $license_data->license will be either "deactivated" or "failed"
        if ($licenseData->license == 'deactivated') {
            delete_option('edd_mpce_video_addon_license_status');
        }        
        
        return $licenseData;
    }
    
    static public function setAndActivateLicenseKey($licenseKey){
        self::setLicenseKey($licenseKey);
        self::activateLicense();
    }
}