<?php
/**
 * Plugin Name: Team dazzler  
 * Version: 1.3.3
 * Description:  Team plugin will manage your teams on your wordpress site easily, you can add unlimited team member with darg & drop builder  
 * Author: Dazzlersoft
 * Author URI: http://www.dazzlersoftware.com
 * Plugin URI: http://dazzlersoftware.com/teams-plugin-for-wordpress/
 */

if ( ! defined( 'ABSPATH' ) ) exit; 
 /**
 * DEFINE PATHS
 */
define("dazzler_team_m_directory_url", plugin_dir_url(__FILE__));
define("dazzler_team_m_text_domain", "dazzler_team_m");

require_once("ink/install.php");

//load plugin default data
function dazzler_team_m_default_data() {
	
	$Settings_Array = serialize( array(
		"team_mb_name_clr" 	 => "#000000",
		"team_mb_pos_clr" => "#000000",
		"team_mb_desc_clr" => "#000000",
		"team_mb_social_icon_clr"   => "#ffffff",
		"team_mb_social_icon_clr_bg"   => "#e5e5e5",
		"team_mb_name_ft_size"   => 18,
		"team_mb_pos_ft_size"   => 14,
		"team_mb_desc_ft_size"   => 14,
		"font_family"   => "Open Sans",
		"team_layout"   => 4,
		"custom_css"   => "",
		"team_mb_wrap_bg_clr"   => "#1e73be",
		"team_mb_opacity" => 80,
		"design"   => 1,
				
	) );

	add_option('Team_M_default_Settings', $Settings_Array);
}
register_activation_hook( __FILE__, 'dazzler_team_m_default_data' );

// hex code to rgb convert
if(!function_exists('dazz_hex2rgb_teams')) {
    function dazz_hex2rgb_teams($hex) {
       $hex = str_replace("#", "", $hex);

       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       $rgb = array($r, $g, $b);
       return $rgb; // returns an array with the rgb values
    }
}

add_action('admin_menu' , 'dazz_team_b_recom_menu');
function dazz_team_b_recom_menu() {
	$submenu = add_submenu_page('edit.php?post_type=team_member', __('Team Free Vs Pro', dazzler_team_m_text_domain), __('Team Free Vs Pro', dazzler_team_m_text_domain), 'administrator', 'dazz_team_b_fvp_page', 'dazz_team_b_fvp_page_funct');
	
	//team style added
   add_action( 'admin_print_styles-' . $submenu, 'dazz_team_b_fvp_js_css' );
}
	
function dazz_team_b_recom_page_funct(){
	require_once('ink/admin/free.php');
}
function dazz_team_b_fvp_js_css(){
	wp_enqueue_style('wpsm_team_settings_fvp', dazzler_team_m_directory_url.'assets/css/settings.css');
	
}
function dazz_team_b_fvp_page_funct(){
	require_once('ink/admin/fvp.php');
}

// team menu 
require_once("ink/admin/menu.php");
require_once("template/shortcode.php");
?>