<?php
/**
 * Sample partial for a custom post type single.
 * Duplicate and customize as needed.
 *
 * @package GenerateChild
 * @see /inc/cpt-output-custom.php
 */

if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="grid-parent clearfix">

	<div class="grid-33">
		<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'large' );
			}
		?>
	</div>

	<div class="grid-66">
		<?php echo $content; ?>
	</div>

</div>