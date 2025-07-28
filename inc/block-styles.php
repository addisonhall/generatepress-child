<?php
/**
 * Custom editor block style variations.
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add block styles as needed
 */
add_action( 'init', 'gpc_register_block_styles' );
function gpc_register_block_styles() {

    $elements = ['h1', 'h2', 'h3', 'h4', 'h5'];

    foreach( $elements as $element ) {
        register_block_style(
            'core/heading',
            array(
                'name'         => 'like-' . $element,
                'label'        => __( strtoupper( $element ) . ' Style', 'GenerateChild' )
            )
        );
        register_block_style(
            'core/paragraph',
            array(
                'name'         => 'like-' . $element,
                'label'        => __( strtoupper( $element ) . ' Style', 'GenerateChild' )
            )
        );
    }
}