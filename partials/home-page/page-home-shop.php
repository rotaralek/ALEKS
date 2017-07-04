<?php wp_reset_query();
$posts_per_page = 4;
if ( tell_get_meta( 'page_home_product_number' ) ) {
	$posts_per_page = tell_get_meta( 'page_home_product_number' );
}
$counter = 0;
$query   = new WP_Query(
	array(
		'post_type'      => 'product',
		'posts_per_page' => $posts_per_page,
		'orderby'        => 'rand'
	)
);
if ( $query->have_posts() ) : ?>
	<section class="page-home-products grey-light-bg">
		<div class="container">
			<div class="heading text-center margin-bottom-60">
				<h2 class="margin-bottom-30"><span><?php echo tell_get_meta( 'page_home_product_title' ); ?></span></h2>
			</div>

			<div class="row cf items">
				<?php while ( $query->have_posts() ) : $query->the_post();
					get_template_part( 'partials/article/article', 'products' );
				endwhile; ?>
			</div>
		</div>
	</section>
<?php endif;
wp_reset_query(); ?>