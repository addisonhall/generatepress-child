<?php
/**
 * Team block template
 *
 * @package GenerateChild
 * @see /blocks/team/block.json
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$image = get_field( 'team_photo' );
$name = get_field( 'team_name' );
$title = get_field( 'team_title' );
$email = get_field( 'team_email' );
?>

<div class="team-block">

    <div class="team-block-col-1">
        <?php echo wp_get_attachment_image( $image, 'full', '', array( 'class' => 'team-block-image' ) ); ?>
    </div>

    <div class="team-block-col-2">
        <h3 class="team-block-name-wrapper">
            <span class="team-block-name"><?php echo $name; ?></span>
            <?php if ( !empty( $title ) ) : ?>
                <small class="team-block-title"><?php echo $title; ?></small>
            <?php endif; ?>
        </h3>
        <?php if ( !empty( $email ) ) : ?>
            <div class="team-block-info">
                <?php if ( !empty( $email ) ) : ?>
                    <br><span class="team-block-email"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</div>