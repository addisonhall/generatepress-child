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
add_image_size( 'portrait-square', 480, 480, array( 'center', 'top' ) );
add_filter( 'image_size_names_choose', 'gpc_add_image_sizes' );
// Add sizes to media admin
function gpc_add_image_sizes( $sizes ) {
  $addsizes = array(
    "portrait-square" => __( "Portrait Square")
  );
  $newsizes = array_merge( $sizes, $addsizes );
  return $newsizes;
}
