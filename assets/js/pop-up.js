(function ( $ ) {
	"use strict";

	class PopUp {
		//Constructor
		constructor( selector, trigger ) {
			this.selector = selector;
			this.trigger = trigger;
			this.windowWidth = $( window ).width();
			this.windowHeight = $( window ).height();
			this.inner = $( document ).find( this.selector ).find( '.inner' );
			this.innerHeight = this.inner.height();
		}

		//Calculate pop up window position
		popUpPosition() {
			var inner = this.inner;
			var innerHeight = inner.height();
			if ( innerHeight >= this.windowHeight ) {
				this.inner.css( {
					top: 30,
					height: this.windowHeight - 60
				} );
			} else {
				var innerOffset = (this.windowHeight - innerHeight) / 2
				this.inner.css( {
					top: innerOffset
				} );
			}
		}

		//Init gallery
		popUpGallery() {
			var thisClassElement = this;
			thisClassElement.inner;

			if ( $( document ).find( '.gallery' ).length ) {
				var gallery = $( document ).find( '.gallery' );
				gallery.each( function () {
					$( this ).owlCarousel( {
						items: 1,
						nav: true,
						mobileBoost: true,
						navText: [ '<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>' ],
						smartSpeed: 2000,
						autoplay: false,
						lazyLoad: true,
						loop: $( this ).children().length > 1,
						onInitialized: function () {
							setTimeout( function () {
								var owlNumber = gallery.find( '.selected' ).parent().index();
								owlNumber = owlNumber - 2;
								gallery.trigger( 'to.owl.carousel', [ owlNumber, 1, true ] );
							}, 100 );

							setTimeout( function () {
								thisClassElement.popUpPosition();
							}, 300 );
						}
					} );
				} );

				$( document ).on( 'keyup', function ( evt ) {
					if ( evt.keyCode == 37 ) {
						//To the left side
						gallery.trigger( 'prev.owl.carousel', 2000 );
					}
					if ( evt.keyCode == 39 ) {
						//To the right side
						gallery.trigger( 'next.owl.carousel', 2000 );
					}
				} );
			}
		}

		//Open pop up window on click
		openPopUp() {
			var thisElement = this;
			var selector = $( document ).find( this.selector );
			var inner = this.inner;

			$( document ).find( this.trigger ).on( 'click', function ( e ) {
				e.preventDefault();

				selector.addClass( 'active' );

				var action = '';
				var postType = '';
				var postId = '';
				var counter = '';

				if ( $( this ).attr( 'data-action' ) ) {
					action = $( this ).attr( 'data-action' );
				}
				if ( $( this ).attr( 'data-post-type' ) ) {
					postType = $( this ).attr( 'data-post-type' );
				}
				if ( $( this ).attr( 'data-post-id' ) ) {
					postId = $( this ).attr( 'data-post-id' );
				}
				if ( $( this ).attr( 'data-counter' ) ) {
					counter = $( this ).attr( 'data-counter' );
				}

				$.ajax( {
					method: 'POST',
					url: ajax_admin[ 'url' ],
					cashe: false,
					async: true,
					data: {
						action: action,
						postType: postType,
						postId: postId,
						counter: counter
					},
					success: function ( response ) {
						inner.html( response );

						thisElement.popUpGallery();
						thisElement.popUpPosition();

						setTimeout( function () {
							selector.addClass( 'loaded' );
						}, 300 );
					},
					error: function () {
						console.log( 'Error' );
					}
				} );
			} );
		}

		//Close pop up window
		popUpExit() {
			var selector = $( document ).find( this.selector );

			$( this.selector ).on( 'click', '.close-layer', function ( e ) {
				e.preventDefault();

				selector.removeClass( 'active' );
				selector.removeClass( 'loaded' );

				setTimeout( function () {
					selector.find( '.inner' ).html( '' );
				}, 300 );
			} );

			$( document ).on( 'keyup', function ( evt ) {
				if ( evt.keyCode == 27 ) {
					selector.removeClass( 'active' );
					selector.removeClass( 'loaded' );

					setTimeout( function () {
						selector.find( '.inner' ).html( '' );
					}, 300 );
				}
			} );
		}

		getResult() {
			this.openPopUp();
			this.popUpExit();
			$( document ).find( 'img' ).lazyload();
		}
	}

	function getPopUp() {
		var getPopUp = new PopUp( '.pop-up', '.open-in-pop-up' );
		getPopUp.getResult();
	}

	getPopUp();
})( jQuery );