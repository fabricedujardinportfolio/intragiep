<?php
/*
Plugin Name: Fabrice Register Custom Post Types 
Description: Plugin to register the DOCUMENT post type for GIEP Documents
Version: 1.0
Author: Fabrice DUJARDIN
Author URI:fabricedujardinportfolio.github.io
Textdomain: GIEP
*/

add_action( 'init', 'fabrice_register_post_type' );
function fabrice_register_post_type() {
	$labels = [
		'name'                     => esc_html__( 'DOCUMENTS', 'GIEP' ),
		'singular_name'            => esc_html__( 'DOCUMENT', 'GIEP' ),
		'add_new'                  => esc_html__( 'Add New', 'GIEP' ),
		'add_new_item'             => esc_html__( 'Add new document', 'GIEP' ),
		'edit_item'                => esc_html__( 'Edit DOCUMENT', 'GIEP' ),
		'new_item'                 => esc_html__( 'New DOCUMENT', 'GIEP' ),
		'view_item'                => esc_html__( 'View DOCUMENT', 'GIEP' ),
		'view_items'               => esc_html__( 'View DOCUMENTS', 'GIEP' ),
		'search_items'             => esc_html__( 'Search DOCUMENTS', 'GIEP' ),
		'not_found'                => esc_html__( 'No documents found', 'GIEP' ),
		'not_found_in_trash'       => esc_html__( 'No documents found in Trash', 'GIEP' ),
		'parent_item_colon'        => esc_html__( 'Parent DOCUMENT:', 'GIEP' ),
		'all_items'                => esc_html__( 'All DOCUMENTS', 'GIEP' ),
		'archives'                 => esc_html__( 'DOCUMENT Archives', 'GIEP' ),
		'attributes'               => esc_html__( 'DOCUMENT Attributes', 'GIEP' ),
		'insert_into_item'         => esc_html__( 'Insert into document', 'GIEP' ),
		'uploaded_to_this_item'    => esc_html__( 'Uploaded to this document', 'GIEP' ),
		'featured_image'           => esc_html__( 'Featured image', 'GIEP' ),
		'set_featured_image'       => esc_html__( 'Set featured image', 'GIEP' ),
		'remove_featured_image'    => esc_html__( 'Remove featured image', 'GIEP' ),
		'use_featured_image'       => esc_html__( 'Use as featured image', 'GIEP' ),
		'menu_name'                => esc_html__( 'DOCUMENTS', 'GIEP' ),
		'filter_items_list'        => esc_html__( 'Filter documents list', 'GIEP' ),
		'items_list_navigation'    => esc_html__( 'Documents list navigation', 'GIEP' ),
		'items_list'               => esc_html__( 'DOCUMENTS list', 'GIEP' ),
		'item_published'           => esc_html__( 'DOCUMENT published', 'GIEP' ),
		'item_published_privately' => esc_html__( 'Document published privately', 'GIEP' ),
		'item_reverted_to_draft'   => esc_html__( 'Document reverted to draft', 'GIEP' ),
		'item_scheduled'           => esc_html__( 'DOCUMENT scheduled', 'GIEP' ),
		'item_updated'             => esc_html__( 'DOCUMENT updated', 'GIEP' ),
		'text_domain'              => esc_html__( 'GIEP', 'GIEP' ),
	];
	$args = [
		'label'               => esc_html__( 'DOCUMENTS', 'GIEP' ),
		'labels'              => $labels,
		'description'         => '',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'menu_position'       => 20,
		'query_var'           => true,
		'can_export'          => true,
		'delete_with_user'    => true,
		'has_archive'         => true,
		'rest_base'           => '',
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-portfolio',
		'capability_type'     => 'post',
		'supports'            => ['title', 'editor', 'thumbnail', 'page-attributes', 'post-formats', 'author', 'excerpt'],
		'taxonomies'          => ['category', 'post_tag', 'post_format', 'bsf_custom_fonts'],
		'rewrite'             => [
			'with_front' => false,
		],
	];

	register_post_type( 'document', $args );
}