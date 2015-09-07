<?php
add_action( 'init', 'lec_init' );
/**
 * Register a post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function lec_init() {
	$labels = array(
		'name'               => _x( 'L-Events', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'L-Event', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'L-Events', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'L-Event', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'L-Event', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New L-Event', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New L-Event', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit L-Event', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View L-Event', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All L-Events', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search L-Events', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent L-Events:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No L-events found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No L-events found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'l-event' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt'),
		'taxonomies' => array('event-category'),
		'menu_icon'			=> 'dashicons-calendar-alt'
	);

	register_post_type( 'l-event', $args );
	flush_rewrite_rules();
}
/*
	Add custom taxonomies
*/
	// hook into the init action and call create_book_taxonomies when it fires
	add_action( 'init', 'lec_create_l_event_taxonomies', 0 );

	// create two taxonomies, Event Categories and writers for the post type "book"
	function lec_create_l_event_taxonomies() {
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Event Categories', 'taxonomy general name' ),
			'singular_name'     => _x( 'Event Category', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Event Categories' ),
			'all_items'         => __( 'All Event Categories' ),
			'parent_item'       => __( 'Parent Event Category' ),
			'parent_item_colon' => __( 'Parent Event Category:' ),
			'edit_item'         => __( 'Edit Event Category' ),
			'update_item'       => __( 'Update Event Category' ),
			'add_new_item'      => __( 'Add New Event Category' ),
			'new_item_name'     => __( 'New Event Category Name' ),
			'menu_name'         => __( 'Event Category' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'event-category' ),
		);

		register_taxonomy( 'event-category', array( 'l-event' ), $args );
	}

?>