<?php
/**
 * Sample partial for a custom post type single.
 * Duplicate and customize as needed.
 *
 * @package GenerateChild
 * @see /inc/cpt-output-custom.php
 */

if ( ! defined( 'ABSPATH' ) ) exit; ?>

<!-- content-cpt-sample-single -->
<div class="grid-parent clearfix content-for-project">

  <div class="grid-33">
    <?php
      if ( has_post_thumbnail() ) {
        the_post_thumbnail( 'large' );
      }
    ?>
  </div>

  <div class="grid-66">
    <p><strong>content-ctp-sample-single</strong></p>
    <?php echo $content; ?>
  </div>

</div>