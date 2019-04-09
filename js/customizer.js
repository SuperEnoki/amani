jQuery(document).ready(function($) {
	
	// JavaScript Live Preview Customizer Helper

	"use strict";

	$('body').append('<style class="amani-css-0"></style>');
	$('body').append('<style class="amani-css-1"></style>');

	$('body').data('amani_color1', amani_theme_color[0]);
	$('body').data('amani_color2', amani_theme_color[1]);
	$('body').data('amani_default-color1', amani_theme_color[0]);
	$('body').data('amani_default-color2', amani_theme_color[1]);
	$('body').data('amani_gradient', amani_theme_gradient);
	$('body').data('amani_background', amani_theme_background);


	// Also in options.js (plugin) styles.php (x2) customizer.js
	var gradients_selectors = '.body-bg, .responsive-nav, .search-wrap, .fourofour, .empty-cat h2, .archive-header h1, h1.post-title, .title-search-no-results';

	// Logo Image

	wp.customize('amani_options[logo]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.logo-wrap .logo-text').hide();
				$('.logo-wrap .logo-image').show();
				$('.logo-wrap .logo-image a').html('<img srcset="'+ encodeURI(to) +' 2x" />');
			} else {
				$('.logo-wrap .logo-text').show();
				$('.logo-wrap .logo-image').hide();
				$('.logo-wrap .logo-image a img').remove();
			}
		});
	});

	// Retina Logo

	wp.customize('amani_options[retina]', function(value) {
		value.bind(function(to) {
			if(to == true) {
				var retina_src = $('.logo-wrap img').attr('src');
				if(typeof retina_src != 'undefined') {
					$('.logo-wrap .logo-image img').remove();
					$('.logo-wrap .logo-image a').append('<img />');
					$('.logo-wrap .logo-image img').attr('srcset', retina_src + ' 2x');
					$('.logo-wrap .logo-image img').attr('src', '');
				} else {

				}
			} else {
				var retina_src = $('.logo-wrap img').attr('srcset');
				if(typeof retina_src != 'undefined') {
					$('.logo-wrap .logo-image img').remove();
					$('.logo-wrap .logo-image a').append('<img />');
					retina_src = retina_src.replace(' 2x', '');
					$('.logo-wrap .logo-image img').attr('src', retina_src);
					$('.logo-wrap .logo-image img').attr('srcset', '');
				} else {

				}
			}
		});
	});

	// Tagline Show/Hide

	wp.customize('amani_options[lead]', function(value) {
		value.bind(function(to) {
			if(to == true) {
				$('.logo-wrap .lead').show();
			} else {
				$('.logo-wrap .lead').hide();
			}
		});
	});

	// Tagline Text

	wp.customize('amani_options[lead_text]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.logo-wrap .lead').text(to);
			} else {
				$('.logo-wrap .lead').text('');
			}
		});
	});

	// Gradient 

	wp.customize('amani_options[gradient]', function(value) {
		value.bind(function(to) {
			if(to) {
				if(to == 'none') {
					$(gradients_selectors).css('background-image', 'none');
					$(gradients_selectors).css('background-color', amani_theme_background);
					$('body').data('amani_gradient', 'none');
				} else {
					var color_scheme = [];
					color_scheme[0] = $('body').data('amani_color1');
					color_scheme[1] = $('body').data('amani_color2');
					$('body').data('amani_gradient', to);
					$(gradients_selectors).css('background-image', 'linear-gradient(to '+to+', '+color_scheme[0]+', '+color_scheme[1]+')');
				}
			}
		});
	});

	// Color Scheme

	wp.customize('amani_options[color_scheme]', function(value) {
		value.bind(function(to) {
			if(to) {
				var gradient = $('body').data('amani_gradient');
				var color_scheme = to.split(" ");
				if(color_scheme[0] == 'custom') {
					// Custom Color scheme, setting values from selected colors
					color_scheme[0] = $('body').data('amani_default-color1');
					color_scheme[1] = $('body').data('amani_default-color2');
				} else {
					// Built-in color scheme, setting values from customizer
					$('body').data('amani_color1', color_scheme[0]);
					$('body').data('amani_color2', color_scheme[1]);
				}
				var amani_CSS = '';
				if (typeof amani_css_0_background != 'undefined') {
					amani_css_0_background.forEach(function(entry) {
						amani_CSS = amani_CSS + ' ' + entry + '{ background-color: ' + color_scheme[0] + '}';
					});
				}
				if (typeof amani_css_0_hover != 'undefined') {
					amani_css_0_hover.forEach(function(entry) {
						amani_CSS = amani_CSS + ' ' + entry + '{ color: ' + color_scheme[0] + '}';
					});
				}
				if (typeof amani_css_0_border != 'undefined') {
					amani_css_0_border.forEach(function(entry) {
						amani_CSS = amani_CSS + ' ' + entry + '{ border-color: ' + color_scheme[0] + '}';
					});
				}
				if (typeof amani_css_1_background != 'undefined') {
					amani_css_1_background.forEach(function(entry) {
						amani_CSS = amani_CSS + ' ' + entry + '{ background-color: ' + color_scheme[1] + '}';
					});
				}
				if (typeof amani_css_1_hover != 'undefined') {
					amani_css_1_hover.forEach(function(entry) {
						amani_CSS = amani_CSS + ' ' + entry + '{ color: ' + color_scheme[1] + '}';
					});
				}
				if (typeof amani_css_1_border != 'undefined') {
					amani_css_1_border.forEach(function(entry) {
						amani_CSS = amani_CSS + ' ' + entry + '{ border-color: ' + color_scheme[1] + '}';
					});
				}
				$(gradients_selectors).css('background-image', 'linear-gradient(to '+gradient+', '+color_scheme[0]+', '+color_scheme[1]+')');
				$('.post-category a').css('background-color', '');
				$('.amani-css-0').html(amani_CSS);
				$('.amani-css-1').html('');
			}
		});
	});

	// Main Color

	wp.customize('amani_options[color1]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('body').data('amani_color1', to);
				$('body').data('amani_default-color1', to);
				var extra_color = $('body').data('amani_color2');
				var gradient = $('body').data('amani_gradient');
				var amani_CSS = '';
				if (typeof amani_css_0_background != 'undefined') {
					amani_css_0_background.forEach(function(entry) {
						amani_CSS = amani_CSS + ' ' + entry + '{ background-color: ' + to + '}';
					});
				}
				if (typeof amani_css_0_hover != 'undefined') {
					amani_css_0_hover.forEach(function(entry) {
						amani_CSS = amani_CSS + ' ' + entry + '{ color: ' + to + '}';
					});
				}
				if (typeof amani_css_0_border != 'undefined') {
					amani_css_0_border.forEach(function(entry) {
						amani_CSS = amani_CSS + ' ' + entry + '{ border-color: ' + to + '}';
					});
				}
				if(gradient != 'none') {
					$(gradients_selectors).css('background-image', 'linear-gradient(to '+gradient+', '+extra_color+', '+to+')');
				}
				$('.post-category a:nth-child(odd)').css('background-color', '');
				$('.amani-css-0').html(amani_CSS);
			}
		});
	});

	// Secondary Color

	wp.customize('amani_options[color2]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('body').data('amani_color2', to);
				$('body').data('amani_default-color2', to);
				var extra_color = $('body').data('amani_color1');
				var gradient = $('body').data('amani_gradient');
				var amani_CSS = '';
				if (typeof amani_css_1_background != 'undefined') {
					amani_css_1_background.forEach(function(entry) {
						amani_CSS = amani_CSS + ' ' + entry + '{ background-color: ' + to + '}';
					});
				}
				if (typeof amani_css_1_hover != 'undefined') {
					amani_css_1_hover.forEach(function(entry) {
						amani_CSS = amani_CSS + ' ' + entry + '{ color: ' + to + '}';
					});
				}
				if (typeof amani_css_1_border != 'undefined') {
					amani_css_1_border.forEach(function(entry) {
						amani_CSS = amani_CSS + ' ' + entry + '{ border-color: ' + to + '}';
					});
				}
				if(gradient != 'none') {
					$(gradients_selectors).css('background-image', 'linear-gradient(to '+gradient+', '+to+', '+extra_color+')');
				}
				$('.post-category a:nth-child(even)').css('background-color', '');
				$('.amani-css-1').html(amani_CSS);
			}
		});
	});

	// Social Share

	wp.customize('amani_options[social_share]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.theme-body').addClass('social_share');
			} else {
				$('.theme-body').removeClass('social_share');
			}
		});
	});

	// Sidebar Position

	wp.customize('amani_options[sidebar_position]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.theme-body').removeClass('sidebar_position-left sidebar_position-right sidebar_position-hidden');
				$('.theme-body').addClass('sidebar_position-' + to);
			}
		});
	});

	// Blog Layout

	wp.customize('amani_options[blog_layout]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.theme-body').removeClass('blog_layout-masonry blog_layout-grid blog_layout-standard blog_layout-list');
				$('.theme-body').addClass('blog_layout-' + to);
			}
		});
	});

	// Top Featured Layout

	wp.customize('amani_options[top_featured_layout]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.theme-body').removeClass('top_featured_layout-trio top_featured_layout-squared top_featured_layout-rounded top_featured_layout-slideshow');
				$('.theme-body').addClass('top_featured_layout-' + to);
			}
		});
	});

	// Body Coloring

	wp.customize('amani_options[body_bg_coloring]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.theme-body').removeClass('b-default b-inversed');
				$('.theme-body').addClass('b-' + to);
			}
		});
	});

	// Content Coloring

	wp.customize('amani_options[content_bg_coloring]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.theme-body').removeClass('c-default c-inversed');
				$('.theme-body').addClass('c-' + to);
			}
		});
	});

	// Body Background Color

	wp.customize('amani_options[body_bg]', function(value) {
		value.bind(function(to) {
			if(to) {
				$(gradients_selectors).css('background-color', to);
			}
		});
	});

	// Content Background Color

	wp.customize('amani_options[content_bg]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.theme-body:not(.blog_layout-masonry) .content').css('background-color', to);
				$('body.single .content, body.page .content').css('background-color', to);
				$('.theme-body.blog_layout-masonry .content .grid-item').css('background-color', to);
				$('.theme-body.blog_layout-masonry .content section').css('background-color', to);
				$('.theme-body.blog_layout-masonry .content .nav-links a.page-numbers:not(.next)').css('background-color', to);
				$('.theme-body.blog_layout-masonry .content .archive-header').css('background-color', to);
				$('.theme-body.blog_layout-masonry .content .empty-cat-wrap').css('background-color', to);
				$('body.error404 .theme-body.blog_layout-masonry .content').css('background-color', to);
				$('body.search-no-results .theme-body.blog_layout-masonry .content').css('background-color', to);
			}
		});
	});

	// Footer Copyright Text

	wp.customize('amani_options[footer_text]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('footer.footer-main .copyright-text').text(to);
			} else {
				$('footer.footer-main .copyright-text').text('');
			}
		});
	});

	// Logo Font Family

	wp.customize('amani_options[logo_font]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.amani-customizer-logo-font').remove();
				$('.logo-wrap .logo-text, .footer-logo').css('font-family', to);
				$('head').append('<link class="amani-customizer-logo-font" href="//fonts.googleapis.com/css?family=' + encodeURI(to) + ':200,300,400,500,600,700,900" rel="stylesheet" />');
			}
		});
	});

	// Logo Font Size

	wp.customize('amani_options[logo_size]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.logo-wrap .logo-text, .footer-logo').css('font-size', to);
			}
		});
	});

	// Logo Uppercase

	wp.customize('amani_options[logo_uppercase]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.logo-wrap .logo-text, .footer-logo').css('text-transform', 'uppercase');
			} else {
				$('.logo-wrap .logo-text, .footer-logo').css('text-transform', 'none');
			}
		});
	});

	// Logo Font Weight

	wp.customize('amani_options[logo_weight]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.logo-wrap .logo-text, .footer-logo').css('font-weight', to);
			}
		});
	});

	// Logo Italic

	wp.customize('amani_options[logo_italic]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.logo-wrap .logo-text, .footer-logo').css('font-style', 'italic');
			} else {
				$('.logo-wrap .logo-text, .footer-logo').css('font-style', 'normal');
			}
		});
	});

	// Heading Font

	wp.customize('amani_options[heading_font]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.amani-customizer-heading-font').remove();
				$('head').append('<link class="amani-customizer-heading-font" href="//fonts.googleapis.com/css?family=' + encodeURI(to) + ':200,300,400,500,600,700,900" rel="stylesheet" />');
				$('h1:not(.logo),h2,h3,h4,h5,h6').css('font-family', to);
			}
		});
	});

	// Heading Uppercase

	wp.customize('amani_options[heading_uppercase]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('h1:not(.logo), h2, h3, h4, h5, h6, .post-title').css('text-transform', 'uppercase');
			} else {
				$('h1:not(.logo), h2, h3, h4, h5, h6, .post-title').css('text-transform', 'none');
			}
		});
	});

	// Post Title Font Size

	wp.customize('amani_options[heading_size]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('h1.post-title').css('font-size', to);
			}
		});
	});

	// Heading Font Weight

	wp.customize('amani_options[heading_weight]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('h1:not(.logo), h2, h3, h4, h5, h6, .post-title').css('font-weight', to);
			}
		});
	});

	// Heading Italic

	wp.customize('amani_options[heading_italic]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('h1:not(.logo), h2, h3, h4, h5, h6, .post-title').css('font-style', 'italic');
			} else {
				$('h1:not(.logo), h2, h3, h4, h5, h6, .post-title').css('font-style', 'normal');
			}
		});
	});

	// Body Font

	wp.customize('amani_options[body_font]', function(value) {
		value.bind(function(to) {
			if(to) {
				$('.amani-customizer-body-font').remove();
				$('head').append('<link class="amani-customizer-body-font" href="//fonts.googleapis.com/css?family=' + encodeURI(to) + ':400,400i,700,700i" rel="stylesheet" />');
				$('body, input, button, textarea, select').css('font-family', to);
			}
		});
	});

});