<?php
/**
 * Custom post type output.
 *
 * These filters and actions tell WordPress to do things
 * like use partials, use custom sort orders, or even add 
 * custom menu classes for specified post types and taxonomies.
 * Must be included in functions.php
 *
 * THE FOLLOWING ARE ALL ONLY EXAMPLES. DUPLICATE AND MODIFY AS NEEDED.
 *
 * @package GenerateChild
 * @see /inc/cpt-output-reset.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Sample custom post type, use partial for output instead of default.
 */
add_filter( 'the_content', 'gpc_cpt_content' );
function gpc_cpt_content( $content ) {
  if ( is_singular( 'custom_post_type_name' ) && is_main_query() && in_the_loop() ) {
    include get_stylesheet_directory() . '/partials/content-cpt-sample-single.php';
  } elseif ( is_post_type_archive( 'custom_post_type_name' ) && is_main_query() ) {
    include get_stylesheet_directory() . '/partials/content-cpt-sample-archive.php';
  } else {
    return $content;
  }
}

/**
 * Sample custom taxonomy, use partial for output instead of default.
 */
add_filter( 'the_content', 'gpc_custom_tax_archive' );
function gpc_custom_tax_archive( $content ) {
  if ( is_tax( 'custom_tax_1' ) || is_tax( 'custom_tax_2' ) ) {
    include get_stylesheet_directory() . '/partials/content-cpt-sample-archive.php';
  } else {
    return $content;
  }
}

/**
 * Custom GeneratePress sidebar layout.
 * @link https://generatepress.com/knowledgebase/choosing-sidebar-layouts/
 */
add_filter( 'generate_sidebar_layout', 'gpc_cpt_layout' );
function gpc_cpt_layout( $layout ) {
   if ( is_singular( 'custom_post_type_name' ) && is_main_query() ) {
      return 'no-sidebar';
  } else {
    return $layout;
  }
}

/**
 * Sample custom sort order for specified post types.
 */
add_action('pre_get_posts', 'gpc_cpt_pre_get_posts');
function gpc_cpt_pre_get_posts( $query ) {
  // do not modify queries in the admin
  if( is_admin() ) {
    return $query;
  }
  // only modify queries for specified post type
  if( isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] === 'custom_post_type_name' ) {
    $query->set( 'orderby', 'meta_value' );	
    $query->set( 'meta_key', 'some_custom_field' );	 
    $query->set( 'order', 'ASC' ); 
  }
  // return
  return $query;
}

/**
 * Custom menu classes.
 */
add_filter( 'nav_menu_css_class', 'gpc_custom_nav_classes', 10, 2 );
function gpc_custom_nav_classes( $classes, $item ) {
  if ( ( is_post_type_archive( 'custom_post_type' ) || is_singular( 'custom_post_type' ) ) && $item->title == 'Custom Title' ) {
    $classes = array_diff( $classes, array( 'current_page_parent' ) );
    $classes[] = 'current_page_parent';
  }
  return $classes;
}