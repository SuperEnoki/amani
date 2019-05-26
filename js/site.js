jQuery(document).ready(function($) {

	"use strict";

	// Initializing scripts

	var amani_grid = '.blog-feed';
	var amani_grid_item = '.grid-item';

	function amani_init() {
		amani_magic_masonry();

		// Instagram image width/height fix
		$('.header-instagram').imagesLoaded(function() {
			var header_instagram_width = $('.header-instagram li').width();
			$('.header-instagram li').css('max-height', header_instagram_width);
			$('.header-instagram').addClass('visible');
		});
		$('.footer-instagram').imagesLoaded(function() {
			var footer_instagram_width = $('.footer-instagram li').width();
			$('.footer-instagram li').css('max-height', footer_instagram_width);
			$('.footer-instagram').addClass('visible');
		});
	}

	/*

	BEGIN

	*/

	// Menu dividing to fist - last half

	var main_nav_length = Math.floor($('.main-nav div > ul > li').length / 2) + 1;
	$('.main-nav div > ul > li:nth-child(n + ' + main_nav_length + ')').addClass('last-half');

	// Search form click

	$(document).on('click', '.search-trigger', function(e) {
		$('body').addClass('search-active');
		setTimeout(function() { 
			$('.search-wrap input').focus();
		}, 300);
	});

	$('.search-wrap').on('click', function(e) {
		var target = $(e.target);
		if($(target).is('input') === false) {
			$('body').removeClass('search-active');
		}
	});

	// Escape Key

	$(document).keyup(function(e) {
		if (e.keyCode == 27) { // escape key maps to keycode `27`
			$('body').removeClass('search-active');
			$('body').removeClass('menu-active');
		}
	});

	// Responsive hamburger click

	$(document).on('click', '.responsive-menu-trigger', function() {
		if($('body').hasClass('menu-active')) {
			$('body').removeClass('menu-active');
		} else {
			history.pushState({id: 'menu'}, '', '');
			$('body').addClass('menu-active');
		}
	});

	window.addEventListener("popstate", function(e) {
		if(history.state.id == 'menu') {
			$('body').removeClass('menu-active');
		}
	});

	$('.responsive-wrap').on('click', function(e) {
		var target = $(e.target);
		if($(target).is('a') === false) {
			$('body').removeClass('menu-active');
		}
	});

	// Scrolltop click

	$(document).on('click', '.scrolltop', function() {
		$('html, body').animate({ scrollTop: 0 }, 300);
	});

	// Wrap Calendar in Divs for better styling

	$('.widget_calendar td:not(:has(>a))').wrapInner('<div></div>');

	// Responsive submenu click

	$(document).on('click', '.responsive-nav .menu-item-has-children > a', function(e) {
		e.preventDefault();
		var curmenu = $(this).parent();
		var submenu = $(this).parent().find('> ul');
		if(submenu.is(':visible')) {
			submenu.hide();
			curmenu.removeClass('active');
			curmenu.parent().find('> li').show();
		} else {
			submenu.show();
			curmenu.addClass('active');
			curmenu.parent().find('> li:not(.active)').hide();
		}
	});

	// Dropdown menu

	$('nav ul.menu li').hover(function() {
		var timeout = $(this).data('timeout');
		var $currentUl = $(this).find('> ul');
		if(timeout) clearTimeout(timeout);
		if($currentUl.hasClass('visible') === false && $currentUl.length > 0) {
			$(this).find('> ul').addClass('visible');
		}
	}, function() {
		$(this).data('timeout', setTimeout($.proxy(function() {
			$(this).find('> ul').removeClass('visible');
		}, this), 200));
	});

	// Infinite Scroll

	$.bktis = {
		containerSelector:  '.blog-feed',
		postSelector:       '.grid-item',
		paginationSelector: '.navigation',
		nextSelector:       '.next',
		loadingHtml:        '',
		show:               function(elems) { elems.show(); },
		nextPageUrl:        null,

		init: function(options) {
			for (var key in options) {
				$.bktis[key] = options[key];
			}

			$(function() {
				$.bktis.extractNextPageUrl($('body'));
				$(window).bind('scroll', $.bktis.scroll);
				$.bktis.scroll();
			});
		},
		
		scroll: function() {
			$($.bktis.containerSelector).imagesLoaded(function() {
				if ($.bktis.nearBottom() && $.bktis.shouldLoadNextPage()) {
					$.bktis.loadNextPage();
				}
			});
		},
		
		nearBottom: function() {
			var scrollTop = $(window).scrollTop(),
					windowHeight = $(window).height(),
					lastPostOffset = $($.bktis.containerSelector).find($.bktis.postSelector).last().offset();

			if (!lastPostOffset) return;
			return (scrollTop > (lastPostOffset.top - windowHeight));
		},

		shouldLoadNextPage: function() {
			return !!$.bktis.nextPageUrl;
		},
		
		loadNextPage: function() {
			var nextPageUrl = $.bktis.nextPageUrl,
					loading = $($.bktis.loadingHtml);
			$.bktis.nextPageUrl = null;
			loading.insertAfter($.bktis.containerSelector);
			$.get(nextPageUrl, function(html) {
				var dom = $(html),
					posts = dom.find($.bktis.containerSelector).find($.bktis.postSelector);
				$.bktis.show(posts.hide().appendTo($.bktis.containerSelector));
				$.bktis.extractNextPageUrl(dom);
				$.bktis.scroll();
			});
		},

		extractNextPageUrl: function(dom) {
			var pagination = dom.find($.bktis.paginationSelector);
			$.bktis.nextPageUrl = pagination.find($.bktis.nextSelector).attr('href');
			pagination.remove();
		}
	}

	if($('.theme-body').hasClass('infinite_scroll') == true) {
		$.bktis.init({
			containerSelector: amani_grid,
			postSelector: amani_grid_item,
			paginationSelector: '.navigation',
			nextSelector: '.next',
			loadingHtml: '<div class="infinite-scroll-spinner"></div>',
			show: function(elems) {
				elems.show();
				amani_init();
			}
		});
	}

	// Magic Masonry

	function amani_magic_masonry() {
		const grid = document.querySelector('.blog_layout-masonry' + ' ' +  amani_grid);
		// checking if grid container exist
		if(typeof(grid) != 'undefined' && grid != null) {
			$(amani_grid).append("<div class='infinite-scroll-spinner'></div>");
			$(amani_grid).imagesLoaded(function() {
				const rowHeight = parseInt($(grid).css("grid-auto-rows"));
				const rowGap = parseInt($(grid).css("grid-row-gap"));
				grid.style.gridAutoRows = "auto";
				grid.style.alignItems = "self-start";
				grid.querySelectorAll(amani_grid_item).forEach(item => {
					item.style.gridRowEnd = `span ${Math.ceil(
						(item.clientHeight + rowGap) / (rowHeight + rowGap)
						)}`;
						if($(item).hasClass('visible') == false) {
							$(item).addClass('visible');
						}
				});
				grid.removeAttribute("style");
				$('.infinite-scroll-spinner').fadeOut('normal', function() { $(this).remove(); });
			});
		} else {
			$(amani_grid).imagesLoaded(function() {
				$(amani_grid_item).addClass('visible');
			});
			$('.infinite-scroll-spinner').fadeOut('normal', function() { $(this).remove(); });
		}
	}

	// When images loaded we show items

	$('.featured-posts').imagesLoaded(function() {
		$('.featured-posts .grid-item').addClass('visible');
	});

	// Slideshow

	var amani_slideshow = (function() {

		function amani_slideshow(element, options) {
			var _ = this;
			_.settings = $.extend($.fn.amani_slideshow.defaults, options);
			_.el = element;
			_.$element = $(element);
			_.$photos = _.$element.children();
			_.count = _.$photos.length;
			_.init();
		}

		amani_slideshow.prototype.init = function() {
			var _ = this;
			if(_.$element.find('.slideshow-paginator').length < 1) {
				_.$element.append('<nav class="slideshow-paginator" />');
				for (var i = 0; i < _.count; i++) {
					_.$element.find('.slideshow-paginator').append('<span/>');
				}
				_.$element.find('.slideshow-paginator span:first-child').addClass('current');
				_.$element.find('.grid-item:first-child').addClass('current');

				_.$element.find('.slideshow-paginator').on('slide_switch', 'span', function() {
					_.$element.find('.slideshow-paginator span').removeClass('current');
					$(this).addClass('current');
					var slide_switch = $(this).index();
					_.$photos.removeClass('current');
					_.$photos.eq(slide_switch).addClass('current');
				});

				_.$element.find('.slideshow-paginator').on('click', 'span', function() {
					$(this).trigger('slide_switch');
				});

				_.$element.data('interval', _.settings.interval);

				_.play();
				_.autoPlayPause();
			}
		}

		amani_slideshow.prototype.play = function() {
			var _ = this;
			if(_.$element.data('stopped') != 1) {
				var $paginator_current = _.$element.find('.slideshow-paginator span.current');
				var $paginator_next = $paginator_current.next();
				if($paginator_next.length > 0) {
					$paginator_next.trigger('slide_switch');
				} else {
					_.$element.find('.slideshow-paginator span:first-child').trigger('slide_switch');
				}
				setTimeout(function() { _.play(); }, _.$element.data('interval'));
			} else {
				setTimeout(function() { _.play(); }, _.$element.data('interval'));
			}

		};

		amani_slideshow.prototype.autoPlayPause = function() {
			var _ = this;
			_.$element.on({
				mouseenter: function(){
					_.$element.data('stopped', 1);
				},
				mouseleave: function(){
					_.$element.data('stopped', 0);
				}
			});
	   };

		$.fn.amani_slideshow = function(options) {
			var instance;
			instance = this.data('amani_slideshow');
			if (!instance) {
				return this.each(function() {
					return $(this).data('amani_slideshow', new amani_slideshow(this,options));
				});
			}
			if (options === true) return instance;
			if ($.type(options) === 'string') instance[options]();
			return this;
		};

		$.fn.amani_slideshow.defaults = {
			interval: 5000,
		};

	}).call(this);

	// Init

	amani_init();

	$('.top_featured_layout-slideshow .featured-top').amani_slideshow({
		interval: 5000
	});

	document.addEventListener('theme-reinit', function() {
		amani_init();
		$('.top_featured_layout-slideshow .featured-top').amani_slideshow({
			interval: 5000
		});
	});

	$(window).resize(function() {
		amani_init();
	});
	$(window).focus(function() {
		amani_init();
	});

});