<?php
/**
 * Add Needed Taxonomies
 */
function tell_init_taxonomies() {
	if ( function_exists( 'tell_get_taxonomies' ) ) {
		foreach ( tell_get_taxonomies() as $type => $options ) {
			tell_add_taxonomy( $type, $options[ 'for' ], $options[ 'config' ], $options[ 'singular' ], $options[ 'multiple' ] );
		}
	}
}

add_action( 'init', 'tell_init_taxonomies' );

/**
 * Register taxonomy wrapper
 * @param string $name
 * @param mixed $object_type
 * @param array $config
 * @param string $singular
 * @param string $multiple
 */
function tell_add_taxonomy( $name, $object_type, $config, $singular = 'Entry', $multiple = 'Entries' ) {

	if ( !isset( $config[ 'labels' ] ) ) {
		$config[ 'labels' ] = array(
			'name'              => $multiple,
			'singular_name'     => $singular,
			'search_items'      => 'Search ' . $multiple,
			'all_items'         => 'All ' . $multiple,
			'parent_item'       => 'Parent ' . $singular,
			'parent_item_colon' => 'Parent ' . $singular . ':',
			'edit_item'         => 'Edit ' . $singular,
			'update_item'       => 'Update ' . $singular,
			'add_new_item'      => 'Add New ' . $singular,
			'new_item_name'     => 'New ' . $singular . ' Name',
			'menu_name'         => $singular,
		);
	}

	register_taxonomy( $name, $object_type, $config );
}