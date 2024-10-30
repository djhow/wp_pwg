<?php
// Custom posts for Golf Clubs, Golf Courses, Scorecards, Holes, Tournaments

function pwg_golfclub() {

	$labels = array(
		'name'                  => _x( 'Golf Clubs', 'Post Type General Name', 'pwg' ),
		'singular_name'         => _x( 'Golf Club', 'Post Type Singular Name', 'pwg' ),
		'menu_name'             => __( 'Golf Clubs', 'pwg' ),
		'name_admin_bar'        => __( 'Golf Club', 'pwg' ),
		'archives'              => __( 'Golf Club Archives', 'pwg' ),
		'attributes'            => __( 'Golf Club Attributes', 'pwg' ),
		'parent_item_colon'     => __( 'Parent Golf Club:', 'pwg' ),
		'all_items'             => __( 'All Golf Clubs', 'pwg' ),
		'add_new_item'          => __( 'Add New Golf Club', 'pwg' ),
		'add_new'               => __( 'Add New Golf Club', 'pwg' ),
		'new_item'              => __( 'New Golf Club', 'pwg' ),
		'edit_item'             => __( 'Edit Golf Club', 'pwg' ),
		'update_item'           => __( 'Update Golf Club', 'pwg' ),
		'view_item'             => __( 'View Golf Club', 'pwg' ),
		'view_items'            => __( 'View Golf Clubs', 'pwg' ),
		'search_items'          => __( 'Search Golf Club', 'pwg' ),
		'not_found'             => __( 'Golf Club Not found', 'pwg' ),
		'not_found_in_trash'    => __( 'Golf Club Not found in Trash', 'pwg' ),
		'featured_image'        => __( 'Golf Club Image', 'pwg' ),
		'set_featured_image'    => __( 'Set Golf Club image', 'pwg' ),
		'remove_featured_image' => __( 'Remove Golf Club image', 'pwg' ),
		'use_featured_image'    => __( 'Use as Golf Club image', 'pwg' ),
		'insert_into_item'      => __( 'Insert into Golf Club', 'pwg' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Golf Club', 'pwg' ),
		'items_list'            => __( 'Golf Clubs list', 'pwg' ),
		'items_list_navigation' => __( 'Golf Club list navigation', 'pwg' ),
		'filter_items_list'     => __( 'Filter Golf Club list', 'pwg' ),
	);
	$args = array(
		'label'                 => __( 'Golf Club', 'pwg' ),
		'description'           => __( 'Golf Club', 'pwg' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor','thumbnail','page-attributes' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'golfclubs',
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'golfclub', $args );

}
add_action( 'init', 'pwg_golfclub', 0 );

function pwg_golfcourse() {

	$labels = array(
		'name'                  => _x( 'Golf Courses', 'Post Type General Name', 'pwg' ),
		'singular_name'         => _x( 'Golf Course', 'Post Type Singular Name', 'pwg' ),
		'menu_name'             => __( 'Golf Courses', 'pwg' ),
		'name_admin_bar'        => __( 'Golf Course', 'pwg' ),
		'archives'              => __( 'Golf Course Archives', 'pwg' ),
		'attributes'            => __( 'Golf Course Attributes', 'pwg' ),
		'parent_item_colon'     => __( 'Parent Golf Course:', 'pwg' ),
		'all_items'             => __( 'All Golf Courses', 'pwg' ),
		'add_new_item'          => __( 'Add New Golf Course', 'pwg' ),
		'add_new'               => __( 'Add New Golf Course', 'pwg' ),
		'new_item'              => __( 'New Golf Course', 'pwg' ),
		'edit_item'             => __( 'Edit Golf Course', 'pwg' ),
		'update_item'           => __( 'Update Golf Course', 'pwg' ),
		'view_item'             => __( 'View Golf Course', 'pwg' ),
		'view_items'            => __( 'View Golf Courses', 'pwg' ),
		'search_items'          => __( 'Search Golf Course', 'pwg' ),
		'not_found'             => __( 'Golf Course Not found', 'pwg' ),
		'not_found_in_trash'    => __( 'Golf Course Not found in Trash', 'pwg' ),
		'featured_image'        => __( 'Golf Course Image', 'pwg' ),
		'set_featured_image'    => __( 'Set Golf Course image', 'pwg' ),
		'remove_featured_image' => __( 'Remove Golf Course image', 'pwg' ),
		'use_featured_image'    => __( 'Use as Golf Course image', 'pwg' ),
		'insert_into_item'      => __( 'Insert into Golf Course', 'pwg' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Golf Course', 'pwg' ),
		'items_list'            => __( 'Golf Courses list', 'pwg' ),
		'items_list_navigation' => __( 'Golf Course list navigation', 'pwg' ),
		'filter_items_list'     => __( 'Filter Golf Courses list', 'pwg' ),
	);
	$args = array(
		'label'                 => __( 'Golf Course', 'pwg' ),
		'description'           => __( 'Golf Course', 'pwg' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail','page-attributes' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'golfcourses',
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'golfcourse', $args );

}
add_action( 'init', 'pwg_golfcourse', 0 );

function pwg_scorecard() {

	$labels = array(
		'name'                  => _x( 'Scorecards', 'Post Type General Name', 'pwg' ),
		'singular_name'         => _x( 'Scorecard', 'Post Type Singular Name', 'pwg' ),
		'menu_name'             => __( 'Scorecards', 'pwg' ),
		'name_admin_bar'        => __( 'Scorecard', 'pwg' ),
		'archives'              => __( 'Scorecard Archives', 'pwg' ),
		'attributes'            => __( 'Scorecard Attributes', 'pwg' ),
		'parent_item_colon'     => __( 'Parent Item:', 'pwg' ),
		'all_items'             => __( 'All Scorecards', 'pwg' ),
		'add_new_item'          => __( 'Add New Scorecard', 'pwg' ),
		'add_new'               => __( 'Add New Scorecard', 'pwg' ),
		'new_item'              => __( 'New Scorecard', 'pwg' ),
		'edit_item'             => __( 'Edit Scorecard', 'pwg' ),
		'update_item'           => __( 'Update Scorecard', 'pwg' ),
		'view_item'             => __( 'View Scorecard', 'pwg' ),
		'view_items'            => __( 'View Scorecards', 'pwg' ),
		'search_items'          => __( 'Search Scorecard', 'pwg' ),
		'not_found'             => __( 'Scorecard Not found', 'pwg' ),
		'not_found_in_trash'    => __( 'Scorecard Not found in Trash', 'pwg' ),
		'featured_image'        => __( 'Scorecard Image', 'pwg' ),
		'set_featured_image'    => __( 'Set Scorecard image', 'pwg' ),
		'remove_featured_image' => __( 'Remove Scorecard image', 'pwg' ),
		'use_featured_image'    => __( 'Use as Scorecard image', 'pwg' ),
		'insert_into_item'      => __( 'Insert into Scorecard', 'pwg' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'pwg' ),
		'items_list'            => __( 'Scorecards list', 'pwg' ),
		'items_list_navigation' => __( 'Scorecards list navigation', 'pwg' ),
		'filter_items_list'     => __( 'Filter Scorecards list', 'pwg' ),
	);
	$args = array(
		'label'                 => __( 'Scorecard', 'pwg' ),
		'description'           => __( 'Golf Scorecard', 'pwg' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'scorecards',
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'scorecard', $args );

}
add_action( 'init', 'pwg_scorecard', 0 );


function pwg_holes() {

	$labels = array(
		'name'                  => _x( 'Holes', 'Post Type General Name', 'pwg' ),
		'singular_name'         => _x( 'Hole', 'Post Type Singular Name', 'pwg' ),
		'menu_name'             => __( 'Holes', 'pwg' ),
		'name_admin_bar'        => __( 'Hole', 'pwg' ),
		'archives'              => __( 'Hole Archives', 'pwg' ),
		'attributes'            => __( 'Hole Attributes', 'pwg' ),
		'parent_item_colon'     => __( 'Parent Hole:', 'pwg' ),
		'all_items'             => __( 'All Holes', 'pwg' ),
		'add_new_item'          => __( 'Add New Hole', 'pwg' ),
		'add_new'               => __( 'Add New Hole', 'pwg' ),
		'new_item'              => __( 'New Hole', 'pwg' ),
		'edit_item'             => __( 'Edit Hole', 'pwg' ),
		'update_item'           => __( 'Update Hole', 'pwg' ),
		'view_item'             => __( 'View Hole', 'pwg' ),
		'view_items'            => __( 'View Holes', 'pwg' ),
		'search_items'          => __( 'Search Hole', 'pwg' ),
		'not_found'             => __( 'Hole Not found', 'pwg' ),
		'not_found_in_trash'    => __( 'Hole Not found in Trash', 'pwg' ),
		'featured_image'        => __( 'Hole Image', 'pwg' ),
		'set_featured_image'    => __( 'Set Hole image', 'pwg' ),
		'remove_featured_image' => __( 'Remove Hole image', 'pwg' ),
		'use_featured_image'    => __( 'Use as Hole image', 'pwg' ),
		'insert_into_item'      => __( 'Insert into Hole', 'pwg' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Hole', 'pwg' ),
		'items_list'            => __( 'Hole list', 'pwg' ),
		'items_list_navigation' => __( 'Holes list navigation', 'pwg' ),
		'filter_items_list'     => __( 'Filter Holes list', 'pwg' ),
	);
	$args = array(
		'label'                 => __( 'Hole', 'pwg' ),
		'description'           => __( 'A post type for each hole on a golf course', 'pwg' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'page-attributes' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'hole', $args );

}
add_action( 'init', 'pwg_holes', 0 );