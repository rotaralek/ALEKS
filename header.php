<!doctype html><!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]--><!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]--><!--[if IE 8]>
<html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]--><!--[if gt IE 8]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width initial-scale=1">
	<meta http-equiv="Expires" content="<?php $next_expires_year = date( 'Y' ) + 1;
	echo date( 'D, d M ' ) . $next_expires_year; ?> 23:59:59 GMT">
	<link rel="icon" href="<?php echo tell_get_option( 'opt-favicon-image', 'url' ); ?>">
	<title><?php wp_title(); ?></title>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> style="<?php
//Select background styles
$background = tell_get_option( 'opt-background' );
if ( is_array( $background ) && !empty( $background ) ) {
	if ( isset( $background[ 'background-color' ] ) && '' != $background[ 'background-color' ] ) {
		echo 'background-color: ' . $background[ 'background-color' ] . ';';
	}
	if ( isset( $background[ 'background-image' ] ) && '' != $background[ 'background-image' ] ) {
		echo 'background-image: url(' . $background[ 'background-image' ] . ');';

		if ( isset( $background[ 'background-repeat' ] ) && '' != $background[ 'background-repeat' ] ) {
			echo 'background-repeat: ' . $background[ 'background-repeat' ] . ';';
		}
		if ( isset( $background[ 'background-size' ] ) && '' != $background[ 'background-size' ] ) {
			echo 'background-size: ' . $background[ 'background-size' ] . ';';
		}
		if ( isset( $background[ 'background-attachment' ] ) && '' != $background[ 'background-attachment' ] ) {
			echo 'background-attachment: ' . $background[ 'background-attachment' ] . ';';
		}
		if ( isset( $background[ 'background-position' ] ) && '' != $background[ 'background-position' ] ) {
			echo 'background-position: ' . $background[ 'background-position' ] . ';';
		}
	}
} ?>">

<?php //Spinner
if ( 'off' != tell_get_option( 'opt-spinner-use' ) ) {
	$spinner_type = 1;

	if ( tell_get_option( 'opt-spinner-layout' ) == '2' ) {
		$spinner_type = 2;
	} elseif ( tell_get_option( 'opt-spinner-layout' ) == '3' ) {
		$spinner_type = 3;
	} elseif ( tell_get_option( 'opt-spinner-layout' ) == '4' ) {
		$spinner_type = 4;
	}

	get_template_part( 'inc/partials/spinners/spinner-' . $spinner_type );
} ?>

<?php //Header
$header_type = 0;

if ( 1 == tell_get_option( 'opt-header-type' ) ) {
	$header_type = 1;
} else if ( 2 == tell_get_option( 'opt-header-type' ) ) {
	$header_type = 2;
}

get_template_part( 'partials/header/header-' . $header_type ); ?>

<?php //Style selector
get_template_part( 'partials/style-selector' ); ?>

<!-- All content box -->
<div class="all-content-box <?php if ( 'off' != tell_get_option( 'opt-spinner-use' ) ) {
	echo 'fade-in-body';
} ?> cf">

	<div class="main-container">
