<?php

// Generating styles for inline display in theme from Customizer and Defaults

function amani_styles() {

	global $amani;

	$amani_css = '';

	// Fonts

	$logo_font = esc_html(amani_get_option('logo_font', $amani['logo_font']));
	$heading_font = esc_html(amani_get_option('heading_font', $amani['heading_font']));
	$body_font = esc_html(amani_get_option('body_font', $amani['body_font']));
	
	// Weight

	$logo_weight = esc_html(amani_get_option('logo_weight', $amani['logo_weight']));
	$heading_weight = esc_html(amani_get_option('heading_weight', $amani['heading_weight']));

	// Italic

	$logo_italic = esc_html(amani_get_option('logo_italic', $amani['logo_italic']));
	$heading_italic = esc_html(amani_get_option('heading_italic', $amani['heading_italic']));

	if($logo_italic) {
		$logo_italic = 'i';
	}
	if($heading_italic) {
		$heading_italic = 'i';
	}

	// Character sets

	$subset='';

	if(amani_get_option('font_char_latin_ext')) {
		$subset.='latin-ext,';
	}
	if(amani_get_option('font_char_cyrillic')) {
		$subset.='cyrillic,';
	}
	if(amani_get_option('font_char_cyrillic_ext')) {
		$subset.='cyrillic-ext,';
	}
	if(amani_get_option('font_char_greek')) {
		$subset.='greek,';
	}
	if(amani_get_option('font_char_greek_ext')) {
		$subset.='greek-ext';
	}

	$subset = rtrim($subset,',');

	// Importing Google Fonts

	$all_fonts = '';

	if(is_customize_preview()) {
		$logo_weight_get        = '200,300,400,500,600,700,900,200i,300i,400i,500i,600i,700i,900i';
		$heading_weight_get     = '200,300,400,500,600,700,900,200i,300i,400i,500i,600i,700i,900i';
	} else {
		$logo_weight_get = $logo_weight.$logo_italic;
		$heading_weight_get = $heading_weight.$heading_italic;
	}

	$default_subsets = '300,400,400i,700,700i';

	if($logo_font == $heading_font) {
		if($logo_font == $body_font) {
			// All fonts same
			if(!in_array($logo_font, $amani['default_fonts'], true)) {
				$all_fonts .= $logo_font.':'.$logo_weight_get.','.$heading_weight_get.','.$default_subsets;
			}
		} else {
			// Logo & Heading font same
			if(!in_array($logo_font, $amani['default_fonts'], true)) {
				$all_fonts .= $logo_font.':'.$logo_weight_get.','.$heading_weight_get.'|';
			}
			if(!in_array($body_font, $amani['default_fonts'], true)) {
				$all_fonts .= $body_font.':'.$default_subsets;
			}
		}
	} elseif($logo_font == $body_font) {
		// Logo & Body font same
		if(!in_array($logo_font, $amani['default_fonts'], true)) {
			$all_fonts .= $logo_font.':'.$logo_weight_get.','.$default_subsets.'|';
		}
		if(!in_array($heading_font, $amani['default_fonts'], true)) {
			$all_fonts .= $heading_font.':'.$heading_weight_get.'';
		}
	} else {
		// Logo Font unique
		if(!in_array($logo_font, $amani['default_fonts'], true)) {
			$all_fonts .= $logo_font.':'.$logo_weight_get.'|';
		}
		if($heading_font == $body_font) {
			// Heading & Body font same
			if(!in_array($heading_font, $amani['default_fonts'], true)) {
				$all_fonts .= $heading_font.':'.$heading_weight_get.','.$default_subsets.'';
			}
		} else {
			// Heading & Body unique
			if(!in_array($heading_font, $amani['default_fonts'], true)) {
				$all_fonts .= $heading_font.':'.$heading_weight_get.'|';
			}
			if(!in_array($body_font, $amani['default_fonts'], true)) {
				$all_fonts .= $body_font.':'.$default_subsets;
			}
		}
	}

	if($all_fonts != '') {
		echo '<link class="amani-g-fonts" href="//fonts.googleapis.com/css?family='.urlencode($all_fonts).'&subset='.urlencode($subset).'" rel="stylesheet" />';
	} else {
		echo '<link class="amani-g-fonts" rel="stylesheet" />';
	}

	// Colors

	$color = amani_api_color_scheme();

	// Begin CSS

	echo '<style>';

	if(!is_admin()) {

		// Content Background

		$content_bg = esc_html(amani_get_option('content_bg', $amani['content_bg']));
		// Extra in customizer.js
		echo '
			.theme-body:not(.blog_layout-masonry) .content,
			.theme-body.blog_layout-masonry .content .nav-links a.page-numbers:not(.next),
			body.error404 .theme-body.blog_layout-masonry .content,
			body.search-no-results .theme-body.blog_layout-masonry .content,
			.theme-body.blog_layout-masonry .content .grid-item,
			.theme-body.blog_layout-masonry .content .archive-header,
			.theme-body.blog_layout-masonry .content .empty-cat-wrap,
			.theme-body.blog_layout-masonry .content section,
			body.single .content,
			body.page .content {
				background-color: '.$content_bg.';
			}
		';

		// Logo Image

		if(amani_get_option('logo')) {
			echo '
				header.header-main .logo-wrap .logo-image { display: block; }
				header.header-main .logo-wrap .logo-text { display: none; }
			';
		}
		
		// Tagline

		if(amani_get_option('lead', $amani['lead'])) {
			echo '
				header.header-main .logo-wrap .lead { display: block; }
				header.header-main .logo-wrap { text-align: center; }
			';
		}

		// Logo Font
		
		echo '
			.logo-wrap .logo-text, .footer-logo { font-family: "'.$logo_font.'"; }
		';

		// Logo Font Size

		echo '
			.logo-wrap .logo-text, .footer-logo { font-size: '.esc_attr(amani_get_option('logo_size', $amani['logo_size'])).'; }
		';

		// Logo Text Transform

		if(amani_get_option('logo_uppercase', $amani['logo_uppercase'])) {
			echo '
				.logo-wrap .logo-text { text-transform: uppercase; } .footer-logo { text-transform: uppercase; }
			';
		}

		// Logo Font Weight

		echo '
			.logo-wrap .logo-text, .footer-logo { 
				font-weight: '.$logo_weight.';
			}
		';

		// Logo Italic

		if($logo_italic) {
			echo '
				.logo-wrap .logo-text, .footer-logo { 
					font-style: italic;
				}
			';
		}

		// Heading Font

		echo '
			h1, h2, h3, h4, h5, h6 { font-family: "'.$heading_font.'"; }
		';

		// Heading Text Transform

		if(amani_get_option('heading_uppercase', $amani['heading_uppercase'])) {
			echo '
				h1:not(.logo), h2, h3, h4, h5, h6 { text-transform: uppercase; }
			';
		}

		// Heading Font Weight

		echo '
			h1:not(.logo), h2, h3, h4, h5, h6 { 
				font-weight: '.$heading_weight.';
			}
		';

		// Heading Italic

		if($heading_italic) {
			echo '
				h1:not(.logo), h2, h3, h4, h5, h6 { 
					font-style: italic;
				}
			';
		}

		// Post Title Font Size

		echo '
			h1.post-title, .woocommerce h1 { 
				font-size: '.esc_attr(amani_get_option('heading_size', $amani['heading_size'])).';
			}
		';

		// Body Font

		echo '
			body, input, button, textarea, select, pre.wp-block-verse, .wp-block-verse { font-family: "'.$body_font.'", sans-serif; }
		';

		for ($cc=0; $cc < $amani['color_num']; $cc++) {
			foreach ($amani['color_places'] as $key => $value) {
				if(!empty($amani['css_colors'][$cc][$key])) {
					echo amani_css_list($amani['css_colors'][$cc][$key]);
					echo '
					{
						'.$value.': '.$color[$cc].';
					}
					';
				}
			}
		}

		// Body Background

		$gradient = esc_attr(amani_get_option('gradient', $amani['gradient']));
		if($gradient == 'none') {
			$body_bg = esc_html(amani_get_option('body_bg', $amani['body_bg']));
			// Also in options.js (plugin) styles.php (x2) customizer.js
			echo '
				.body-bg, .responsive-nav, .search-wrap {
					background-color: '.$body_bg.';
				}
			';
			// No gradient - Headings plain color
			echo '.fourofour, .empty-cat h2, .archive-header h1, h1.post-title, .title-search-no-results { color: '.$color[0].'; }';
		} else {
			// Also in options.js (plugin) styles.php (x2) customizer.js
			echo '.body-bg, .responsive-nav, .search-wrap, .fourofour, .empty-cat h2, .archive-header h1, h1.post-title, .title-search-no-results { background-image: linear-gradient(to '.$gradient.', '.$color[0].', '.$color[1].'); }';
			echo '.fourofour, .empty-cat h2, .archive-header h1, h1.post-title, .title-search-no-results { -webkit-background-clip: text; -webkit-text-fill-color: transparent; }';
		}

	} else {

		// Gutenberg

		// Gradient

		$gradient = esc_attr(amani_get_option('gradient', $amani['gradient']));
		if($gradient == 'none') {
			// echo '.editor-post-title__block .editor-post-title__input { color: '.$color[0].' }';
		} else {
			// Also in options.js (plugin) styles.php (x2) customizer.js
			echo '.editor-post-title__block .editor-post-title__input { background-image: linear-gradient(to '.$gradient.', '.$color[0].', '.$color[1].'); -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; }';
		}

		echo '.wp-block .wp-block-button__link { background-color: '.$color[0].'; }';
		echo '.wp-block a:hover { color: '.$color[0].'; }';

		// Heading Font

		echo '
			.wp-block h1, .wp-block h2, .wp-block h3, .wp-block h4, .wp-block h5, .wp-block h6, .editor-post-title__block .editor-post-title__input { font-family: "'.$heading_font.'"; }
		';

		// Heading Text Transform

		if(amani_get_option('heading_uppercase', $amani['heading_uppercase'])) {
			echo '
				.wp-block h1:not(.logo), .wp-block h2, .wp-block h3, .wp-block h4, .wp-block h5, .wp-block h6, .editor-post-title__block .editor-post-title__input { text-transform: uppercase; }
			';
		}

		// Heading Font Weight

		echo '
			.wp-block h1:not(.logo), .wp-block h2, .wp-block h3, .wp-block h4, .wp-block h5, .wp-block h6, .editor-post-title__block .editor-post-title__input { 
				font-weight: '.$heading_weight.';
			}
		';

		// Heading Italic

		if($heading_italic) {
			echo '
				.wp-block h1:not(.logo), .wp-block h2, .wp-block h3, .wp-block h4, .wp-block h5, .wp-block h6, .editor-post-title__block .editor-post-title__input { 
					font-style: italic;
				}
			';
		}

		// Post Title Font Size

		echo '
			.editor-post-title__block .editor-post-title__input { 
				font-size: '.esc_attr(amani_get_option('heading_size', $amani['heading_size'])).';
			}
		';

		// Body Font

		echo '
			.wp-block { font-family: "'.$body_font.'", sans-serif; }
		';
	}

	// End CSS Closing Tag

	echo '</style>';
}
add_action('wp_head', 'amani_styles', 100);
add_action('admin_head', 'amani_styles', 100);

function amani_gutenberg_styles() {
	// Load the theme styles within Gutenberg.
	wp_enqueue_style('amani-gutenberg', get_template_directory_uri() . "/css/editor.css");
}
add_action('enqueue_block_editor_assets', 'amani_gutenberg_styles');

?>