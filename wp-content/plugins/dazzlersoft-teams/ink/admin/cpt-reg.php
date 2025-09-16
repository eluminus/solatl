<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$labels = array(
				'name'                => _x( 'Teams', 'Teams', dazzler_team_m_text_domain ),
				'singular_name'       => _x( 'Teams', 'Team', dazzler_team_m_text_domain ),
				'menu_name'           => __( 'Teams', dazzler_team_m_text_domain ),
				'parent_item_colon'   => __( 'Parent Item:', dazzler_team_m_text_domain ),
				'all_items'           => __( 'All Teams', dazzler_team_m_text_domain ),
				'view_item'           => __( 'View Teams', dazzler_team_m_text_domain ),
				'add_new_item'        => __( 'Add New Teams', dazzler_team_m_text_domain ),
				'add_new'             => __( 'Add New Teams', dazzler_team_m_text_domain ),
				'edit_item'           => __( 'Edit Teams', dazzler_team_m_text_domain ),
				'update_item'         => __( 'Update Teams', dazzler_team_m_text_domain ),
				'search_items'        => __( 'Search Teams', dazzler_team_m_text_domain ),
				'not_found'           => __( 'No Teams Found', dazzler_team_m_text_domain ),
				'not_found_in_trash'  => __( 'No Teams found in Trash', dazzler_team_m_text_domain ),
			);
			$args = array(
				'label'               => __( 'Teams', dazzler_team_m_text_domain ),
				'description'         => __( 'Teams', dazzler_team_m_text_domain ),
				'labels'              => $labels,
				'supports'            => array( 'title', '', '', '', '', '', '', '', '', '', '', ),
				//'taxonomies'          => array( 'category', 'post_tag' ),
				 'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => false,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-businessman',
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => false,
				'capability_type'     => 'page',
			);
			register_post_type( 'team_Member', $args );
			
 ?>