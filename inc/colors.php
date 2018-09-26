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
 * Insert custom colors
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