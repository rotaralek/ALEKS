<?php if ( 'hide' != tell_get_option( 'opt-colors-selector' ) ): ?>
	<div class="style-selector white-bg">
		<div class="trigger show white-bg blue-col">
			<i class="material-icons">settings</i>
		</div>

		<h2><?php _e( 'Style selector', 'local' ); ?></h2>
		<hr>

		<h3><?php _e( 'Choose color scheme', 'local' ); ?>:</h3>

		<div class="color-selector">
			<div class="colors">
				<div class="color show-color red-bg"></div>
				<div class="colorSelector" id="change_red_col"></div>
			</div>

			<div class="colors">
				<div class="color show-color blue-bg"></div>
				<div class="colorSelector" id="change_blue_col"></div>
			</div>

			<div class="colors">
				<div class="color show-color blue-light-bg"></div>
				<div class="colorSelector" id="change_blue_light_col"></div>
			</div>

			<div class="colors">
				<div class="color show-color yellow-bg"></div>
				<div class="colorSelector" id="change_yellow_col"></div>
			</div>

			<div class="colors">
				<div class="color show-color orange-bg"></div>
				<div class="colorSelector" id="change_orange_col"></div>
			</div>
		</div>
	</div>
<?php endif; ?>