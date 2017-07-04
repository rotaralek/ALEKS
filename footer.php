</div>

<footer class="grey-light-bg">
	<div class="container top-line">
		<div class="row cf">
			<div class="col-lg-4 col-sm-6 about-block margin-bottom-30">
				<h3><?php echo tell_get_option( 'opt-footer-about-title' ); ?></h3>
				<p><?php echo tell_get_option( 'opt-footer-about-text' ); ?></p>
			</div>

			<div class="col-lg-4 col-sm-6 popular-block margin-bottom-30">
				<h3><?php echo tell_get_option( 'opt-footer-news-title' ); ?></h3>

				<div class="items">
					<?php
					wp_reset_query();
					$query = new WP_Query(
						array(
							'posts_per_page'      => 3,
							'post_type'           => 'post',
							'ignore_sticky_posts' => 1,
							'post__not_in'        => get_option( 'sticky_posts' )
						)
					);
					if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
						<article class="cf margin-bottom-15">
							<a href="<?php the_permalink(); ?>" class="left">
								<?php echo tell_get_post_image( 60, 60 ); ?>
							</a>

							<div class="text">
								<h4>
									<a href="<?php the_permalink(); ?>" class="black-col orange-col-hover"><?php the_title(); ?></a>
								</h4>
								<time datetime="<?php the_time( 'Y-m-d' ); ?>" class="text-center left">
									<i class="material-icons">event_note</i><?php the_time( 'Y-m-d' ); ?></time>
							</div>
						</article>
					<?php endwhile; endif;
					wp_reset_query(); ?>
				</div>
			</div>

			<div class="col-lg-4 col-sm-6 tags-block margin-bottom-30">
				<h3><?php echo tell_get_option( 'opt-footer-tags-title' ); ?></h3>

				<div class="items cf">
					<?php $args = array(
						'orderby'                => 'count',
						'order'                  => 'ASC',
						'hide_empty'             => true,
						'exclude'                => array(),
						'exclude_tree'           => array(),
						'include'                => array(),
						'number'                 => 18,
						'fields'                 => 'all',
						'slug'                   => '',
						'parent'                 => '',
						'hierarchical'           => true,
						'child_of'               => 0,
						'get'                    => '', // ставим all чтобы получить все термины
						'name__like'             => '',
						'pad_counts'             => false,
						'offset'                 => '',
						'search'                 => '',
						'cache_domain'           => 'core',
						'name'                   => '', // str/arr поле name для получения термина по нему. C 4.2.
						'childless'              => false, // true не получит (пропустит) термины у которых есть дочерние термины. C 4.2.
						'update_term_meta_cache' => true, // подгружать метаданные в кэш
						'meta_query'             => '',
					);
					$all_tags   = get_tags( $args );
					foreach ( $all_tags as $tag ) {
						echo '<a href="' . get_tag_link( $tag->term_id ) . '" class="black-col white-bg orange-bg-hover white-col-hover">' . $tag->name . '</a>';
					} ?>
				</div>
			</div>
		</div>
	</div>

	<div class="bottom-line">
		<div class="container">
			<p><?php echo tell_get_option( 'opt-footer-copyright-text' ); ?></p>
		</div>
	</div>
</footer>    </div>

<!-- Scripts -->
<?php wp_footer(); ?>
</body></html>