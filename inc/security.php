<?php
/**
 * Content security policy with nonces. Doesn't work great with caching.
 *
 * Do some security stuff to harden WordPress.
 * Must be included in functions.php
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Set empty nonce variable
 */
$csp_nonce = '';

/**
 * Generate nonce for Content Security Policy
 */
if ( ! is_admin() ) {
    $csp_nonce = bin2hex(openssl_random_pseudo_bytes(32));
}

/**
 * Content Security Policy settings.
 */
$csp_settings_arr = array(
    "base-uri" => array(
        "'self'",
    ),
    'default-src' => array(
        "'self'",
    ),
    'object-src' => array(
        "'none'",
    ),
    'style-src' => array(
        "'self'",
        "'unsafe-inline'",
        "https://fonts.googleapis.com",
    ),
    'font-src' => array(
        "'self'",
        "https://fonts.gstatic.com",
    ),
    'connect-src' => array(
        "'self'",
        "https://www.google-analytics.com",
        "https://www.analytics.google.com",
        "https://www.googletagmanager.com",
        "https://l.clarity.ms",
        "https://www.cloudways.com",
    ),
    'script-src' => array(
        "'nonce-$csp_nonce'",
        "'strict-dynamic'",
        "'unsafe-inline'",
        "http:",
        "https:",
    ),
    'img-src' => array(
        "'self'",
        "https://www.google-analytics.com",
        "https://www.googletagmanager.com",
        "https://www.clarity.ms",
        "https://c.clarity.ms",
        "https://c.bing.com",
        "https://www.cloudways.com",
        "https://patterns.generateblocks.com",
    ),
    'form-action' => array(
        "'self'",
        "https://www.cloudways.com",
    )
);

/**
 * Generate header with Content Security Policy
 */
add_action( 'send_headers', 'gpc_add_content_security_header' );
function gpc_add_content_security_header() {
    if ( is_admin() ) return;
    global $csp_settings_arr;
    $csp_settings_str = '';
    foreach( $csp_settings_arr as $setting => $values ) {
        $csp_settings_str .= $setting . ' ';
        foreach( $values as $value ) {
            $csp_settings_str .= $value . ' ';
        }
        $csp_settings_str .= '; ';
    }
    header( "Content-Security-Policy: $csp_settings_str" );
}

/**
 * Add nonce to all inline scripts for CSP.
 */
add_filter( 'wp_inline_script_attributes', 'gpc_add_nonce_to_inline_scripts', 999 );
function gpc_add_nonce_to_inline_scripts( $attr ) {
    if ( is_admin() ) return $attr;
    $attr = array();
    global $csp_nonce;
    $attr = array(
        'type' => 'text/javascript',
        'nonce' => $csp_nonce,
    );
    return $attr;
}

/**
 * Add nonce to all registered scripts for CSP.
 */
add_filter( 'script_loader_tag', 'gpc_add_nonce_to_scripts', 999 );
function gpc_add_nonce_to_scripts( $html ) {
    global $csp_nonce;
    return gpc_add_nonce_to_dom_scripts( $html, $csp_nonce );
}

/**
 * Add nonces to footer scripts that are inserted "manually".
 */
add_action( 'wp_footer', 'gpc_start_footer_ob', 1 );
function gpc_start_footer_ob() {
    ob_start( 'gpc_end_footer_ob_callback' );
}
add_action( 'wp_footer', 'gpc_end_footer_ob', 9999 );
function gpc_end_footer_ob() {
    ob_end_flush();
}
function gpc_end_footer_ob_callback( $buffer ) {
    global $csp_nonce;
    return gpc_add_nonce_to_dom_scripts( $buffer, $csp_nonce );
}

/**
 * Add nonces to scripts via DOMDocument
 * 
 * @see https://www.php.net/manual/en/book.libxml.php Requires libxml
 */
function gpc_add_nonce_to_dom_scripts( $html, $nonce ) {
    $doc = new DOMDocument();
    $doc->loadHTML( $html );
    $xpath = new DOMXPath( $doc );
    $nodes = $xpath->query('//script');
    foreach( $nodes as $node ) {
        $node->setAttribute( 'nonce', $nonce );
    }
    $html = trim( preg_replace( '/^<!DOCTYPE.+?>/', '', str_replace( array( '<html>', '</html>', '<head>', '</head>', '<body>', '</body>' ), array( '', '', '', '', '', '' ), $doc->saveHTML() ) ) );
    return $html;
}