<?php
/**
 * Modify GenerateBlocks output.
 *
 * Must be included in functions.php
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Set defaults for GenerateBlocks output
 * @link https://generatepress.com/forums/search/generateblocks+default/
 */
add_filter( 'generateblocks_defaults', function( $defaults ) {

    // get style settings from GeneratePress
    $gpc_theme_settings = wp_parse_args(
        get_option( 'generate_settings', array() ),
        generate_get_color_defaults()
    );

    // BUTTONS
    $defaults['button']['backgroundColor'] = $gpc_theme_settings['form_button_background_color'];
    $defaults['button']['backgroundColorHover'] = $gpc_theme_settings['form_button_background_color_hover'];
    $defaults['button']['textColor'] = $gpc_theme_settings['form_button_text_color'];
    $defaults['button']['textColorHover'] = $gpc_theme_settings['form_button_text_color_hover'];
    $defaults['button']['paddingTop'] = '10';
    $defaults['button']['paddingRight'] = '20';
    $defaults['button']['paddingBottom'] = '10';
    $defaults['button']['paddingLeft'] = '20';
    $defaults['button']['fontFamily'] = generate_get_font_family_css( 'font_buttons', 'generate_settings', generate_get_default_fonts() );
    $defaults['button']['fontSize'] = absint( $gpc_theme_settings['body_font_size'] );
    $defaults['button']['fontSizeUnit'] = 'px';
    $defaults['button']['fontWeight'] = esc_attr( $gpc_theme_settings['buttons_font_weight'] );

    return $defaults;
} );