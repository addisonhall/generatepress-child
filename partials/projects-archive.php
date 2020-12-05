<?php
/**
 * Sample partial for a custom post type archive.
 * Duplicate and customize as needed.
 *
 * @package GenerateChild
 * @see /inc/cpt-output-custom.php
 */

if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="grid-parent clearfix">

  <div class="grid-33">
    <?php if ( has_post_thumbnail() ) : ?>
      <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail', array( 'class' => '' ) ); ?></a>
    <?php endif; ?>
  </div>

  <div class="grid-66">
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
  </div>

</div>
