(function ( $ ) {
	"use strict";

	//Load more
	var oneTimeLoad = 1;
	$( document ).find( '.load-more' ).on( 'click', 'button', function ( e ) {
		e.preventDefault();

		if ( $( this ).hasClass( 'not-active' ) ) {
			return;
		}

		$( this ).addClass( 'loading' );

		//Default values
		var trigger = $( this );
		var action = 'load_posts';
		var postType = 'post';
		var postStatus = 'publish';
		var numberOfPosts = 1;
		var offset = 1;
		var taxonomy = '';
		var category = '';
		var tags = '';
		var search = '';
		var templatePart = '';
		var ajaxData = trigger.parent().parent();

		if ( ajaxData.attr( 'data-action' ) ) {
			action = ajaxData.attr( 'data-action' );
		}
		if ( ajaxData.attr( 'data-post-type' ) ) {
			postType = ajaxData.attr( 'data-post-type' );
		}
		if ( ajaxData.attr( 'data-post-status' ) ) {
			postStatus = ajaxData.attr( 'data-post-status' );
		}
		if ( ajaxData.attr( 'data-number-of-posts' ) ) {
			numberOfPosts = parseInt( ajaxData.attr( 'data-number-of-posts' ) );
		}
		if ( ajaxData.attr( 'data-offset' ) ) {
			offset = parseInt( ajaxData.attr( 'data-offset' ) );
		}
		if ( ajaxData.attr( 'data-taxonomy' ) ) {
			taxonomy = ajaxData.attr( 'data-taxonomy' );
		}
		if ( ajaxData.attr( 'data-category' ) ) {
			category = ajaxData.attr( 'data-category' );
		}
		if ( ajaxData.attr( 'data-tags' ) ) {
			tags = ajaxData.attr( 'data-tags' );
		}
		if ( ajaxData.attr( 'data-search' ) ) {
			search = ajaxData.attr( 'data-search' );
		}
		if ( ajaxData.attr( 'data-template-part' ) ) {
			templatePart = ajaxData.attr( 'data-template-part' );
		}

		if ( 0 != oneTimeLoad ) {
			$.ajax( {
				method: "POST",
				url: ajax_admin[ 'url' ],
				cache: false,
				data: {
					nonce: ajax_admin[ 'nonce' ],
					action: action,
					postType: postType,
					numberOfPosts: numberOfPosts,
					offset: offset,
					taxonomy: taxonomy,
					category: category,
					tags: tags,
					search: search,
					templatePart: templatePart,
					postStatus: postStatus
				},
				beforeSend: function () {
					oneTimeLoad = 0;
				},
				success: function ( response ) {
					offset = offset + numberOfPosts;
					ajaxData.attr( 'data-offset', offset );
					ajaxData.find( '.place-for-upload' ).append( response );

					oneTimeLoad = 1;

					trigger.removeClass( 'loading' );
					if ( '' == response ) {
						trigger.addClass( 'not-active' );
					}

					$( window ).trigger( 'resize' ).trigger( 'scroll' );

					$( document ).find( 'img' ).lazyload();
				},
				error: function () {
					console.log( 'Error' );
				}
			} );
		}
	} );
})( jQuery );