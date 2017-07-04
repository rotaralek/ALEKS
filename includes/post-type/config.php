<?php
/**
 * Add post types that are used in the theme
 *
 * @return array
 */
function tell_get_post_types() {
	return array(
		/*'tours'       => array(
			'config'   => array(
				'public'            => true,
				'menu_position'     => 41,
				'has_archive'       => true,
				'supports'          => array(
					'title',
					'editor',
					'thumbnail',
					'comments',
					'tags',
					'excerpt'
				),
				'show_in_nav_menus' => true,
				'taxonomies'        => array( 'post_tag' ),
				'menu_icon'         => 'dashicons-palmtree'
			),
			'singular' => __( 'Tour', 'local' ),
			'multiple' => __( 'Tours', 'local' ),
			'columns'  => array(
				'first_image',
			)
		),*/
	);
}