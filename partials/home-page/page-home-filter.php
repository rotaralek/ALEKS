<?php if ( tell_get_meta( 'page_home_post_type' ) ) {
	$post_types = tell_get_meta( 'page_home_post_type' );
	if ( !empty( $post_types ) ) {
		$post_types_categories = $post_types . '-country';
	} else {
		$post_types = 'post';
	}
} else {
	$post_types = 'post';
} ?>
<div class="template-home-filter">
	<div class="multi-tabs">
		<div class="nav-container text-center">
			<nav class="cf text-center">
				<?php if ( 'hide' != tell_get_meta( 'page_home_filter_travels_show' ) ) : ?>
					<a href="#tab-1" class="left blue-bg white-col">
						<?php _e( 'Travels', 'local' ); ?>
					</a>
				<?php endif; ?>

				<?php if ( 'hide' != tell_get_meta( 'page_home_filter_hotels_show' ) ) : ?>
					<a href="#tab-2" class="left red-bg white-col">
						<?php _e( 'Hotels', 'local' ); ?>
					</a>
				<?php endif; ?>

				<?php if ( 'hide' != tell_get_meta( 'page_home_filter_rooms_show' ) ) : ?>
					<a href="#tab-3" class="left red-bg white-col">
						<?php _e( 'Rooms', 'local' ); ?>
					</a>
				<?php endif; ?>

				<?php if ( 'hide' != tell_get_meta( 'page_home_filter_car_rentals_show' ) ) : ?>
					<a href="#tab-4" class="left red-bg white-col">
						<?php _e( 'Car Rentals', 'local' ); ?>
					</a>
				<?php endif; ?>
			</nav>
		</div>

		<div class="tab-container">
			<?php if ( 'hide' != tell_get_meta( 'page_home_filter_travels_show' ) ) : ?>
				<div class="tab-item blue-bg white-col posts-filter" id="tab-1">
					<form action="<?php the_permalink(); ?>" method="POST" class="filter-form search-travels text-center" data-post-type="tours" data-number-of-posts="<?php echo tell_get_meta( 'page_home_post_type_number' ); ?>">
						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Travel type', 'local' ); ?></p>

							<div class="input-field white-bg big-select">
								<select name="filter_type" class="select-menu select-type">
									<option value="" label><?php _e( 'Select type', 'local' ); ?></option>
									<option value="tours"><?php _e( 'Tours', 'local' ); ?></option>
									<option value="cruises"><?php _e( 'Cruises', 'local' ); ?></option>
									<option value="excursions"><?php _e( 'Excursions', 'local' ); ?></option>
								</select>

								<i class="material-icons white-col blue-light-bg yellow-bg-hover">expand_more</i>
							</div>
						</label>

						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Where do you want to go?', 'local' ); ?></p>

							<div class="input-field country-select white-bg big-select">
								<select name="filter_country" class="select-menu">
									<option value="" label><?php _e( 'Select country', 'local' ); ?></option>
								</select>

								<i class="material-icons white-col blue-light-bg yellow-bg-hover">expand_more</i>
							</div>
						</label>

						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Available resorts', 'local' ); ?></p>

							<div class="input-field resort-select white-bg big-select">
								<select name="filter_city" class="select-menu">
									<option value="" label><?php _e( 'Select resort', 'local' ); ?></option>
								</select>

								<i class="material-icons white-col blue-light-bg yellow-bg-hover">expand_more</i>
							</div>
						</label>

						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Stars', 'local' ); ?></p>

							<div class="input-field star-select white-bg">
								<select name="filter_stars" class="select-menu">
									<option value="" label></option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>

								<i class="material-icons white-col blue-light-bg yellow-bg-hover">star</i>
							</div>
						</label>

						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Price', 'local' ); ?></p>

							<input type="text" name="filter_price" class="range-amount white-col">

							<div class="range-slider" data-max-price="<?php echo tell_get_meta( 'page_home_filter_price' ); ?>"></div>
						</label>

						<button type="submit" class="btn small blue-light-bg orange-bg-hover btn-shadow"><?php _e( 'Search', 'local' ); ?></button>
					</form>
				</div>
			<?php endif; ?>

			<?php if ( 'hide' != tell_get_meta( 'page_home_filter_hotels_show' ) ) : ?>
				<div class="tab-item blue-bg white-col hotels-filter" id="tab-2">
					<form action="<?php the_permalink(); ?>" method="POST" class="filter-form search-hotels text-center" data-post-type="hotels" data-number-of-posts="<?php echo tell_get_meta( 'page_home_post_type_number' ); ?>" data-to-rices="true">
						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Where do you want to go?', 'local' ); ?></p>

							<div class="input-field country-select white-bg big-select">
								<select name="filter_country" class="select-menu">
									<option value="" label><?php _e( 'Select country', 'local' ); ?></option>
									<?php $args = array(
										'type'         => array( 'hotels' ),
										'child_of'     => 0,
										'parent'       => 0,
										'orderby'      => 'name',
										'order'        => 'ASC',
										'hide_empty'   => 1,
										'hierarchical' => 1,
										'exclude'      => '',
										'include'      => '',
										'number'       => '',
										'taxonomy'     => 'hotels-country',
										'pad_counts'   => false );

									$categories = get_categories( $args );
									foreach ( $categories as $cat ) {
										echo '<option value="' . $cat->slug . '">' . $cat->name . '</option>';
									} ?>
								</select>

								<i class="material-icons white-col blue-light-bg yellow-bg-hover">expand_more</i>
							</div>
						</label>

						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Cities', 'local' ); ?></p>

							<div class="input-field resort-select white-bg big-select">
								<select name="filter_city" class="select-menu">
									<option value="" label><?php _e( 'Select the city', 'local' ); ?></option>
								</select>

								<i class="material-icons white-col blue-light-bg yellow-bg-hover">expand_more</i>
							</div>
						</label>

						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Stars', 'local' ); ?></p>

							<div class="input-field star-select white-bg">
								<select name="filter_stars" class="select-menu">
									<option value="" label></option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>

								<i class="material-icons white-col blue-light-bg yellow-bg-hover">star</i>
							</div>
						</label>

						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Price', 'local' ); ?></p>

							<input type="text" name="filter_price" class="range-amount white-col">

							<div class="range-slider" data-max-price="<?php echo tell_get_meta( 'page_home_filter_price' ); ?>"></div>
						</label>

						<button type="submit" class="btn small blue-light-bg orange-bg-hover btn-shadow"><?php _e( 'Search', 'local' ); ?></button>
					</form>
				</div>
			<?php endif; ?>

			<?php if ( 'hide' != tell_get_meta( 'page_home_filter_rooms_show' ) ) : ?>
				<div class="tab-item blue-bg white-col rooms-filter" id="tab-3">
					<form action="<?php the_permalink(); ?>" method="POST" class="filter-form search-rooms text-center" data-post-type="rooms" data-number-of-posts="<?php echo tell_get_meta( 'page_home_post_type_number' ); ?>">
						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Room type', 'local' ); ?></p>

							<div class="input-field country-select white-bg big-select">
								<select name="filter_room_type" class="select-menu">
									<option value="" label><?php _e( 'Select room type', 'local' ); ?></option>
									<?php $args = array(
										'type'         => array( 'rooms' ),
										'child_of'     => 0,
										'parent'       => 0,
										'orderby'      => 'name',
										'order'        => 'ASC',
										'hide_empty'   => 1,
										'hierarchical' => 1,
										'exclude'      => '',
										'include'      => '',
										'number'       => '',
										'taxonomy'     => 'room-type',
										'pad_counts'   => false );

									$categories = get_categories( $args );
									foreach ( $categories as $cat ) {
										echo '<option value="' . $cat->slug . '">' . $cat->name . '</option>';
									} ?>
								</select>

								<i class="material-icons white-col blue-light-bg yellow-bg-hover">expand_more</i>
							</div>
						</label>

						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Price', 'local' ); ?></p>

							<input type="text" name="filter_price" class="range-amount white-col">

							<div class="range-slider" data-max-price="<?php echo tell_get_meta( 'page_home_filter_price' ); ?>"></div>
						</label>

						<button type="submit" class="btn small blue-light-bg orange-bg-hover btn-shadow"><?php _e( 'Search', 'local' ); ?></button>
					</form>
				</div>
			<?php endif; ?>

			<?php if ( 'hide' != tell_get_meta( 'page_home_filter_car_rentals_show' ) ) : ?>
				<div class="tab-item blue-bg white-col" id="tab-4">
					<form action="<?php the_permalink(); ?>" method="POST" class="filter-form search-car-rentals text-center" data-post-type="car-rentals" data-number-of-posts="<?php echo tell_get_meta( 'page_home_post_type_number' ); ?>">
						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Where do you want to go?', 'local' ); ?></p>

							<div class="input-field country-select white-bg big-select">
								<select name="filter_country" class="select-menu">
									<option value="" label><?php _e( 'Select country', 'local' ); ?></option>
									<?php $args = array(
										'type'         => array( 'car-rentals' ),
										'child_of'     => 0,
										'parent'       => 0,
										'orderby'      => 'name',
										'order'        => 'ASC',
										'hide_empty'   => 1,
										'hierarchical' => 1,
										'exclude'      => '',
										'include'      => '',
										'number'       => '',
										'taxonomy'     => 'car-rentals-country',
										'pad_counts'   => false );

									$categories = get_categories( $args );
									foreach ( $categories as $cat ) {
										echo '<option value="' . $cat->slug . '">' . $cat->name . '</option>';
									} ?>
								</select>

								<i class="material-icons white-col blue-light-bg yellow-bg-hover">expand_more</i>
							</div>
						</label>

						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Cities', 'local' ); ?></p>

							<div class="input-field resort-select white-bg big-select">
								<select name="filter_country" class="select-menu">
									<option value="" label><?php _e( 'Select the city', 'local' ); ?></option>
								</select>

								<i class="material-icons white-col blue-light-bg yellow-bg-hover">expand_more</i>
							</div>
						</label>

						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Body type', 'local' ); ?></p>

							<div class="input-field body-type-select white-bg big-select">
								<select name="filter_body_type" class="select-menu">
									<option value="" label><?php _e( 'Select the type', 'local' ); ?></option>
									<?php $args = array(
										'type'         => array( 'car-rentals' ),
										'child_of'     => 0,
										'parent'       => 0,
										'orderby'      => 'name',
										'order'        => 'ASC',
										'hide_empty'   => 1,
										'hierarchical' => 1,
										'exclude'      => '',
										'include'      => '',
										'number'       => '',
										'taxonomy'     => 'body-type',
										'pad_counts'   => false );

									$categories = get_categories( $args );
									foreach ( $categories as $cat ) {
										echo '<option value="' . $cat->slug . '">' . $cat->name . '</option>';
									} ?>
								</select>

								<i class="material-icons white-col blue-light-bg yellow-bg-hover">expand_more</i>
							</div>
						</label>

						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Transmission', 'local' ); ?></p>

							<div class="input-field body-type-select white-bg big-select">
								<select name="filter_transmission" class="select-menu">
									<option value="" label><?php _e( 'Transmission', 'local' ); ?></option>
									<?php $args = array(
										'type'         => array( 'car-rentals' ),
										'child_of'     => 0,
										'parent'       => 0,
										'orderby'      => 'name',
										'order'        => 'ASC',
										'hide_empty'   => 1,
										'hierarchical' => 1,
										'exclude'      => '',
										'include'      => '',
										'number'       => '',
										'taxonomy'     => 'transmission',
										'pad_counts'   => false );

									$categories = get_categories( $args );
									foreach ( $categories as $cat ) {
										echo '<option value="' . $cat->slug . '">' . $cat->name . '</option>';
									} ?>
								</select>

								<i class="material-icons white-col blue-light-bg yellow-bg-hover">expand_more</i>
							</div>
						</label>

						<label class="black-col text-left margin-bottom-30">
							<p class="white-col"><?php _e( 'Price', 'local' ); ?></p>

							<input type="text" name="filter_price" class="range-amount white-col">

							<div class="range-slider" data-max-price="<?php echo tell_get_meta( 'page_home_filter_price' ); ?>"></div>
						</label>

						<button type="submit" class="btn small blue-light-bg orange-bg-hover btn-shadow"><?php _e( 'Search', 'local' ); ?></button>
					</form>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>