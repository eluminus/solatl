<?php

add_action('mpce_add_simple_shortcode', 'mpcevaAddSimpleShortcode');

function mpcevaAddSimpleShortcode() {
	add_shortcode('mpceva_video_lightbox', 'mpcevaVideoLightboxShortcodeSimple');
	add_shortcode('mpceva_video_slider', 'mpcevaVideoSliderShortcodeSimple');
	add_shortcode('mpceva_video', 'mpcevaVideoShortcodeSimple');
}

function mpcevaVideoLightboxShortcodeSimple($atts) {
	extract(shortcode_atts(array(
		'video_type' => 'youtube',
		'video_link_youtube' => '',
		'video_link_vimeo' => '',
		'video_mp4' => '',
		'video_webm' => '',
		'video_ogg' => '',
		'video_preview_image' => '',
		'video_description' => ''
	), $atts));

	$result = '';

	switch ($video_type) {
		case 'youtube':
			$video_id = mpcevaGetIdByYoutubeUrl($video_link_youtube);
			$video_src = mpcevaGenerateUrlByYoutubeId($video_id);
			if ($video_src) {
				$video_src = esc_url_raw($video_src);
				$result .= "[embed]{$video_src}[/embed]";
			}
			break;

		case 'vimeo':
			$video_id = mpcevaGetIdByVimeoUrl($video_link_vimeo);
			$video_src = mpcevaGenerateUrlByVimeoId($video_id);
			if ($video_src) {
				$video_src = esc_url_raw($video_src);
				$result .= "[embed]{$video_src}[/embed]";
			}
			break;

		case 'html5':
			$imageSrc = '';
			if (!empty($video_preview_image)) {
				$imageAttrs = wp_get_attachment_image_src($video_preview_image, 'full');
				$imageSrc = $imageAttrs && isset($imageAttrs[0]) ? $imageAttrs[0] : '';
			}

			$result .= '[video';
			if (!empty($video_mp4))     $result .= ' mp4="' . $video_mp4 . '"';
			if (!empty($video_webm))    $result .= ' webm="' . $video_webm . '"';
			if (!empty($video_ogg))     $result .= ' ogv="' . $video_ogg . '"';
			if (!empty($imageSrc))      $result .= ' poster="' . $imageSrc . '"';
			$result .= ']';
			break;
	}

	if ($video_description) {
		$result .= '<p>' . base64_decode($video_description) . '</p>';
	}

	return $result;
}


function mpcevaVideoSliderShortcodeSimple($atts, $content = null) {
	return do_shortcode($content);
}

function mpcevaVideoShortcodeSimple($atts, $content = null) {
	extract(shortcode_atts(array(
		'video_type' => 'youtube',
		'video_link_youtube' => '',
		'video_link_vimeo' => '',
		'video_mp4' => '',
		'video_webm' => '',
		'video_ogg' => '',
		'image' => '',
		'size' => 'full'
	), $atts));

	$result = '';

	switch ($video_type) {
		case 'youtube':
			$video_id = mpcevaGetIdByYoutubeUrl($video_link_youtube);
			$video_src = mpcevaGenerateUrlByYoutubeId($video_id);
			if ($video_src) {
				$video_src = esc_url_raw($video_src);
				$result .= "[embed]{$video_src}[/embed]";
			}
			break;

		case 'vimeo':
			$video_id = mpcevaGetIdByVimeoUrl($video_link_vimeo);
			$video_src = mpcevaGenerateUrlByVimeoId($video_id);
			if ($video_src) {
				$video_src = esc_url_raw($video_src);
				$result .= "[embed]{$video_src}[/embed]";
			}
			break;

		case 'html5':
			$result .= '[video';
			if (!empty($video_mp4))     $result .= ' mp4="' . $video_mp4 . '"';
			if (!empty($video_webm))    $result .= ' webm="' . $video_webm . '"';
			if (!empty($video_ogg))     $result .= ' ogv="' . $video_ogg . '"';
			$result .= ']';
			break;

		case 'image':
			if (isset($image) && !empty($image)) {
				$id = (int)$image;
				$attachment = get_post($id);

				if (!empty($attachment) && $attachment->post_type === 'attachment') {
					if (wp_attachment_is_image($id)) {
						require_once ABSPATH . '/wp-admin/includes/media.php';

						$title = esc_attr($attachment->post_title);
						$alt = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
						empty($alt) && ($alt = trim(strip_tags($attachment->post_excerpt)));
						empty($alt) && ($alt = trim(strip_tags($attachment->post_title)));

						$size = $size === 'custom' ? 'full' : $size;

						$linkArr = wp_get_attachment_image_src($id, 'full');
						$link = $linkArr[0];

						$result .= get_image_send_to_editor($id, '', $title, 'left', $link, false, $size, $alt);
					}
				}
			}
			break;
	}

	return $result;
}
