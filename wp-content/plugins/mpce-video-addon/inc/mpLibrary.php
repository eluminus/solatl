<?php
if (!defined('ABSPATH')) exit;

function mpcevaLibrary( $mpceLibrary ) {
	$videoLightboxObj = new MPCEObject('mpceva_video_lightbox', __('Video Lightbox', 'mpce-video-addon'), 'plugins/' . MPCE_VIDEO_ADDON_PLUGIN_SYMLINK_DIR_NAME . '/assets/images/video-lightbox.png', array(
		'video_type' => array(
			'type' => 'radio-buttons',
			'label' => __('Source:', 'mpce-video-addon'),
			'description' => '',
			'default' => 'youtube',
			'list' => array(
				'youtube' => 'Youtube',
				'vimeo' => 'Vimeo',
				'html5' => 'HTML5',
			)
		),
		'video_link_youtube' => array(
			'type' => 'text',
			'label' => __('Video URL', 'mpce-video-addon'),
			'description' => '',
			'default' => 'https://www.youtube.com/watch?v=t0jFJmTDqno',
			'dependency' => array(
				'parameter' => 'video_type',
				'value' => 'youtube'
			)
		),
		'video_link_vimeo' => array(
			'type' => 'text',
			'label' => __('Video URL', 'mpce-video-addon'),
			'description' => '',
			'default' => 'https://vimeo.com/74700415',
			'dependency' => array(
				'parameter' => 'video_type',
				'value' => 'vimeo'
			)
		),
		'video_mp4' => array(
			'type' => 'media-video',
			'label' => __('Video Source MP4', 'mpce-video-addon'),
			'description' => '',
			'dependency' => array(
				'parameter' => 'video_type',
				'value' => 'html5'
			)
		),
		'video_webm' => array(
			'type' => 'media-video',
			'label' => __('Video Source WEBM', 'mpce-video-addon'),
			'description' => '',
			'dependency' => array(
				'parameter' => 'video_type',
				'value' => 'html5'
			)
		),
		'video_ogg' => array(
			'type' => 'media-video',
			'label' => __('Video Source OGG', 'mpce-video-addon'),
			'description' => '',
			'dependency' => array(
				'parameter' => 'video_type',
				'value' => 'html5'
			)
		),
		'video_preview_image' => array(
                'type' => 'image',
                'label' =>  __('Custom thumbnail', 'mpce-video-addon'),
                'default' => '',
				'description' => __('Use this option to set a picture from the media library', 'mpce-video-addon'),
		),
		'video_description' => array(
			'type' => 'longtext64',
			'label' => __('Caption', 'mpce-video-addon'),
			'description' => '',
		),
	), 91, MPCEObject::ENCLOSED, MPCEObject::RESIZE_HORIZONTAL);
	
	$videoLightboxStyles =array(
		'mp_style_classes' => array(
			'basic' => array(
				'class' => 'mpceva-lightbox',
				'label' => __('Lightbox', 'mpce-video-addon')
			),
			'predefined' => array(
				'bordered' => array(
					'label' => __('Border', 'mpce-video-addon'),
					'values' => array(
						'bordered' => array(
							'class' => 'mpceva-lightbox-bordered',
							'label' => __('Bordered', 'mpce-video-addon')
						),
					),
				),
				'rounded-corners' => array(
					'label' =>__('Corners', 'mpce-video-addon'),
					'values' => array(
						'rounded-corners' => array(
							'class' => 'mpceva-lightbox-rounded-corners',
							'label' => __('Rounded corners', 'mpce-video-addon')
						),
					),
				),
				'play-btn' => array(
					'label' =>__('Play Button', 'mpce-video-addon'),
					'values' => array(
						'play-btn' => array(
							'class' => 'mpceva-lightbox-play-btn',
							'label' => __('Play button', 'mpce-video-addon')
						),
					),
				),
				'overlay' => array(
					'label' =>__('Overlay', 'mpce-video-addon'),
					'values' => array(
						'overlay' => array(
							'class' => 'mpceva-lightbox-overlay',
							'label' => __('Overlay', 'mpce-video-addon')
						),
					),
				),
			),
			'default' => array('mpceva-lightbox-bordered', 'mpceva-lightbox-rounded-corners', 'mpceva-lightbox-play-btn', 'mpceva-lightbox-overlay'),
			'selector' => ''
		),
		
	);
	
	$videoLightboxObj->addStyle($videoLightboxStyles);
	
	$videoObj = new MPCEObject('mpceva_video', __('Video', 'mpce-video-addon'), null, array(
		 'video_type' => array(
			'type' => 'radio-buttons',
			'label' => __('Source:', 'mpce-video-addon'),
			'description' => '',
			'default' => 'youtube',
			'list' => array(
				'youtube' => 'Youtube',
				'vimeo' => 'Vimeo',
				'html5' => 'HTML5',
				'image' => 'Image'
			)
		),
		'video_link_youtube' => array(
			'type' => 'text',
			'label' => __('Video URL', 'mpce-video-addon'),
			'description' => '',
			'default' => 'https://www.youtube.com/watch?v=t0jFJmTDqno',
			'dependency' => array(
				'parameter' => 'video_type',
				'value' => 'youtube'
			)
		),
		'video_link_vimeo' => array(
			'type' => 'text',
			'label' => __('Video URL', 'mpce-video-addon'),
			'description' => '',
			'default' => 'https://vimeo.com/74700415',
			'dependency' => array(
				'parameter' => 'video_type',
				'value' => 'vimeo'
			)
		),
		'video_mp4' => array(
			'type' => 'media-video',
			'label' => __('Video Source MP4', 'mpce-video-addon'),
			'description' => '',
			'dependency' => array(
				'parameter' => 'video_type',
				'value' => 'html5'
			)
		),
		'video_webm' => array(
			'type' => 'media-video',
			'label' => __('Video Source WEBM', 'mpce-video-addon'),
			'description' => '',
			'dependency' => array(
				'parameter' => 'video_type',
				'value' => 'html5'
			)
		),
		'video_ogg' => array(
			'type' => 'media-video',
			'label' => __('Video Source OGG', 'mpce-video-addon'),
			'description' => '',
			'dependency' => array(
				'parameter' => 'video_type',
				'value' => 'html5'
			)
		),
		'image' => array(
                'type' => 'image',
                'label' => __('Select Image', 'mpce-video-addon'),
                'default' => '',
                'description' => '',
                'autoOpen' => 'false',
				'dependency' => array(
					'parameter' => 'video_type',
					'value' => 'image'
				),
            ),
		'size' => array(
                'type' => 'radio-buttons',
                'label' => __('Image size', 'mpce-video-addon'),
                'default' => 'full',
                'list' => array(
                    'full' => __('Full', 'mpce-video-addon'),
                    'large' => __('Large', 'mpce-video-addon'),
                    'medium' => __('Medium', 'mpce-video-addon'),
                    'thumbnail' => __('Thumbnail', 'mpce-video-addon'),
                    'custom' => __('Custom', 'mpce-video-addon'),
                ),
				'dependency' => array(
					'parameter' => 'video_type',
					'value' => 'image'
				),
            ),
            'custom_size' => array(
                'type' => 'text',
                'description' => __('Enter image size in pixels, ex. 200x100 (Width x Height)', 'mpce-video-addon'),
                'dependency' => array(
                    'parameter' => 'size',
                    'value' => 'custom'
                ),
            ),
	), null, MPCEObject::ENCLOSED, MPCEObject::RESIZE_NONE, false); 
	
	$videoSliderObj = new MPCEObject('mpceva_video_slider', __('Video Slider', 'mpce-video-addon'), 'plugins/' . MPCE_VIDEO_ADDON_PLUGIN_SYMLINK_DIR_NAME . '/assets/images/video-slider.png', array(
		'elements' => array(
            'type' => 'group',
            'contains' => 'mpceva_video',
            'items' => array(
                'label' => array(
                    'default' => __('Video', 'mpce-video-addon'),
                    'parameter' => 'video_type'
                ),
                'count' => 2
            ),
            'text' => __('Add Media', 'mpce-video-addon'),
            'disabled' => 'false'
        ),
		'autoplay' => array(
			'type' => 'checkbox',
			'label' => __('Autoplay video', 'mpce-video-addon'),
			'default' => 'false',
			'description' => ''
		),
		'slideshow' => array(
			'type' => 'checkbox',
			'label' => __('Enable slideshow', 'mpce-video-addon'),
			'default' => 'false',
			'description' => ''
		),
		'slideshow_speed' => array(
			'type' => 'spinner',
			'label' => __('Slideshow speed in seconds', 'mpce-video-addon'),
			'default' => 10,
			'min' => 1,
			'max' => 25,
			'step' => 1,
			'dependency' => array(
				'parameter' => 'slideshow',
				'value' => 'true'
			)
		),
	), 92, MPCEObject::ENCLOSED, MPCEObject::RESIZE_HORIZONTAL);
	
	$videoSliderStyles =array(
		'mp_style_classes' => array(
			'basic' => array(
				'class' => 'mpceva-slider',
				'label' => __('Slider', 'mpce-video-addon')
			),
		)
	);	
	$videoSliderObj->addStyle($videoSliderStyles);
	
	$mpceLibrary->addObject($videoLightboxObj, MPCEShortcode::PREFIX . 'media');
	$mpceLibrary->addObject($videoSliderObj, MPCEShortcode::PREFIX . 'media');
	$mpceLibrary->addObject($videoObj, MPCEShortcode::PREFIX . 'media');
}
add_action('mp_library', 'mpcevaLibrary', 11, 1);