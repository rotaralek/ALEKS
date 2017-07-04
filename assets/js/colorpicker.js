(function ( $ ) {
	"use strict";

	/**
	 *
	 * Color picker
	 * Author: Stefan Petre www.eyecon.ro
	 *
	 * Dual licensed under the MIT and GPL licenses
	 *
	 */
	var ColorPicker = function () {
		var
			ids = {},
			inAction,
			charMin = 65,
			visible,
			tpl = '<div class="colorpicker"><div class="colorpicker_color"><div><div></div></div></div><div class="colorpicker_hue"><div></div></div><div class="colorpicker_new_color"></div><div class="colorpicker_current_color"></div><div class="colorpicker_hex"><input type="text" maxlength="6" size="6" /></div><div class="colorpicker_rgb_r colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_g colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_h colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_s colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_submit"></div></div>',
			defaults = {
				eventName: 'click',
				onShow: function () {
				},
				onBeforeShow: function () {
				},
				onHide: function () {
				},
				onChange: function () {
				},
				onSubmit: function () {
				},
				color: 'ff0000',
				livePreview: true,
				flat: false
			},
			fillRGBFields = function ( hsb, cal ) {
				var rgb = HSBToRGB( hsb );
				$( cal ).data( 'colorpicker' ).fields
					.eq( 1 ).val( rgb.r ).end()
					.eq( 2 ).val( rgb.g ).end()
					.eq( 3 ).val( rgb.b ).end();
			},
			fillHSBFields = function ( hsb, cal ) {
				$( cal ).data( 'colorpicker' ).fields
					.eq( 4 ).val( hsb.h ).end()
					.eq( 5 ).val( hsb.s ).end()
					.eq( 6 ).val( hsb.b ).end();
			},
			fillHexFields = function ( hsb, cal ) {
				$( cal ).data( 'colorpicker' ).fields
					.eq( 0 ).val( HSBToHex( hsb ) ).end();
			},
			setSelector = function ( hsb, cal ) {
				$( cal ).data( 'colorpicker' ).selector.css( 'backgroundColor', '#' + HSBToHex( {
						h: hsb.h,
						s: 100,
						b: 100
					} ) );
				$( cal ).data( 'colorpicker' ).selectorIndic.css( {
					left: parseInt( 150 * hsb.s / 100, 10 ),
					top: parseInt( 150 * (100 - hsb.b) / 100, 10 )
				} );
			},
			setHue = function ( hsb, cal ) {
				$( cal ).data( 'colorpicker' ).hue.css( 'top', parseInt( 150 - 150 * hsb.h / 360, 10 ) );
			},
			setCurrentColor = function ( hsb, cal ) {
				$( cal ).data( 'colorpicker' ).currentColor.css( 'backgroundColor', '#' + HSBToHex( hsb ) );
			},
			setNewColor = function ( hsb, cal ) {
				$( cal ).data( 'colorpicker' ).newColor.css( 'backgroundColor', '#' + HSBToHex( hsb ) );
			},
			keyDown = function ( ev ) {
				var pressedKey = ev.charCode || ev.keyCode || -1;
				if ( (pressedKey > charMin && pressedKey <= 90) || pressedKey == 32 ) {
					return false;
				}
				var cal = $( this ).parent().parent();
				if ( cal.data( 'colorpicker' ).livePreview === true ) {
					change.apply( this );
				}
			},
			change = function ( ev ) {
				var cal = $( this ).parent().parent(), col;
				if ( this.parentNode.className.indexOf( '_hex' ) > 0 ) {
					cal.data( 'colorpicker' ).color = col = HexToHSB( fixHex( this.value ) );
				} else if ( this.parentNode.className.indexOf( '_hsb' ) > 0 ) {
					cal.data( 'colorpicker' ).color = col = fixHSB( {
						h: parseInt( cal.data( 'colorpicker' ).fields.eq( 4 ).val(), 10 ),
						s: parseInt( cal.data( 'colorpicker' ).fields.eq( 5 ).val(), 10 ),
						b: parseInt( cal.data( 'colorpicker' ).fields.eq( 6 ).val(), 10 )
					} );
				} else {
					cal.data( 'colorpicker' ).color = col = RGBToHSB( fixRGB( {
						r: parseInt( cal.data( 'colorpicker' ).fields.eq( 1 ).val(), 10 ),
						g: parseInt( cal.data( 'colorpicker' ).fields.eq( 2 ).val(), 10 ),
						b: parseInt( cal.data( 'colorpicker' ).fields.eq( 3 ).val(), 10 )
					} ) );
				}
				if ( ev ) {
					fillRGBFields( col, cal.get( 0 ) );
					fillHexFields( col, cal.get( 0 ) );
					fillHSBFields( col, cal.get( 0 ) );
				}
				setSelector( col, cal.get( 0 ) );
				setHue( col, cal.get( 0 ) );
				setNewColor( col, cal.get( 0 ) );
				cal.data( 'colorpicker' ).onChange.apply( cal, [ col, HSBToHex( col ), HSBToRGB( col ) ] );
			},
			blur = function ( ev ) {
				var cal = $( this ).parent().parent();
				cal.data( 'colorpicker' ).fields.parent().removeClass( 'colorpicker_focus' );
			},
			focus = function () {
				charMin = this.parentNode.className.indexOf( '_hex' ) > 0 ? 70 : 65;
				$( this ).parent().parent().data( 'colorpicker' ).fields.parent().removeClass( 'colorpicker_focus' );
				$( this ).parent().addClass( 'colorpicker_focus' );
			},
			downIncrement = function ( ev ) {
				var field = $( this ).parent().find( 'input' ).focus();
				var current = {
					el: $( this ).parent().addClass( 'colorpicker_slider' ),
					max: this.parentNode.className.indexOf( '_hsb_h' ) > 0 ? 360 : (this.parentNode.className.indexOf( '_hsb' ) > 0 ? 100 : 255),
					y: ev.pageY,
					field: field,
					val: parseInt( field.val(), 10 ),
					preview: $( this ).parent().parent().data( 'colorpicker' ).livePreview
				};
				$( document ).bind( 'mouseup', current, upIncrement );
				$( document ).bind( 'mousemove', current, moveIncrement );
			},
			moveIncrement = function ( ev ) {
				ev.data.field.val( Math.max( 0, Math.min( ev.data.max, parseInt( ev.data.val + ev.pageY - ev.data.y, 10 ) ) ) );
				if ( ev.data.preview ) {
					change.apply( ev.data.field.get( 0 ), [ true ] );
				}
				return false;
			},
			upIncrement = function ( ev ) {
				change.apply( ev.data.field.get( 0 ), [ true ] );
				ev.data.el.removeClass( 'colorpicker_slider' ).find( 'input' ).focus();
				$( document ).unbind( 'mouseup', upIncrement );
				$( document ).unbind( 'mousemove', moveIncrement );
				return false;
			},
			downHue = function ( ev ) {
				var current = {
					cal: $( this ).parent(),
					y: $( this ).offset().top
				};
				current.preview = current.cal.data( 'colorpicker' ).livePreview;
				$( document ).bind( 'mouseup', current, upHue );
				$( document ).bind( 'mousemove', current, moveHue );
			},
			moveHue = function ( ev ) {
				change.apply(
					ev.data.cal.data( 'colorpicker' )
						.fields
						.eq( 4 )
						.val( parseInt( 360 * (150 - Math.max( 0, Math.min( 150, (ev.pageY - ev.data.y) ) )) / 150, 10 ) )
						.get( 0 ),
					[ ev.data.preview ]
				);
				return false;
			},
			upHue = function ( ev ) {
				fillRGBFields( ev.data.cal.data( 'colorpicker' ).color, ev.data.cal.get( 0 ) );
				fillHexFields( ev.data.cal.data( 'colorpicker' ).color, ev.data.cal.get( 0 ) );
				$( document ).unbind( 'mouseup', upHue );
				$( document ).unbind( 'mousemove', moveHue );
				return false;
			},
			downSelector = function ( ev ) {
				var current = {
					cal: $( this ).parent(),
					pos: $( this ).offset()
				};
				current.preview = current.cal.data( 'colorpicker' ).livePreview;
				$( document ).bind( 'mouseup', current, upSelector );
				$( document ).bind( 'mousemove', current, moveSelector );
			},
			moveSelector = function ( ev ) {
				change.apply(
					ev.data.cal.data( 'colorpicker' )
						.fields
						.eq( 6 )
						.val( parseInt( 100 * (150 - Math.max( 0, Math.min( 150, (ev.pageY - ev.data.pos.top) ) )) / 150, 10 ) )
						.end()
						.eq( 5 )
						.val( parseInt( 100 * (Math.max( 0, Math.min( 150, (ev.pageX - ev.data.pos.left) ) )) / 150, 10 ) )
						.get( 0 ),
					[ ev.data.preview ]
				);
				return false;
			},
			upSelector = function ( ev ) {
				fillRGBFields( ev.data.cal.data( 'colorpicker' ).color, ev.data.cal.get( 0 ) );
				fillHexFields( ev.data.cal.data( 'colorpicker' ).color, ev.data.cal.get( 0 ) );
				$( document ).unbind( 'mouseup', upSelector );
				$( document ).unbind( 'mousemove', moveSelector );
				return false;
			},
			enterSubmit = function ( ev ) {
				$( this ).addClass( 'colorpicker_focus' );
			},
			leaveSubmit = function ( ev ) {
				$( this ).removeClass( 'colorpicker_focus' );
			},
			clickSubmit = function ( ev ) {
				var cal = $( this ).parent();
				var col = cal.data( 'colorpicker' ).color;
				cal.data( 'colorpicker' ).origColor = col;
				setCurrentColor( col, cal.get( 0 ) );
				cal.data( 'colorpicker' ).onSubmit( col, HSBToHex( col ), HSBToRGB( col ), cal.data( 'colorpicker' ).el );
			},
			show = function ( ev ) {
				var cal = $( '#' + $( this ).data( 'colorpickerId' ) );
				cal.data( 'colorpicker' ).onBeforeShow.apply( this, [ cal.get( 0 ) ] );
				var pos = $( this ).offset();
				var viewPort = getViewport();
				var top = pos.top + this.offsetHeight;
				var left = pos.left;
				if ( top + 176 > viewPort.t + viewPort.h ) {
					top -= this.offsetHeight + 176;
				}
				if ( left + 356 > viewPort.l + viewPort.w ) {
					left -= 356;
				}
				cal.css( { left: left + 'px', top: top + 'px' } );
				if ( cal.data( 'colorpicker' ).onShow.apply( this, [ cal.get( 0 ) ] ) != false ) {
					cal.show();
				}
				$( document ).bind( 'mousedown', { cal: cal }, hide );
				return false;
			},
			hide = function ( ev ) {
				if ( !isChildOf( ev.data.cal.get( 0 ), ev.target, ev.data.cal.get( 0 ) ) ) {
					if ( ev.data.cal.data( 'colorpicker' ).onHide.apply( this, [ ev.data.cal.get( 0 ) ] ) != false ) {
						ev.data.cal.hide();
					}
					$( document ).unbind( 'mousedown', hide );
				}
			},
			isChildOf = function ( parentEl, el, container ) {
				if ( parentEl == el ) {
					return true;
				}
				if ( parentEl.contains ) {
					return parentEl.contains( el );
				}
				if ( parentEl.compareDocumentPosition ) {
					return !!(parentEl.compareDocumentPosition( el ) & 16);
				}
				var prEl = el.parentNode;
				while ( prEl && prEl != container ) {
					if ( prEl == parentEl )
						return true;
					prEl = prEl.parentNode;
				}
				return false;
			},
			getViewport = function () {
				var m = document.compatMode == 'CSS1Compat';
				return {
					l: window.pageXOffset || (m ? document.documentElement.scrollLeft : document.body.scrollLeft),
					t: window.pageYOffset || (m ? document.documentElement.scrollTop : document.body.scrollTop),
					w: window.innerWidth || (m ? document.documentElement.clientWidth : document.body.clientWidth),
					h: window.innerHeight || (m ? document.documentElement.clientHeight : document.body.clientHeight)
				};
			},
			fixHSB = function ( hsb ) {
				return {
					h: Math.min( 360, Math.max( 0, hsb.h ) ),
					s: Math.min( 100, Math.max( 0, hsb.s ) ),
					b: Math.min( 100, Math.max( 0, hsb.b ) )
				};
			},
			fixRGB = function ( rgb ) {
				return {
					r: Math.min( 255, Math.max( 0, rgb.r ) ),
					g: Math.min( 255, Math.max( 0, rgb.g ) ),
					b: Math.min( 255, Math.max( 0, rgb.b ) )
				};
			},
			fixHex = function ( hex ) {
				var len = 6 - hex.length;
				if ( len > 0 ) {
					var o = [];
					for ( var i = 0; i < len; i++ ) {
						o.push( '0' );
					}
					o.push( hex );
					hex = o.join( '' );
				}
				return hex;
			},
			HexToRGB = function ( hex ) {
				var hex = parseInt( ((hex.indexOf( '#' ) > -1) ? hex.substring( 1 ) : hex), 16 );
				return { r: hex >> 16, g: (hex & 0x00FF00) >> 8, b: (hex & 0x0000FF) };
			},
			HexToHSB = function ( hex ) {
				return RGBToHSB( HexToRGB( hex ) );
			},
			RGBToHSB = function ( rgb ) {
				var hsb = {
					h: 0,
					s: 0,
					b: 0
				};
				var min = Math.min( rgb.r, rgb.g, rgb.b );
				var max = Math.max( rgb.r, rgb.g, rgb.b );
				var delta = max - min;
				hsb.b = max;
				if ( max != 0 ) {

				}
				hsb.s = max != 0 ? 255 * delta / max : 0;
				if ( hsb.s != 0 ) {
					if ( rgb.r == max ) {
						hsb.h = (rgb.g - rgb.b) / delta;
					} else if ( rgb.g == max ) {
						hsb.h = 2 + (rgb.b - rgb.r) / delta;
					} else {
						hsb.h = 4 + (rgb.r - rgb.g) / delta;
					}
				} else {
					hsb.h = -1;
				}
				hsb.h *= 60;
				if ( hsb.h < 0 ) {
					hsb.h += 360;
				}
				hsb.s *= 100 / 255;
				hsb.b *= 100 / 255;
				return hsb;
			},
			HSBToRGB = function ( hsb ) {
				var rgb = {};
				var h = Math.round( hsb.h );
				var s = Math.round( hsb.s * 255 / 100 );
				var v = Math.round( hsb.b * 255 / 100 );
				if ( s == 0 ) {
					rgb.r = rgb.g = rgb.b = v;
				} else {
					var t1 = v;
					var t2 = (255 - s) * v / 255;
					var t3 = (t1 - t2) * (h % 60) / 60;
					if ( h == 360 ) h = 0;
					if ( h < 60 ) {
						rgb.r = t1;
						rgb.b = t2;
						rgb.g = t2 + t3
					}
					else if ( h < 120 ) {
						rgb.g = t1;
						rgb.b = t2;
						rgb.r = t1 - t3
					}
					else if ( h < 180 ) {
						rgb.g = t1;
						rgb.r = t2;
						rgb.b = t2 + t3
					}
					else if ( h < 240 ) {
						rgb.b = t1;
						rgb.r = t2;
						rgb.g = t1 - t3
					}
					else if ( h < 300 ) {
						rgb.b = t1;
						rgb.g = t2;
						rgb.r = t2 + t3
					}
					else if ( h < 360 ) {
						rgb.r = t1;
						rgb.g = t2;
						rgb.b = t1 - t3
					}
					else {
						rgb.r = 0;
						rgb.g = 0;
						rgb.b = 0
					}
				}
				return { r: Math.round( rgb.r ), g: Math.round( rgb.g ), b: Math.round( rgb.b ) };
			},
			RGBToHex = function ( rgb ) {
				var hex = [
					rgb.r.toString( 16 ),
					rgb.g.toString( 16 ),
					rgb.b.toString( 16 )
				];
				$.each( hex, function ( nr, val ) {
					if ( val.length == 1 ) {
						hex[ nr ] = '0' + val;
					}
				} );
				return hex.join( '' );
			},
			HSBToHex = function ( hsb ) {
				return RGBToHex( HSBToRGB( hsb ) );
			},
			restoreOriginal = function () {
				var cal = $( this ).parent();
				var col = cal.data( 'colorpicker' ).origColor;
				cal.data( 'colorpicker' ).color = col;
				fillRGBFields( col, cal.get( 0 ) );
				fillHexFields( col, cal.get( 0 ) );
				fillHSBFields( col, cal.get( 0 ) );
				setSelector( col, cal.get( 0 ) );
				setHue( col, cal.get( 0 ) );
				setNewColor( col, cal.get( 0 ) );
			};
		return {
			init: function ( opt ) {
				opt = $.extend( {}, defaults, opt || {} );
				if ( typeof opt.color == 'string' ) {
					opt.color = HexToHSB( opt.color );
				} else if ( opt.color.r != undefined && opt.color.g != undefined && opt.color.b != undefined ) {
					opt.color = RGBToHSB( opt.color );
				} else if ( opt.color.h != undefined && opt.color.s != undefined && opt.color.b != undefined ) {
					opt.color = fixHSB( opt.color );
				} else {
					return this;
				}
				return this.each( function () {
					if ( !$( this ).data( 'colorpickerId' ) ) {
						var options = $.extend( {}, opt );
						options.origColor = opt.color;
						var id = 'collorpicker_' + parseInt( Math.random() * 1000 );
						$( this ).data( 'colorpickerId', id );
						var cal = $( tpl ).attr( 'id', id );
						if ( options.flat ) {
							cal.appendTo( this ).show();
						} else {
							cal.appendTo( document.body );
						}
						options.fields = cal
							.find( 'input' )
							.bind( 'keyup', keyDown )
							.bind( 'change', change )
							.bind( 'blur', blur )
							.bind( 'focus', focus );
						cal
							.find( 'span' ).bind( 'mousedown', downIncrement ).end()
							.find( '>div.colorpicker_current_color' ).bind( 'click', restoreOriginal );
						options.selector = cal.find( 'div.colorpicker_color' ).bind( 'mousedown', downSelector );
						options.selectorIndic = options.selector.find( 'div div' );
						options.el = this;
						options.hue = cal.find( 'div.colorpicker_hue div' );
						cal.find( 'div.colorpicker_hue' ).bind( 'mousedown', downHue );
						options.newColor = cal.find( 'div.colorpicker_new_color' );
						options.currentColor = cal.find( 'div.colorpicker_current_color' );
						cal.data( 'colorpicker', options );
						cal.find( 'div.colorpicker_submit' )
							.bind( 'mouseenter', enterSubmit )
							.bind( 'mouseleave', leaveSubmit )
							.bind( 'click', clickSubmit );
						fillRGBFields( options.color, cal.get( 0 ) );
						fillHSBFields( options.color, cal.get( 0 ) );
						fillHexFields( options.color, cal.get( 0 ) );
						setHue( options.color, cal.get( 0 ) );
						setSelector( options.color, cal.get( 0 ) );
						setCurrentColor( options.color, cal.get( 0 ) );
						setNewColor( options.color, cal.get( 0 ) );
						if ( options.flat ) {
							cal.css( {
								position: 'relative',
								display: 'block'
							} );
						} else {
							$( this ).bind( options.eventName, show );
						}
					}
				} );
			},
			showPicker: function () {
				return this.each( function () {
					if ( $( this ).data( 'colorpickerId' ) ) {
						show.apply( this );
					}
				} );
			},
			hidePicker: function () {
				return this.each( function () {
					if ( $( this ).data( 'colorpickerId' ) ) {
						$( '#' + $( this ).data( 'colorpickerId' ) ).hide();
					}
				} );
			},
			setColor: function ( col ) {
				if ( typeof col == 'string' ) {
					col = HexToHSB( col );
				} else if ( col.r != undefined && col.g != undefined && col.b != undefined ) {
					col = RGBToHSB( col );
				} else if ( col.h != undefined && col.s != undefined && col.b != undefined ) {
					col = fixHSB( col );
				} else {
					return this;
				}
				return this.each( function () {
					if ( $( this ).data( 'colorpickerId' ) ) {
						var cal = $( '#' + $( this ).data( 'colorpickerId' ) );
						cal.data( 'colorpicker' ).color = col;
						cal.data( 'colorpicker' ).origColor = col;
						fillRGBFields( col, cal.get( 0 ) );
						fillHSBFields( col, cal.get( 0 ) );
						fillHexFields( col, cal.get( 0 ) );
						setHue( col, cal.get( 0 ) );
						setSelector( col, cal.get( 0 ) );
						setCurrentColor( col, cal.get( 0 ) );
						setNewColor( col, cal.get( 0 ) );
					}
				} );
			}
		};
	}();

	$.fn.extend( {
		ColorPicker: ColorPicker.init,
		ColorPickerHide: ColorPicker.hidePicker,
		ColorPickerShow: ColorPicker.showPicker,
		ColorPickerSetColor: ColorPicker.setColor
	} );

	$( window ).on( 'load', function () {
		setTimeout( function () {
			$( document ).find( '.style-selector' ).css( {
				top: 80
			} );
		}, 1000 );
	} );

	var changeColor = function ( selector, color ) {
		$( '#' + selector ).ColorPicker( {
			color: color,
			flat: true,
			onChange: function ( hsb, hex, rgb ) {
				if ( 'change_red_col' == selector ) {
					$( '.red-bg, .red-bg-hover:hover, .red-bg-hover:active, .red-bg-hover:focus,.woocommerce div.product .woocommerce-tabs ul.tabs li a' ).css( 'background-color', '#' + hex );
					$( '.red-col, .red-col-hover:hover, .red-col-hover:active, .red-col-hover:focus,.tell-team.dark .socialbut a:hover,.content-style a, #bbpress-forums a,#buddypress a' ).css( 'color', '#' + hex );
				} else if ( 'change_blue_col' == selector ) {
					$( '.blue-bg, .blue-bg-hover:hover, .blue-bg-hover:active, .blue-bg-hover:focus,.multi-tabs .nav-container nav a:hover, .multi-tabs .nav-container nav a:active, .multi-tabs .nav-container nav a:focus,.woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span,.woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover, .woocommerce div.product .woocommerce-tabs ul.tabs li a:active, .woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,.woocommerce div.product .woocommerce-tabs .panel' ).css( 'background-color', '#' + hex );
					$( '.blue-col, .blue-col-hover:hover, .blue-col-hover:active, .blue-col-hover:focus, header .bottom-line .full-menu > ul > li.current-menu-item > a,header .bottom-line .full-menu a:hover, header .bottom-line .full-menu a:active, header .bottom-line .full-menu a:focus,header .one-line .full-menu a:hover, header .one-line .full-menu a:active, header .one-line .full-menu a:focus,.sidebar a:hover, .sidebar a:active, .sidebar a:focus, .woocommerce ul.products li.product a.woocommerce-LoopProduct-link:hover, .woocommerce ul.products li.product a.woocommerce-LoopProduct-link:active, .woocommerce ul.products li.product a.woocommerce-LoopProduct-link:focus' ).css( 'color', '#' + hex );
				} else if ( 'change_blue_light_col' == selector ) {
					$( '.blue-light-bg, .blue-light-bg-hover:hover, .blue-light-bg-hover:active, .blue-light-bg-hover:focus, .blue-light-bg, .blue-light-bg-hover:hover, .blue-light-bg-hover:active, .blue-light-bg-hover:focus, .template-home-filter .range-slider.ui-slider .ui-slider-range, .template-home-filter .range-slider .ui-state-default, .template-home-filter .range-slider .ui-widget-content .ui-state-default, .template-home-filter .range-slider .ui-widget-header .ui-state-default, .blue-light-bg, .blue-light-bg-hover:hover, .blue-light-bg-hover:active, .blue-light-bg-hover:focus, .template-home-filter .range-slider.ui-slider .ui-slider-range, .template-home-filter .range-slider .ui-state-default, .template-home-filter .range-slider .ui-widget-content .ui-state-default, .template-home-filter .range-slider .ui-widget-header .ui-state-default, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce div.product #respond input#submit.alt, .woocommerce div.product a.button.alt, .woocommerce div.product button.button.alt, .woocommerce div.product input.button.alt, #add_payment_method .wc-proceed-to-checkout a.checkout-button, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,.woocommerce .widget_price_filter .ui-slider .ui-slider-range,#bbpress-forums div.bbp-search-form input[type=submit], #bbpress-forums div.bbp-search-form button[type=submit],#bbpress-forums fieldset.bbp-form input[type=submit], #bbpress-forums fieldset.bbp-form button[type=submit],#buddypress input[type=submit], #buddypress button[type=submit], #buddypress button[type=button]' ).css( 'background-color', '#' + hex );
					$( '.blue-light-col, .blue-light-col-hover:hover, .blue-col-light-hover:active, .blue-light-col-hover:focus, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce ul.products li.product .price, .woocommerce ul.products li.product .price ins' ).css( 'color', '#' + hex );
					$( '.template-home-filter .range-slider.ui-slider-horizontal, .woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content' ).css( 'border-color', '#' + hex );
				} else if ( 'change_yellow_col' == selector ) {
					$( '.yellow-bg, .yellow-bg-hover:hover, .yellow-bg-hover:active, .yellow-bg-hover:focus,.template-home-slider .owl-dots .owl-dot:hover, .template-home-slider .owl-dots .owl-dot:focus, .template-home-slider .owl-dots .owl-dot:active, .template-home-slider .owl-dots .owl-dot.active,.top-offers-slider .owl-dots .owl-dot:hover, .top-offers-slider .owl-dots .owl-dot:focus, .top-offers-slider .owl-dots .owl-dot:active, .top-offers-slider .owl-dots .owl-dot.active' ).css( 'background-color', '#' + hex );
					$( '.yellow-col, .yellow-col-hover:hover, .yellow-col-hover:active, .yellow-col-hover:focus, .woocommerce .products .star-rating, .woocommerce .star-rating, .woocommerce p.stars a' ).css( 'color', '#' + hex );
				} else if ( 'change_orange_col' == selector ) {
					$( '.orange-bg, .orange-bg-hover:hover, .orange-bg-hover:active, .orange-bg-hover:focus,.template-home-filter .range-slider.ui-slider .ui-slider-range, .template-home-filter .range-slider .ui-state-default, .template-home-filter .range-slider .ui-widget-content .ui-state-default, .template-home-filter .range-slider .ui-widget-header .ui-state-default,.woocommerce #respond input#submit:hover, .woocommerce #respond input#submit:active, .woocommerce #respond input#submit:focus, .woocommerce a.button:hover, .woocommerce a.button:active, .woocommerce a.button:focus, .woocommerce button.button:hover, .woocommerce button.button:active, .woocommerce button.button:focus, .woocommerce input.button:hover, .woocommerce input.button:active, .woocommerce input.button:focus,.woocommerce .widget_price_filter .ui-slider .ui-slider-handle:hover, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle:active, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle:focus,.woocommerce div.product #respond input#submit.alt:hover, .woocommerce div.product #respond input#submit.alt:active, .woocommerce div.product #respond input#submit.alt:focus, .woocommerce div.product a.button.alt:hover, .woocommerce div.product a.button.alt:active, .woocommerce div.product a.button.alt:focus, .woocommerce div.product button.button.alt:hover, .woocommerce div.product button.button.alt:active, .woocommerce div.product button.button.alt:focus, .woocommerce div.product input.button.alt:hover, .woocommerce div.product input.button.alt:active, .woocommerce div.product input.button.alt:focus,.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.woocommerce span.onsale,#bbpress-forums div.bbp-search-form input[type=submit]:hover, #bbpress-forums div.bbp-search-form input[type=submit]:active, #bbpress-forums div.bbp-search-form input[type=submit]:focus, #bbpress-forums div.bbp-search-form button[type=submit]:hover, #bbpress-forums div.bbp-search-form button[type=submit]:active, #bbpress-forums div.bbp-search-form button[type=submit]:focus,#bbpress-forums fieldset.bbp-form input[type=submit]:hover, #bbpress-forums fieldset.bbp-form input[type=submit]:active, #bbpress-forums fieldset.bbp-form input[type=submit]:focus, #bbpress-forums fieldset.bbp-form button[type=submit]:hover, #bbpress-forums fieldset.bbp-form button[type=submit]:active, #bbpress-forums fieldset.bbp-form button[type=submit]:focus,#buddypress input[type=submit]:hover, #buddypress input[type=submit]:active, #buddypress input[type=submit]:focus, #buddypress button[type=submit]:hover, #buddypress button[type=submit]:active, #buddypress button[type=submit]:focus, #buddypress button[type=button]:hover, #buddypress button[type=button]:active, #buddypress button[type=button]:focus' ).css( 'background-color', '#' + hex );
					$( '.orange-col, .orange-col-hover:hover, .orange-col-hover:active, .orange-col-hover:focus' ).css( 'color', '#' + hex );
					$( '.template-home-filter .range-slider.ui-slider-horizontal' ).css( 'border-color', '#' + hex );
				}
			},
			onSubmit: function ( hsb, hex, rgb ) {
				$.ajax( {
					method: "POST",
					url: ajax_admin[ 'url' ],
					cache: false,
					data: {
						action: selector,
						color: hex
					},
					success: function ( response ) {
						location.reload();
					},
					error: function () {
						console.log( 'Error' );
					}
				} );
			}
		} );
	};

	changeColor( 'change_red_col', '#F44336' );
	changeColor( 'change_blue_col', '#2196F3' );
	changeColor( 'change_blue_light_col', '#64B5F6' );
	changeColor( 'change_yellow_col', '#FFEB3B' );
	changeColor( 'change_orange_col', '#FF9800' );

	$( '.style-selector' ).on( 'click', '.show', function () {
		$( this ).addClass( 'hide' );
		$( this ).removeClass( 'show' );
		$( '.style-selector' ).addClass( 'active' );
	} );

	$( '.style-selector' ).on( 'click', '.hide', function () {
		$( this ).removeClass( 'hide' );
		$( this ).addClass( 'show' );
		$( '.style-selector' ).removeClass( 'active' );
	} );

	$( '.color-selector' ).on( 'click', '.show-color', function () {
		$( '.colorSelector' ).fadeOut( 300 );
		$( '.colorSelector .color' ).removeClass( 'hide-color' );
		$( '.colorSelector .color' ).addClass( 'show-color' );
		$( this ).parent().find( '.colorSelector' ).fadeIn( 300 );
		$( this ).addClass( 'hide-color' );
		$( this ).removeClass( 'show-color' );
	} );

	$( '.color-selector' ).on( 'click', '.hide-color', function () {
		$( this ).parent().find( '.colorSelector' ).fadeOut( 300 );
		$( this ).addClass( 'show-color' );
		$( this ).removeClass( 'hide-color' );
	} );

	$( '.colorpicker_submit' ).on( 'click', function () {
		var thisSubmit = $( this ).parent().parent().parent();
		thisSubmit.find( '.color' ).addClass( 'show-color' ).removeClass( 'hide-color' );
		thisSubmit.find( '.colorSelector' ).fadeOut( 300 );
	} );
})( jQuery );


