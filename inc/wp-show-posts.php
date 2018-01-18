<?php
/**
 * Modify WP Show Posts output.
 *
 * Must be included in functions.php
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'wpsp_disable_image_link', 'tu_disable_links', 10, 2 );
add_filter( 'wpsp_disable_title_link', 'tu_disable_links', 10, 2 );
function tu_disable_links( $output, $settings ) {
    if ( 1746 === $settings['list_id'] ) {
      return true;
    }
  return $output;
}

/**
 * Remove permalinks from WP Show Posts output using DOMDocument and DOMXpath.
 * @link https://stackoverflow.com/questions/36096834/selectivly-replace-certain-html-tags-via-php-while-keeping-some
 * @link https://techsparx.com/software-development/wordpress/dom-document-pitfalls.html
 */
// add_filter( 'the_content', 'gpc_remove_wpshowposts_permalinks', 20 );
function gpc_remove_wpshowposts_permalinks( $content ) {

  // EDIT HERE!
  // Add the ID (as shown) of each WP Show Post entry
  // that you want to affect to this array.
  // That should be all you need to do.
  $which_wpshowposts = array(
    'id="wpsp-123"'
  );

  foreach ( $which_wpshowposts as $wpshowpost ) {

    if ( strpos( $content, $wpshowpost ) ) {
      $html = new DOMDocument( null, 'UTF-8' );
      $html->validateOnParse = false;
      @$html->loadHTML( '<meta http-equiv="content-type" content="text/html; charset=utf-8">' . $content );
      $xpath = new DOMXPath( $html );
  
      $selectors_array = array(
        '//section[@' . $wpshowpost . ']//*[contains(@class,"wp-show-posts-entry-title")]/a',
        '//section[@' . $wpshowpost . ']//*[contains(@class,"wp-show-posts-image")]/a',
        '//section[@' . $wpshowpost . ']//*[contains(@class,"wp-show-posts-author")]/a',
        '//section[@' . $wpshowpost . ']//*[contains(@class,"wp-show-posts-posted-on")]/a'
      );
  
      $selectors = implode( '|', $selectors_array );
  
      while ( $node = $xpath->query( $selectors )->item(0) ) {
        $fragment = $html->createDocumentFragment();
        while ( $node->childNodes->length ) {
          $fragment->appendChild( $node->childNodes->item(0) );
        }
        $node->parentNode->replaceChild( $fragment, $node );
      }
  
      // See https://techsparx.com/software-development/wordpress/dom-document-pitfalls.html
      $content = str_replace( array( '<body>', '</body>'), '', $html->saveHTML( $html->getElementsByTagName( 'body' )->item(0) ) );
  
    }

  }

  return $content;
}
