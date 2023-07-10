<?php
/**
 * Advanced Custom Fields related stuff.
 *
 * Must be included in functions.php
 *
 * @package GenerateChild
 * @link https://www.advancedcustomfields.com/resources/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Initialize ACF Options Page.
 * @link https://www.advancedcustomfields.com/resources/options-page/
 */
if( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page( array(
		'page_title' => 'Theme General Settings',
		'menu_title' => 'Theme Settings',
		'menu_slug' => 'theme-general-settings',
		'capability' => 'edit_posts',
		'redirect' => false
	));
}

/**
 * Initialize ACF Google Maps.
 * @link https://www.advancedcustomfields.com/resources/acf-settings/
 */
// add_action('acf/init', 'gpc_acf_init');
function gpc_acf_init() {
  acf_update_setting( 'google_api_key', 'key_goes_here' );
}