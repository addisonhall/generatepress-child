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
    wp_enqueue_style( 'gpc-base', get_stylesheet_directory_uri() . '/css/base.css', false, GPC_VERSION, 'all');
    wp_enqueue_style( 'gpc-gutenberg', get_stylesheet_directory_uri() . '/css/gutenberg.css', false, GPC_VERSION, 'all');
    wp_enqueue_script( 'gpc-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', '', GPC_VERSION, true );
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

    // Load editor scripts for all post types
    wp_enqueue_script( 'gpc-editor', get_stylesheet_directory_uri() . '/admin/js/editor.js', array( 'wp-blocks', 'wp-dom' ), GPC_VERSION, true );
    
    // Load editor scripts for specific post types
    global $current_screen;
    if ( $current_screen->post_type == 'post' ) {
        wp_enqueue_script( 'gpc-editor-post', get_stylesheet_directory_uri() . '/admin/js/editor-post.js', array( 'wp-blocks', 'wp-dom' ), GPC_VERSION, true );
    }
}

/**
 * Add custom editor styles.
 */
add_theme_support( 'wp-block-styles' );
add_theme_support( 'editor-styles' );
add_editor_style( 'css/gutenberg.css' );

/**
 * Add body classes.
 */
add_filter( 'body_class', 'gpc_body_classes' );
function gpc_body_classes( $classes ) {
    $classes[] = 'gpc';
    return $classes;
}

/**
 * Add .has-js class to html element.
 */
add_action( 'generate_before_header','gpc_add_js_class' );  
function gpc_add_js_class() { ?> 
    <script>
        const htmlEl = document.documentElement;
        htmlEl.classList.add('has-js');
    </script>
<?php }

/**
 * Enable shortcodes in widgets.
 */
add_filter( 'widget_text' , 'do_shortcode' );

/**
 * Enable excerpts in pages.
 */
add_post_type_support( 'page', 'excerpt' );

/**
 * Include other functions as needed from the `inc` folder.
 */
require get_stylesheet_directory() . '/inc/helper-functions.php';
require get_stylesheet_directory() . '/inc/users.php';
require get_stylesheet_directory() . '/inc/generatepress.php';
require get_stylesheet_directory() . '/inc/colors.php'; // should be before styles.php to access colors
require get_stylesheet_directory() . '/inc/styles.php';
require get_stylesheet_directory() . '/inc/fonts.php';
require get_stylesheet_directory() . '/inc/generateblocks.php';
require get_stylesheet_directory() . '/inc/dashboard-widgets.php';
require get_stylesheet_directory() . '/inc/widgets.php';
require get_stylesheet_directory() . '/inc/sub-menu-widget.php';
require get_stylesheet_directory() . '/inc/breadcrumbs.php';
require get_stylesheet_directory() . '/inc/optimizations.php';
require get_stylesheet_directory() . '/inc/image-sizes.php';
// require get_stylesheet_directory() . '/inc/wp-show-posts.php';
// require get_stylesheet_directory() . '/inc/cpt-output-custom.php';
// require get_stylesheet_directory() . '/inc/advanced-custom-fields.php';
// require get_stylesheet_directory() . '/inc/woocommerce.php';
// require get_stylesheet_directory() . '/inc/shortcodes.php';
