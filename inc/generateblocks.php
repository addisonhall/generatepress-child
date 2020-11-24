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
 * 
 * Refer to these files for help with settings:
 * wp-content/themes/generatepress/inc/css-output.php
 * wp-content/plugins/generateblocks/includes/defaults.php
 */
add_filter( 'generateblocks_defaults', function( $defaults ) {

    // get style settings from GeneratePress
    $gpc_theme_settings = wp_parse_args(
        get_option( 'generate_settings', array() ),
        generate_get_color_defaults(),
        generate_get_default_fonts()
    );

    $og_defaults = generate_get_default_fonts( false );

    /** Uncomment and view source to see values */
    /*
    echo '<!--';
    echo 'og_defaults: ';
    print_r( $og_defaults );
    echo 'gpc_theme_settings: ';
    print_r( $gpc_theme_settings );
    echo '-->';
    */

    // should be 'inherit' by default
    $buttons_family = $og_defaults['font_buttons'];
    if ( isset( $gpc_theme_settings['font_buttons'] ) && !empty( $gpc_theme_settings['font_buttons'] ) ) {
        $buttons_family = $gpc_theme_settings['font_buttons'];
    }

    // should be empty by default
    $buttons_font_size = $og_defaults['buttons_font_size'];
    if ( isset( $gpc_theme_settings['buttons_font_size'] ) && !empty( $gpc_theme_settings['buttons_font_size'] ) ) {
        $buttons_font_size = absint( $gpc_theme_settings['buttons_font_size'] );
    }

    // BUTTONS
    $defaults['button']['backgroundColor'] = $gpc_theme_settings['form_button_background_color'];
    $defaults['button']['backgroundColorHover'] = $gpc_theme_settings['form_button_background_color_hover'];
    $defaults['button']['textColor'] = $gpc_theme_settings['form_button_text_color'];
    $defaults['button']['textColorHover'] = $gpc_theme_settings['form_button_text_color_hover'];
    $defaults['button']['paddingTop'] = '10';
    $defaults['button']['paddingRight'] = '20';
    $defaults['button']['paddingBottom'] = '10';
    $defaults['button']['paddingLeft'] = '20';
    $defaults['button']['fontFamily'] = $buttons_family;
    $defaults['button']['fontSize'] = $buttons_font_size;
    $defaults['button']['fontSizeUnit'] = 'px';
    $defaults['button']['fontWeight'] = esc_attr( $gpc_theme_settings['buttons_font_weight'] );

    return $defaults;
} );