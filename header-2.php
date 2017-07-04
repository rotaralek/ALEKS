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

<body <?php body_class( 'window-scroll' ); ?> style="<?php $background = tell_get_option( 'opt-background' );
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
<!-- Spinner -->
<?php if ( 'off' != tell_get_option( 'opt-spinner-use' ) ) {
	if ( tell_get_option( 'opt-spinner-layout' ) == '2' ) {
		get_template_part( 'inc/partials/spinners/spinner-2' );
	} elseif ( tell_get_option( 'opt-spinner-layout' ) == '3' ) {
		get_template_part( 'inc/partials/spinners/spinner-3' );
	} elseif ( tell_get_option( 'opt-spinner-layout' ) == '4' ) {
		get_template_part( 'inc/partials/spinners/spinner-4' );
	} else {
		get_template_part( 'inc/partials/spinners/spinner-1' );
	}
} ?>

<!-- Body -->
<div class="body <?php if ( 'off' != tell_get_option( 'opt-spinner-use' ) ) {
	echo 'fade-in-body';
} ?> cf">
	<header class="fixed white-bg">
		<div class="one-line">
			<div class="container cf">
				<div class="logo left text-center">
					<?php if ( tell_get_option( 'opt-logo-image', 'url' ) ) { ?>
						<a href="<?php echo esc_url( home_url() ); ?>/" class="white-col">
							<img src="<?php echo tell_get_option( 'opt-logo-image', 'url' ); ?>" alt="<?php echo bloginfo( 'name' ); ?>">
						</a>
					<?php } else { ?>
						<a href="<?php echo esc_url( home_url() ); ?>/" class="logo-title black-col"><?php echo bloginfo( 'name' ); ?></a>
					<?php } ?>
				</div>


				<div class="right cf text-center">
					<nav class="mobile-menu left text-left">
						<i class="material-icons black-col blue-col-hover open-menu">view_headline</i>
						<div class="menu-container white-bg">
							<?php if ( has_nav_menu( 'mobile_main_menu' ) ) {
								wp_nav_menu( array(
									'menu'           => '',
									'container'      => '',
									'container_id'   => '',
									'menu_class'     => 'menu',
									'menu_id'        => '',
									'echo'           => true,
									'before'         => '',
									'after'          => '',
									'link_before'    => '',
									'link_after'     => '',
									'depth'          => 0,
									'theme_location' => 'mobile_main_menu'
								) );
							} ?>
						</div>
					</nav>

					<nav class="full-menu left text-left">
						<?php if ( has_nav_menu( 'main_menu' ) ) {
							wp_nav_menu( array(
								'menu'           => '',
								'container'      => '',
								'container_id'   => '',
								'menu_class'     => 'menu',
								'menu_id'        => '',
								'echo'           => true,
								'before'         => '',
								'after'          => '',
								'link_before'    => '',
								'link_after'     => '',
								'depth'          => 0,
								'theme_location' => 'main_menu',
							) );
						} ?>
					</nav>

					<div class="search left cf">
						<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="left">
							<input type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php _e( 'Search', 'local' ); ?>"/>

							<button type="submit" class="material-icons">search</button>
						</form>

						<button type="button" class="open left material-icons">search</button>
						<button type="button" class="close left current-co material-icons red-col">clear</button>
					</div>
				</div>
			</div>

			<div class="bottom-waves cf">
				<div class="waves-line">
					<?php for ( $i = 0; $i < 140; $i++ ) {
						echo '<div class="wave wave-in left"></div>';
						echo '<div class="wave wave-out left"></div>';
					} ?>
				</div>
			</div>
		</div>
	</header>

	<div class="header-height"></div>

	<?php get_template_part( 'partials/style-selector' ); ?>

	<div class="main-container">