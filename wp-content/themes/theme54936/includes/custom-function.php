<?php
	// Loads child theme textdomain
	load_child_theme_textdomain( CURRENT_THEME, CHILD_DIR . '/languages' );

	// Loads custom scripts.
    require_once( 'custom-js.php' );

    add_filter( 'cherry_stickmenu_selector', 'cherry_change_selector' );
    function cherry_change_selector($selector) {
        $selector = 'header .stuck_wrapper';
        return $selector;
    }


/**
 * Service Box
 *
 */
if (!function_exists('service_box_shortcode')) {

    function service_box_shortcode( $atts, $content = null, $shortcodename = '' ) {
        extract(shortcode_atts(
            array(
                'title'        => '',
                'subtitle'     => '',
                'icon'         => '',
                'icon_link'    => '',
                'text'         => '',
                'btn_text'     => __('Read more', CHERRY_PLUGIN_DOMAIN),
                'btn_link'     => '',
                'btn_size'     => '',
                'target'       => '',
                'custom_class' => '',
        ), $atts));

        $output =  '<div class="service-box '.$custom_class.' '.$icon.'">';

        if($icon != 'no'){
            $icon_url = CHERRY_PLUGIN_URL . 'includes/images/' . strtolower($icon) . '.png' ;
            if( defined ('CHILD_DIR') ) {
                if(file_exists(CHILD_DIR.'/images/'.strtolower($icon).'.png')){
                    $icon_url = CHILD_URL.'/images/'.strtolower($icon).'.png';
                }
            }
            if ( empty( $icon_link ) ) {
                $output .= '<figure class="icon"><img src="'.$icon_url.'" alt="" /></figure>';
            } else {
                $output .= '<figure class="icon"><a href="' . esc_url( $icon_link ) . '"><img src="' . $icon_url . '" alt="" /></a></figure>';
            }
        }

        $output .= '<div class="service-box_body">';

        if ($title!="") {
            $output .= '<h3 class="title">';
            $output .= $title;
            $output .= '</h3>';
        }
        if ($subtitle!="") {
            $output .= '<h5 class="sub-title">';
            $output .= $subtitle;
            $output .= '</h5>';
        }
        if ($text!="") {
            $output .= '<div class="service-box_txt">';
            $output .= $text;
            $output .= '</div>';
        }
        if ($btn_link!="") {
            $output .=  '<div class="btn-align"><a href="'.$btn_link.'" title="'.$btn_text.'" class="btn btn-inverse btn-'.$btn_size.' btn-primary " target="'.$target.'">';
            $output .= $btn_text;
            $output .= '</a></div>';
        }
        $output .= '</div>';
        $output .= '</div><!-- /Service Box -->';

        $output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

        return $output;
    }
    add_shortcode('service_box', 'service_box_shortcode');
}


    /**
     * Isotope view
     *
     */

    if ( !function_exists('shortcode_isotope_view') ) {
        function shortcode_isotope_view( $args ) {

            extract( shortcode_atts( array(
                'post_type'         => 'post',
                'posts_count'       => 'all',
                'columns'           => 3,
                'filter'            => 'false',
                'filter_all_title'  => 'All',
                'fullwidth'         => 'false',
                'layout'            => 'masonry',
                'thumb_width'       => 750,
                'thumb_height'      => 0,
                'excerpt_count'     => 0,
                'more_btn'          => '',
                'custom_class'      => ''
            ), $args) );

            $rand_id = uniqid();
            $terms_category = $post_type == 'post' ? 'category' : $post_type . '_category';
            $posts_count = strval($posts_count) == 'all' ? -1 : intval( $posts_count );
            $excerpt_count = strval($excerpt_count) == 'all' ? -1 :  $excerpt_count;

            $fullwidth_class = '';    
            if($fullwidth == 'true') $fullwidth_class = " fullwidth-object";

            $output = '<div id="isotopeview-shortcode-' .$rand_id. '" class="isotopeview-shortcode'.$fullwidth_class.' '.$custom_class.'">';

                if($filter == 'true'){
                    $output .= '<div class="isotopeview_filter_buttons">';
                        $output .= '<div class="filter_button current-category" data-filter="*">'. $filter_all_title .'</div>';
                        $terms = get_terms($terms_category);
                        foreach ( $terms as $term ) {
                            $output .= '<div class="filter_button" data-filter="'.$term->slug.'">'.$term->name.'</div>';
                        }
                    $output .= '</div>';
                }


                // WP_Query arguments
                $args = array(
                    'posts_per_page'      => $posts_count,
                    'post_type'           => $post_type
                );

                // The Query
                $isotopeview_query = new WP_Query( $args );

                $output .= '<div class="isotopeview_wrapper" data-columns="'.$columns.'">';
                    if ( $isotopeview_query->have_posts()) :
                        $index = 1;
                        while ( $isotopeview_query->have_posts() ) : $isotopeview_query->the_post();
                            $post_id = $isotopeview_query->post->ID;

                            $post_categories =  wp_get_post_terms( $post_id, $terms_category );
                            $post_categories_slug = '';

                            $portfolioPostFormat = get_post_meta($post_id, 'tz_portfolio_type', true);
                            $blogPostFormat = get_post_format( $post_id );
                            $prettyType ="isotopeViewPrettyPhoto";

                            if (($blogPostFormat='gallery') || ($portfolioPostFormat == 'Slideshow') || ($portfolioPostFormat == 'Grid Gallery'))
                                $prettyType = "isotopeViewPrettyPhoto[gallery".$index."]";

                            foreach($post_categories as $c){
                                $post_categories_slug .= ' ' .$c->slug;
                            }

                            if ( has_post_thumbnail( $post_id ) ) {
                                $output .= '<div class="isotopeview-item isotopeview-item-'.$index.' '.$post_categories_slug.'">';
                                    $output .= '<div class="inn_wrapper">';
                                    $output .= '<figure class="thumbnail">';
                                        $attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
                                        $url            = $attachment_url['0'];
                                        $image          = aq_resize($url, $thumb_width, $thumb_height, true);

                                        $output .= '<a rel="'.$prettyType.'" href="' .  $url . '" title="' . esc_html( get_the_title( $post_id ) ) . '" >';
                                            $output .= '<img src="'.$image.'" alt="" />';
                                        $output .= '</a>';
                                    $output .= '</figure>';

                                    if (($blogPostFormat='gallery') || ($portfolioPostFormat == 'Slideshow') || ($portfolioPostFormat == 'Grid Gallery')) {
                                        $images = get_children( array(
                                            'orderby'        => 'menu_order',
                                            'order'          => 'ASC',
                                            'post_type'      => 'attachment',
                                            'post_parent'    => $post_id,
                                            'post_mime_type' => 'image',
                                            'post_status'    => null,
                                            'numberposts'    => -1
                                        ));

                                        if ( $images ) {
                                            foreach ( $images as $attachment_id => $attachment ) {
                                                $image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' ); // returns an array
                                                $image            = aq_resize( $image_attributes[0], $image_size['width'], $image_size['height'], true );
                                                $image_title      = $attachment->post_title;
                                                $link_href = $image_attributes[0];

                                                $output .= '<a href="'.$link_href.'"  style="display:none" rel="'.$prettyType.'"></a>';
                                            }
                                        }
                                    }

                                    $output .= '<div class="isotopeview-item-content" style="position: absolute;">';
                                        $output .= postTitleBuilder($post_id);
                                        $output .= postExcerptBuilder($post_id, $excerpt_count);
                                        $output .= postMoreLinkBuilder($post_id, $more_btn);
                                    $output .= '</div>';
                                $output .= '</div>';
                                $output .= '</div>';

                                $index++;
                            }
                        endwhile;
                    endif;
                $output .= '</div>';

            $output .= '</div>';

            $output .= '<script type="text/javascript">
                            jQuery(document).ready(function($) {
                                $("#isotopeview-shortcode-' .$rand_id. '").cherryIsotopeView({
                                    columns    : '. $columns .',
                                    fullwidth  : '. $fullwidth .',
                                    layout     : "'. $layout .'"
                                });
                            });
                        </script>';

            wp_reset_postdata();

            return $output;
        }
        add_shortcode( 'isotope_view', 'shortcode_isotope_view' );
    }

    // Title builder
    function postTitleBuilder($postID){
        $output = '';
        $post_title      = esc_html( get_the_title( $postID ) );
        $post_title_attr = esc_attr( strip_tags( get_the_title( $postID ) ) );
        if ( !empty($post_title{0}) ) {
            $output .= '<h5><a href="' . getPostPermalink($postID) . '" title="' . $post_title_attr . '">';
                $output .= $post_title;
            $output .= '</a></h5>';
        }
        return $output;
    }

    // Excerpt builder
    function postExcerptBuilder($postID, $excerpt_count){
        if($excerpt_count != 0){
            $output = '';

            if ( has_excerpt($postID) ) {
                $excerpt = wp_strip_all_tags( get_the_excerpt() );
            } else {
                $excerpt = wp_strip_all_tags( strip_shortcodes (get_the_content() ) );
            }

            if ( !empty($excerpt{0}) ) {
                $output .= $excerpt_count == -1 ? '<p class="excerpt">' . $excerpt . '</p>' : '<p class="excerpt">' . my_string_limit_words( $excerpt, $excerpt_count ) . '</p>';
            }

            return $output;
        }
    }

    // Link builder
    function postMoreLinkBuilder($postID, $linkText){
        $resultDOM = '';
        $linkText = esc_html( wp_kses_data( $linkText ) );
        $post_title_attr = esc_attr( strip_tags( get_the_title( $postID ) ) );
            if ( $linkText != '' ) {
                $resultDOM .= '<a href="' . get_permalink( $postID ) . '" class="" title="' . $post_title_attr . '">';
                    $resultDOM .= __( $linkText, CHERRY_PLUGIN_DOMAIN );
                $resultDOM .= '</a>';
            }
        return $resultDOM;
    }


    // get post's permalink
    function getPostPermalink($postID){
        if ( get_post_meta( $postID, 'tz_link_url', true ) ) {
            $post_permalink = ( $format == 'format-link' ) ? esc_url( get_post_meta( $postID, 'tz_link_url', true ) ) : get_permalink( $postID );
        } else {
            $post_permalink = get_permalink( $postID );
        }
        return $post_permalink;
    }
// Extra Wrap
if (!function_exists('extra_wrap_shortcode')) {
    function extra_wrap_shortcode( $atts, $content = null, $shortcodename = '' ) {
        extract(shortcode_atts(array(
            'custom_class'  => ''
        ), $atts));
        $output = '<div class="extra-wrap '.$custom_class.'">';
            $output .= do_shortcode($content);
        $output .= '</div>';

        $output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

        return $output;
    }
    add_shortcode('extra_wrap', 'extra_wrap_shortcode');
}


//Recent Testimonials
if (!function_exists('shortcode_recenttesti')) {

    function shortcode_recenttesti( $atts, $content = null, $shortcodename = '' ) {
        extract(shortcode_atts(array(
                'num'           => '5',
                'thumb'         => 'true',
                'excerpt_count' => '30',
                'custom_class'  => '',
        ), $atts));

        // WPML filter
        $suppress_filters = get_option('suppress_filters');

        $args = array(
                'post_type'        => 'testi',
                'numberposts'      => $num,
                'orderby'          => 'post_date',
                'suppress_filters' => $suppress_filters
            );
        $testi = get_posts($args);

        $itemcounter = 0;

        $output = '<div class="testimonials '.$custom_class.'">';

        global $post;
        global $my_string_limit_words;

        foreach ($testi as $k => $post) {
            //Check if WPML is activated
            if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
                global $sitepress;

                $post_lang = $sitepress->get_language_for_element($post->ID, 'post_testi');
                $curr_lang = $sitepress->get_current_language();
                // Unset not translated posts
                if ( $post_lang != $curr_lang ) {
                    unset( $testi[$k] );
                }
                // Post ID is different in a second language Solution
                if ( function_exists( 'icl_object_id' ) ) {
                    $post = get_post( icl_object_id( $post->ID, 'testi', true ) );
                }
            }
            setup_postdata( $post );
            $post_id = $post->ID;
            $excerpt = get_the_excerpt();

            // Get custom metabox value.
            $testiname  = get_post_meta( $post_id, 'my_testi_caption', true );
            $testiurl   = esc_url( get_post_meta( $post_id, 'my_testi_url', true ) );
            $testiinfo  = get_post_meta( $post_id, 'my_testi_info', true );
            $testiemail = sanitize_email( get_post_meta( $post_id, 'my_testi_email', true ) );

            $attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
            $url            = $attachment_url['0'];
            $image          = aq_resize($url, 66, 66, true);

            $output .= '<div class="testi-item list-item-'.$itemcounter.'">';
                $output .= '<blockquote class="testi-item_blockquote">';
                if ( !empty( $testiname ) ) {
                        $output .= '<span class="user">';
                            $output .= $testiname;
                        $output .= '</span>';
                    }

                    $output .= '<p><a href="'.get_permalink( $post_id ).'">';
                        $output .= wp_trim_words($excerpt,$excerpt_count);
                    $output .= '</a></p><div class="clear"></div>';

                $output .= '</blockquote>';


                $output .= '</small>';
                if ($thumb == 'true') {
                    if ( has_post_thumbnail( $post_id ) ){
                        $output .= '<figure class="featured-thumbnail">';
                        $output .= '<img src="'.$image.'" alt="" />';
                        $output .= '</figure>';
                    }
                }

            $output .= '</div>';
            $itemcounter++;

        }
        wp_reset_postdata(); // restore the global $post variable
        $output .= '</div>';

        $output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

        return $output;
    }
    add_shortcode('recenttesti', 'shortcode_recenttesti');

}

// Horizontal Rule
if (!function_exists('hr_shortcode')) {
    function hr_shortcode( $atts, $content = null, $shortcodename = '' ) {
        extract(shortcode_atts(array(
            'custom_class'  => ''
        ), $atts));

        $output = '<div class="hr '.$custom_class.'"></div><!-- .hr (end) -->';

        $output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

        return $output;
    }
    add_shortcode('hr', 'hr_shortcode');
}

// Extra Wrap
if (!function_exists('extra_wrap_shortcode')) {
    function extra_wrap_shortcode( $atts, $content = null, $shortcodename = '' ) {
        extract(shortcode_atts(array(
            'custom_class'  => ''
        ), $atts));
        $output = '<div class="extra-wrap '.$custom_class.'">';
            $output .= do_shortcode($content);
        $output .= '</div>';

        $output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

        return $output;
    }
    add_shortcode('extra_wrap', 'extra_wrap_shortcode');
}


/**
 * Banner
 *
 */
if ( !function_exists( 'banner_shortcode' ) ) {

    function banner_shortcode( $atts, $content = null, $shortcodename = '' ) {
        extract( shortcode_atts(
            array(
                'img'          => '',
                'banner_link'  => '',
                'title'        => '',
                'text'         => '',
                'btn_text'     => '',
                'target'       => '',
                'custom_class' => ''
        ), $atts));

        $uploads          = wp_upload_dir();
        $uploads_dir_name = end( ( explode( '/', $uploads['baseurl'] ) ) );

        $img_path = explode( 'uploads', $img );
        if ( 1 == count( $img_path ) ) {
            $img_path = explode( $uploads_dir_name, $img );
        }
        $_img = end( $img_path );

        if ( 1 < count( $img_path ) ) {
            $img = $uploads['baseurl'] . $_img;
        }

        $output =  '<div class="banner-wrap '.$custom_class.'">';
        if ($img !="") {
            $output .= '<figure class="featured-thumbnail">';
            if ($banner_link != "") {
                $output .= '<a href="'. $banner_link .'" title="'. $title .'"><img src="'.CHILD_URL.'/images/' . $img .'" title="'. $title .'" alt="" /></a>';
            } else {
                $output .= '<img src="'.CHILD_URL.'/images/' . $img .'" title="'. $title .'" alt="" />';
            }
            $output .= '</figure>';
        }
        if ($title!="") {
            $output .= '<h3>';
            $output .= $title;
            $output .= '</h3>';
        }
        if ($text!="") {
            $output .= '<p>';
            $output .= $text;
            $output .= '</p>';
        }
        if ($btn_text!="") {
            $output .=  '<div class="link-align banner-btn"><a href="'.$banner_link.'" title="'.$btn_text.'" class="btn btn-link" target="'.$target.'">';
            $output .= $btn_text;
            $output .= '</a></div>';
        }
        $output .= '</div><!-- .banner-wrap (end) -->';

        $output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

        return $output;
    }
    add_shortcode('banner', 'banner_shortcode');

}

//------------------------------------------------------
//  Related Posts
//------------------------------------------------------
    if(!function_exists('cherry_related_posts')){
        function cherry_related_posts($args = array()){
            global $post;
            $default = array(
                'post_type' => get_post_type($post),
                'class' => 'related-posts',
                'class_list' => 'related-posts_list',
                'class_list_item' => 'related-posts_item',
                'display_title' => true,
                'display_link' => true,
                'display_thumbnail' => true,
                'width_thumbnail' => 170,
                'height_thumbnail' => 170,
                'before_title' => '<h2 class="related-posts_h">',
                'after_title' => '</h2>',
                'posts_count' => 4
            );
            extract(array_merge($default, $args));

            $post_tags = wp_get_post_terms($post->ID, $post_type.'_tag', array("fields" => "slugs"));
            $tags_type = $post_type=='post' ? 'tag' : $post_type.'_tag' ;
            $suppress_filters = get_option('suppress_filters');// WPML filter
            $blog_related = apply_filters( 'cherry_text_translate', of_get_option('blog_related'), 'blog_related' );
            if ($post_tags && !is_wp_error($post_tags)) {
                $args = array(
                    "$tags_type" => implode(',', $post_tags),
                    'post_status' => 'publish',
                    'posts_per_page' => $posts_count,
                    'ignore_sticky_posts' => 1,
                    'post__not_in' => array($post->ID),
                    'post_type' => $post_type,
                    'suppress_filters' => $suppress_filters
                    );
                query_posts($args);
                if ( have_posts() ) {
                    $output = '<div class="'.$class.'">';
                    $output .= $display_title ? $before_title.$blog_related.$after_title : '' ;
                    $output .= '<ul class="'.$class_list.' clearfix">';
                    while( have_posts() ) {
                        the_post();
                        $thumb   = has_post_thumbnail() ? get_post_thumbnail_id() : PARENT_URL.'/images/empty_thumb.gif';
                        $blank_img = stripos($thumb, 'empty_thumb.gif');
                        $img_url = $blank_img ? $thumb : wp_get_attachment_url( $thumb,'full');
                        $image   = $blank_img ? $thumb : aq_resize($img_url, $width_thumbnail, $height_thumbnail, true) or $img_url;
                        $excerpt        = get_the_excerpt();

                        $output .= '<li class="'.$class_list_item.'">';
                        $output .= $display_thumbnail ? '<figure class="thumbnail featured-thumbnail"><a href="'.get_permalink().'" title="'.get_the_title().'"><img data-src="'.$image.'" alt="'.get_the_title().'" /></a></figure>': '' ;
                        // $output .= $display_link ? '<p><a href="'.get_permalink().'" >'.my_string_limit_words($excerpt, 10);.'</a></p>': '' ;
                        $output .= my_string_limit_words($excerpt, 4);
                        $output .= '</li>';
                    }
                    $output .= '</ul></div>';
                    echo $output;
                }
                wp_reset_query();
            }
        }
    }

/*-----------------------------------------------------------------------------------*/
/* Custom Comments Structure
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'mytheme_comment' ) ) {
    function mytheme_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
            <div class="wrapper">
                <div class="comment-author vcard">
                    <?php echo get_avatar( $comment->comment_author_email, 82 ); ?>
                    <?php printf('<span class="author">%1$s</span>', get_comment_author_link()) ?>
                </div>
                <?php if ($comment->comment_approved == '0') : ?>
                    <em><?php echo theme_locals("your_comment") ?></em>
                <?php endif; ?>
                <div class="extra-wrap">
                    <?php comment_text() ?>                
                    <div class="wrapper comment_bot">
                        <h3>
                        
                        <div class="comment_meta"><?php printf('%1$s', get_comment_date()) ?></div>
                        <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                        </h3>
                    </div>
                </div>
            </div>           
        </div>
<?php }
}
?>