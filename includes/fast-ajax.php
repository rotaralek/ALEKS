<?php
//mimic the actuall admin-ajax
define( 'DOING_AJAX', true );

if ( !isset( $_POST[ 'action' ] ) )
	die( '-1' );

//make sure you update this line
//to the relative location of the wp-load.php
require_once( '../../../../wp-load.php' );

//Typical headers
header( 'Content-Type: text/html' );
send_nosniff_header();

//Disable caching
header( 'Cache-Control: no-cache' );
header( 'Pragma: no-cache' );

$action = esc_attr( trim( $_POST[ 'action' ] ) );

//A bit of security
$allowed_actions = array(
	'load_posts',
	'change_red_col',
	'change_blue_col',
	'change_blue_light_col',
	'change_yellow_col',
	'change_orange_col',
	'contact_form_submit',
	'login_form',
	'registration_form',
	'registration'
);

if ( in_array( $action, $allowed_actions ) ) {
	if ( is_user_logged_in() )
		do_action( 'tell_ajax_' . $action );
	else
		do_action( 'tell_ajax_nopriv_' . $action );
} else {
	die( '-1' );
}