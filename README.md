# GeneratePress child theme

This is a child theme for the [GeneratePress](https://generatepress.com/) WordPress theme. I found myself using the same conventions over and over, so I thought it would be best standardize and include them here.

If you've never heard of GeneratePress, it's a solid, flexible, and lightweight "framework" theme that allows developers to get the most common components up and running quickly. It also includes lots of [hooks](https://generatepress.com/knowledgebase/hook-list/) and [filters](https://generatepress.com/knowledgebase/filter-list/) to help customize and extend.

GeneratePress itself is free, but I highly recommend the [premium add-ons](https://generatepress.com/premium/). It's easily money well spent.

## What's included

I've tried to be thorough with comments at the top of each file, but here's the gist of it.

### CSS

As of now, there's only `base.css` within the `css` folder, and just as it's named, its only purpose is to provide some "base" styles not already included in GeneratePress. Much of it is pulled from [Basscss](http://basscss.com/), but I've modified and added here and there to make it more in line with GeneratePress styling.

By the way, GeneratePress implements [Unsemantic](http://unsemantic.com/) for its layout styling. The additional [default styling](https://github.com/tomusborne/generatepress/blob/master/style.unmin.css) is on Github.

The `style.css` file is where I include all of my custom styling. I have not included any preprocessor setup, so feel free to rig up whatever you prefer.

### JavaScript

Only one JavaScript file is present, `js/scripts.js`, for all of my javascript goodies. As of now it includes:

- a small margin "fix" for the Lightweight Grid Columns plugin (see explanation below)
- a simple function that recalls matchHeight so that ajax Gravity Forms don't bork the layout
- a simple scroll-to function for inline anchor links
- a generic Google Maps function for Advanced Custom Fields (see Plugins below)

I plan on simply editing this file as needed.

### Functions

**Note:** I've ~~recently~~ rearranged some things here in the latest update. The idea is to compartmentalize things as much as possible.

The `functions.php` file and everything within the `inc` folder go together. You'll find the usual within `functions.php`, but the `inc` folder includes some optional files that can be "required" as needed.

It will probably be easiest to check the comments in each file to find out what's going on, but basically, it's:

- `advanced-custom-fields.php`: Helpers for Google Maps and bi-directional relationships in Advanced Custom Fields
- `cpt-output-custom.php`: Tells custom post types and taxonomies to use specified template partials (stored within `partials`)
- `cpt-output-reset.php`: Heads off the default display of custom post types and taxonomies so that our custom partials can be used instead
- `dashboard-widgets.php`: Where my dashboard widgets live
- `generatepress.php`: Some customizations for GeneratePress. I've updated some things here for GP 2.0.
- `image-sizes.php`: Optional custom image sizes
- `optimizations.php`: Some stuff to make our site lean and mean
- `shortcodes.php`: Where my shortcodes live
- `styles.php`: Creates additional inline styles from colors set within the customizer of GeneratePress
- `sub-menu-widget.php`: Creates a contextual sub menu widget that pulls from the specified menu theme location. Defaults to `primary`.
- `sub-menu.php`: Function for adding contextual sub menus. Used by `sub-menu-widget.php`.
- `users.php`: Currently defines what the admin looks like for the `editor` and `shop_manager` roles. Requires the [Members plugin](https://wordpress.org/plugins/members/) by Justin Tadlock.
- `woocommerce.php`: Customizations, if necessary, for WooCommerce.
- `wp-show-posts.php`: Customizations, if necessary, for [WP Show Posts](https://wpshowposts.com/). This currently only contains a filter for removing all links for occasions where you only require a list (but not links, obviously).

### Partials

Within `partials` you'll find a couple of sample template files for setting up a custom layout for custom post types. I prefer this method (for now, anyway) instead of the [template hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/) convention so that my template files won't necessarily require tweaking as the result of a theme update. This may be dumb, so I'll revisit if that's the case.

These partials are called from within `inc/cpt-custom-output.php`.

### Screenshot

I've included an [Affinity Designer](https://affinity.serif.com/en-us/) file to create the `screenshot.png` for the child theme. Of course you can use whatever you like to make your 1200x900 PNG or JPEG file to suit your needs.

### Other

#### Margin fix for Lightweight Grid Columns

Lightweight Grid Columns is an outstanding plugin for creating grid columns within your content. The only issue I've found is that it creates a small ten pixel margin difference if used with content not placed in a grid column. There's now a small bit of JavaScript that wraps sets of columns in a div (`.lgc-row`) along with some CSS that provides negative left and right margins to even things out. This is the same technique that Bootstrap 3.x uses.

## Plugins I normally use

- [GeneratePress Premium](https://generatepress.com/premium/)
- [Lightweight Grid Columns](https://wordpress.org/plugins/lightweight-grid-columns/)
- [Advanced Custom Fields](https://www.advancedcustomfields.com/)
- [Custom Post Type UI](https://wordpress.org/plugins/custom-post-type-ui/)
- [WP Show Posts](https://wpshowposts.com/)
- [Dynamic Widgets](https://wordpress.org/plugins/dynamic-widgets/)
- [Gravity Forms](http://www.gravityforms.com/) or [Formidable Pro](https://formidablepro.com/)
- [Members](https://wordpress.org/plugins/members/)
- [WP Featherlight](https://wordpress.org/plugins/wp-featherlight/)
- [Soliloquy](https://soliloquywp.com/)
- [Autoptimize](https://wordpress.org/plugins/autoptimize/)
- ~~[Display Widgets](https://wordpress.org/plugins/display-widgets/)~~
- ~~[Black Studio TinyMCE Widget](https://wordpress.org/plugins/black-studio-tinymce-widget/)~~
