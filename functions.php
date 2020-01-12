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
    wp_enqueue_script( 'gpc-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), GPC_VERSION, true );
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
 * Add .has-js class to html element.
 */
add_action( 'generate_before_header','gpc_add_js_class' );  
function gpc_add_js_class() { ?> 
    <script>
        jQuery('html').addClass('has-js');
    </script>
<?php }

/**
 * Responsive embedded video.
 */
add_filter( 'embed_oembed_html', 'gpc_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'gpc_embed_html' ); // Jetpack
function gpc_embed_html( $html ) {
    return '<div class="video-container">' . $html . '</div>';
}

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
require get_stylesheet_directory() . '/inc/users.php';
require get_stylesheet_directory() . '/inc/generatepress.php';
require get_stylesheet_directory() . '/inc/styles.php';
require get_stylesheet_directory() . '/inc/colors.php';
require get_stylesheet_directory() . '/inc/fonts.php';
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
