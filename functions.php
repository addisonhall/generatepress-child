<?php
/**
 * GeneratePress Child Theme functions and definitions
 *
 * All functions are prefixed with gpc_
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'GPC_VERSION', '1.0.0' );

/**
 * Hide admin bar.
 */
show_admin_bar( false );

/**
 * Enqueue scripts and styles.
 */
add_action( 'wp_enqueue_scripts', 'gpc_scripts' );
function gpc_scripts() {
    wp_enqueue_style( 'gpc-settings', get_stylesheet_directory_uri() . '/css/settings.css', false, GPC_VERSION, 'all');
    wp_enqueue_script( 'gpc-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', [ 'jquery' ], GPC_VERSION, true );
    
    // add 'has-js' class to html element
    wp_register_script( 'gpc-html-js', '', );
    wp_enqueue_script( 'gpc-html-js' );
    wp_add_inline_script( 'gpc-html-js', "document.documentElement.classList.add('has-js');" );
}

/**
 * Enqueue admin scripts and styles.
 */
add_action( 'admin_enqueue_scripts', 'gpc_admin_scripts' );
function gpc_admin_scripts() {
    wp_enqueue_style( 'gpc-editor', get_stylesheet_directory_uri() . '/admin/css/editor.css', false, GPC_VERSION, 'all');
}

/**
 * Enqueue Gutenberg scripts and styles.
 * @link https://www.billerickson.net/how-to-remove-core-wordpress-blocks/
 */
add_action( 'enqueue_block_editor_assets', 'gpc_gutenberg_scripts' );
function gpc_gutenberg_scripts() {

    global $current_screen;
    
    wp_enqueue_style( 'gpc-settings', get_stylesheet_directory_uri() . '/css/settings.css', false, GPC_VERSION, 'all');
    wp_enqueue_style( 'gpc-editor', get_stylesheet_directory_uri() . '/admin/css/editor.css', false, GPC_VERSION, 'all');

    // Load editor scripts for all post types
    wp_enqueue_script( 'gpc-editor', get_stylesheet_directory_uri() . '/admin/js/editor.js', array( 'wp-blocks', 'wp-dom' ), GPC_VERSION, true );
    
    // Load editor scripts for specific post types
    if ( $current_screen->post_type == 'post' ) {
        wp_enqueue_script( 'gpc-editor-post', get_stylesheet_directory_uri() . '/admin/js/editor-post.js', array( 'wp-blocks', 'wp-dom' ), GPC_VERSION, true );
    }
}

/**
 * Initialize ACF Gutenberg blocks.
 * @link https://www.advancedcustomfields.com/resources/acf_register_block_type/
 */
// register_block_type( __DIR__ . '/blocks/team/block.json' );

/**
 * Remove all default block patterns from Gutenberg editor
 * @see https://github.com/WordPress/gutenberg/issues/26667
 */
add_action( 'init', function() {
	remove_theme_support( 'core-block-patterns' );
}, 9 );

/**
 * Add custom editor styles.
 */
add_theme_support( 'wp-block-styles' );
add_theme_support( 'editor-styles' );

/**
 * Allow SVGs
 * TODO: need to sanitize? better to use plugin?
 */
add_filter( 'upload_mimes', 'gpc_add_file_types_to_uploads' );
function gpc_add_file_types_to_uploads( $file_types ) {
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge( $file_types, $new_filetypes );
    return $file_types;
}

/**
 * Add body classes.
 */
add_filter( 'body_class', 'gpc_body_classes' );
function gpc_body_classes( $classes ) {
    $classes[] = 'gpc';
    return $classes;
}

/**
 * Enable shortcodes in widgets.
 */
// add_filter( 'widget_text' , 'do_shortcode' );

/**
 * Enable excerpts in pages.
 */
add_post_type_support( 'page', 'excerpt' );

/**
 * Customize CPT title fields.
 */
//add_filter( 'enter_title_here', 'gpc_change_title_text' );
function gpc_change_title_text( $title ){
    $screen = get_current_screen();
    if ( 'staff' == $screen->post_type ) {
        $title = 'Enter staff name here';
    }
    return $title;
}

/**
 * Ability to remove extra archive pages, if we want to.
 */
// add_action( 'template_redirect', 'gpc_remove_wp_archives' );
 function gpc_remove_wp_archives(){
  //If we are on category or tag or date or author archive
  if( is_category() || is_tag() || is_date() || is_author() ) {
    global $wp_query;
    $wp_query->set_404(); //set to 404 not found page
  }
}

/**
 * Redirect author pages
 */
add_action( 'template_redirect', 'gpc_redirect_author_page' );
function gpc_redirect_author_page() {
    $is_author_set = get_query_var( 'author', '' );
	if ( $is_author_set != '' && !is_admin() ) {
		wp_redirect( home_url(), 301 );
		exit;
	}
}

/**
 * Disable rest api unless authenticated
 */
add_filter( 'rest_authentication_errors', 'gpc_disable_rest_api' );
function gpc_disable_rest_api( $result ) {
    if ( ! empty( $result ) ) {
      return $result;
    }
    if ( ! is_user_logged_in() ) {
      return new WP_Error( 'rest_not_logged_in', 'You are not currently logged in.', array( 'status' => 401 ) );
    }
    if ( ! current_user_can( 'edit_posts' ) ) {
      return new WP_Error( 'rest_not_admin', 'You do not have the right privileges for this.', array( 'status' => 401 ) );
    }
    return $result;
};

/**
 * Disable xmlrpc
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Hide Wordpress version from source view
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Include other functions as needed from the `inc` folder.
 */
require get_stylesheet_directory() . '/inc/helper-functions.php';
require get_stylesheet_directory() . '/inc/security.php';
require get_stylesheet_directory() . '/inc/users.php';
require get_stylesheet_directory() . '/inc/generatepress.php';
// require get_stylesheet_directory() . '/inc/colors.php'; // should be before styles.php to access colors
// require get_stylesheet_directory() . '/inc/styles.php';
require get_stylesheet_directory() . '/inc/block-styles.php';
// require get_stylesheet_directory() . '/inc/fonts.php';
// require get_stylesheet_directory() . '/inc/generateblocks.php';
require get_stylesheet_directory() . '/inc/login.php';
// require get_stylesheet_directory() . '/inc/dashboard-widgets.php';
// require get_stylesheet_directory() . '/inc/widgets.php';
// require get_stylesheet_directory() . '/inc/sub-menu.php';
// require get_stylesheet_directory() . '/inc/sub-menu-widget.php';
// require get_stylesheet_directory() . '/inc/breadcrumbs.php';
require get_stylesheet_directory() . '/inc/optimizations.php';
require get_stylesheet_directory() . '/inc/image-sizes.php';
// require get_stylesheet_directory() . '/inc/wp-show-posts.php';
// require get_stylesheet_directory() . '/inc/cpt-output-custom.php';
// require get_stylesheet_directory() . '/inc/advanced-custom-fields.php';
// require get_stylesheet_directory() . '/inc/woocommerce.php';
require get_stylesheet_directory() . '/inc/shortcodes.php';
