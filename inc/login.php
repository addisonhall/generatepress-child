<?php
/**
 * Customize Wordpress login.
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Use the site logo for the Wordpress login screen.
 */
add_action( 'login_head', 'gpc_custom_login_logo' );
function gpc_custom_login_logo() {
    if ( has_custom_logo() ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        $logo_url = $image[0];
        echo '<style type="text/css">
        h1 a { background-image:url(' . $logo_url . ') !important; background-size:auto !important; background-size:contain !important; width:310px !important; height:100px !important; }
        </style>';
    }
}
    