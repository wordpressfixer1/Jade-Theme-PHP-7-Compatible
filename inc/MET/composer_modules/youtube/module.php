<?php
	// Register Module
function register_youtube_module() {
	return dslc_register_module( "MET_Youtube" );
}
add_action('dslc_hook_register_modules','register_youtube_module');

class MET_Youtube extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'MET_Youtube';
		$this->module_title = __( 'YouTube', 'dslc_string' );
		$this->module_icon = 'youtube';
		$this->module_category = 'met - general';

	}

	function options() {

		$dslc_options = array(

			array(
				'label' => __( 'YouTube ID/URL', 'dslc_string' ),
				'id' => 'video_id',
				'std' => 'SmfKfX6_UmA',
				'type' => 'text',
			),

			array(
				'label' => __( 'Resize - Width', 'dslc_string' ),
				'id' => 'vid_resize_width',
				'std' => '560',
				'type' => 'text',
			),
			array(
				'label' => __( 'Resize - Height', 'dslc_string' ),
				'id' => 'vid_resize_height',
				'std' => '315',
				'type' => 'text',
			),
			array(
				'label' => __( 'Resize - Type', 'dslc_string' ),
				'id' => 'vid_resize_type',
				'std' => 'px',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Pixel (px)', 'dslc_string' ),
						'value' => 'px',
					),
					array(
						'label' => __( 'Percent (%)', 'dslc_string' ),
						'value' => '%',
					),
				)
			),

			array(
				'label' => __( 'Start video at', 'dslc_string' ),
				'id' => 'vid_start',
				'std' => '',
				'type' => 'text',
			),
			array(
				'label' => __( 'End video at', 'dslc_string' ),
				'id' => 'vid_end',
				'std' => '',
				'type' => 'text',
			),

			array(
				'label' => __( 'Force HD', 'dslc_string' ),
				'id' => 'force_hd',
				'std' => '0',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => '0',
					),
					array(
						'label' => __( '720p', 'dslc_string' ),
						'value' => 'hd720',
					),
					array(
						'label' => __( '1080p', 'dslc_string' ),
						'value' => 'hd1080',
					),
				)
			),

			array(
				'label' => __( 'Preview Image', 'dslc_string' ),
				'id' => 'preview_image',
				'std' => '',
				'type' => 'image',
				'tab' => 'player',
				'help' => 'Not supported by Internet Explorer 7 or earlier'
			),
			array(
				'label' => __( 'Player Options', 'dslc_string' ),
				'id' => 'player_options',
				'std' => '',
				'type' => 'checkbox',
				'tab' => 'player',
				'choices' => array(
					array(
						'label' => __( 'Autoplay', 'dslc_string' ),
						'value' => 'autoplay=1',
					),
					array(
						'label' => __( 'Loop', 'dslc_string' ),
						'value' => 'loop=1',
					),
					array(
						'label' => __( 'Disable Info Bar', 'dslc_string' ),
						'value' => 'showinfo=0',
					),
					array(
						'label' => __( 'Disable Releated Videos', 'dslc_string' ),
						'value' => 'rel=0',
					),
					array(
						'label' => __( 'Light UI', 'dslc_string' ),
						'value' => 'theme=light',
					),
					array(
						'label' => __( 'Disable Fullscreen', 'dslc_string' ),
						'value' => 'fs=0',
					),
					array(
						'label' => __( 'White Progress Bar', 'dslc_string' ),
						'value' => 'color=white',
					),
					array(
						'label' => __( 'Disable Autohide Play Bar', 'dslc_string' ),
						'value' => 'autohide=0',
					),
					array(
						'label' => __( 'Disable Controls', 'dslc_string' ),
						'value' => 'controls=0',
					),
					array(
						'label' => __( 'Disable Keyboard', 'dslc_string' ),
						'value' => 'disablekb=1',
					),
				)
			),

			array(
				'label' => __( 'Playback Location', 'dslc_string' ),
				'id' => 'playback_location',
				'std' => '0',
				'type' => 'select',
				'tab' => 'player',
				'help' => '*Only available if preview image is exist!',
				'choices' => array(
					array(
						'label' => __( 'Current', 'dslc_string' ),
						'value' => '0',
					),
					array(
						'label' => __( 'Lightbox', 'dslc_string' ),
						'value' => 'lightbox',
					),
					array(
						'label' => __( 'Fullscreen', 'dslc_string' ),
						'value' => 'fullscreen',
					),
				)
			),


			/**
			 * Styling
			 */

			array(
				'label' => __( 'Align', 'dslc_string' ),
				'id' => 'css_align',
				'std' => 'center',
				'type' => 'select',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.mc-custom-youtube-player',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'choices' => array(
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'left',
					),
					array(
						'label' => __( 'Center', 'dslc_string' ),
						'value' => 'center',
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'right',
					),
				)
			),
			array(
				'label' => __( 'BG Color', 'dslc_string' ),
				'id' => 'css_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.mc-custom-youtube-player',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'dslc_string' ),
				'id' => 'css_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.mc-custom-youtube-player > iframe, .mc-custom-youtube-player > a',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Width', 'dslc_string' ),
				'id' => 'css_border_width',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.mc-custom-youtube-player > iframe, .mc-custom-youtube-player > a',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'dslc_string' ),
				'id' => 'css_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'dslc_string' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'dslc_string' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'dslc_string' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'dslc_string' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.mc-custom-youtube-player > iframe, .mc-custom-youtube-player > a',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Radius', 'dslc_string' ),
				'id' => 'css_border_radius',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.mc-custom-youtube-player > iframe, .mc-custom-youtube-player > a',
				'affect_on_change_rule' => 'border-radius',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Margin Bottom', 'dslc_string' ),
				'id' => 'css_margin_bottom',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.mc-custom-youtube-player',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Vertical', 'dslc_string' ),
				'id' => 'css_padding_vertical',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.mc-custom-youtube-player',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px'
			),
			array(
				'label' => __( 'Padding Horizontal', 'dslc_string' ),
				'id' => 'css_padding_horizontal',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.mc-custom-youtube-player',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px'
			),

		);

		$dslc_options = met_lc_extras($dslc_options, array('animation','parallax'), 'shared_options');
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		$this->module_start( $options );

		/* Module output starts here */
		global $dslc_active;

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
			$dslc_is_admin = true;
		else
			$dslc_is_admin = false;

		$module_id = uniqid('mcyoutube_');

		/* MC Shared Options */
		$met_shared_options = met_lc_extras( $options, array(
			'groups'   => array('animation', 'parallax'),
			'params'   => array(
				'js'           => false,
				'css'          => false,
				'external_run' => false,
				'is_grid'      => false,
			),
			'is_admin' => $dslc_is_admin,
		), 'shared_options_output' );

		if ( !$dslc_is_admin && $met_shared_options['activity'] ){
			wp_enqueue_style('metcreative-animate');
			wp_enqueue_script('metcreative-wow');
		}

		$is_video_valid = false;
		$video_embed_url = $embed_url_query = $embed_iframe = $mfp_src = '';
		$embed_url_params = array();

		if( !empty( $options['video_id'] ) ){

			$video_embed_url = video_url_to_embed($options['video_id']);
			if( $video_embed_url !== false ){
				$is_video_valid = true;
			}else{
				$video_embed_url = 'http://www.youtube.com/embed/'.$options['video_id'];
				$is_video_valid = true;
			}

		}

		if( !empty($options['vid_start']) ) $embed_url_params['start'] = $options['vid_start'];
		if( !empty($options['vid_end']) ) $embed_url_params['end'] = $options['vid_end'];
		if( !empty($options['force_hd']) OR $options['force_hd'] != '0' ) $embed_url_params['vq'] = $options['force_hd'];

		$player_options = $options['player_options'];
		if ( ! empty( $player_options ) )
			$player_options = explode( ' ', trim( $player_options ) );
		else
			$player_options = false;

		if( is_array( $player_options ) ){
			foreach( $player_options as $player_option ){
				$player_option = explode('=',$player_option);
				$embed_url_params[$player_option[0]] = $player_option[1];
			}
		}

		if( is_array( $embed_url_params ) && count( $embed_url_params ) > 0 ){
			$embed_url_query = $video_embed_url.'?'.http_build_query($embed_url_params);
		}else{
			$embed_url_query = $video_embed_url;
		}

		if( $options['vid_resize_type'] == 'px' ){
			$embed_iframe_sizes = 'width="'.$options['vid_resize_width'].'" height="'.$options['vid_resize_height'].'"';
		}else{
			$embed_iframe_sizes = 'style="width:'.$options['vid_resize_width'].'%;height:'.$options['vid_resize_height'].';"';
		}

?>

		<div class="mc-custom-youtube-player <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>

			<?php if ( $is_video_valid === false ) : ?>

				<div class="dslc-notification dslc-red"><?php _e( 'No video has been set yet or video id/url is not valid!', 'dslc_string' ); ?></div>

			<?php else : ?>

				<?php if ( empty( $options['preview_image'] ) ) : ?>
					<iframe <?php echo $embed_iframe_sizes ?> src="<?php echo $embed_url_query ?>" frameborder="0"></iframe>
				<?php else : ?>
					<a class="<?php echo $module_id ?>_trigger" href="javascript:;" data-loc="<?php echo $options['playback_location'] ?>" style="display:block;width:<?php echo $options['vid_resize_width'].$options['vid_resize_type'] ?>;height:<?php echo $options['vid_resize_height'].$options['vid_resize_type'] ?>;background: url('<?php echo $options['preview_image'] ?>') no-repeat center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;overflow:hidden;<?php echo ( ($options['css_align'] == 'center') ? 'margin-left:auto;margin-right:auto' : '' ) ?>"></a>

					<?php if ( $options['playback_location'] == 'fullscreen' ) $mfp_src = '<div style="position:relative;width: 99vw;height:98vh;background-color: rgba(0,0,0,0.4)"><iframe style="width: 94vw;height:90vh;margin-top: 4vh;" src="'.$embed_url_query.'" frameborder="0"></iframe></div>'; ?>
					<?php if ( $options['playback_location'] == 'lightbox' ) $mfp_src = '<div><iframe '.$embed_iframe_sizes.' src="'.$embed_url_query.'" frameborder="0"></iframe></div>'; ?>

					<script>
						jQuery(document).ready(function( $ ) {

							$('.<?php echo $module_id ?>_trigger').on('click', function(){
								var $yt_trigger = $(this);
								var player_loc = $yt_trigger.attr('data-loc');

								if( player_loc == '0' ){
									$yt_trigger.html('<iframe <?php echo $embed_iframe_sizes ?> src="<?php echo $embed_url_query ?>" frameborder="0"></iframe>');
								}else{
									$.magnificPopup.open({
										items: {src: '<?php echo $mfp_src ?>',type: 'inline'},
										type: 'inline'
									}, 0);
								}
							});

						});
					</script>
				<?php endif; ?>

			<?php endif; ?>

		</div><!-- .mc-custom-youtube-player -->
		<?php echo $met_shared_options['script']; ?>

		<?php
		/* Module output ends here */
		$this->module_end( $options );
	}

}