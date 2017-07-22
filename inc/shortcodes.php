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
