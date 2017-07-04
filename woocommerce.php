<?php get_header( '2' ); ?>

	<div class="container padding-top-60">
		<div class="row cf">
			<div class="col-md-9 margin-bottom-30">
				<?php if ( have_posts() ) :
					woocommerce_content();
				endif;
				wp_reset_query(); ?>
			</div>

			<div class="col-md-3 margin-bottom-30">
				<div class="sidebar cf">
					<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 'sidebar-shop' ) ) {
						//dynamic_sidebar('sidebar-shop');
					} else {
						get_sidebar();
					} ?>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>