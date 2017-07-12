<?php

/**
 * Options config File
 */

if ( !class_exists( 'Redux' ) ) {
	return;
}


// This is your option name where all the Redux data is stored.
$opt_name = "theme_options";

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
	// TYPICAL -> Change these values as you need/desire
	'opt_name'             => $opt_name,
	// This is where your data is stored in the database and also becomes your global variable name.
	'display_name'         => $theme->get( 'Name' ),
	// Name that appears at the top of your panel
	'display_version'      => $theme->get( 'Version' ),
	// Version that appears at the top of your panel
	'menu_type'            => 'menu',
	//Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
	'allow_sub_menu'       => true,
	// Show the sections below the admin menu item or not
	'menu_title'           => __( 'Options', 'local' ),
	'page_title'           => __( 'Options', 'local' ),
	// You will need to generate a Google API key to use this feature.
	// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
	'google_api_key'       => '',
	// Set it you want google fonts to update weekly. A google_api_key value is required.
	'google_update_weekly' => false,
	// Must be defined to add google fonts to the typography module
	'async_typography'     => true,
	// Use a asynchronous font on the front end or font string
	//'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
	'admin_bar'            => true,
	// Show the panel pages on the admin bar
	'admin_bar_icon'       => 'dashicons-portfolio',
	// Choose an icon for the admin bar menu
	'admin_bar_priority'   => 50,
	// Choose an priority for the admin bar menu
	'global_variable'      => '',
	// Set a different name for your global variable other than the opt_name
	'dev_mode'             => false,
	// Show the time the page took to load, etc
	'update_notice'        => false,
	// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
	'customizer'           => false,
	// Enable basic customizer support
	//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
	//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

	// OPTIONAL -> Give you extra features
	'page_priority'        => null,
	// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	'page_parent'          => 'themes.php',
	// For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	'page_permissions'     => 'manage_options',
	// Permissions needed to access the options panel.
	'menu_icon'            => '',
	// Specify a custom URL to an icon
	'last_tab'             => '',
	// Force your panel to always open to a specific tab (by id)
	'page_icon'            => 'icon-themes',
	// Icon displayed in the admin panel next to your menu_title
	'page_slug'            => '_options',
	// Page slug used to denote the panel
	'save_defaults'        => true,
	// On load save the defaults to DB before user clicks save or not
	'default_show'         => true,
	// If true, shows the default value next to each field that is not the default value.
	'default_mark'         => '',
	// What to print by the field's title if the value shown is default. Suggested: *
	'show_import_export'   => false,
	// Shows the Import/Export panel when not used as a field.

	// CAREFUL -> These options are for advanced use only
	'transient_time'       => 60 * MINUTE_IN_SECONDS,
	'output'               => true,
	// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	'output_tag'           => true,
	// Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	// 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

	// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	'database'             => '',
	// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

	'use_cdn' => true,
	// If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

	//'compiler'             => true,

	// HINTS
	'hints'   => array(
		'icon'          => 'el el-question-sign',
		'icon_position' => 'right',
		'icon_color'    => 'lightgray',
		'icon_size'     => 'normal',
		'tip_style'     => array(
			'color'   => 'light',
			'shadow'  => true,
			'rounded' => false,
			'style'   => '',
		),
		'tip_position'  => array(
			'my' => 'top left',
			'at' => 'bottom right',
		),
		'tip_effect'    => array(
			'show' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'mouseover',
			),
			'hide' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'click mouseleave',
			),
		),
	)
);

// Panel Intro text -> before the form
if ( !isset( $args[ 'global_variable' ] ) || $args[ 'global_variable' ] !== false ) {
	if ( !empty( $args[ 'global_variable' ] ) ) {
		$v = $args[ 'global_variable' ];
	} else {
		$v = str_replace( '-', '_', $args[ 'opt_name' ] );
	}
	$args[ 'intro_text' ] = __( '<p>Panel options for managing threads. Here you can change some parameters.</p>', 'local' );
} else {
	$args[ 'intro_text' ] = '';
}

// Add content after the form.
$args[ 'footer_text' ] = '';

Redux::setArgs( $opt_name, $args );

/*
 * ---> END ARGUMENTS
 */


/*
 * ---> START HELP TABS
 */

$tabs = array(
	array(
		'id'      => 'redux-help-tab-1',
		'title'   => __( 'Theme Information 1', 'local' ),
		'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'local' )
	),
	array(
		'id'      => 'redux-help-tab-2',
		'title'   => __( 'Theme Information 2', 'local' ),
		'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'local' )
	)
);
Redux::setHelpTab( $opt_name, $tabs );

// Set the help sidebar
$content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'local' );
Redux::setHelpSidebar( $opt_name, $content );


/*
 * <--- END HELP TABS
 */


/*
 *
 * ---> START SECTIONS
 *
 */

/*

	As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


 */

// -> START Basic Fields
Redux::setSection( $opt_name, array(
	'title'  => __( 'Site logo', 'local' ),
	'id'     => 'opt-logo',
	'desc'   => __( 'Upload Logo.', 'local' ),
	'icon'   => 'el el-star-empty',
	'fields' => array(
		array(
			'id'       => 'opt-logo-image',
			'type'     => 'media',
			'url'      => true,
			'title'    => __( 'Media w/ URL', 'local' ),
			'desc'     => __( 'Upload an image. Size: 180x72px', 'local' ),
			'subtitle' => __( 'Upload any media using the WordPress native uploader', 'local' )
		)
	)
) );

Redux::setSection( $opt_name, array(
	'title'  => __( 'Favorite Icon', 'local' ),
	'id'     => 'opt-favicon',
	'desc'   => __( 'Upload favicon. Size: 32x32px', 'local' ),
	'icon'   => 'el el-picture',
	'fields' => array(
		array(
			'id'       => 'opt-favicon-image',
			'type'     => 'media',
			'url'      => true,
			'title'    => __( 'Media w/ URL', 'local' ),
			'desc'     => __( 'Upload an image. Size: 32x32px', 'local' ),
			'subtitle' => __( 'Upload any media using the WordPress native uploader', 'local' )
		)
	)
) );

Redux::setSection( $opt_name, array(
	'title'  => __( 'Style', 'local' ),
	'id'     => 'opt-colors',
	'desc'   => __( 'Select Colors.', 'local' ),
	'icon'   => 'el el-brush',
	'fields' => array(
		array(
			'id'      => 'opt-colors-selector',
			'title'   => __( 'Show color selector for users?', 'local' ),
			'type'    => 'select',
			'options' => array(
				'show' => __( 'Show', 'local' ),
				'hide' => __( 'Hide', 'local' )
			)
		),
		array(
			'id'       => 'opt-background',
			'type'     => 'background',
			'title'    => __( 'Body Background Color', 'local' ),
			'subtitle' => __( 'Pick a background color for the theme (default: #fff).', 'local' ),
			'default'  => array(
				'background-color' => '#FFFFFF',
			)
		),
		array(
			'id'       => 'opt-change-red-col',
			'type'     => 'color',
			'title'    => __( 'Red color', 'local' ),
			'desc'     => __( 'Insert the color. HEX', 'local' ),
			'subtitle' => __( 'Default: #F44336', 'local' ),
			'default'  => '#F44336',
			'validate' => 'color'
		),
		array(
			'id'       => 'opt-change-blue-col',
			'type'     => 'color',
			'title'    => __( 'Blue color', 'local' ),
			'desc'     => __( 'Insert the color. HEX', 'local' ),
			'subtitle' => __( 'Default: #2196F3', 'local' ),
			'default'  => '#2196F3',
			'validate' => 'color'
		),
		array(
			'id'       => 'opt-change-blue-light-col',
			'type'     => 'color',
			'title'    => __( 'Blue light color', 'local' ),
			'desc'     => __( 'Insert the color. HEX', 'local' ),
			'subtitle' => __( 'Default: #64B5F6', 'local' ),
			'default'  => '#64B5F6',
			'validate' => 'color'
		),
		array(
			'id'       => 'opt-change-yellow-col',
			'type'     => 'color',
			'title'    => __( 'Yellow color', 'local' ),
			'desc'     => __( 'Insert the color. HEX', 'local' ),
			'subtitle' => __( 'Default: #FFEB3B', 'local' ),
			'default'  => '#FFEB3B',
			'validate' => 'color'
		),
		array(
			'id'       => 'opt-change-orange-col',
			'type'     => 'color',
			'title'    => __( 'Orange color', 'local' ),
			'desc'     => __( 'Insert the color. HEX', 'local' ),
			'subtitle' => __( 'Default: #FF9800', 'local' ),
			'default'  => '#FF9800',
			'validate' => 'color'
		)
	)
) );

Redux::setSection( $opt_name, array(
	'title'  => __( 'Lazy load images', 'local' ),
	'id'     => 'opt-lazy-load',
	'icon'   => 'el el-picture',
	'fields' => array(
		array(
			'id'      => 'opt-lazy-load-init',
			'title'   => __( 'Use lazy load?', 'local' ),
			'type'    => 'select',
			'options' => array(
				'use'     => __( 'Use', 'local' ),
				'not_use' => __( 'Not use', 'local' )
			)
		),
		array(
			'id'       => 'opt-thumbnail',
			'type'     => 'media',
			'title'    => __( 'Image', 'local' ),
			'desc'     => __( 'Size: 1920x1080px', 'local' ),
			'subtitle' => __( 'Upload an image', 'local' )
		)
	)
) );

Redux::setSection( $opt_name, array(
	'title'  => __( 'Typography', 'local' ),
	'id'     => 'opt-typography',
	'desc'   => __( 'Upload Background images.', 'local' ),
	'icon'   => 'el el-font',
	'fields' => array(
		array(
			'id'          => 'opt-typography-body',
			'type'        => 'typography',
			'title'       => __( 'Change the body style', 'local' ),
			'google'      => true,
			'font-backup' => true,
			'output'      => array( 'body', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ),
			'units'       => 'px',
			'subtitle'    => __( 'Typography option with each property can be called individually.', 'local' ),
			'default'     => array(
				'font-family' => 'Roboto',
				'font-size'   => '12px',
				'font-weight' => '300'
			),
		),
		array(
			'id'          => 'opt-typography-h1',
			'type'        => 'typography',
			'title'       => __( 'Change the h1 style', 'local' ),
			'google'      => true,
			'font-backup' => true,
			'output'      => array( '.content-style h1' ),
			'units'       => 'px',
			'subtitle'    => __( 'Typography option with each property can be called individually.', 'local' ),
			'default'     => array(
				'color'       => '#333',
				'font-style'  => '400',
				'font-family' => 'Roboto',
				'google'      => true,
				'font-size'   => '50px',
				'line-height' => '50'
			),
		),
		array(
			'id'          => 'opt-typography-h2',
			'type'        => 'typography',
			'title'       => __( 'Change the h2 style', 'local' ),
			'google'      => true,
			'font-backup' => true,
			'output'      => array( '.content-style h2' ),
			'units'       => 'px',
			'subtitle'    => __( 'Typography option with each property can be called individually.', 'local' ),
			'default'     => array(
				'color'       => '#333',
				'font-style'  => '400',
				'font-family' => 'Roboto',
				'google'      => true,
				'font-size'   => '40px',
				'line-height' => '40'
			),
		),
		array(
			'id'          => 'opt-typography-h3',
			'type'        => 'typography',
			'title'       => __( 'Change the h3 style', 'local' ),
			'google'      => true,
			'font-backup' => true,
			'output'      => array( '.content-style h3' ),
			'units'       => 'px',
			'subtitle'    => __( 'Typography option with each property can be called individually.', 'local' ),
			'default'     => array(
				'color'       => '#333',
				'font-style'  => '400',
				'font-family' => 'Roboto',
				'google'      => true,
				'font-size'   => '35px',
				'line-height' => '35'
			),
		),
		array(
			'id'          => 'opt-typography-h4',
			'type'        => 'typography',
			'title'       => __( 'Change the h4 style', 'local' ),
			'google'      => true,
			'font-backup' => true,
			'output'      => array( '.content-style h4' ),
			'units'       => 'px',
			'subtitle'    => __( 'Typography option with each property can be called individually.', 'local' ),
			'default'     => array(
				'color'       => '#333',
				'font-style'  => '400',
				'font-family' => 'Roboto',
				'google'      => true,
				'font-size'   => '25px',
				'line-height' => '25'
			),
		),
		array(
			'id'          => 'opt-typography-h5',
			'type'        => 'typography',
			'title'       => __( 'Change the h5 style', 'local' ),
			'google'      => true,
			'font-backup' => true,
			'output'      => array( '.content-style h5' ),
			'units'       => 'px',
			'subtitle'    => __( 'Typography option with each property can be called individually.', 'local' ),
			'default'     => array(
				'color'       => '#333',
				'font-style'  => '400',
				'font-family' => 'Roboto',
				'google'      => true,
				'font-size'   => '20px',
				'line-height' => '20'
			),
		),
		array(
			'id'          => 'opt-typography-h6',
			'type'        => 'typography',
			'title'       => __( 'Change the h6 style', 'local' ),
			'google'      => true,
			'font-backup' => true,
			'output'      => array( '.content-style h6' ),
			'units'       => 'px',
			'subtitle'    => __( 'Typography option with each property can be called individually.', 'local' ),
			'default'     => array(
				'color'       => '#333',
				'font-style'  => '400',
				'font-family' => 'Roboto',
				'google'      => true,
				'font-size'   => '15px',
				'line-height' => '15'
			),
		)
	)
) );

Redux::setSection( $opt_name, array(
	'title'  => __( 'Spinners', 'local' ),
	'id'     => 'opt-spinners',
	'desc'   => __( 'Select the loader style.', 'local' ),
	'icon'   => 'el el-repeat',
	'fields' => array(
		array(
			'id'       => 'opt-spinner-use',
			'type'     => 'select',
			'title'    => __( 'Use spinner?', 'local' ),
			'subtitle' => __( 'Select option', 'local' ),
			'options'  => array(
				'on'  => 'On',
				'off' => 'Off'
			),
			'default'  => 'on'
		),
		array(
			'id'       => 'opt-spinner-layout',
			'type'     => 'image_select',
			'title'    => __( 'Spinners', 'local' ),
			'subtitle' => __( 'Select spinner style.', 'local' ),
			'options'  => array(
				'1' => __( 'Style 1', 'local' ),
				'2' => __( 'Style 2', 'local' ),
				'3' => __( 'Style 3', 'local' ),
				'4' => __( 'Style 4', 'local' )
			)
		)
	)
) );

Redux::setSection( $opt_name, array(
	'title'  => __( 'Header', 'local' ),
	'id'     => 'opt-header',
	'desc'   => __( 'Insert details.', 'local' ),
	'icon'   => 'el el-flag',
	'fields' => array(
		array(
			'id'       => 'opt-header-type',
			'title'    => __( 'Text', 'local' ),
			'subtitle' => __( 'Insert the text', 'local' ),
			'type'     => 'select',
			'options'  => array(
				'1' => __( 'Two lines style', 'local' ),
				'2' => __( 'Two lines full width style', 'local' ),
				'3' => __( 'Three lines style', 'local' ),
				'4' => __( 'Full width three lines style', 'local' )
			)
		),
	)
) );

Redux::setSection( $opt_name, array(
	'title' => __( 'Footer', 'local' ),
	'id'    => 'opt-footer',
	'icon'  => 'el el-cog'
) );

Redux::setSection( $opt_name, array(
	'title'      => __( 'About', 'local' ),
	'id'         => 'opt-footer-about',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'opt-footer-about-title',
			'title'    => __( 'Title', 'local' ),
			'type'     => 'text',
			'subtitle' => __( 'Insert the title', 'local' )
		),
		array(
			'id'       => 'opt-footer-about-text',
			'title'    => __( 'Text', 'local' ),
			'type'     => 'textarea',
			'subtitle' => __( 'Insert the text', 'local' )
		)
	)
) );

Redux::setSection( $opt_name, array(
	'title'      => __( 'Tags', 'local' ),
	'id'         => 'opt-footer-tags',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'opt-footer-tags-title',
			'title'    => __( 'Title', 'local' ),
			'type'     => 'text',
			'subtitle' => __( 'Insert the title', 'local' )
		)
	)
) );

Redux::setSection( $opt_name, array(
	'title'      => __( 'Copyright', 'local' ),
	'id'         => 'opt-footer-copyright',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'opt-footer-copyright-text',
			'title'    => __( 'Text', 'local' ),
			'type'     => 'text',
			'subtitle' => __( 'Insert the text', 'local' )
		)
	)
) );