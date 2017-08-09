<?php
/*
Plugin Name: Create custom post type
Plugin URI: http://booking-travel.tellus.md/
Description: This plugin create custom post types for theme
Version: 1.0
Author: Tellus-Themes
Author http://tellus.md
*/

//Include config file
require_once( dirname( __FILE__ ) . '/config.php' );

/**
 * Add Needed Post Types
 */
function tell_post_types() {
	if ( function_exists( 'tell_get_post_types' ) ) {
		foreach ( tell_get_post_types() as $type => $options ) {
			tell_add_post_type( $type, $options[ 'config' ], $options[ 'singular' ], $options[ 'multiple' ] );
		}
	}
}

add_action( 'init', 'tell_post_types' );


/**
 * Register Post Type Wrapper
 * @param string $name
 * @param array $config
 * @param string $singular
 * @param string $multiple
 */
function tell_add_post_type( $name, $config, $singular = 'Entry', $multiple = 'Entries' ) {
	if ( !isset( $config[ 'labels' ] ) ) {
		$config[ 'labels' ] = array(
			'name'               => $multiple,
			'singular_name'      => $singular,
			'not_found'          => 'No ' . $multiple . ' Found',
			'not_found_in_trash' => 'No ' . $multiple . ' found in Trash',
			'edit_item'          => 'Edit ', $singular,
			'search_items'       => 'Search ' . $multiple,
			'view_item'          => 'View ', $singular,
			'new_item'           => 'New ' . $singular,
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New ' . $singular
		);
	}

	register_post_type( $name, $config );
}