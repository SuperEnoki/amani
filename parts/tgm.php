<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package		TGM-Plugin-Activation
 * @subpackage Example
 * @version		2.6.1
 * @author		 Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright	Copyright (c) 2011, Thomas Griffin
 * @license		http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link			 https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */

require_once get_template_directory() . '/parts/class-tgm-plugin-activation.php';
add_action('tgmpa_register', 'amani_theme_register_required_plugins');
function amani_theme_register_required_plugins() {

	global $amani;

	$plugins = array(

		array(
			'name'			=> esc_html__('Bekento Tools 4', 'amani'),
			'slug'			=> 'bekento-tools-4',
			'source'			=> esc_url('https://bekento.space/plugins/bekento-tools-4.zip'),
		),

		array(
			'name'			=> esc_html__('Post Views Counter', 'amani'),
			'slug'			=> 'post-views-counter',
			'required'		=> false,
		),

		array(
			'name'			=> esc_html__('Instagram Widget', 'amani'),
			'slug'			=> 'wp-instagram-widget',
			'required'		=> false,
		),

		array(
			'name'			=> esc_html__('Twitter Widget', 'amani'),
			'slug'			=> 'simple-twitter-tweets',
			'required'		=> false,
		),

		array(
			'name'			=> esc_html__('Contact Form 7', 'amani'),
			'slug'			=> 'contact-form-7',
			'required'		=> false,
		)

	);

	$config = array(
		'id'            => 'amani', // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path'  => '', // Default absolute path to bundled plugins.
		'menu'          => 'amani-install-plugins', // Menu slug.
		'parent_slug'   => 'themes.php', // Parent menu slug.
		'capability'    => 'edit_theme_options', // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'   => true, // Show admin notices or not.
		'dismissable'   => true, // If false, a user cannot dismiss the nag message.
		'dismiss_msg'   => '', // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic'  => false, // Automatically activate plugins after installation or not.
		'message'       => '', // Message to output right before the plugins table.
	);

	tgmpa($plugins, $config);
}
