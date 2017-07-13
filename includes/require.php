<?php
require_once( dirname( __FILE__ ) . '/functions.php' );
require_once( dirname( __FILE__ ) . '/init.php' );
require_once( dirname( __FILE__ ) . '/ajax.php' );

//CSS style options add to the page
require_once( dirname( __FILE__ ) . '/css-options/css-options.php' );

//Post type init
foreach ( glob( dirname( __FILE__ ) . '/post-type/*.php' ) as $file ) {
	require_once( $file );
}

//Taxonomies init
foreach ( glob( dirname( __FILE__ ) . '/taxonomies/*.php' ) as $file ) {
	require_once( $file );
}

//Meta box init
foreach ( glob( dirname( __FILE__ ) . '/metaboxes/*.php' ) as $file ) {
	require_once( $file );
}

//Image size init
foreach ( glob( dirname( __FILE__ ) . '/image-resize/*.php' ) as $file ) {
	require_once( $file );
}

//TGM init
foreach ( glob( dirname( __FILE__ ) . '/tgm/*.php' ) as $file ) {
	require_once( $file );
}

//Redux
if ( class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/options/config.php' ) ) {
	require_once( dirname( __FILE__ ) . '/options/config.php' );
}

//Widgets init
//Post widget
foreach ( glob( dirname( __FILE__ ) . '/widgets/most-popular-posts/*.php' ) as $file ) {
	require_once( $file );
}
//Order form widget
foreach ( glob( dirname( __FILE__ ) . '/widgets/order-form/*.php' ) as $file ) {
	require_once( $file );
}