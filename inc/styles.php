<?php
/**
 * Additional inline styles.
 *
 * These additional styles pull styling
 * info from customizations in GeneratePress.
 * It requires the Colors portion of the
 * premium add-on.
 *
 * @package GenerateChild
 * @link https://generatepress.com/downloads/generate-colors/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'gpc_base_inline_css_func' ) ) :
    
    function gpc_base_inline_css_func() {
        
        // Get our settings
        $gpc_settings = wp_parse_args( 
            get_option( 'generate_settings', array() ),
            generate_get_color_defaults()
        );
        
        // Initiate our CSS class
        $gpc_css = new GeneratePress_CSS;
        
        // Grab our theme colors from inc/colors.php
        global $gpc_theme_colors;
        
        // Add theme color custom properties
        $gpc_css->set_selector( ':root' );
        for( $i = 0; $i < count( $gpc_theme_colors ); $i++ ) {
            $gpc_css->add_property( '--' . esc_attr( $gpc_theme_colors[$i]['slug'] ), esc_attr( $gpc_theme_colors[$i]['color'] ) );
        }
        
        // Add standard WP classes based on our theme colors
        for( $i = 0; $i < count( $gpc_theme_colors ); $i++ ) {
            $color_slug = esc_attr( $gpc_theme_colors[$i]['slug'] );
            $color_hex = esc_attr( $gpc_theme_colors[$i]['color'] );
            $gpc_css->set_selector( '.has-' . $color_slug . '-color, body .editor-styles-wrapper .has-' . $color_slug . '-color, .wp-block-button__link.has-text-color.has-' . $color_slug . '-color' );
            $gpc_css->add_property( 'color', $color_hex );
            $gpc_css->set_selector( '.has-' . $color_slug . '-background-color, body .editor-styles-wrapper .has-' . $color_slug . '-background-color' );
            $gpc_css->add_property( 'background-color', $color_hex );
        }
        
        // Form button-outline
        $gpc_css->set_selector( '.button.button-outline, .button.button-outline:visited, .woocommerce .button.button-outline, .woocommerce .button.button-outline:visited' );
        $gpc_css->add_property( 'border-color', esc_attr( $gpc_settings[ 'form_button_background_color' ] ) );
        $gpc_css->add_property( 'color', esc_attr( $gpc_settings[ 'form_button_background_color' ] ) );
        
        // Form button-outline hover
        $gpc_css->set_selector( '.button.button-outline:hover, .button.button-outline:focus, .woocommerce .button.button-outline:hover, .woocommerce .button.button-outline:focus' );
        $gpc_css->add_property( 'border-color', esc_attr( $gpc_settings[ 'form_button_background_color_hover' ] ) );
        $gpc_css->add_property( 'color', esc_attr( $gpc_settings[ 'form_button_background_color_hover' ] ) );

        // Allow us to hook CSS into our output
        // do_action( 'gpc_base_inline_css', $gpc_css );
        
        // Return our dynamic CSS
        return $gpc_css->css_output();
        
    }
    
endif;

add_action( 'wp_enqueue_scripts', 'gpc_add_inline_styles' );
function gpc_add_inline_styles() {
    $gpc_css = gpc_base_inline_css_func();
    // this must reference an already queued stylesheet
    wp_add_inline_style( 'gpc-base', $gpc_css );
}

add_action( 'admin_enqueue_scripts', 'gpc_add_inline_admin_styles' );
function gpc_add_inline_admin_styles() {
    $gpc_admin_css = gpc_base_inline_css_func();
    // this must reference an already queued stylesheet
    wp_add_inline_style( 'gpc-editor', $gpc_admin_css );
}