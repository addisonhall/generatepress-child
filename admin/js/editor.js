/**
 * Disable specific Gutenberg editor blocks on all post types.
 * @link https://www.billerickson.net/how-to-remove-core-wordpress-blocks/
 * @link List of core blocks: https://gist.github.com/megclaypool/39dac8a1bd4e2b4cadd3af0021c1017d
 */

wp.domReady( () => {

    // comment out blocks to keep
    const blockTypesToDisable = [

        // - TEXT ---
        // 'core/paragraph',
        // 'core/heading',
        // 'core/list',
        // 'core/quote',
        'core/freeform',
        'core/code',
        'core/preformatted',
        'core/pullquote',
        // 'core/table',
        'core/verse',
        
        // - MEDIA ---
        // 'core/image',
        // 'core/gallery',
        'core/audio',
        'core/cover',
        // 'core/file',
        'core/media-text',
        'core/video',

        // - DESIGN ---
        'core/buttons',
        'core/columns',
        'core/group',
        'core/more',
        'core/nextpage',
        // 'core/separator',
        // 'core/spacer',

        // - WIDGETS ---
        'core/archives',
        'core/calendar',
        'core/categories',
        // 'core/html',
        'core/latest-comments',
        'core/latest-posts',
        'core/page-list',
        'core/rss',
        'core/search',
        // 'core/shortcode',
        'core/social-links',
        'core/tag-cloud',

        // - THEME ---
        'core/navigation',
        'core/site-logo',
        'core/site-title',
        'core/site-tagline',
        'core/query',
        'core/avatar',
        'core/post-title',
        'core/post-excerpt',
        'core/post-featured-image',
        'core/post-content',
        'core/post-author',
        'core/post-date',
        'core/post-terms',
        'core/post-navigation-link',
        'core/read-more',
        'core/comments-query-loop',
        'core/post-comments-form',
        'core/loginout',
        'core/term-description',
        'core/query-title',
        'core/post-author-biography',

        // - EMBEDS ---
        // 'core/embed',
        
    ];

    blockTypesToDisable.forEach(element => {
        wp.blocks.unregisterBlockType(element);
    });

} );