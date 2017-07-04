<header class="fixed">
	<div class="top-header-container">
		<div class="top-line">
			<div class="container cf">
				<?php if ( tell_get_option( 'opt-header-phone-text' ) ) { ?>
					<div class="left red-bg white-col phone-block text-center">
						<p>
							<?php echo tell_get_option( 'opt-header-phone-text' ); ?>

							<span>
										<?php echo tell_get_option( 'opt-header-phone-number-first-part' ); ?>
									</span>

							<i>
								<?php echo tell_get_option( 'opt-header-phone-number-second-part' ); ?>
							</i>
						</p>

						<!--<div class="before"></div>
						<div class="after"></div>-->
					</div>
				<?php } ?>

				<div class="right social-block text-center share">
					<?php get_template_part( 'partials/social' ); ?>
				</div>
			</div>
		</div>

		<div class="main-line white-bg">
			<div class="top-waves cf">
				<div class="waves-line">
					<?php for ( $i = 0; $i < 140; $i++ ) {
						echo '<div class="wave wave-in left"></div>';
						echo '<div class="wave wave-out left"></div>';
					} ?>
				</div>
			</div>

			<div class="middle-line cf text-center">
				<div class="background white-bg"></div>

				<div class="container cf">
					<div class="logo">
						<?php if ( tell_get_option( 'opt-logo-image', 'url' ) ) { ?>
							<a href="<?php echo esc_url( home_url() ); ?>/" class="white-col">
								<img src="<?php echo tell_get_option( 'opt-logo-image', 'url' ); ?>" alt="<?php echo bloginfo( 'name' ); ?>">
							</a>
						<?php } else { ?>
							<a href="<?php echo esc_url( home_url() ); ?>/" class="logo-title black-col"><?php echo bloginfo( 'name' ); ?></a>
						<?php } ?>
					</div>


					<div class="right cf fixed-search">
						<nav class="mobile-menu left">
							<i class="material-icons black-col blue-col-hover open-menu">view_headline</i>
							<div class="menu-container">
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

						<div class="search left cf">
							<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="left">
								<input type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php _e( 'Search', 'local' ); ?>"/>

								<button type="submit" class="material-icons">search</button>
							</form>

							<button type="button" class="open left material-icons">search</button>
							<button type="button" class="close left current-co material-icons red-col">clear
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="bottom-line text-center">
				<div class="container cf">
					<div class="background white-bg"></div>

					<nav class="full-menu">
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
	</div>

	<div class="bottom-header-container">
		<div class="one-line white-bg">
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
						<button type="button" class="close left current-co material-icons">clear</button>
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
	</div>
</header>