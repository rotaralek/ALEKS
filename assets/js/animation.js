(function ( $ ) {
	"use strict";

	function addAnimation(animatedClass, animatedEffect, animationDelay){
		if(!animationDelay){
			animationDelay = '';
		}
		$(animatedClass).addClass(animatedEffect);
		$(window).load(function() {
			$(animatedClass).addClass('animated ' + animationDelay);
		});
	}
	function addAnimationMultiElements(animatedClass, animatedEffect, animationDelay, delay){
		if(!animationDelay){
			animationDelay = '';
		}
		if(!delay){
			delay = 0;
		}
		$(animatedClass).addClass(animatedEffect);
		if(animatedClass.length) {
			$(window).load(function () {
				setTimeout(function(){
					$(animatedClass).each(function (i) {
						var item = $(this);
						setTimeout(function () {
							item.addClass('animated');
							setTimeout(function () {
								item.removeClass('active');
							}, 1000);
						}, animationDelay * i);
					});
				}, delay);
			});
		}
	}
	function scrollAnimation(animatedClass, animatedEffect, animationDelay, delay){
		if(!animationDelay){
			animationDelay = '';
		}
		if(!delay){
			delay = 0;
		}
		$(animatedClass).addClass(animatedEffect);
		if(animatedClass.length){
			$( window ).on('scroll', function() {
				setTimeout(function () {
					var windowOffset = $(window).scrollTop();
					var windowHeight = $(window).height();
					var partWindowHeight = (windowHeight / 4) * 3;
					var elementPosition = $(animatedClass).offset();
					var animationStart = windowOffset + partWindowHeight;
					if (typeof elementPosition != 'undefined') {
						if (animationStart >= elementPosition.top) {
							$(animatedClass).addClass('animated ' + animationDelay);
						}
					}
				}, delay);
			});
		}
	}
	function scrollAnimationMultiElements(animatedClass, animatedEffect, animationDelay, delay){
		if(!animationDelay){
			animationDelay = '';
		}
		if(!delay){
			delay = 0;
		}
		$(animatedClass).addClass(animatedEffect);
		$( window ).on('scroll', function() {
			if (animatedClass.length) {
				var windowOffset = $(window).scrollTop();
				var windowHeight = $(window).height();
				var partWindowHeight = (windowHeight / 4) * 3;
				var elementPosition = $(animatedClass).offset();
				var animationStart = windowOffset + partWindowHeight;
				if (typeof elementPosition != 'undefined') {
					if (animationStart >= elementPosition.top) {
						setTimeout(function () {
							$(animatedClass).each(function (i) {
								var item = $(this);
								setTimeout(function () {
									item.addClass('animated');
									setTimeout(function () {
										item.removeClass('active');
									}, 1000);
								}, animationDelay * i);
							});
						}, delay);
					}
				}
			}
		});
	}

	var windowWidth = $(window).width();

	//Animation init
	//addAnimation('header', 'animation-slide-from-top', 'delay-2');

	//scrollAnimation('.page-home-information h2', 'animation-slide-from-bottom');
})( jQuery );