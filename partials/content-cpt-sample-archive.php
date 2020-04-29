<?php
/**
 * Sample partial for a custom post type archive.
 * Duplicate and customize as needed.
 *
 * @package GenerateChild
 * @see /inc/cpt-output-custom.php
 */

if ( ! defined( 'ABSPATH' ) ) exit; ?>

<!-- content-cpt-sample-archive -->
<div class="grid-parent clearfix content-archive-for-projects">

  <div class="grid-33">
    <?php if ( has_post_thumbnail() ) : ?>
      <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail', array( 'class' => '' ) ); ?></a>
    <?php endif; ?>
  </div>

  <div class="grid-66">
    <p><strong>content-ctp-sample-archive</strong></p>
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
  </div>

</div>
