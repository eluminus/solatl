<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes();?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes();?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes();?>> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" <?php language_attributes();?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes();?>> <!--<![endif]-->
<head>
	<title><?php if ( is_category() ) {
		echo theme_locals("category_for")." &quot;"; single_cat_title(); echo '&quot; | '; bloginfo( 'name' );
	} elseif ( is_tag() ) {
		echo theme_locals("tag_for")." &quot;"; single_tag_title(); echo '&quot; | '; bloginfo( 'name' );
	} elseif ( is_archive() ) {
		wp_title(''); echo " ".theme_locals("archive")." | "; bloginfo( 'name' );
	} elseif ( is_search() ) {
		echo theme_locals("fearch_for")." &quot;".esc_html($s).'&quot; | '; bloginfo( 'name' );
	} elseif ( is_home() || is_front_page()) {
		bloginfo( 'name' ); echo ' | '; bloginfo( 'description' );
	}  elseif ( is_404() ) {
		echo theme_locals("error_404")." | "; bloginfo( 'name' );
	} elseif ( is_single() ) {
		wp_title('');
	} else {
		wp_title( ' | ', true, 'right' ); bloginfo( 'name' );
	} ?></title>
	<meta name="description" content="<?php wp_title(); echo ' | '; bloginfo( 'description' ); ?>" />
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="//gmpg.org/xfn/11" />
	<?php if(of_get_option('favicon') != ''){ ?>
	<link rel="icon" href="<?php echo of_get_option('favicon', '' ); ?>" type="image/x-icon" />
	<?php } else { ?>
	<link rel="icon" href="<?php echo CHILD_URL; ?>/favicon.ico" type="image/x-icon" />
	<?php } ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'atom_url' ); ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo CHILD_URL; ?>/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo CHILD_URL; ?>/bootstrap/css/responsive.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo PARENT_URL; ?>/css/camera.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo CHILD_URL; ?>/main-style.css" />
	<?php
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
	?>
	<?php /* The HTML5 Shim is required for older browsers, mainly older versions IE */ ?>
	<!--[if lt IE 9]>
		<div id="ie7-alert" style="width: 100%; text-align:center;">
			<img src="http://tmbhtest.com/images/ie7.jpg" alt="Upgrade IE 8" width="640" height="344" border="0" usemap="#Map" />
			<map name="Map">
				<area shape="rect" coords="500,350,550,400" href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
				<area shape="rect" coords="610,350,660,400" href="http://www.firefox.com">
				<area shape="rect" coords="560,350,610,400" href="http://www.apple.com/safari/download/">
				<area shape="rect" coords="670,350,720,400" href="http://www.opera.com">
				<area shape="rect" coords="720,350,770,400" href="http://www.google.com/chrome">
			</map>
		</div>
	<![endif]-->
</head>
<body <?php body_class(); ?>>
<?php cherry_get_wrapper_begin("wrapper"); ?>
	<div id="motopress-main" class="main-holder">
		<?php get_template_part('wrapper/wrapper-header'); ?>