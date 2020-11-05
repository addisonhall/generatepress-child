<?php
/**
 * Include specific colors in WordPress customizer.
 *
 * Must be included in functions.php
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ADD YOUR THEME COLORS HERE!
 * Array of theme colors will be added to WordPress
 */
$gpc_theme_colors = array(
    array(
		'name'  => __( 'White', 'generatepress-child' ),
		'slug'  => 'white',
		'color'	=> '#ffffff',
	),
	array(
		'name'  => __( 'Light gray', 'generatepress-child' ),
		'slug'  => 'light-gray',
		'color'	=> '#eeeeee',
	),
	array(
		'name'  => __( 'Dark gray', 'generatepress-child' ),
		'slug'  => 'dark-gray',
		'color'	=> '#666666',
	),
	array(
		'name'  => __( 'Black', 'generatepress-child' ),
		'slug'  => 'black',
		'color' => '#000000',
    ),
);

/**
 * Insert custom colors for the Customizer
 * @link https://docs.generatepress.com/article/generate_default_color_palettes/
 */
add_filter( 'generate_default_color_palettes', 'gpc_custom_color_palettes' );
function gpc_custom_color_palettes( $palettes ) {
    global $gpc_theme_colors;
    $palettes = array();
    for( $i = 0; $i < count( $gpc_theme_colors ); $i++ ) {
        $palettes[] = $gpc_theme_colors[$i]['color'];
    }
	return $palettes;
}

/**
 * Custom Gutenberg colors
 * See "Registering your colors" in this post:
 * @link https://www.billerickson.net/wordpress-color-palette-button-styling-gutenberg/
 */
add_theme_support( 'editor-color-palette', $gpc_theme_colors );
