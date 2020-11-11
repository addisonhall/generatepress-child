/**
 * Disable specific Gutenberg editor blocks on Posts.
 * @link https://www.billerickson.net/how-to-remove-core-wordpress-blocks/
 * @link List of core blocks: https://gist.github.com/megclaypool/39dac8a1bd4e2b4cadd3af0021c1017d
 */
wp.domReady( () => {
    if ( typeof wp.blocks.getBlockType( 'generateblocks/grid' ) !== 'undefined' ) {
        wp.blocks.unregisterBlockType( 'generateblocks/grid' );
        wp.blocks.unregisterBlockType( 'generateblocks/container' );
        wp.blocks.unregisterBlockType( 'generateblocks/button-container' );
        wp.blocks.unregisterBlockType( 'generateblocks/button' );
        wp.blocks.unregisterBlockType( 'generateblocks/headline' );
    }
} );