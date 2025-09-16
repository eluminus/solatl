<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action('plugins_loaded', 'dazzler_team_m_tr');
function dazzler_team_m_tr() {
	load_plugin_textdomain( dazzler_team_m_text_domain, FALSE, dirname( plugin_basename(__FILE__)).'/languages/' );
}
//shortocde scripts
function dazzler_team_m_front_script() {
	wp_enqueue_style('dazzler_team_m-font-awesome-front', dazzler_team_m_directory_url.'assets/css/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style('dazzler_team_m_bootstrap-front', dazzler_team_m_directory_url.'assets/css/bootstrap-front.css');
	wp_enqueue_style('dazzler_team_m_teams_css', dazzler_team_m_directory_url.'assets/css/teams.css');
}

add_action( 'wp_enqueue_scripts', 'dazzler_team_m_front_script' );
add_filter( 'widget_text', 'do_shortcode');

add_action( 'admin_notices', 'dazz_team_b_review' );
function dazz_team_b_review() {

	// Verify that we can do a check for reviews.
	$review = get_option( 'dazz_team_b_review' );
	$time	= time();
	$load	= false;
	if ( ! $review ) {
		$review = array(
			'time' 		=> $time,
			'dismissed' => false
		);
		add_option('dazz_team_b_review', $review);
		//$load = true;
	} else {
		// Check if it has been dismissed or not.
		if ( (isset( $review['dismissed'] ) && ! $review['dismissed']) && (isset( $review['time'] ) && (($review['time'] + (DAY_IN_SECONDS * 2)) <= $time)) ) {
			$load = true;
		}
	}
	// If we cannot load, return early.
	if ( ! $load ) {
		return;
	}

	// We have a candidate! Output a review message.
	?>
	<div class="notice notice-info is-dismissible dazz-team-b-review-notice">
		<div style="float:left;margin-right:10px;margin-bottom:5px;">
			<img style="width:100%;width: 150px;height: auto;" src="<?php echo dazzler_team_m_directory_url.'assets/images/icon-show.png'; ?>" />
		</div>
		<p style="font-size:18px;">'Hi! We saw you have been using <strong>Team  plugin</strong> for a few days and wanted to ask for your help to <strong>make the plugin better</strong>.We just need a minute of your time to rate the plugin. Thank you!</p>
		<p style="font-size:18px;"><strong><?php _e( '~ dazzlersoft', '' ); ?></strong></p>
		<p style="font-size:19px;"> 
			<a style="color: #fff;background: #ef4238;padding: 5px 7px 4px 6px;border-radius: 4px;" href="https://wordpress.org/support/plugin/dazzlersoft-teams/reviews/?filter=5#new-post" class="dazz-team-b-dismiss-review-notice dazz-team-b-review-out" target="_blank" rel="noopener">Rate the plugin</a>&nbsp; &nbsp;
			<a style="color: #fff;background: #27d63c;padding: 5px 7px 4px 6px;border-radius: 4px;" href="#"  class="dazz-team-b-dismiss-review-notice dazz-rate-later" target="_self" rel="noopener"><?php _e( 'Nope, maybe later', '' ); ?></a>&nbsp; &nbsp;
			<a style="color: #fff;background: #31a3dd;padding: 5px 7px 4px 6px;border-radius: 4px;" href="#" class="dazz-team-b-dismiss-review-notice dazz-rated" target="_self" rel="noopener"><?php _e( 'I already did', '' ); ?></a>
		</p>
	</div>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			$(document).on('click', '.dazz-team-b-dismiss-review-notice, .dazz-team-b-dismiss-notice .notice-dismiss', function( event ) {
				if ( $(this).hasClass('dazz-team-b-review-out') ) {
					var dazz_rate_data_val = "1";
				}
				if ( $(this).hasClass('dazz-rate-later') ) {
					var dazz_rate_data_val =  "2";
					event.preventDefault();
				}
				if ( $(this).hasClass('dazz-rated') ) {
					var dazz_rate_data_val =  "3";
					event.preventDefault();
				}

				$.post( ajaxurl, {
					action: 'dazz_team_b_dismiss_review',
					dazz_rate_data_team_b : dazz_rate_data_val
				});
				
				$('.dazz-team-b-review-notice').hide();
				//location.reload();
			});
		});
	</script>
	<?php
}

add_action( 'wp_ajax_dazz_team_b_dismiss_review', 'dazz_team_b_dismiss_review' );
function dazz_team_b_dismiss_review() {
	if ( ! $review ) {
		$review = array();
	}
	
	if($_POST['dazz_rate_data_team_b']=="1"){
		
	}
	if($_POST['dazz_rate_data_team_b']=="2"){
		$review['time'] 	 = time();
		$review['dismissed'] = false;
		update_option( 'dazz_team_b_review', $review );
	}
	if($_POST['dazz_rate_data_team_b']=="3"){
		$review['time'] 	 = time();
		$review['dismissed'] = true;
		update_option( 'dazz_team_b_review', $review );
	}
	
	die;
}

function dazz_team_b_header_info() {
 	if(get_post_type()=="team_member") {
		?>
		
			<div class="wpsm_ac_h_i ">
				<div class="texture-layer">
					<div class="col-md-3">
						<img src="<?php echo dazzler_team_m_directory_url.'assets/images/team-preview-banner.png'; ?>"  class="img-responsive"/>
					
					</div>
				
					
					
						<div class="col-md-9">
							<div class="wpsm_ac_h_b col-md-6" style="text-align:left">
								<a class="btn btn-danger btn-lg " href="http://dazzlersoftware.com/themes/team-pro/" target="_blank">Upgarde To Pro</a><a class="btn btn-success btn-lg " href="http://dazzlersoftware.com/themes/team-pro-demo/" target="_blank">Team Pro Demo</a>
							</div>								
							<div class="col-md-6" style="text-align:left">							
								<h1 style="color: #fff;
    font-size: 45px;
    font-weight: 800;
    margin-top: 6px;">Team Pro Features</h1>							
							</div>					
						
							<div class="col-md-12" style="padding-bottom:20px;">
								<a href="http://dazzlersoftware.com/themes/team-pro/" target="_blank">
									<div class="col-md-3 pad-o">
										<ul>
											<li> <i class="fa fa-check"></i>50+ Grid Templates </li>
											<li> <i class="fa fa-check"></i>50+ Touch Slider Templates</li>
											<li> <i class="fa fa-check"></i>4+ Gridder Templates</li>
											<li> <i class="fa fa-check"></i>2+ Table Look Templates </li>
											<li> <i class="fa fa-check"></i>Filter Option</li>
											
										</ul>
									</div>
									<div class="col-md-3 pad-o">
										<ul>
											<li><i class="fa fa-check"></i>10+ Column Layout</li>
											<li> <i class="fa fa-check"></i>20+ Social Profiles Integrated</li>
											<li> <i class="fa fa-check"></i>5+ Team Detail Popups</li>								
											<li> <i class="fa fa-check"></i>Add Team Website</li>								
											<li> <i class="fa fa-check"></i>Add Team Email</li>						
										</ul>
									</div>
									<div class="col-md-3 pad-o">
										<ul>
											
											<li> <i class="fa fa-check"></i>Add Team Phone Number</li>
											<li> <i class="fa fa-check"></i>Add Team Person Address </li>		
											<li> <i class="fa fa-check"></i>5+ Dot navigation Style</li>
											<li> <i class="fa fa-check"></i>5+ Button Navigation Style</li>											
											<li> <i class="fa fa-check"></i>Team Widget Pack</li>
											
										</ul>
									</div>
									<div class="col-md-3 pad-o">
										<ul>
											<li> <i class="fa fa-check"></i>500+ Google Fonts </li>
											<li> <i class="fa fa-check"></i>Border Color Customization </li>
											<li> <i class="fa fa-check"></i>Unlimited Color Scheme </li>
											<li> <i class="fa fa-check"></i>Custom Css </li>
											<li> <i class="fa fa-check"></i>All Browser Compatible </li>
										</ul>
									</div>
								</a>
							</div>				
						</div>				
				</div>
			
			</div>
		<?php  
	}
}
add_action('in_admin_header','dazz_team_b_header_info');
?>