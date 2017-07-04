<?php wp_reset_query();
$query = new WP_Query(
	array(
		'post_type'      => 'partners',
		'posts_per_page' => -1
	)
);
if ( $query->have_posts() ) : ?>
	<section class="page-home-partners white-bg">
		<div class="heading text-center margin-bottom-60">
			<h2><span><?php echo tell_get_meta( 'page_home_partners_title' ); ?></span></h2>
		</div>

		<div class="items text-center">
			<?php while ( $query->have_posts() ) :
			$query->the_post();
			if ( tell_get_meta( 'partners_url' ) ){ ?>
			<a href="<?php echo tell_get_meta( 'partners_url' ); ?>" class="item margin-bottom-30">
				<?php } else { ?>
				<div class="item margin-bottom-30">
					<?php }
					echo tell_get_post_image( 150, 150, false, true, true );
					if ( tell_get_meta( 'partners_url' ) ){ ?>
			</a>
			<?php } else { ?>
		</div>
		<?php }
		endwhile; ?>
		</div>
	</section>
<?php endif;
wp_reset_query(); ?>