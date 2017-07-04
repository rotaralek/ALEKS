(function ( $ ) {
	"use strict";

	/*
	 * Get window size
	 */
	var windowWidth = $( window ).width();
	var windowHeight = $( window ).height();
	var bodyHeight = $( 'body' ).height();

	//Header scroll effect
	if ( $( document ).find( 'header' ).length ) {
		var headerItem = $( document ).find( 'header' );
		var headerHeight = headerItem.height();

		var headerResize = function () {
			$( document ).find( '.header-height' ).css( {
				height: headerHeight
			} );
		};

		headerResize();

		$( window ).resize( function () {
			headerResize();
		} );

		if ( headerItem.find( '.top-header-container' ).length ) {
			var headerTopLine = headerItem.find( '.top-header-container' );
			var headerBottomLine = headerItem.find( '.bottom-header-container' );
			var headerOffset = 0;

			if ( $( document ).find( '#wpadminbar' ).length ) {
				headerOffset = $( document ).find( '#wpadminbar' ).height();
			}

			var headerEffect = function () {
				var scroll_top = $( document ).scrollTop();

				if ( scroll_top > 0 ) {
					headerItem.addClass( 'white-bg' );

					headerItem.find( '.background' ).css( {
						opacity: 1
					} );

					headerTopLine.css( {
						top: -300
					} );

					headerBottomLine.css( {
						top: headerOffset
					} );
				} else {
					headerItem.removeClass( 'white-bg' );

					headerItem.find( '.background' ).css( {
						opacity: 0.8
					} );

					headerBottomLine.css( {
						top: -300
					} );

					headerTopLine.css( {
						top: headerOffset
					} );
				}
			};
			headerEffect();

			$( window ).on( 'scroll', function () {
				headerEffect();
			} );

			window.addEventListener( "orientationchange", function () {
				headerEffect();
			}, false );
		}
	}

	//Home page slider
	if ( $( document ).find( '.template-home-slider' ).length ) {
		var pageHomeSlider = function () {
			if ( $( document ).find( '#wpadminbar' ).length ) {
				windowHeight = windowHeight - $( '#wpadminbar' ).height();
			}

			$( document ).find( '.template-home-slider' ).css( {
				height: windowHeight
			} );
			$( document ).find( '.template-home-slider .item' ).css( {
				height: windowHeight
			} );
			var textBlockHeight = $( document ).find( '.template-home-slider .item .text' ).height();
			var textBlockPosition = (windowHeight - textBlockHeight) / 2;
			var dotsBlockPosition = textBlockPosition + textBlockHeight + (textBlockHeight / 3);
			$( document ).find( '.template-home-slider .item .text' ).css( {
				top: textBlockPosition
			} );

			/*setTimeout( function () {
			 $( document ).find( '.template-home-slider .owl-dots' ).css( {
			 top: dotsBlockPosition
			 } );
			 }, 100 );*/
		};

		$( window ).on( 'load', function () {
			pageHomeSlider();
		} );

		$( window ).resize( function () {
			pageHomeSlider();
		} );
	}

	//Header phone block
	/*if ( $( document ).find( 'header .top-line .phone-block' ).length ) {
	 var phoneBlock = $( document ).find( 'header .top-line .phone-block' ).width();
	 phoneBlock = (phoneBlock + 30) / 2;
	 $( document ).find( 'header .top-line .phone-block .before' ).css( {
	 borderRightWidth: phoneBlock
	 } );
	 $( document ).find( 'header .top-line .phone-block .after' ).css( {
	 borderLeftWidth: phoneBlock
	 } );
	 }*/

	//Search toggle
	$( document ).on( 'click', '.search > button', function ( e ) {
		e.preventDefault();

		if ( $( this ).hasClass( 'open' ) ) {
			$( this ).parent().addClass( 'active' );
		} else {
			$( this ).parent().removeClass( 'active' );
		}
	} );

	$( window ).on( 'load', function () {
		/*
		 * Spinner
		 */
		$( document ).find( '.spinner' ).css( {
			opacity: 0,
			zIndex: -1
		} );

		$( document ).find( '.fade-in-body' ).css( { opacity: 1 } );

		/*
		 * Slider
		 */
		if ( $( document ).find( '.tell-slider' ).length ) {
			var owl = $( document ).find( '.tell-slider' );
			owl.each( function () {
				$( this ).owlCarousel( {
					items: 1,
					nav: true,
					mobileBoost: true,
					navText: [ '', '' ],
					margin: 0,
					merge: false,
					center: false,
					autoPlayTimeout: 3000,
					autoPlaySpeed: 6000,
					smartSpeed: 1500,
					autoplay: false,
					autoplayHoverPause: true,
					loop: $( this ).children().length > 1
				} );
			} );

			setTimeout( function () {
				if ( owl.find( '.owl-item.active iframe' ).length ) {
					var defaultVideoSrc = owl.find( '.owl-item.active iframe' ).attr( 'data-default-src' );
					var parameters = '?autoplay=1&controls=0&showinfo=0&loop=1';
					var newVideoSrc = defaultVideoSrc + parameters;
					owl.find( '.owl-item.active iframe' ).attr( 'src', newVideoSrc );
				}
			}, 1000 );

			owl.on( 'changed.owl.carousel', function ( event ) {
				setTimeout( function () {
					owl.find( '.owl-item' ).each( function () {
						var parameters = '?autoplay=1&controls=0&showinfo=0&loop=1';
						if ( $( this ).find( 'iframe' ).length ) {
							var defaultVideoSrc = $( this ).find( 'iframe' ).attr( 'data-default-src' );
							$( this ).find( 'iframe' ).attr( 'src', defaultVideoSrc );
							var newVideoSrc = defaultVideoSrc + parameters;
							if ( owl.find( '.owl-item.active iframe' ).length ) {
								owl.find( '.owl-item.active iframe' ).attr( 'src', newVideoSrc );
							}
						}
					} );

					$( document ).find( 'img' ).lazyload( {
						threshold: 200
					} );
				}, 100 );
			} );

			$( document ).on( 'keyup', function ( evt ) {
				if ( evt.keyCode == 37 ) {
					//To the left side
					owl.trigger( 'prev.owl.carousel', 2000 );
				}
				if ( evt.keyCode == 39 ) {
					//To the right side
					owl.trigger( 'next.owl.carousel', 2000 );
				}
			} );
		}
	} );

	if ( $( document ).find( '.cruises-archive' ).length ) {
		if ( windowWidth > 1024 ) {
			var currentHeight = 0;
			$( document ).find( '.cruises-archive article' ).each( function () {
				currentHeight = $( this ).height();
				$( this ).css( {
					height: currentHeight
				} );
			} );
		}
	}

	//Tabs
	if ( $( document ).find( '.multi-tabs' ).length ) {
		var container = $( '.multi-tabs' );
		$( document ).find( '.multi-tabs nav' ).on( 'click', 'a', function ( e ) {
			e.preventDefault();
			$( document ).find( '.multi-tabs nav a' ).removeClass( 'active' ).removeClass( 'blue-bg' ).addClass( 'red-bg' );
			$( this ).addClass( 'active' ).removeClass( 'red-bg' ).addClass( 'blue-bg' );
			var currentId = $( this ).attr( 'href' );
			var thisLink = $( this ).attr( 'href' );
			$( document ).find( '.multi-tabs .tab-item' ).removeClass( 'active' ).removeClass( 'blue-bg' ).addClass( 'red-bg' );
			$( document ).find( thisLink ).addClass( 'active' ).removeClass( 'red-bg' ).addClass( 'blue-bg' );
		} );
	}

	if ( $( document ).find( '.inner-multi-tabs' ).length ) {
		var inner_container = $( '.inner-multi-tabs' );
		$( document ).find( '.inner-multi-tabs .inner-multi-tabs-nav' ).on( 'click', 'a', function ( e ) {
			e.preventDefault();
			$( document ).find( '.inner-multi-tabs .inner-multi-tabs-nav a' ).removeClass( 'inner-active' );
			$( this ).addClass( 'inner-active' );
			var thisLink = $( this ).attr( 'href' );
			inner_container.find( '.inner-multi-tabs-item' ).removeClass( 'inner-active' );
			$( document ).find( thisLink ).addClass( 'inner-active' );
		} );
	}

	function setEqualHeight( columns ) {
		if ( $( this ).length ) {
			if ( 1024 <= windowWidth ) {
				var tallestcolumn = 0;
				columns.each(
					function () {
						var currentHeight = $( this ).innerHeight();
						if ( currentHeight > tallestcolumn ) {
							tallestcolumn = currentHeight;
						}
					}
				);
				columns.innerHeight( tallestcolumn );
			}
		}
	}

	setEqualHeight();

	//Ui

	//Date picker
	if ( $( document ).find( '.date-picker' ).length ) {
		$( document ).find( '.date-picker' ).datepicker( {
			dateFormat: 'dd/mm/yy'
		} );
	}

	//Select
	if ( $( document ).find( '.select-menu' ).length ) {
		$( document ).find( '.select-menu' ).selectmenu();
	}

	//Price range
	if ( $( document ).find( '.range-slider' ).length ) {
		var maxPrice = $( document ).find( '.range-slider' ).attr( 'data-max-price' );
		if ( '' == maxPrice ) {
			maxPrice = 2500;
		}
		var partFromPrice = maxPrice / 2;
		$( document ).find( '.range-slider' ).slider( {
			range: true,
			min: 0,
			max: maxPrice,
			values: [ 0, partFromPrice ],
			slide: function ( event, ui ) {
				$( document ).find( ".range-amount" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
			}
		} );
		$( document ).find( '.range-amount' ).val( $( document ).find( '.range-slider' ).slider( 'values', 0 ) +
			" - " + $( document ).find( '.range-slider' ).slider( 'values', 1 ) );
	}

	//Share
	if ( $( document ).find( '.share' ).length ) {
		$( document ).find( '.share' ).on( 'click', 'a', function ( e ) {
			e.preventDefault();
			var left = ($( window ).width() / 2) - (450 / 2),
				top = ($( window ).height() / 2) - (450 / 2);
			var href = $( this ).attr( 'href' );
			window.open( href, '_blank', "channelmode=1, toolbar=1, scrollbars=1, resizable=1", "width=450, height=450" );
		} );
	}

	if ( $( document ).find( '.top-page-header' ).length ) {
		var topPageHeader = $( document ).find( '.top-page-header' ).width();
		var topPageHeaderInfo = $( document ).find( '.top-page-header .all-offers' );
		var topPageHeaderTitle = $( document ).find( '.top-page-header h1' );
		var topPageHeaderTitleWidth = topPageHeaderTitle.width();
		if ( $( document ).find( '.top-page-header h1' ).length ) {
			var topPageHeaderTitle = $( document ).find( '.top-page-header h1' );
			var topPageHeaderInfoWidth = topPageHeaderInfo.width();
		} else {
			topPageHeaderInfoWidth = 0;
		}
		if ( (topPageHeaderTitleWidth + topPageHeaderInfoWidth) > topPageHeader ) {
			$( document ).find( '.top-page-header h1' ).css( {
				fontSize: '4vw'
			} );
		}
	}

	//template-home-filter add active class to the tab
	if ( $( document ).find( '.template-home-filter' ).find( 'nav a' ).length ) {
		var filterLinkCounter = 0;
		var filterItemCounter = 0;
		$( document ).find( '.template-home-filter' ).find( 'nav a' ).each( function () {
			if ( filterLinkCounter == 0 ) {
				$( this ).addClass( 'active' ).removeClass( 'red-bg' ).addClass( 'blue-bg' );
			}
			filterLinkCounter++;
		} );
		$( document ).find( '.template-home-filter' ).find( '.tab-item' ).each( function () {
			if ( filterItemCounter == 0 ) {
				$( this ).addClass( 'active' );
				filterItemCounter++;
			}
		} );
	}

	//Lazy load images
	$( document ).find( 'img' ).lazyload( {
		threshold: 200,
		failure_limit: 10
	} );
})( jQuery );