<?php
/**
 * Theme shortcodes.
 *
 * Create custom shortcodes to use in theme.
 * Must be included in functions.php
 *
 * THE FOLLOWING ARE ALL ONLY EXAMPLES. DUPLICATE AND MODIFY AS NEEDED.
 *
 * @package GenerateChild
 * @link https://codex.wordpress.org/Shortcode_API
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Submenu shortcode.
 * [gpc_submenu menu='primary' parent_id=12 menu_class='class-names']
 */
function gpc_submenu_func( $atts ) {
    $atts = shortcode_atts( array(
        'menu' => 'primary',
        'parent_id' => null,
        'menu_class' => 'gpc-sub-menu',
    ), $atts );
    $menu = $atts['menu'];
    $parent_id = $atts['parent_id'];
    $menu_class = $atts['menu_class'];
    $sub_menu_output = wp_nav_menu( array(
		'theme_location' => $menu,
		'sub_menu' => true,
        'parent_id' => $parent_id,
		'menu_class' => $menu_class,
		'echo' => false
	) );
	return $sub_menu_output;
}
add_shortcode( 'gpc_submenu', 'gpc_submenu_func' );

/**
 * Menu to filter custom taxonomy.
 * [gpc_custom_taxonomy_filter]
 */
 function gpc_custom_taxonomy_filter_func() {
    $cur_tax = get_queried_object()->slug;
    $cur_tax_id = get_queried_object()->id;
    $args = array(
        'current_category' => $cur_tax_id,
        'title_li' => '',
        'taxonomy' => 'custom_taxonomy'
    );
    ob_start(); ?>
    <ul>
        <li><a href="<?php echo esc_url( home_url( '/' ) ) . 'slug'; ?>">All Categories</a></li>
        <?php wp_list_categories( $args ); ?>
    </ul>
    <?php
    return ob_get_clean();
}
add_shortcode( 'gpc_custom_taxonomy_filter', 'gpc_custom_taxonomy_filter_func' );

/**
 * Output custom post type.
 * [gpc_output_custom_post_type]
 */
 function gpc_output_custom_post_type_func() {
    ob_start();
    $args = array (
        'post_type' => 'custom_post_type',
        'order' => 'ASC',
        'orderby' => 'meta_value',
        'meta_key' => 'some_custom_field',
    );
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            include get_stylesheet_directory() . '/partials/content-cpt-sample-archive.php';
        endwhile;
        wp_reset_postdata();
        $output = ob_get_clean();
        return $output;
    endif;
}
add_shortcode( 'gpc_output_custom_post_type', 'gpc_output_custom_post_type_func' );

/**
 * Output sponsors.
 * EXAMPLE SHORTCODE FOR OUTPUTTING SPONSORS.
 * REQUIRES CUSTOM POST TYPE AND ADVANCED CUSTOM FIELDS.
 * @param string $layout "full" or "logos". Defaults to "full".
 * [site_sponsors layout=full]
 */
function gpc_output_foundation_sponsors_func( $atts ) {
    $atts = shortcode_atts( array(
        'layout' => 'full',
    ), $atts );
    $layout = $atts[ 'layout' ];
    ob_start();
    $args = array (
        'post_type' => 'sponsor',
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => 50,
    );
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) {
        echo '<!-- Layout: ' . $layout . ' -->';
        if ( $layout == 'full' ) {
            while ( $query->have_posts() ) : $query->the_post();
                include get_stylesheet_directory() . '/template-parts/shortcodes/sponsors/sponsors.php';
            endwhile;
        } elseif ( $layout == 'logos' ) {
            echo '<ul class="sponsor-logo-list">';
            while ( $query->have_posts() ) : $query->the_post();
                include get_stylesheet_directory() . '/template-parts/shortcodes/sponsors/sponsor-logos.php';
            endwhile;
            echo '</ul>';
        }
        wp_enqueue_style( 'gpc-sponsors' );
    }
    wp_reset_postdata();
    $output = ob_get_clean();
    return $output;
}
add_shortcode( 'site_sponsors', 'gpc_output_foundation_sponsors_func' );

/**
 * Shortcode assets
 */
add_action( 'wp_enqueue_scripts', 'gpc_shortcode_assets' );
function gpc_shortcode_assets() {
	wp_register_style( 'gpc-sponsors', get_stylesheet_directory_uri() . '/template-parts/shortcodes/sponsors/sponsors.css', array(), '1.0.0' );
}