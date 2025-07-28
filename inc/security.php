<?php
/**
 * Content security policy with nonces. Doesn't work great with caching.
 *
 * Do some security stuff to harden WordPress.
 * Must be included in functions.php
 *
 * @package GenerateChild
 * @see https://content-security-policy.com/ Reference guide for content security policies
 * @see https://csp-evaluator.withgoogle.com/ Test with Google's CSP Evaluator
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
    ),
    'form-action' => array(
        "'self'",
        "https://www.cloudways.com",
    )
);

/**
 * Generate header with Content Security Policy.
 * Also add other headers if relevant.
 * 
 * @see https://developer.wordpress.org/reference/hooks/send_headers/ Docs for send_headers hook
 */
add_action( 'send_headers', 'gpc_add_custom_headers' );
function gpc_add_custom_headers() {
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
    header( 'Referrer-Policy: no-referrer-when-downgrade' );
    header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains' );
    header( 'X-Frame-Options: SAMEORIGIN' );
    header( 'X-Content-Type-Options: nosniff' );
    header( 'Permissions-Policy: fullscreen=(self "' . site_url() . '"), geolocation=*' ); // change the URL to match the site!
}

/**
 * Add nonce to all inline scripts for CSP.
 * 
 * @see https://developer.wordpress.org/reference/hooks/wp_inline_script_attributes/ Docs for wp_inline_script_attributes filter
 */
add_filter( 'wp_inline_script_attributes', 'gpc_add_nonce_to_inline_scripts', 999 );
function gpc_add_nonce_to_inline_scripts( $attr ) {
    if ( is_admin() ) return $attr;
    global $csp_nonce;
    $attr['nonce'] = $csp_nonce;
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
 * Add nonces to head and footer scripts that are inserted "manually".
 * 
 * @see https://wordpress.stackexchange.com/questions/161971/overwrite-or-replace-code-in-wp-footer Provided the output buffer solution using wp_footer
 */
add_action( 'wp_head', 'gpc_start_head_ob', 1 );
function gpc_start_head_ob() {
    ob_start( 'gpc_end_head_and_footer_ob_callback' );
}
add_action( 'wp_head', 'gpc_end_head_ob', 999 );
function gpc_end_head_ob() {
    ob_end_flush();
}
add_action( 'wp_footer', 'gpc_start_footer_ob', 1 );
function gpc_start_footer_ob() {
    ob_start( 'gpc_end_head_and_footer_ob_callback' );
}
add_action( 'wp_footer', 'gpc_end_footer_ob', 999 );
function gpc_end_footer_ob() {
    ob_end_flush();
}
function gpc_end_head_and_footer_ob_callback( $buffer ) {
    global $csp_nonce;
    return gpc_add_nonce_to_dom_scripts( $buffer, $csp_nonce );
}

/**
 * Add nonces to scripts via DOMDocument
 * 
 * @see https://www.php.net/manual/en/book.libxml.php Requires libxml
 * @see https://wordpress.stackexchange.com/questions/161971/overwrite-or-replace-code-in-wp-footer WP StackExchange that helped me write this function
 */
function gpc_add_nonce_to_dom_scripts( $html, $nonce ) {
    $doc = new DOMDocument();
    $doc->loadHTML( $html );
    $xpath = new DOMXPath( $doc );
    $nodes = $xpath->query('//script');
    foreach( $nodes as $node ) {
        $node->setAttribute( 'nonce', $nonce );
    }
    $html = trim( preg_replace( '/^<!DOCTYPE.+?>/', '', str_replace( array( '<html>', '</html>', '<head>', '</head>', '<body>', '</body>' ), array( '', '', '', '', '', '' ), $doc->saveHTML() ) ) ); // DOMDocument will try to add doctype, html, etc., so strip these out if added.
    return $html;
}