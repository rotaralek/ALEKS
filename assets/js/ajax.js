(function ( $ ) {
	"use strict";

	var windowWidth = $( window ).width();
	var windowHeight = $( window ).height();

	//Load posts in current tab
	if ( $( '.category-no-redirect' ).length ) {
		var categoriesContainer = $( '.category-no-redirect' );
		var containerForUpload = $( 'body' ).find( '.place-for-upload' );
		var dataForAjax = containerForUpload.parent();
		var numberOfPosts = dataForAjax.attr( 'data-number-of-posts' );

		var trigger = containerForUpload.parent().find( '.load-more .btn' );

		categoriesContainer.on( 'click', 'a', function ( e ) {
			e.preventDefault();

			trigger.addClass( 'loading' );

			var thisLink = $( this );
			categoriesContainer.find( 'a' ).removeClass( 'active' ).removeClass( 'red-col' ).addClass( 'black-col' );
			thisLink.addClass( 'active' ).addClass( 'red-col' ).removeClass( 'black-col' );

			var category = thisLink.attr( 'data-category' );
			var postType = thisLink.attr( 'data-post-type' );
			dataForAjax.attr( 'data-offset', numberOfPosts );
			dataForAjax.attr( 'data-category', category );

			$.ajax( {
				method: "POST",
				url: ajax_admin[ 'url' ],
				cache: false,
				data: {
					nonce: ajax_admin[ 'nonce' ],
					action: 'load_posts',
					postType: postType,
					numberOfPosts: numberOfPosts,
					category: category
				},
				success: function ( response ) {
					containerForUpload.html( response );

					trigger.removeClass( 'loading' );
					trigger.removeClass( 'not-active' );

					$( document ).find( 'img' ).lazyload();
				},
				error: function () {
					console.log( 'Error' );
				}
			} );
		} );
	}

	//Contact form send
	if ( $( '.contact-form-send' ).length ) {
		var container = $( '.contact-form-send' );
		container.on( 'click', 'button', function ( e ) {
			e.preventDefault();
			var allFields = container.serializeArray();

			$.ajax( {
				method: "POST",
				url: ajax_admin[ 'url' ],
				cache: false,
				data: {
					nonce: ajax_admin[ 'nonce' ],
					action: 'contact_form_submit',
					allFields: allFields
				},
				success: function ( response ) {
					container.find( '.respond' ).html( response );
				},
				error: function () {
					console.log( 'Error' );
				}
			} );
		} );
	}

	//Reviews
	if ( $( '.comment-reviews-block' ).length ) {
		var containerReviews = $( '.comment-reviews-block' );
		var reviewsForm = containerReviews.find( '.reviews-form form' );

		reviewsForm.on( 'click', 'button', function ( e ) {
			e.preventDefault();

			var thisButton = $( this );
			if ( thisButton.hasClass( 'loading' ) ) {
				return;
			}
			thisButton.addClass( 'loading' );

			var reviewFields = reviewsForm.serializeArray();
			var postId = reviewsForm.find( 'input[name=post_id]' ).val();

			$.ajax( {
				method: "POST",
				url: ajax_admin[ 'url' ],
				cache: false,
				data: {
					nonce: ajax_admin[ 'nonce' ],
					action: 'reviews_create',
					reviewFields: reviewFields
				},
				success: function ( response ) {
					reviewsForm.find( '.response' ).html( response );

					$.ajax( {
						method: "POST",
						url: ajax_admin[ 'url' ],
						cache: false,
						data: {
							nonce: ajax_admin[ 'nonce' ],
							action: 'reviews_posts',
							postId: postId
						},
						success: function ( response ) {
							containerReviews.find( '.reviews-list' ).html( response );
							thisButton.removeClass( 'loading' );
						},
						error: function () {
							console.log( 'Error' );
						}
					} );
				},
				error: function () {
					console.log( 'Error' );
				}
			} );
		} );
	}

	//Filters
	$( 'select[name=filter_type]' ).on( 'selectmenuchange', function () {
		var postType = $( this ).val();
		var formContainer = $( this ).parent().parent().parent();
		formContainer.attr( 'data-post-type', postType );
		var baseLabel = formContainer.find( 'select[name=filter_country] option:first-of-type' ).html();

		$.ajax( {
			method: "POST",
			url: ajax_admin[ 'url' ],
			cache: false,
			data: {
				nonce: ajax_admin[ 'nonce' ],
				action: 'tell_get_country',
				postType: postType,
				baseLabel: baseLabel
			},
			success: function ( response ) {
				formContainer.find( 'select[name=filter_country]' ).html( response );
				formContainer.find( 'select[name=filter_country]' ).selectmenu( 'refresh' );
			},
			error: function () {
				console.log( 'Error' );
			}
		} );
	} );

	$( 'select[name=filter_country]' ).on( 'selectmenuchange', function () {
		var selectValue = $( this ).val();

		var formContainer = $( this ).parent().parent().parent();
		var postType = formContainer.attr( 'data-post-type' );
		var baseLabel = formContainer.find( 'select[name=filter_city] option:first-of-type' ).html();

		$.ajax( {
			method: "POST",
			url: ajax_admin[ 'url' ],
			cache: false,
			data: {
				nonce: ajax_admin[ 'nonce' ],
				action: 'tell_get_child_country',
				postType: postType,
				selectValue: selectValue,
				baseLabel: baseLabel
			},
			success: function ( response ) {
				formContainer.find( 'select[name=filter_city]' ).html( response );
				formContainer.find( 'select[name=filter_city]' ).selectmenu( 'refresh' );
			},
			error: function () {
				console.log( 'Error' );
			}
		} );
	} );

	if ( $( '.filter-form' ).length ) {
		$( '.filter-form' ).on( 'click', 'button', function ( e ) {
			e.preventDefault();

			var thisButton = $( this );
			if ( thisButton.hasClass( 'loading' ) ) {
				return;
			}
			thisButton.addClass( 'loading' );

			var action = 'load_posts';
			var postType = 'post';
			var numberOfPosts = 1;
			var offset = 0;
			var category = '';
			var resortCategory = '';
			var date = '';
			var stars = '';
			var price = '';
			var toPrices = '';
			var city = '';
			var roomType = '';
			var bodyType = '';
			var transmission = '';
			var dataForAjax = $( '.ajax-data' );
			var formContainer = thisButton.parent();

			if ( formContainer.attr( 'data-post-type' ) ) {
				postType = formContainer.attr( 'data-post-type' );
			}
			if ( formContainer.attr( 'data-number-of-posts' ) ) {
				numberOfPosts = formContainer.attr( 'data-number-of-posts' );
			}
			if ( dataForAjax.find( 'select[name=filter_country]' ) ) {
				category = dataForAjax.find( 'select[name=filter_country]' ).val();
			}
			if ( dataForAjax.find( 'select[name=filter_city]' ) ) {
				city = dataForAjax.find( 'select[name=filter_city]' ).val();
			}
			if ( dataForAjax.find( 'select[name=filter_stars]' ) ) {
				stars = dataForAjax.find( 'select[name=filter_stars]' ).val();
			}
			if ( dataForAjax.find( 'input[name=filter_price]' ) ) {
				price = dataForAjax.find( 'input[name=filter_price]' ).val();
			}

			if ( dataForAjax.attr( 'data-number-of-posts' ) ) {
				toPrices = parseInt( dataForAjax.attr( 'data-number-of-posts' ) );
			}

			if ( dataForAjax.find( 'select[name=filter_room_type]' ) ) {
				roomType = dataForAjax.find( 'select[name=filter_room_type]' ).val();
			}

			if ( dataForAjax.find( 'select[name=filter_body_type]' ) ) {
				bodyType = dataForAjax.find( 'select[name=filter_body_type]' ).val();
			}

			if ( dataForAjax.find( 'select[name=filter_transmission]' ) ) {
				transmission = dataForAjax.find( 'select[name=filter_transmission]' ).val();
			}

			$.ajax( {
				method: "POST",
				url: ajax_admin[ 'url' ],
				cache: false,
				data: {
					nonce: ajax_admin[ 'nonce' ],
					action: 'load_posts',
					postType: postType,
					category: category,
					city: city,
					stars: stars,
					price: price,
					numberOfPosts: numberOfPosts,
					offset: offset,
					roomType: roomType,
					bodyType: bodyType,
					transmission: transmission
				},
				success: function ( response ) {
					dataForAjax.attr( 'data-offset', numberOfPosts );
					dataForAjax.attr( 'data-post-type', postType );
					if ( 'tours' == postType || 'cruises' == postType || 'excursions' == postType || 'hotels' == postType ) {
						dataForAjax.attr( 'data-category', category );
						dataForAjax.attr( 'data-city', city );
						dataForAjax.attr( 'data-stars', stars );
						dataForAjax.attr( 'data-price', price );

						dataForAjax.removeAttr( 'data-room-type' );
						dataForAjax.removeAttr( 'data-body-type' );
						dataForAjax.removeAttr( 'data-transmission' );
					} else if ( 'rooms' == postType ) {
						dataForAjax.attr( 'data-room-type', roomType );
						dataForAjax.attr( 'data-price', price );

						dataForAjax.removeAttr( 'data-category' );
						dataForAjax.removeAttr( 'data-city' );
						dataForAjax.removeAttr( 'data-stars' );
						dataForAjax.removeAttr( 'data-body-type' );
						dataForAjax.removeAttr( 'data-transmission' );
					} else if ( 'car-rentals' == postType ) {
						dataForAjax.attr( 'data-body-type', bodyType );
						dataForAjax.attr( 'data-transmission', transmission );

						dataForAjax.removeAttr( 'data-room-type' );
						dataForAjax.removeAttr( 'data-stars' );
					}
					$( '.place-for-upload' ).html( response );

					//Lazy load images
					$( document ).find( 'img' ).lazyload( {
						threshold: 200
					} );

					thisButton.removeClass( 'loading' );

					$( window ).trigger( 'resize' ).trigger( 'scroll' );
				},
				error: function () {
					console.log( 'Error' );
				}
			} );

			$.ajax( {
				method: "POST",
				url: ajax_admin[ 'url' ],
				cache: false,
				data: {
					nonce: ajax_admin[ 'nonce' ],
					action: 'load_categories',
					postType: postType
				},
				success: function ( response ) {
					$( '.category-no-redirect' ).html( response );

					thisButton.removeClass( 'loading' );
				},
				error: function () {
					console.log( 'Error' );
				}
			} );
		} );
	}

	if ( $( '.order-form' ).length ) {
		$( '.order-form' ).on( 'click', 'button', function ( e ) {
			e.preventDefault();

			var thisButton = $( this );
			if ( thisButton.hasClass( 'loading' ) ) {
				return;
			}
			thisButton.addClass( 'loading' );

			var orderItemId = '';
			var orderItemName = '';
			var orderName = '';
			var orderDateBegin = '';
			var orderDateEnd = '';
			var orderPhone = '';
			var orderEmail = '';
			var orderMessage = '';

			var container = thisButton.parent().parent();
			if ( container.find( 'input[name=order_item_id]' ).length ) {
				orderItemId = container.find( 'input[name=order_item_id]' ).val();
			}
			if ( container.find( 'input[name=order_item_name]' ).length ) {
				orderItemName = container.find( 'input[name=order_item_name]' ).val();
			}
			if ( container.find( 'input[name=order_name]' ).length ) {
				orderName = container.find( 'input[name=order_name]' ).val();
			}
			if ( container.find( 'input[name=order_date_begin]' ).length ) {
				orderDateBegin = container.find( 'input[name=order_date_begin]' ).val();
			}
			if ( container.find( 'input[name=order_date_end]' ).length ) {
				orderDateEnd = container.find( 'input[name=order_date_end]' ).val();
			}
			if ( container.find( 'input[name=order_phone]' ).length ) {
				orderPhone = container.find( 'input[name=order_phone]' ).val();
			}
			if ( container.find( 'input[name=order_email]' ).length ) {
				orderEmail = container.find( 'input[name=order_email]' ).val();
			}
			if ( container.find( 'textarea[name=order_message]' ).length ) {
				orderMessage = container.find( 'textarea[name=order_message]' ).val();
			}

			$.ajax( {
				method: "POST",
				url: ajax_admin[ 'url' ],
				cache: false,
				data: {
					nonce: ajax_admin[ 'nonce' ],
					action: 'order_submit',
					orderItemId: orderItemId,
					orderItemName: orderItemName,
					orderName: orderName,
					orderDateBegin: orderDateBegin,
					orderDateEnd: orderDateEnd,
					orderPhone: orderPhone,
					orderEmail: orderEmail,
					orderMessage: orderMessage
				},
				success: function ( response ) {
					container.find( '.response' ).html( response );

					thisButton.removeClass( 'loading' );
				},
				error: function () {
					console.log( 'Error' );
				}
			} );
		} );
	}
})( jQuery );