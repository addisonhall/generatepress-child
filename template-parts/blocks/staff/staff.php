<?php
/**
 * HBAJ Staff block template
 *
 * @package GenerateChild
 * @see /inc/advanced-custom-fields.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$image = get_field( 'image' );
$name = get_field( 'name' );
$title = get_field( 'title' );
$phone_1 = get_field( 'phone_1' );
$phone_2 = get_field( 'phone_2' );
$email = get_field( 'email' );
?>

<div class="staff-block">

    <div class="staff-block-col-1">
        <?php echo wp_get_attachment_image( $image, 'full', '', array( 'class' => 'staff-block-image' ) ); ?>
    </div>

    <div class="staff-block-col-2">
        <h3 class="staff-block-name-wrapper">
            <span class="staff-block-name"><?php echo $name; ?></span>
            <?php if ( !empty( $title ) ) : ?>
                <small class="staff-block-title"><?php echo $title; ?></small>
            <?php endif; ?>
        </h3>
        <?php if ( !empty( $phone_1 ) || !empty( $phone_2) || !empty( $email ) ) : ?>
            <div class="staff-block-info">
                <?php if ( !empty( $phone_1 ) ) : ?>
                    <span class="staff-block-phone-1"><?php echo $phone_1; ?></span>
                <?php endif; ?>
                <?php if ( !empty( $phone_2 ) ) : ?>
                    &middot; <span class="staff-block-phone-2"><?php echo $phone_2; ?></span>
                <?php endif; ?>
                <?php if ( !empty( $email ) ) : ?>
                    <br><span class="staff-block-email"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</div>