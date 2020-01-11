<?php
/**
 * Template part for listing sponsors
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$website = get_field( 'website' );
?>

<div class="sponsor-block">

    <div class="sponsor-block-col-1">
        <?php if ( !empty( $website ) ) : ?><a href="<?php echo $website; ?>" target="_blank"><?php endif; ?>
        <?php the_post_thumbnail( 'full', array( 'class' => 'sponsor-block-image' ) ); ?>
        <?php if ( !empty( $website ) ) : ?></a><?php endif; ?>
    </div>

    <div class="sponsor-block-col-2">
        <?php the_content(); ?>
    </div>

</div>
