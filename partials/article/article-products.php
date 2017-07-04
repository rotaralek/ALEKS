<div class="col-md-3 col-sm-6 margin-bottom-30 item">
	<article <?php post_class( 'archive-product-item card-shadow white-bg' ); ?>>
		<div class="image margin-bottom-15">
			<a href="<?php the_permalink(); ?>" class="row">
				<?php echo tell_get_post_image( 300, 300 ); ?>
			</a>
		</div>

		<div class="text cf">
			<h3 class="margin-bottom-15">
				<a href="<?php the_permalink(); ?>" class="black-col blue-col-hover"><?php the_title(); ?></a>
			</h3>

			<div class="price blue-light-col margin-bottom-30">
				<?php $regular_price = get_post_meta( $post->ID, '_regular_price' );
				if ( is_array( $regular_price ) && !empty( $regular_price ) ) {
					foreach ( $regular_price as $price ) {
						$regular_price_item = $price;
						if ( '' != $regular_price_item && !strpos( $regular_price_item, '.' ) ) {
							$regular_price_item = $regular_price_item . '.00';
						}
					}
				}

				if ( isset( $regular_price_item ) && !empty( $regular_price_item ) ) {
					$sale_price = get_post_meta( $post->ID, '_sale_price' );
					if ( is_array( $sale_price ) && !empty( $sale_price ) ) {
						foreach ( $sale_price as $price ) {
							$sale_price_item = $price;
							if ( '' != $sale_price_item && !strpos( $sale_price_item, '.' ) ) {
								$sale_price_item = $sale_price_item . '.00';
							}
						}
					}

					if ( isset( $sale_price_item ) && !empty( $sale_price_item ) ) { ?>
						<del class="red-col">
							<?php echo tell_get_option( 'opt-currency' ) . $regular_price_item; ?>
						</del>

						<ins class="blue-light-col">
							<?php echo tell_get_option( 'opt-currency' ) . $sale_price_item; ?>
						</ins>
					<?php } else { ?>
						<ins class="blue-light-col">
							<?php echo tell_get_option( 'opt-currency' ) . $regular_price_item; ?>
						</ins>
					<?php }
				} ?>
			</div>
		</div>

		<a href="<?php the_permalink(); ?>" class="btn small blue-light-bg white-col orange-bg-hover btn-shadow right"><?php _e( 'Details', 'local' ); ?></a>
	</article>
</div>