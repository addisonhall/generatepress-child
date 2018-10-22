<?php
/**
 * Font functions for GeneratePress.
 *
 * Must be included in functions.php
 *
 * @package GenerateChild
 * @link https://docs.generatepress.com/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Show all the Google fonts.
 * @link https://docs.generatepress.com/article/customizing-the-google-font-list/
 */
add_filter( 'generate_number_of_fonts', 'gp_adjust_google_fonts_list' );
function gp_adjust_google_fonts_list() {
  return all; // set to 'all' or a number
}

/**
 * Remove Google fonts CSS reference in markup.
 * @link https://docs.generatepress.com/article/remove-google-fonts/
 */
// add_action( 'wp_enqueue_scripts', 'gpc_remove_google_fonts', 10 );
// function gpc_remove_google_fonts() {
//   wp_dequeue_style( 'generate-fonts' );
// }

/**
 * Add custom fonts to font list.
 * @link https://docs.generatepress.com/article/customizing-the-google-font-list/
 */
// add_filter( 'generate_typography_customize_list', 'gpc_add_custom_fonts' );
// function gpc_add_custom_fonts( $fonts ) {
// 	$fonts[ 'benton-sans' ] = array( 
// 		'name' => 'benton-sans',
// 		'variants' => array( '300', '300i', '400', '400i', '700', '700i' ),
// 		'category' => 'sans-serif'
// 	);
// 	$fonts[ 'benton-modern' ] = array( 
// 		'name' => 'benton-modern',
// 		'variants' => array( '400', '400i', '700', '700i' ),
// 		'category' => 'serif'
// 	);
// 	return $fonts;
// }