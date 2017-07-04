<?php wp_reset_query();
$counter = 0;
$query   = new WP_Query(
	array(
		'post_type'      => 'news',
		'posts_per_page' => 4
	)
);
if ( $query->have_posts() ) : ?>
	<section class="page-home-news">
		<?php /*if ( tell_get_meta( 'page_home_news_bg_image' ) ) {
			$bg_image = tell_get_meta( 'page_home_news_bg_image' );
			if ( isset( $bg_image ) && !empty( $bg_image ) ) {
				foreach ( $bg_image as $image ) {
					echo '<div class="background-image blue-light-bg"></div>';
				}
			}
		} */ ?>

		<div class="container">
			<div class="heading text-center margin-bottom-60">
				<h2 class="margin-bottom-30"><span><?php echo tell_get_meta( 'page_home_news_title' ); ?></span></h2>
			</div>

			<div class="row cf">
				<?php while ( $query->have_posts() ) : $query->the_post();
					if ( 0 == $counter ) { ?>
						<article <?php post_class( 'archive-news-item col-md-6 margin-bottom-30' ); ?>>
							<div class="image margin-bottom-15">
								<a href="<?php the_permalink(); ?>">
									<?php echo tell_get_post_image( 570, 320 ); ?>
								</a>
							</div>

							<div class="text">
								<h2>
									<a href="<?php the_permalink(); ?>" class="black-col blue-col-hover"><?php the_title(); ?></a>
								</h2>

								<time datetime="<?php the_time( 'Y-m-d' ); ?>">
									<i class="material-icons">date_range</i><?php the_time( 'Y-m-d' ); ?></time>

								<div class="description">
									<?php echo tell_trim_excerpt( 40 ); ?>
								</div>
							</div>
						</article>
					<?php } else { ?>
						<article <?php post_class( 'archive-news-item col-md-6 cf margin-bottom-15' ); ?>>
							<div class="col-xs-3 image margin-bottom-15">
								<a href="<?php the_permalink(); ?>" class="row">
									<?php echo tell_get_post_image( 145, 145 ); ?>
								</a>
							</div>

							<div class="col-xs-9 text image margin-bottom-15">
								<h2>
									<a href="<?php the_permalink(); ?>" class="black-col blue-col-hover"><?php the_title(); ?></a>
								</h2>

								<time datetime="<?php the_time( 'Y-m-d' ); ?>">
									<i class="material-icons">date_range</i><?php the_time( 'Y-m-d' ); ?></time>

								<div class="description">
									<?php echo tell_trim_excerpt( 20 ); ?>
								</div>
							</div>
						</article>
					<?php }
					$counter++;
				endwhile; ?>
			</div>
		</div>
	</section>
<?php endif;
wp_reset_query(); ?>