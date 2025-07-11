<?php
/**
 * Additional inline styles.
 * BEST TO USE BUILT-IN STYLING WITH GP 3.1 AND GENERATEBLOCKS
 *
 * These additional styles pull styling
 * info from customizations in GeneratePress.
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Generate utility styles based on values in customizer
 */
if ( ! function_exists( 'gpc_base_inline_css_func' ) ) :
    
    function gpc_base_inline_css_func() {

        if ( ! Utils_Themes::is_active_or_parent( 'GeneratePress' ) ) return;

        // get GeneratePress settings
        $font_settings = wp_parse_args(
            get_option( 'generate_settings', array() ),
            generate_get_default_fonts()
        );

        $typography_arr = $font_settings['typography'];

        // Initiate our CSS class
        $gpc_css = new GeneratePress_CSS;

        $copy_elements = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
        $block_style_els_arr = [];

        foreach( $typography_arr as $typography ) {
            $element = $typography['selector'];
            if ( in_array( $element, $copy_elements ) ) {

                array_push( $block_style_els_arr, $element );

                $gpc_css->set_selector( '.is-style-like-' . $element );
                $gpc_css->add_property( 'font-family', $typography['fontFamily']);
                $gpc_css->add_property( 'font-size', $typography['fontSize']);
                $gpc_css->add_property( 'font-style', $typography['fontStyle']);
                $gpc_css->add_property( 'font-weight', $typography['fontWeight']);
                $gpc_css->add_property( 'letter-spacing', $typography['letterSpacing']);
                $gpc_css->add_property( 'line-height', $typography['lineHeight']);
                $gpc_css->add_property( 'margin-bottom', $typography['marginBottom']);
                $gpc_css->add_property( 'text-transform', $typography['textTransform']);
                
                $gpc_css->start_media_query( generate_get_media_query( 'tablet' ) );
                
                $gpc_css->set_selector( '.is-style-like-' . $element );
                $gpc_css->add_property( 'font-size', $typography['fontSizeTablet']);
                $gpc_css->add_property( 'font-style', $typography['fontStyleTablet']);
                $gpc_css->add_property( 'font-weight', $typography['fontWeightTablet']);
                $gpc_css->add_property( 'letter-spacing', $typography['letterSpacingTablet']);
                $gpc_css->add_property( 'line-height', $typography['lineHeightTablet']);
                $gpc_css->add_property( 'margin-bottom', $typography['marginBottomTablet']);
                $gpc_css->add_property( 'text-transform', $typography['textTransformTablet']);
                
                $gpc_css->stop_media_query();
                
                $gpc_css->start_media_query( generate_get_media_query( 'mobile' ) );
                
                $gpc_css->set_selector( '.is-style-like-' . $element );
                $gpc_css->add_property( 'font-size', $typography['fontSizeMobile']);
                $gpc_css->add_property( 'font-style', $typography['fontStyleMobile']);
                $gpc_css->add_property( 'font-weight', $typography['fontWeightMobile']);
                $gpc_css->add_property( 'letter-spacing', $typography['letterSpacingMobile']);
                $gpc_css->add_property( 'line-height', $typography['lineHeightMobile']);
                $gpc_css->add_property( 'margin-bottom', $typography['marginBottomMobile']);
                $gpc_css->add_property( 'text-transform', $typography['textTransformMobile']);

                $gpc_css->stop_media_query();
            }
        }

        // Return our dynamic CSS
        return [
            'css' => $gpc_css->css_output(),
            'block_els' => $block_style_els_arr,
        ];

    }

endif;

/**
 * Create option to contain utility styles after saving customizer
 */
add_action( 'customize_save_after', 'gpc_save_gp_utility_css' );
function gpc_save_gp_utility_css() {
    if ( ! Utils_Themes::is_active_or_parent( 'GeneratePress' ) ) return;
    $gpc_css_and_elements = gpc_base_inline_css_func();
    update_option( 'gpc_utility_css', $gpc_css_and_elements['css'] );
    update_option( 'gpc_utility_elements', $gpc_css_and_elements['block_els'] );
}

/**
 * Check for utility css options and create block styles
 */
if ( function_exists( 'register_block_style' ) && get_option( 'gpc_utility_css' ) && get_option( 'gpc_utility_elements' ) ) {
    
    if ( ! Utils_Themes::is_active_or_parent( 'GeneratePress' ) ) return;

    $elements = get_option( 'gpc_utility_elements' );

    if ( ! $elements ) return;

    foreach( $elements as $element ) {
        register_block_style(
            'core/heading',
            array(
                'name'         => 'like-' . $element,
                'label'        => strtoupper( $element ) . ' Style'
            )
        );
        register_block_style(
            'core/paragraph',
            array(
                'name'         => 'like-' . $element,
                'label'        => strtoupper( $element ) . ' Style'
            )
        );
    }
}

/**
 * Enqueue utility styles
 */
add_action( 'enqueue_block_assets', 'gpc_add_inline_styles' );
function gpc_add_inline_styles() {
    if ( ! Utils_Themes::is_active_or_parent( 'GeneratePress' ) ) return;
    $gpc_css = get_option( 'gpc_utility_css' );
    if ( ! $gpc_css ) return;
    wp_register_style( 'gpc-utility', false );
    wp_enqueue_style( 'gpc-utility' );
    wp_add_inline_style( 'gpc-utility', $gpc_css );
}