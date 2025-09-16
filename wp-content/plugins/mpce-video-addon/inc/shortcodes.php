<?php
if (!defined('ABSPATH')) exit;

$mpcevaShortcodeFunctions = array(
	'mpceva_video_lightbox' => 'mpcevaVideoLightboxShortcode',
	'mpceva_video_slider' => 'mpcevaVideoSliderShortcode',
	'mpceva_video' => 'mpcevaVideoShortcode'
);
foreach ($mpcevaShortcodeFunctions as $sortcode_name => $function_name) {
    add_shortcode($sortcode_name, $function_name);
}

function mpcevaVideoLightboxShortcode( $atts, $content, $shortcodeName ) {
	$defaultAtts =array(
		'video_type' => 'youtube',
		'video_link_youtube' => '',
		'video_link_vimeo' => '',
		'video_mp4' => '',
		'video_webm' => '',
		'video_ogg' => '',
		'video_preview_image' => '',
		'video_description' => '',
	);
	$mp_style_classes = '';
	$marginClasses = '';
	$classes = '';
	$mpceClasses = '';
	$mpceActive = is_plugin_active('motopress-content-editor/motopress-content-editor.php') || is_plugin_active('motopress-content-editor-lite/motopress-content-editor.php');
	if ($mpceActive) $defaultAtts = MPCEShortcode::addStyleAtts($defaultAtts);
	extract(shortcode_atts($defaultAtts, $atts));
	$imageSrc = '';
	$html5_attr = '';
	$html5_video = '';
	$video_src = '';
	$result = '';
	switch ($video_type) {
		case 'youtube':
			$video_mp4 = '';
			$video_webm = '';
			$video_ogg = '';
			$video_id = mpcevaGetIdByYoutubeUrl($video_link_youtube);
			$imageSrc = '//img.youtube.com/vi/'. $video_id .'/0.jpg';
			$video_src = mpcevaGenerateUrlByYoutubeId($video_id);
			break;
		case 'vimeo':
			$video_mp4 = '';
			$video_webm = '';
			$video_ogg = '';
			$video_id = mpcevaGetIdByVimeoUrl($video_link_vimeo);
			$imageSrc = mpcevaGetThumbnailByVimeoApi($video_id);
			$video_src = mpcevaGenerateUrlByVimeoId($video_id);
			break;
		case 'html5':
			$video_link_youtube = '';
			$video_link_vimeo = '';
			$uniq = uniqid();
			$hide = '';
			if ($mpceActive && method_exists('MPCEShortcode', 'isContentEditor') && MPCEShortcode::isContentEditor()) {
				$hide = 'mpceva-hide';
			}
			$html5_video .= '<div id="mpceva-html5-popup_'. $uniq .'" class="mfp-hide '. $hide .' "><video class="mpceva-html5" controls>';
			if (!empty($video_mp4) ) $html5_video .= '<source src="'. $video_mp4 .'" type="video/mp4">';
			if (!empty($video_webm)) $html5_video .= '<source src="'. $video_webm .'" type="video/webm">';
			if (!empty($video_ogg) ) $html5_video .= '<source src="'. $video_ogg .'" type="video/ogg">';
									 $html5_video .= 'Your browser does not support the video tag.';
			if (!empty($video_mp4) ) {
				$video_src = $video_mp4;
			} else if (!empty($video_webm)) {
				$video_src = $video_webm;
			} else if (!empty($video_ogg) ) {
				$video_src = $video_ogg;
			}
			$html5_attr = ' data-mfp-src="#mpceva-html5-popup_'. $uniq .'" data-id="mpceva_html5_popup"';
			$html5_video .= '</video></div>';
			break;
	}
	if ( !empty($video_preview_image) ) {
		$imageAttrs = wp_get_attachment_image_src($video_preview_image, 'full');
		$imageSrc = $imageAttrs && isset($imageAttrs[0]) ? $imageAttrs[0] : '';
	}
	if ($mpceActive) wp_enqueue_script('mpce-magnific-popup');
	wp_enqueue_style('mpceva-style');
	wp_enqueue_script('mpceva-script');
	if ($mpceActive) {
		if ( !empty($mp_style_classes) ) $mp_style_classes = ' ' . $mp_style_classes;
		$mpceClasses .= MPCEShortcode::getMarginClasses($margin) . MPCEShortcode::getBasicClasses('mpceva-video-lightbox');
		if (method_exists('MPCEShortcode', 'handleCustomStyles')) {
			$mpceClasses .= MPCEShortcode::handleCustomStyles($mp_custom_style, $shortcodeName);
		}
	}
	$link_attr = 'data-id="mpceva_popup"';
	if ( !empty($html5_attr) ) $link_attr = $html5_attr;
	
	$result .= '<div class="mpceva-video-lightbox-obj '. $classes . $mpceClasses . $mp_style_classes .'">';
	$result .= $html5_video;
	$result .= '<div class="link-wrapper"><a href="'. $video_src .'" '. $link_attr .' class="mpceva_popup mpceva_'. $video_type .'" >';
	if ( !empty($imageSrc) ) $result .= '<span class="wrapper"><img src="'. $imageSrc .'"></span>';
	$result .= '</a></div>';
	if ($video_description) {
		$result .= '<p class="mpceva-video-lightbox-description">'. base64_decode($video_description) .'</p>';
	}
	$result .= '</div>';
	
	return $result;
}

function mpcevaVideoSliderShortcode($atts, $content, $shortcodeName) {
	$defaultAtts = array(
		'autoplay' => 'false',
		'slideshow' => 'false',
		'slideshow_speed' =>''
	);
	$videos = '';
	$data_slideshow_speed = '';
	$marginClasses = '';
	$classes = '';
	$mp_style_classes = '';
	$mpceClasses = '';
	$mpceActive = is_plugin_active('motopress-content-editor/motopress-content-editor.php') || is_plugin_active('motopress-content-editor-lite/motopress-content-editor.php');;
	$isContentEditor = $mpceActive && method_exists('MPCEShortcode', 'isContentEditor') && MPCEShortcode::isContentEditor();
	
	if ($mpceActive) $defaultAtts = MPCEShortcode::addStyleAtts($defaultAtts);
	extract(shortcode_atts($defaultAtts, $atts));
	if ($mpceActive) wp_enqueue_script('mpce-flexslider');
	wp_enqueue_style('mpceva-style');
	wp_enqueue_script('mpceva-script');
	if ($mpceActive) {
		if ( !empty($mp_style_classes) ) $mp_style_classes = ' ' . $mp_style_classes;
		$mpceClasses .= MPCEShortcode::getMarginClasses($margin) . MPCEShortcode::getBasicClasses('mpceva-video-lightbox');
		if (method_exists('MPCEShortcode', 'handleCustomStyles')) {
			$mpceClasses .= MPCEShortcode::handleCustomStyles($mp_custom_style, $shortcodeName);
		}
	}
	
	$result = '';
	if ($slideshow !== 'false') {
		$data_slideshow_speed = 'data-slideshow-speed="'. (int)$slideshow_speed*1000 .'"';
	}
	$uniqid = uniqid();
	$result .= '<div class="mpceva-video-slider-obj mpceva-video-slider-preload'. $classes . $mp_style_classes . $mpceClasses .'" >';
	$result .= '<div class="mpceva-flexslider" id="mpce-flexslider-'. $uniqid .'" data-slideshow="'. $slideshow . '" '. $data_slideshow_speed .' data-autoplay="'. $autoplay .'" data-mpce="'. $isContentEditor .'" >';
	$result .= '<ul class="slides">';
	$result .= do_shortcode($content);
	$result .= '</ul>';
	$result .= '</div>';
	$result .= '<div class="mpceva-video-slider-preloader"></div>';
	$result .= '</div>';
	return $result;
}

function mpcevaVideoShortcode($atts, $content = null) {
	$defaultAtts = array(
		'video_type' => 'youtube',
		'video_link_youtube' => '',
		'video_link_vimeo' => '',
		'video_mp4' => '',
		'video_webm' => '',
		'video_ogg' => '',
		'image' => '',
		'size' => 'full',
		'custom_size' => ''
	);
	$mpceActive = is_plugin_active('motopress-content-editor/motopress-content-editor.php') || is_plugin_active('motopress-content-editor-lite/motopress-content-editor.php');;
	if ($mpceActive) $defaultAtts = MPCEShortcode::addStyleAtts($defaultAtts);
	extract(shortcode_atts($defaultAtts, $atts));
	
	$result ='';
	switch ($video_type) {
		case 'youtube':
			$uniq = uniqid();
			$video_mp4 = '';
			$video_webm = '';
			$video_ogg = '';
			$video_link_vimeo = '';
			$image='';
			if  ( !empty($video_link_youtube) ){
				$video_id = mpcevaGetIdByYoutubeUrl($video_link_youtube);
				if ( $video_id ) {
						$result .= '<li class="mpceva-slide mpceva-youtube-slide" id="slide-'. $uniq .'" ><div class="mpceva-youtube-wrapper"><iframe class="mpceva-yt-player" id="mpceva-youtube-frame-'. $uniq .'" src="https://www.youtube.com/embed/'. $video_id .'?enablejsapi=1&html5=1"  webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div></li>';
				}
			}
			break;
		case 'vimeo':
			$uniq = uniqid();
			$video_mp4 = '';
			$video_webm = '';
			$video_ogg = '';
			$video_link_youtube = '';
			$image='';
			if  ( !empty($video_link_vimeo) ){
				$video_id = mpcevaGetIdByVimeoUrl($video_link_vimeo);
				if ( $video_id ) {
						$result .= '<li class="mpceva-slide mpceva-vimeo-slide" ><div class="mpceva-vimeo-wrapper"><iframe id="vimeoplayer_'. $uniq .'" src="https://player.vimeo.com/video/'. $video_id .'?api=1&player_id=vimeoplayer_'. $uniq .'" data-id="vimeo_player"  webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div></li>';
				}
			}
			break;
		case 'html5':
			$html5_video = '';
			$video_link_vimeo = '';
			$video_link_youtube = '';
			$image='';
			if ( !empty($video_mp4) || !empty($video_webm) || !empty($video_ogg) ) {
				$html5_video .= '<li class="mpceva-slide mpceva-html5-slide" ><div class="mpceva-html5-wrapper"><video class="mpceva-html5" controls>';
				if (!empty($video_mp4) ) $html5_video .= '<source src="'. $video_mp4 .'" type="video/mp4">';
				if (!empty($video_webm)) $html5_video .= '<source src="'. $video_webm .'" type="video/webm">';
				if (!empty($video_ogg) ) $html5_video .= '<source src="'. $video_ogg .'" type="video/ogg">';
										 $html5_video .= 'Your browser does not support the video tag.';
				$html5_video .= '</video></div></li>';
			}
			$result .= $html5_video;
			break;
		case 'image':
			$video_link_vimeo = '';
			$video_link_youtube = '';
			$video_mp4 = '';
			$video_webm = '';
			$video_ogg = '';
			if ( !empty($image) ) {
				if ($size === 'custom') {
					$size = array_pad(explode('x', $custom_size), 2, 0);
				}
				$imageAttrs = wp_get_attachment_image_src($image, $size);
				$imageSrc = $imageAttrs && isset($imageAttrs[0]) ? $imageAttrs[0] : '';
				$result .= '<li class="mpceva-slide mpceva-image-slide" ><div class="mpceva-image-wrapper"><div class="mpceva-image-view" style="background-image: url('. $imageSrc .');"></div></div></li>';
			}
			break;
	}
	return $result;
}

function mpcevaGetIdByYoutubeUrl( $urlOrId ) {
	preg_match('/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))(?P<idbyurl>[^\?&\"\'>]+)|(?P<id>[A-za-z0-9_-]{11})/', $urlOrId, $matches);
	return isset($matches['id']) ? $matches['id'] : ( isset($matches['idbyurl']) ? $matches['idbyurl'] : '' );
}
	
function mpcevaGetIdByVimeoUrl( $urlOrId ) {
	preg_match('/^(?:(?:https?:\/\/|)(?:www\.|player\.|)vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(?P<idbyurl>\d+)(?:\/|\?|\#\w*|))|(?P<id>\d+)$/', $urlOrId, $matches);
	return isset($matches['id']) ? $matches['id'] : ( isset($matches['idbyurl']) ? $matches['idbyurl'] : '');        
}
	
function mpcevaGetThumbnailByVimeoApi( $id ) {
	$apiBaseUrl = 'https://vimeo.com/api/oembed.json';
	$response = wp_remote_get(add_query_arg(array('url' => mpcevaGenerateUrlByVimeoId($id)), $apiBaseUrl), array('timeout' => 15, 'sslverify' => false));
	if (is_wp_error($response)) 
		return false;
	$responseBody = wp_remote_retrieve_body($response);
	$data = json_decode($responseBody, true);                
    return (!is_null($data) && isset($data['thumbnail_url'])) ? $data['thumbnail_url'] : false;                
}

function mpcevaGenerateUrlByVimeoId( $id ) {
	return 'https://player.vimeo.com/video/' . $id;
}

function mpcevaGenerateUrlByYoutubeId( $id ) {
	return 'https://youtube.com/watch?v=' . $id;
}
