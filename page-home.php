<?php
/*
  * Template name: Template Home
  * */

wp_reset_query();
$query_slider = new WP_Query(
	array(
		'post_type'      => array( 'tours', 'excursions', 'cruises', 'hotels', 'rooms', 'car-rentals', 'post', 'news' ),
		'posts_per_page' => 1,
		'meta_query'     => array(
			array(
				'key'   => 'tell_slider_home_show',
				'value' => 'show'
			)
		)
	)
);
if ( $query_slider->have_posts() && 'hide' != tell_get_meta( 'page_home_slider_display' ) ) {
	get_header();
} else {
	get_header( '2' );
}
wp_reset_query(); ?>

	<!-- Slider -->
<?php if ( 'hide' != tell_get_meta( 'page_home_slider_display' ) ) {
	get_template_part( 'partials/home-page/page-home', 'slider' );
} ?>

	<!-- Filter -->
<?php if ( 'hide' != tell_get_meta( 'page_home_filter_display' ) ) {
	get_template_part( 'partials/home-page/page-home', 'filter' );
} ?>

	<!-- Tours -->
<?php if ( 'hide' != tell_get_meta( 'page_home_filter_display' ) ) {
	get_template_part( 'partials/home-page/page-home', 'posts' );
} ?>

	<!-- Information -->
<?php if ( 'hide' != tell_get_meta( 'page_home_information_display' ) ) {
	get_template_part( 'partials/home-page/page-home', 'information' );
} ?>

	<!-- News -->
<?php if ( 'hide' != tell_get_meta( 'page_home_news_display' ) ) {
	get_template_part( 'partials/home-page/page-home', 'news' );
} ?>

	<!-- Shop -->
<?php if ( 'hide' != tell_get_meta( 'page_home_product_display' ) ) {
	get_template_part( 'partials/home-page/page-home', 'shop' );
} ?>

	<!-- Partners -->
<?php if ( 'hide' != tell_get_meta( 'page_home_partners_display' ) ) {
	get_template_part( 'partials/home-page/page-home', 'partners' );
} ?>

<?php get_footer(); ?>