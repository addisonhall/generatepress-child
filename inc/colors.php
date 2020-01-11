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
 * Insert custom colors for the Customizer
 * @link https://docs.generatepress.com/article/generate_default_color_palettes/
 */
add_filter( 'generate_default_color_palettes', 'gpc_custom_color_palettes' );
function gpc_custom_color_palettes( $palettes ) {
	$palettes = array(
		'#000000',
		'#FFFFFF',
		'#efecea',
		'#bed7d3',
		'#4a7d6d',
		'#d8751b',
		'#fed850',
	);
	return $palettes;
}

/**
 * Custom Gutenberg colors
 */
add_theme_support( 'editor-color-palette', array(
    array(
		'name'  => __( 'White', 'generatepress-child' ),
		'slug'  => 'white',
		'color'	=> '#ffffff',
	),
	array(
		'name'  => __( 'Light gray', 'generatepress-child' ),
		'slug'  => 'light-gray',
		'color'	=> '#E3E6EB',
	),
	array(
		'name'  => __( 'Black', 'generatepress-child' ),
		'slug'  => 'black',
		'color' => '#000000',
       ),
) );