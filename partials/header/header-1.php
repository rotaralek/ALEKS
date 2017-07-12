<header class="type-1">
	<div class="container cf">
		<div class="right">
			<div class="share">
				<a href="<?php echo tell_get_share( 'fb' ); ?>" class="grey-dark-col blue-col-hover" target="_blank"><i class="socicon-facebook"></i></a>
				<a href="<?php echo tell_get_share( 'ok' ); ?>" class="grey-dark-col blue-col-hover" target="_blank"><i class="socicon-odnoklassniki"></i></a>
				<a href="<?php echo tell_get_share( 'vk' ); ?>" class="grey-dark-col blue-col-hover" target="_blank"><i class="socicon-vkontakte"></i></a>
				<a href="<?php echo tell_get_share( 'twi' ); ?>" class="grey-dark-col blue-col-hover" target="_blank"><i class="socicon-twitter"></i></a>
				<a href="<?php echo tell_get_share( 'goglp' ); ?>" class="grey-dark-col blue-col-hover" target="_blank"><i class="socicon-googleplus"></i></a>
				<a href="<?php echo tell_get_share( 'pin' ); ?>" class="grey-dark-col blue-col-hover" target="_blank"><i class="socicon-pinterest"></i></a>
			</div>
		</div>

		<div class="right">
			<div class="login-line">
				<?php global $user_ID, $user_identity, $current_user;

				wp_get_current_user();
				if ( !$user_ID ) { ?>
					<button type="button" class="right btn small blue-bg white-col blue-light-bg-hover open-in-pop-up" data-action="registration_form" data-content-type="form"><?php _e( 'Registration', 'local' ); ?></button>

					<button type="button" class="right btn small blue-bg white-col blue-light-bg-hover open-in-pop-up" data-action="login_form" data-content-type="form"><?php _e( 'Login', 'local' ); ?></button>
				<?php } else { ?>
					<a href="<?php echo wp_logout_url( 'index.php' ); ?>" class="btn small blue-bg white-col blue-light-bg-hover right"><?php _e( 'Exit', 'local' ); ?></a>

					<a href="<?php echo esc_url( esc_url( esc_url( home_url( '/' ) ) ) ) . 'experts/' . $current_user->user_login; ?>" class="btn small blue-bg white-col blue-light-bg-hover right">
						<?php if ( isset( $current_user->user_firstname ) && !empty( $current_user->user_firstname ) && isset( $current_user->user_lastname ) && !empty( $current_user->user_lastname ) ) {
							echo $current_user->user_firstname . ' ' . $current_user->user_lastname;
						} else {
							echo $current_user->user_login;
						} ?>
					</a>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="container cf">
		<div class="left">
			<div class="logo">
				<?php if ( tell_get_option( 'opt-logo-image', 'url' ) ) { ?>
					<a href="<?php echo esc_url( home_url() ); ?>/" class="white-col">
						<img src="<?php echo tell_get_option( 'opt-logo-image', 'url' ); ?>" alt="<?php echo bloginfo( 'name' ); ?>">
					</a>
				<?php } else { ?>
					<a href="<?php echo esc_url( home_url() ); ?>/" class="logo-title black-col"><?php echo bloginfo( 'name' ); ?></a>

					<p><?php echo bloginfo( 'description' ); ?></p>
				<?php } ?>
			</div>
		</div>

		<div class="right cf">
			<nav class="left">
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
				<form method="GET" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="left">
					<input type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php _e( 'Search', 'local' ); ?>"/>

					<button type="submit" class="material-icons">search</button>
				</form>

				<button type="button" class="open left material-icons">search</button>
				<button type="button" class="close left current-co material-icons">clear</button>
			</div>
		</div>
	</div>
</header>