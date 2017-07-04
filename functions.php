<?php
/****************************************************************
 * DO NOT DELETE
 ****************************************************************/

//Require init

function lang_theme_setup() {
	load_theme_textdomain( 'local', get_template_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'lang_theme_setup' );

//Admin side init
require_once( dirname( __FILE__ ) . '/includes/require.php' );

/****************************************************************
 * You can add your functions here.
 *
 * BE CAREFUL! Functions will disappear after update.
 * If you want to add custom functions you should do manual
 * updates only.
 ****************************************************************/