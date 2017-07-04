<?php
add_filter( 'rwmb_meta_boxes', 'tell_register_meta_boxes' );
function tell_register_meta_boxes( $meta_boxes ) {
	$prefix = 'tell_';

	$meta_boxes[] = array(
		'id'         => 'post',
		'title'      => __( 'Page fields', 'local' ),
		'post_types' => array( 'post' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'fields'     => array(
			array(
				'name' => __( 'Gallery', 'local' ),
				'desc' => __( 'Upload an image', 'local' ),
				'id'   => $prefix . 'post_gallery',
				'type' => 'image_advanced'
			),
			array(
				'name'    => __( 'Show this post on home page', 'local' ),
				'desc'    => __( 'Select the "Show" to display this post on home page', 'local' ),
				'id'      => $prefix . 'slider_home_show',
				'type'    => 'select',
				'std'     => 'Hide',
				'options' => array(
					'hide' => __( 'Hide', 'local' ),
					'show' => __( 'Show', 'local' )
				)
			),
			/*array(
				'name' => __( 'Video', 'local' ),
				'desc' => __( 'Insert the url', 'local' ),
				'id'   => $prefix . 'post_video',
				'type' => 'url'
			),*/
			/*array(
				'name' => __('Number of views', 'local'),
				'desc' => __('Insert the number of views', 'local'),
				'id' => $prefix . 'post_views',
				'type' => 'number'
			),*/
		)
	);

	$meta_boxes[] = array(
		'id'         => 'page_home',
		'title'      => __( 'Page fields', 'local' ),
		'post_types' => array( 'page' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'only_on'    => array(
			'template' => array( 'page-home.php' )
		),
		'fields'     => array(
			array(
				'name' => __( 'Sidebar', 'local' ),
				'id'   => $prefix . 'page_home_slider',
				'type' => 'heading'
			),
			array(
				'name'    => __( 'Show sidebar?', 'local' ),
				'desc'    => __( 'Select "Hide" to remove this sidebar from page', 'local' ),
				'id'      => $prefix . 'page_home_sidebar',
				'type'    => 'select',
				'options' => array(
					'show' => __( 'Show', 'local' ),
					'hide' => __( 'Hide', 'local' )
				)
			),
			array(
				'name'    => __( 'Sidebar position', 'local' ),
				'desc'    => __( 'Select position of sidebar', 'local' ),
				'id'      => $prefix . 'page_home_sidebar_position',
				'type'    => 'select',
				'options' => array(
					'right' => __( 'Right', 'local' ),
					'left'  => __( 'Left', 'local' )
				)
			),
			array(
				'name' => __( 'Posts', 'local' ),
				'id'   => $prefix . 'page_home_posts',
				'type' => 'heading'
			),
			array(
				'name'    => __( 'Cols', 'local' ),
				'desc'    => __( 'Select number of cols', 'local' ),
				'id'      => $prefix . 'page_home_posts_cols',
				'type'    => 'select',
				'options' => array(
					'1' => 1,
					'2' => 2,
					'3' => 3
				)
			),
		)
	);

	$meta_boxes[] = array(
		'id'         => 'page_contact',
		'title'      => __( 'Page fields', 'local' ),
		'post_types' => array( 'page' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'only_on'    => array(
			'template' => array( 'template-contact.php' )
		),
		'fields'     => array(
			array(
				'name' => __( 'Country', 'local' ),
				'desc' => __( 'Insert the country', 'local' ),
				'id'   => $prefix . 'template_contact_country',
				'type' => 'text',
				'std'  => ''
			),
			array(
				'name' => __( 'Address', 'local' ),
				'desc' => __( 'Insert the address', 'local' ),
				'id'   => $prefix . 'template_contact_address',
				'type' => 'text',
				'std'  => ''
			),
			array(
				'name' => __( 'Phone', 'local' ),
				'desc' => __( 'Insert the phone numbers', 'local' ),
				'id'   => $prefix . 'template_contact_phone',
				'type' => 'text',
				'std'  => ''
			),
			array(
				'name' => __( 'Email', 'local' ),
				'desc' => __( 'Insert the email address', 'local' ),
				'id'   => $prefix . 'template_contact_email',
				'type' => 'text',
				'std'  => ''
			),
			array(
				'name' => __( 'Form title', 'local' ),
				'desc' => __( 'Insert the title', 'local' ),
				'id'   => $prefix . 'template_contact_form_title',
				'type' => 'text',
				'std'  => ''
			),
			array(
				'name' => __( 'Form text', 'local' ),
				'desc' => __( 'Insert the text', 'local' ),
				'id'   => $prefix . 'template_contact_form_text',
				'type' => 'textarea',
				'std'  => ''
			),
			array(
				'name' => __( 'Google API KEY', 'local' ),
				'desc' => __( 'Insert the key', 'local' ),
				'id'   => $prefix . 'template_contact_api_key',
				'type' => 'input',
				'std'  => ''
			)
		)
	);

	foreach ( $meta_boxes as $k => $meta_box ) {
		if ( isset( $meta_box[ 'only_on' ] ) && !rw_maybe_include( $meta_box[ 'only_on' ] ) ) {
			unset( $meta_boxes[ $k ] );
		}
	}

	return $meta_boxes;
}

/**
 * Check if meta boxes is included
 *
 * @return bool
 */
function rw_maybe_include( $conditions ) {
	// Always include in the frontend to make helper function work
	if ( !is_admin() ) {
		return true;
	}
	// Always include for ajax
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return true;
	}
	if ( isset( $_GET[ 'post' ] ) ) {
		$post_id = intval( $_GET[ 'post' ] );
	} elseif ( isset( $_POST[ 'post_ID' ] ) ) {
		$post_id = intval( $_POST[ 'post_ID' ] );
	} else {
		$post_id = false;
	}
	$post_id = (int)$post_id;
	$post    = get_post( $post_id );
	foreach ( $conditions as $cond => $v ) {
		// Catch non-arrays too
		if ( !is_array( $v ) ) {
			$v = array( $v );
		}
		switch ( $cond ) {
			case 'id':
				if ( in_array( $post_id, $v ) ) {
					return true;
				}
				break;
			case 'parent':
				$post_parent = $post->post_parent;
				if ( in_array( $post_parent, $v ) ) {
					return true;
				}
				break;
			case 'slug':
				$post_slug = $post->post_name;
				if ( in_array( $post_slug, $v ) ) {
					return true;
				}
				break;
			case 'category': //post must be saved or published first
				$categories = get_the_category( $post->ID );
				$catslugs   = array();
				foreach ( $categories as $category ) {
					array_push( $catslugs, $category->slug );
				}
				if ( array_intersect( $catslugs, $v ) ) {
					return true;
				}
				break;
			case 'template':
				$template = get_post_meta( $post_id, '_wp_page_template', true );
				if ( in_array( $template, $v ) ) {
					return true;
				}
				break;
		}
	}

	// If no condition matched
	return false;
}