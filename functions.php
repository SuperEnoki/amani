<?php

	// Theme options that can be edited in WordPress Theme Customizer, defaults are here

	// Header

	$amani['logo_font']             = 'Comfortaa';
	$amani['logo_size']             = '48px';
	$amani['logo_weight']           = '600';
	$amani['logo_italic']           = false;
	$amani['logo_uppercase']        = true;
	$amani['lead']                  = false;

	$amani['header_layout']         = 'three';

	// Content

	$amani['social_share']          = true;
	$amani['infinite_scroll']       = true;

	$amani['sidebar_position']      = 'hidden';
	$amani['blog_layout']           = 'masonry';
	$amani['top_featured_layout']   = 'squared';

	$amani['body_font']             = 'Quicksand';

	$amani['heading_font']          = 'Comfortaa';
	$amani['heading_uppercase']     = false;
	$amani['heading_size']          = '52px';
	$amani['heading_weight']        = '700';
	$amani['heading_italic']        = false;

	$amani['color_scheme']          = '#ff71ce #01cdfe #29eaa1 #b967ff #ffe13c';
	$amani['color1']                = '#ff71ce';
	$amani['color2']                = '#01cdfe';
	$amani['colored_categories']    = true;

	$amani['gradient']              = 'top right';

	$amani['body_bg']               = '#01cdfe';
	$amani['body_bg_coloring']      = 'inversed'; # default / inversed
	$amani['content_bg']            = '#ffffff';
	$amani['content_bg_coloring']   = 'default';

	$amani['style_set']             = ''; # To enable set 'Custom'

	// Style Sets

	// Custom, won't change the settings set by user in Customizer
	$amani['style_sets']['Custom'] = array();

	$amani['style_sets']['Vaporwave'] = array(
		'logo_font' 					=> 'Satisfy',
		'logo_size'						=> '54px',
		'heading_font'					=> 'Open Sans',
		'heading_weight'				=> '400',
		'body_font'						=> 'Segoe UI, San Francisco',
		'logo_uppercase' 				=> false,
		'header_layout'				=> 'four',
		'blog_layout'					=> 'list',
		'top_featured_layout'		=> 'slideshow',
	);

	// Getting theme options from database and storing it in array
	$amani['db_options'] = get_option('amani_options');

	if($amani['style_set'] != '') {
		// If the style set is set in customizer we will replace values from customizer with pre-configured before in this file
		if(isset($amani['db_options']['style_set'])) {
			$amani_selected_style_set = $amani['db_options']['style_set'];
		} else {
			$amani_selected_style_set =  $amani['style_set'];
		}
		foreach ($amani['style_sets'][$amani_selected_style_set] as $key => $value) {
			$amani['db_options'][$key] = $value;
		}
	}

	// Getting option from array
	function amani_get_option($req_option, $default='') {
		global $amani;

		if(isset($amani['db_options'][$req_option])) {
			$option = $amani['db_options'][$req_option];
		} else {
			if(isset($default)) {
				$option = $default;
			} else {
				$option = '';
			}
		}
		return $option;
	}

	// Featured Locations

	$amani['featured_locations'] = array('top_featured_category');

	// Colors

	$amani['color_num'] = 2;

	$amani['color_schemes'] = array('Custom'=>'custom',

		'Vaporwave'
					=> '#ff71ce #01cdfe #29eaa1 #b967ff #ffe13c',

		'Space Overflow'
					=> '#f90068 #510080 #990075 #d5006c #200087',

		'Funky Soul'
					=> '#ff0e8b #00f2a2 #b01ae7 #fe4a0d #4ebecd',

		'School Boy'
					=> '#ee9c80 #a2c2e5 #6eb6b8 #ee8080 #f9b6b6',

		'Pool Party'
					=> '#fd9ab6 #11d7d8 #63c8c4 #a2c2e5 #ee9c80',

		'Lime Digital'
					=> '#fbc300 #5fabbe #f8be9f #efd345 #05ffa1',

		'Scotty Loved This One'
					=> '#51918b #f8be9f #414f5c #c7e2c7 #efd345',

		'Circa 1976'
					=> '#d8460b #f5c600 #c21703 #9b4923 #007291',
	);

	// Gradients

	$amani['gradients'] = array(
		'Solid Color'   => 'none',
		'Bottom'        => 'bottom',
		'Top'           => 'top',
		'Right'         => 'right',
		'Left'          => 'left',
		'Top Right'     => 'top right',
		'Top Left'      => 'top left',
		'Bottom Right'  => 'bottom right',
		'Bottom Left'   => 'bottom left',
	);

	// Coloring Types

	$amani['colorings'] = array(
		'White'  => 'default',
		'Dark'   => 'inversed',
	);

	// Header layouts

	$amani['header_layouts'] = array(
		'Menu on the Right Side' => 'one',
		'Centered Logo + Two Menus on Sides' => 'two',
		'Centered Menu + Search Button' => 'three',
		'Menu Below Logo' => 'four'
	);

	// Top Featured Layouts

	$amani['top_featured_layouts'] = array(
		'Trio'       => 'trio',
		'Slideshow'  => 'slideshow',
		'Rounded'    => 'rounded',
		'Squared'    => 'squared'
	);

	// Sidebar positions

	$amani['sidebar_positions'] = array(
		'Right'   => 'right',
		'Left'    => 'left',
		'Hidden'  => 'hidden'
	);

	// Blog Layout

	$amani['blog_layouts'] = array(
		'Grid'      => 'grid',
		'Masonry'   => 'masonry',
		'List'      => 'list',
		'Standard'  => 'standard'
	);

	// CSS color changes

	$amani['color_places'] = array(
		'background'  => 'background-color',
		'border'      => 'border-color',
		'hover'       => 'color'
	);

	// CSS color 1

	// Space before each element is needed if you don't want to apply styling to body directly
	// If no space it will work like this: body.b-inversed.blog_layout-masonry

	$amani['css_colors'][0]['hover'] = array(
		' .has-one-color',
		' .content article .post-content a:not( .wp-block-button__link ):hover',
		' .post-content i',
		' .empty-cat a',
		' .content .grid-item:nth-child(even) .post-title a:hover',
		' .widget_post_views_counter_list_widget li:nth-child(even) a:hover',
		' .bekento_thumbnail_recent_posts ul:not(.show_images) .marker',
		' .content .author-bio .person:nth-child(odd) h3.name a:hover',
		':not(.colored_categories) .content .post-tags a',
		':not(.colored_categories) .content .widget_tag_cloud a',
		':not(.colored_categories) .content .post-category a',
	);

	$amani['css_colors'][0]['background'] = array(
		' .has-one-background-color',
		' .post-pages > span',
		' .theme-menu ul > li > ul li:hover > a',
		' .theme-menu div > ul > li.current-menu-item > a',
		' .theme-menu div > ul > li.current-cat > a',
		' .theme-menu div > ul > li.current_page_item > a',
		' .responsive-nav div > ul li.active > a',
		' .post-content button',
		' .sidebar button',
		' .wp-block-button__link:not( .has-background )',
		' a.button',
		' .widget button',
		' .post-content button',
		' input[type=submit]',
		' .default-button',
		' .follow a',
		' .bekento-options button.button',
		' #submit',
		' .widget_tag_cloud .tagcloud a',
		' .widget_calendar caption',
		' .post-tags .tagcloud a',
		' .post-category a:nth-child(odd)',
		' nav.navigation .current',
		' .woocommerce #primary button',
		' article.sticky:before',
		' .bekento_thumbnail_recent_posts .show_images li:nth-child(odd) .post-thumbnail',
		' article.format-link .post-image-wrap:after',
		' article.format-status .post-image-wrap:after',
	);

	$amani['css_colors'][0]['border'] = array(
		' .infinite-scroll-spinner:before',
		' .blog-feed .grid-item:nth-child(even) section',
		'.blog_layout-masonry .main-sidebar section:nth-child(even)',
	);

	// CSS color 2

	$amani['css_colors'][1]['hover'] = array(
		' .has-two-color',
		' .content .grid-item:nth-child(odd) .post-title a:hover',
		' .content .author-bio .person:nth-child(even) h3.name a:hover',
		' .widget_post_views_counter_list_widget li:nth-child(odd) a:hover',
	);

	$amani['css_colors'][1]['background'] = array(
		' .has-two-background-color',
		' article.format-status .post-image-cover span i',
		' .post-category a:nth-child(even)',
		' .bekento_thumbnail_recent_posts .show_images li:nth-child(even) .post-thumbnail',
		' .widget_calendar tbody td:not(#today) a',
	);

	$amani['css_colors'][1]['border'] = array(
		' .infinite-scroll-spinner:after',
		' .blog-feed .grid-item:nth-child(odd) section',
		'.blog_layout-masonry .main-sidebar section:nth-child(odd)',
	);


	// Default Mac / Windows fonts

	$amani['default_fonts'] = array(
		'Segoe UI, San Francisco',
		'Arial, Helvetica',
		'Georgia',
		'Lucida Sans Unicode, Lucida Grande',
		'Palatino Linotype, Book Antiqua, Palatino',
		'Tahoma, Geneva',
		'Times New Roman, Times',
		'Trebuchet MS',
		'Verdana, Geneva'
	);

	// Font weight

	$amani['weight_list'] = array(
		'200' => 'Extra Light 200',
		'300' => 'Light 300',
		'400' => 'Regular 400',
		'500' => 'Medium 500',
		'600' => 'Semi-Bold 600',
		'700' => 'Bold 700',
		'900' => 'Black 900'
	);

	// Social networks list
	
	$amani['social'] = array(
		'envelope'       => '#D44638',
		'rss-square'     => '#f26522',
		'facebook'       => '#4267b2',
		'twitter-square' => '#1da1f2',
		'instagram'      => '#e1306c',
		'discord'        => '#7289DA',
		'flickr'         => '#FF0084',
		'vimeo'          => '#1ab7ea',
		'youtube'        => '#ff0000',
		'soundcloud'     => '#ff3300',
		'medium'         => '#000000',
		'etsy'           => '#F56400',
		'spotify'        => '#1ed760',
		'snapchat'       => '#fffc00',
		'500px'          => '#000000',
		'tumblr-square'  => '#36465a',
		'pinterest'      => '#bd081c',
		'github'         => '#000000',
		'gitlab'         => '#e14329',
		'steam'          => '#000000',
		'twitch'         => '#4b367c',
		'reddit'         => '#ff4500',
		'behance'        => '#0057ff',
		'dribbble'       => '#ea4c89',
		'xing'           => '#009090',
		'linkedin'       => '#0073b1',
		'yelp'           => '#d32323',
		'tripadvisor'    => '#00a680',
		'qq'             => '#000000',
		'weibo'          => '#df2029',
		'weixin'         => '#7bb32e',
		'telegram'       => '#0088cc',
	);

	// Setting content width

	if (!isset($content_width)) {
		$content_width = 700;
	}
	
	// Loading essential theme scripts

	function amani_load_scripts() {
		require_once(get_template_directory() . '/parts/customizer.php');
		require_once(get_template_directory() . '/parts/all.php');
		require_once(get_template_directory() . '/parts/tgm.php');
		require_once(get_template_directory() . '/parts/styles.php');
	}
	add_action('after_setup_theme', 'amani_load_scripts', 1);

	// You can reset all saved options quickly using this function: delete_option('amani_options');

?>