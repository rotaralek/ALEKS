<?php
/*
 * Enqueue Theme Styles
 */
function create_enqueue_styles() {
	wp_register_style( 'add_main_css', get_template_directory_uri() . '/assets/styles/css/style.css', array(), true, 'all' );
	wp_enqueue_style( 'add_main_css' );
}

add_action( 'wp_enqueue_scripts', 'create_enqueue_styles' );

/**
 * Enqueue Theme Scripts
 */
function create_enqueue_scripts() {
	wp_register_script( 'add_jquery', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), true, true );
	wp_register_script( 'add_jquery_ui', get_template_directory_uri() . '/assets/js/jquery-ui.min.js', array(), true, true );
	wp_register_script( 'add_animation', get_template_directory_uri() . '/assets/js/animation.js', array(), true, true );
	wp_register_script( 'add_all', get_template_directory_uri() . '/assets/js/all.js', array(), true, true );
	wp_register_script( 'add_load_more', get_template_directory_uri() . '/assets/js/load-more.js', array(), true, true );
	wp_register_script( 'add_ajax', get_template_directory_uri() . '/assets/js/ajax.js', array(), true, true );
	wp_register_script( 'add_pop_up', get_template_directory_uri() . '/assets/js/pop-up.js', array(), true, true );
	wp_register_script( 'add_scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), true, true );
	wp_register_script( 'add_colorpicker', get_template_directory_uri() . '/assets/js/colorpicker.js', array(), true, true );

	wp_enqueue_script( 'add_jquery' );
	wp_enqueue_script( 'add_jquery_ui' );
	wp_enqueue_script( 'add_animation' );
	wp_enqueue_script( 'add_all' );
	wp_enqueue_script( 'add_load_more' );
	wp_enqueue_script( 'add_ajax' );
	wp_enqueue_script( 'add_pop_up' );
	wp_enqueue_script( 'add_scripts' );
	wp_enqueue_script( 'add_colorpicker' );

	wp_localize_script( 'add_jquery', 'ajax_admin',
		array(
			'url'    => get_template_directory_uri() . '/includes/fast-ajax.php',
			'wp_url' => admin_url( 'admin-ajax.php' ),
			'nonce'  => wp_create_nonce( 'ajax_admin-nonce' )
		)
	);
}

add_action( 'wp_enqueue_scripts', 'create_enqueue_scripts' );

/*
 * Add favicon
 */
function add_favicon() {
	if ( tell_get_option( 'opt-favicon-image', 'url' ) ) { ?>
		<link rel="shortcut icon" href="<?php echo tell_get_option( 'opt-favicon-image', 'url' ); ?>">
		<?php
	}
}

add_action( 'wp_head', 'add_favicon' );

/*
 * Register menu
 */
function register_header_menu() {
	register_nav_menu( 'main_menu', __( 'Main Menu', 'local' ) );
	register_nav_menu( 'mobile_main_menu', __( 'Mobile Main Menu', 'local' ) );
}

add_action( 'init', 'register_header_menu' );

/*
 * Register sidebar
 */
if ( function_exists( 'register_sidebar' ) ) {
	register_sidebar( array(
		'name'          => __( 'Right sidebar', 'local' ),
		'id'            => 'right-sidebar',
		'description'   => __( 'Displayed on the right side of the page', 'local' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<p class="caption">',
		'after_title'   => '</p><div class="line"></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Shop sidebar', 'local' ),
		'id'            => 'sidebar-shop',
		'description'   => __( 'Displayed on the right side of the page', 'local' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<p class="caption">',
		'after_title'   => '</p><div class="line"></div>',
	) );
}

//Share
function share_parameters() {
	global $post;
	if ( isset( $post ) ) {
		if ( has_post_thumbnail( $post->ID ) ) {
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			$image = $thumb[ '0' ];
		} else {
			$image = '';
		}
		echo '<meta property="og:title" content="' . esc_attr( strip_tags( get_the_title() ) ) . '">';
		echo '<meta property="og:type" content="article">';
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">';
		echo '<meta property="og:url" content="' . esc_url( get_the_permalink() ) . '">';
		echo '<meta property="og:description" content="' . esc_attr( strip_tags( tell_trim_excerpt( 40 ) ) ) . '">';

		echo '<meta name="twitter:card" content="summary_large_image">';
		echo '<meta name="twitter:site" content="">';
		echo '<meta name="twitter:title" content="' . esc_attr( strip_tags( get_the_title() ) ) . '">';
		echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">';
		echo '<meta name="twitter:url" content="' . esc_url( get_the_permalink() ) . '">';
		echo '<meta name="twitter:description" content="' . esc_attr( strip_tags( tell_trim_excerpt( 40 ) ) ) . '">';

		echo '<meta itemprop="name" content="' . esc_attr( strip_tags( get_the_title() ) ) . '">';
		echo '<meta itemprop="description" content="' . esc_attr( strip_tags( tell_trim_excerpt( 40 ) ) ) . '">';
		echo '<meta itemprop="image" content="' . esc_url( $image ) . '">';
	}

}

add_action( 'wp_head', 'share_parameters' );