<?php
/**
 * Template part for listing sponsors
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$website = get_field( 'website' );
?>

<li class="sponsor-logo">

    <?php if ( !empty( $website ) ) : ?><a href="<?php echo $website; ?>" target="_blank"><?php endif; ?>
    <?php the_post_thumbnail( 'full', array( 'class' => 'sponsor-logo-image' ) ); ?>
    <?php if ( !empty( $website ) ) : ?></a><?php endif; ?>

</li>