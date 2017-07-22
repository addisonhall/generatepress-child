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
 * Initialize ACF Google Maps.
 * @link https://www.advancedcustomfields.com/resources/acf-settings/
 */
// add_action('acf/init', 'gpc_acf_init');
function gpc_acf_init() {
  acf_update_setting('google_api_key', 'key_goes_here');
}

/**
 * ACF bi-directional relationships
 * @link: https://www.advancedcustomfields.com/resources/bidirectional-relationships/
 */
// add_filter('acf/update_value/name=custom_post_type', 'gpc_bidirectional_acf_update_value', 10, 3);
function gpc_bidirectional_acf_update_value( $value, $post_id, $field  ) {

  // vars
  $field_name = $field['name'];
  $global_name = 'is_updating_' . $field_name;


  // bail early if this filter was triggered from the update_field() function called within the loop below
  // - this prevents an inifinte loop
  if( !empty($GLOBALS[ $global_name ]) ) return $value;


  // set global variable to avoid inifite loop
  // - could also remove_filter() then add_filter() again, but this is simpler
  $GLOBALS[ $global_name ] = 1;


  // loop over selected posts and add this $post_id
  if( is_array($value) ) {

    foreach( $value as $post_id2 ) {

      // load existing related posts
      $value2 = get_field($field_name, $post_id2, false);


      // allow for selected posts to not contain a value
      if( empty($value2) ) {

        $value2 = array();

      }


      // bail early if the current $post_id is already found in selected post's $value2
      if( in_array($post_id, $value2) ) continue;


      // append the current $post_id to the selected post's 'related_posts' value
      $value2[] = $post_id;


      // update the selected post's value
      update_field($field_name, $value2, $post_id2);

    }

  }


  // find posts which have been removed
  $old_value = get_field($field_name, $post_id, false);

  if( is_array($old_value) ) {

    foreach( $old_value as $post_id2 ) {

      // bail early if this value has not been removed
      if( is_array($value) && in_array($post_id2, $value) ) continue;


      // load existing related posts
      $value2 = get_field($field_name, $post_id2, false);


      // bail early if no value
      if( empty($value2) ) continue;


      // find the position of $post_id within $value2 so we can remove it
      $pos = array_search($post_id, $value2);


      // remove
      unset( $value2[ $pos] );


      // update the un-selected post's value
      update_field($field_name, $value2, $post_id2);

    }

  }


  // reset global varibale to allow this filter to function as per normal
  $GLOBALS[ $global_name ] = 0;


  // return
    return $value;

}
