<?php
/**
 * Image slider template
 * Uses Swiper JS
 *
 * @package GenerateChild
 * @see /inc/advanced-custom-fields.php
 * @link https://swiperjs.com/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$slider_category = get_field( 'slider_category' );

global $post;
$slider_args = array(
    'post_type' => 'image_slider',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'tax_query' => array(
        array(
            'taxonomy' => 'image_slider_category',
            'field' => 'term_id',
            'terms' => $slider_category
        )
    )
);
$slider_query = new WP_Query( $slider_args );
if ( $slider_query->have_posts() ) {
    echo '<div class="gpc-image-slider-wrapper swiper" data-slider-category="' . implode( ',', $slider_category ) . '">';     
    echo '<div class="swiper-wrapper">';
    while ( $slider_query->have_posts() ) : $slider_query->the_post();
        do_action( 'gpc_image_slider_post_loop' ); // Hook name for content template
    endwhile;
    echo '</div>';
    echo '<div class="swiper-pagination"></div>';
    echo '<div class="swiper-button-prev"></div>';
    echo '<div class="swiper-button-next"></div>';
    echo '</div>';
    wp_reset_postdata();
}