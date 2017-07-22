<?php
/**
 * Custom image sizes.
 *
 * THE FOLLOWING ARE ALL ONLY EXAMPLES. DUPLICATE AND MODIFY AS NEEDED.
 *
 * @package GenerateChild
 */

/**
 * Additional image sizes
 */
add_image_size( 'square-small', 480, 480, array( 'center', 'center' ) );
add_image_size( 'square-medium', 640, 640, array( 'center', 'center' ) );
add_filter( 'image_size_names_choose', 'gpc_add_image_sizes' );
// Add sizes to media admin
function gpc_add_image_sizes( $sizes ) {
  $addsizes = array(
    "square-small" => __( "Square Small"),
    "square-medium" => __( "Square Medium"),
  );
  $newsizes = array_merge( $sizes, $addsizes );
  return $newsizes;
}
