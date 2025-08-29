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
 * Output Relevanssi search results title
 * @see https://www.relevanssi.com/user-manual/functions/relevanssi_the_title/
 * 
 * [gpc_relevanssi_search_title]
 */
add_shortcode( 'gpc_relevanssi_search_title', 'gpc_relevanssi_search_title_func' );
function gpc_relevanssi_search_title_func() {

    // get post type
    $post_id = get_the_ID();
    $post_type = get_post_type( $post_id );
    $post_type_obj = get_post_type_object( $post_type );
    $post_type_singular_label = $post_type_obj->labels->singular_name;

    // set default link target
    $target = '_self';

    // get default link
    $post_link = get_the_permalink();

    // if result is attachment, link directly to file in new tab
    if ( $post_type === 'attachment' )  {
        $target = '_blank';
        $post_link = wp_get_attachment_url( $post_id );
    }

    return '<div class="gbp-section__tagline">' . $post_type_singular_label . ':</div><a href="' . $post_link . '" target="' . $target . '">' . relevanssi_the_title( $echo = false ) . '</a>';
}

/**
 * Output Wordpress excerpt
 * [gpc_search_excerpt]
 */
add_shortcode( 'gpc_search_excerpt', 'gpc_search_excerpt_func' );
function gpc_search_excerpt_func() {

    // get post type
    $post_id = get_the_ID();
    $post_type = get_post_type( $post_id );

    $excerpt = get_the_excerpt();

    switch ( $post_type ) {
        case 'wms_document':
            $excerpt = get_field( 'document_description', $post_id );
            break;
        default:
            $excerpt = get_the_excerpt();
            break;
    }

    return $excerpt;
}