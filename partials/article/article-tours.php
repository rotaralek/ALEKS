<div class="col-sm-6 margin-bottom-30">
	<article <?php post_class( 'archive-tours-item card-shadow flex-box transition' ); ?>>
		<div class="image">
			<a href="<?php the_permalink(); ?>">
				<?php echo tell_get_post_image( 420, 420 ); ?>
			</a>
		</div>

		<div class="text cf white-bg">
			<div class="top-waves cf">
				<div class="waves-line">
					<?php for ( $i = 0; $i < 40; $i++ ) {
						echo '<div class="wave wave-in left"></div>';
						echo '<div class="wave wave-out left"></div>';
					} ?>
				</div>
			</div>

			<h2>
				<a href="<?php the_permalink(); ?>" class="black-col blue-col-hover"><?php the_title(); ?></a>
				<span class="orange-col"><?php echo tell_get_meta( 'post_stars' ); ?>
					<sup class="material-icons">star</sup>
				</span>
			</h2>

			<div class="details">
				<?php $current_category = wp_get_post_terms( $post->ID, 'tours-country', array( "fields" => "all" ) );
				foreach ( $current_category as $category ) {
					$link = get_term_link( $category->slug, 'tours-country' );
					echo '<a href="' . $link . '" class="red-col blue-col-hover"><i class="material-icons red-col">place</i>' . $category->name . '</a>';
				} ?>

				<?php if ( tell_get_meta( 'tours_length' ) ) { ?>
					<span><i class="material-icons">alarm</i><?php echo tell_get_meta( 'tours_length' ); ?></span>
				<?php } ?>

				<?php if ( tell_get_meta( 'post_date_begin' ) ) { ?>
					<p><i class="material-icons">event_note</i><?php echo tell_get_date_revert( tell_get_meta( 'post_date_begin' ) ) . ' - ' . tell_get_date_revert( tell_get_meta( 'post_date_end' ) ); ?></p>
				<?php } ?>
			</div>
		</div>

		<div class="price">
			<?php if ( tell_get_meta( 'post_price' ) ) { ?>
				<span class="red-bg white-col"><?php echo tell_get_option( 'opt-currency' ) . ' ' . tell_get_meta( 'post_price' ); ?></span>
			<?php } ?>
		</div>
	</article>
</div>