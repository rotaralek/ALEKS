<?php
function tell_css_options()
{
	if ( isset( $_COOKIE[ 'change_red_col' ] ) ) {
		$change_red_col = $_COOKIE[ 'change_red_col' ];
	} else {
		$change_red_col = tell_get_option( 'opt-change-red-col' );
	}
	if ( isset( $_COOKIE[ 'change_blue_col' ] ) ) {
		$change_blue_col = $_COOKIE[ 'change_blue_col' ];
	} else {
		$change_blue_col = tell_get_option( 'opt-change-blue-col' );
	}
	if ( isset( $_COOKIE[ 'change_blue_light_col' ] ) ) {
		$change_blue_light_col = $_COOKIE[ 'change_blue_light_col' ];
	} else {
		$change_blue_light_col = tell_get_option( 'opt-change-blue-light-col' );
	}
	if ( isset( $_COOKIE[ 'change_yellow_col' ] ) ) {
		$change_yellow_col = $_COOKIE[ 'change_yellow_col' ];
	} else {
		$change_yellow_col = tell_get_option( 'opt-change-yellow-col' );
	}
	if ( isset( $_COOKIE[ 'change_orange_col' ] ) ) {
		$change_orange_col = $_COOKIE[ 'change_orange_col' ];
	} else {
		$change_orange_col = tell_get_option( 'opt-change-orange-col' );
	} ?>

	<style type='text/css'>
		/*Background*/
		body {
		<?php if(tell_get_option('opt-color')){
			echo 'background-color: ' . tell_get_option('opt-color');
		} ?>
		}

		/*Colors*/
		.red-bg, .red-bg-hover:hover, .red-bg-hover:active, .red-bg-hover:focus, .tell-divider span, .woocommerce div.product .woocommerce-tabs ul.tabs li a, .content-style table thead {
			background-color: <?php echo $change_red_col ?>;
		}

		.red-col, .red-col-hover:hover, .red-col-hover:active, .red-col-hover:focus, .tell-team.dark .socialbut a:hover, .content-style a, #bbpress-forums a,
		#buddypress a {
			color: <?php echo $change_red_col ?>;
		}

		.blue-bg, .blue-bg-hover:hover, .blue-bg-hover:active, .blue-bg-hover:focus,
		.multi-tabs .nav-container nav a:hover, .multi-tabs .nav-container nav a:active, .multi-tabs .nav-container nav a:focus,
		.woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span,
		.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover, .woocommerce div.product .woocommerce-tabs ul.tabs li a:active, .woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,
		.woocommerce div.product .woocommerce-tabs .panel {
			background-color: <?php echo $change_blue_col ?>;
		}

		.blue-col, .blue-col-hover:hover, .blue-col-hover:active, .blue-col-hover:focus,
		header .bottom-line .full-menu > ul > li.current-menu-item > a,
		header .bottom-line .full-menu a:hover, header .bottom-line .full-menu a:active, header .bottom-line .full-menu a:focus,
		header .one-line .full-menu a:hover, header .one-line .full-menu a:active, header .one-line .full-menu a:focus, .sidebar a:hover, .sidebar a:active, .sidebar a:focus,
		.woocommerce ul.products li.product a.woocommerce-LoopProduct-link:hover, .woocommerce ul.products li.product a.woocommerce-LoopProduct-link:active, .woocommerce ul.products li.product a.woocommerce-LoopProduct-link:focus {
			color: <?php echo $change_blue_col ?>;
		}

		.blue-light-bg, .blue-light-bg-hover:hover, .blue-light-bg-hover:active, .blue-light-bg-hover:focus,
		.blue-light-bg, .blue-light-bg-hover:hover, .blue-light-bg-hover:active, .blue-light-bg-hover:focus,
		.template-home-filter .range-slider.ui-slider .ui-slider-range, .template-home-filter .range-slider .ui-state-default,
		.template-home-filter .range-slider .ui-widget-content .ui-state-default, .template-home-filter .range-slider .ui-widget-header .ui-state-default,
		.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,
		.woocommerce div.product #respond input#submit.alt, .woocommerce div.product a.button.alt, .woocommerce div.product button.button.alt, .woocommerce div.product input.button.alt,
		#add_payment_method .wc-proceed-to-checkout a.checkout-button, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button,
		.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
		#bbpress-forums div.bbp-search-form input[type=submit], #bbpress-forums div.bbp-search-form button[type=submit],
		#bbpress-forums fieldset.bbp-form input[type=submit], #bbpress-forums fieldset.bbp-form button[type=submit],
		#buddypress input[type=submit], #buddypress button[type=submit], #buddypress button[type=button] {
			background-color: <?php echo $change_blue_light_col ?>;
		}

		.blue-light-col, .blue-light-col-hover:hover, .blue-light-col-hover:active, .blue-light-col-hover:focus,
		.woocommerce div.product p.price, .woocommerce div.product span.price,
		.woocommerce ul.products li.product .price, .woocommerce ul.products li.product .price ins {
			color: <?php echo $change_blue_light_col ?>;
		}

		.template-home-filter .range-slider.ui-slider-horizontal, .woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content {
			border-color: <?php echo $change_blue_light_col ?>;
		}

		.yellow-bg, .yellow-bg-hover:hover, .yellow-bg-hover:active, .yellow-bg-hover:focus,
		.template-home-slider .owl-dots .owl-dot:hover, .template-home-slider .owl-dots .owl-dot:focus, .template-home-slider .owl-dots .owl-dot:active, .template-home-slider .owl-dots .owl-dot.active, .top-offers-slider .owl-dots .owl-dot:hover, .top-offers-slider .owl-dots .owl-dot:focus, .top-offers-slider .owl-dots .owl-dot:active, .top-offers-slider .owl-dots .owl-dot.active {
			background-color: <?php echo $change_yellow_col ?>;
		}

		.yellow-col, .yellow-col-hover:hover, .yellow-col-hover:active, .yellow-col-hover:focus, .woocommerce .products .star-rating, .woocommerce .star-rating, .woocommerce p.stars a {
			color: <?php echo $change_yellow_col ?>;
		}

		.orange-bg, .orange-bg-hover:hover, .orange-bg-hover:active, .orange-bg-hover:focus,
		.template-home-filter .range-slider .ui-state-default:hover, .template-home-filter .range-slider .ui-state-default:active,
		.template-home-filter .range-slider .ui-state-default:focus, .template-home-filter .range-slider .ui-state-default .ui-widget-header .ui-state-hover,
		.template-home-filter .range-slider .ui-widget-content .ui-state-default:hover, .template-home-filter .range-slider .ui-widget-content .ui-state-default:active,
		.template-home-filter .range-slider .ui-widget-content .ui-state-default:focus,
		.template-home-filter .range-slider .ui-widget-content .ui-state-default .ui-widget-header .ui-state-hover,
		.template-home-filter .range-slider .ui-widget-header .ui-state-default:hover, .template-home-filter .range-slider .ui-widget-header .ui-state-default:active,
		.template-home-filter .range-slider .ui-widget-header .ui-state-default:focus,
		.template-home-filter .range-slider .ui-widget-header .ui-state-default .ui-widget-header .ui-state-hover,
		.woocommerce #respond input#submit:hover, .woocommerce #respond input#submit:active, .woocommerce #respond input#submit:focus,
		.woocommerce a.button:hover, .woocommerce a.button:active, .woocommerce a.button:focus, .woocommerce button.button:hover,
		.woocommerce button.button:active, .woocommerce button.button:focus, .woocommerce input.button:hover, .woocommerce input.button:active,
		.woocommerce input.button:focus, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle:hover, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle:active,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-handle:focus, .woocommerce div.product #respond input#submit.alt:hover, .woocommerce div.product #respond input#submit.alt:active,
		.woocommerce div.product #respond input#submit.alt:focus, .woocommerce div.product a.button.alt:hover,
		.woocommerce div.product a.button.alt:active, .woocommerce div.product a.button.alt:focus,
		.woocommerce div.product button.button.alt:hover, .woocommerce div.product button.button.alt:active,
		.woocommerce div.product button.button.alt:focus, .woocommerce div.product input.button.alt:hover,
		.woocommerce div.product input.button.alt:active, .woocommerce div.product input.button.alt:focus,
		.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,
		.woocommerce span.onsale, #bbpress-forums div.bbp-search-form input[type=submit]:hover, #bbpress-forums div.bbp-search-form input[type=submit]:active,
		#bbpress-forums div.bbp-search-form input[type=submit]:focus, #bbpress-forums div.bbp-search-form button[type=submit]:hover,
		#bbpress-forums div.bbp-search-form button[type=submit]:active, #bbpress-forums div.bbp-search-form button[type=submit]:focus,
		#bbpress-forums fieldset.bbp-form input[type=submit]:hover, #bbpress-forums fieldset.bbp-form input[type=submit]:active,
		#bbpress-forums fieldset.bbp-form input[type=submit]:focus, #bbpress-forums fieldset.bbp-form button[type=submit]:hover,
		#bbpress-forums fieldset.bbp-form button[type=submit]:active, #bbpress-forums fieldset.bbp-form button[type=submit]:focus,
		#buddypress input[type=submit]:hover, #buddypress input[type=submit]:active, #buddypress input[type=submit]:focus,
		#buddypress button[type=submit]:hover, #buddypress button[type=submit]:active, #buddypress button[type=submit]:focus,
		#buddypress button[type=button]:hover, #buddypress button[type=button]:active, #buddypress button[type=button]:focus {
			background-color: <?php echo $change_orange_col ?>;
		}

		.orange-col, .orange-col-hover:hover, .orange-col-hover:active, .orange-col-hover:focus {
			color: <?php echo $change_orange_col ?>;
		}
	</style>
<?php }

add_action( 'wp_head', 'tell_css_options' );