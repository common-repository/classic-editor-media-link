<?php
/*
	Plugin Name:	Classic Editor Media Link
	Plugin URI:		https://profiles.wordpress.org/rockstarlab/
	Description:	Plugin adds Media Library Button to the default TinyMCE (Classic Editor) Insert Link dialog
	Version:			1.0.0
	Author:				Dmytro Kudleichuk, RockStarLab
	Author URI:		https://profiles.wordpress.org/rockstarlab/profile/
	Text Domain:	classic-editor-media-link
	Domain Path:	/language
	License:			GPL v2 or later
	License URI:	https://www.gnu.org/licenses/gpl-2.0.html
*/

// If this file is called directly, abort.
if ( ! defined('WPINC')) {
	die();
}

// define plugin constants
define( 'RSL_CEML_FILE', __FILE__);
define( 'RSL_CEML_PATH', trailingslashit( plugin_dir_path( RSL_CEML_FILE )));
define( 'RSL_CEML_URL', plugins_url( '/', RSL_CEML_FILE));

// load plugin translations
add_action( 'init', function() {
	load_plugin_textdomain( 'classic-editor-media-link', false, dirname( plugin_basename( RSL_CEML_FILE ) ) . '/language' );
});

// Enqueue JS scripts and styles on the backend part
add_action( 'admin_enqueue_scripts', function() {

	$asset_file = RSL_CEML_PATH . 'build/index.asset.php';

	if( ! file_exists( $asset_file ) ) {
		return;
	}

	$asset = include $asset_file;

	wp_register_script(
		'rsl-classic-editor-media-link',
		plugins_url( 'build/index.js', RSL_CEML_FILE ),
		$asset['dependencies'],
		$asset['version'],
		[
			'in_footer' => true,
		]
	);

	wp_enqueue_script( 'rsl-classic-editor-media-link');
	wp_set_script_translations( 'rsl-classic-editor-media-link', 'classic-editor-media-link', plugin_dir_path( RSL_CEML_FILE) . 'language' );

	wp_enqueue_style(
		'rsl-classic-editor-media-link',
		plugins_url( 'build/index.css', RSL_CEML_FILE ),
		array_filter(
			$asset['dependencies'],
			function ( $style ) {
				return wp_style_is( $style, 'registered' );
			}
		),
		$asset['version'],
	);

});
