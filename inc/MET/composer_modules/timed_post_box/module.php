<?php

// Register Module
function register_timedpostbox_module() {
	return dslc_register_module( "MET_TimedPostBox" );
}
add_action('dslc_hook_register_modules','register_timedpostbox_module');

class MET_TimedPostBox extends DSLC_Module {

    var $module_id = 'MET_TimedPostBox';
    var $module_title = 'Clock on Image';
    var $module_icon = 'info';
    var $module_category = 'met - events';

    function options() {

		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'tribe_events'
		);
		$dslc_query = new WP_Query($args);

		if ( $dslc_query->have_posts() ){
			while ( $dslc_query->have_posts() ) : $dslc_query->the_post();
				$events[] = array('id' => get_the_ID() ,'title' => get_the_title());
			endwhile;
		}
		wp_reset_query();
		$events_choices = array();

		if ( isset( $events ) && $events ) {
			foreach ( $events as $event ) {
				$events_choices[] = array(
					'label' => $event['title'],
					'value' => $event['id']
				);
			}
		}

        $dslc_options = array(
			array(
				'label' => __( 'Active Events', 'dslc_string' ),
				'id' => 'event_id',
				'std' => '',
				'type' => 'select',
				'choices' => $events_choices
			),
			array(
				'label' => __( 'Date Format', 'dslc_string' ),
				'id' => 'date_format',
				'std' => 'Y-M-d H:i',
				'type' => 'text',
				'tab' => 'thumbnail'
			),

			array(
				'label' => __( 'Resize - Height', 'dslc_string' ),
				'id' => 'thumb_resize_height',
				'std' => '',
				'type' => 'text',
				'tab' => 'thumbnail'
			),
			array(
				'label' => __( 'Resize - Width', 'dslc_string' ),
				'id' => 'thumb_resize_width_manual',
				'std' => '',
				'type' => 'text',
				'tab' => 'thumbnail',
			),
			array(
				'label' => __( 'Resize - Width', 'dslc_string' ),
				'id' => 'thumb_resize_width',
				'std' => '',
				'type' => 'text',
				'tab' => 'thumbnail',
				'visibility' => 'hidden'
			),
        );

        $dslc_options = array_merge(
            $dslc_options,

            // Details
            lc_general('.met_timed_post_box_details', 'Details', array('background-color' => '#EFEEE9','text-align' => 'center')),
			lc_paddings('.met_timed_post_box_details', 'Details', array('t' => '19', 'r' => '0', 'b' => '19', 'l' => '0')),

            // Title
            lc_general('.met_timed_post_box_title', 'Title', array('color' => '','color:hover' => '', 'font-size' => '30', 'line-height' => '40', 'font-weight' => '400')),

			// Date
			lc_general('.met_timed_post_box_time', 'Date', array('color' => '', 'font-size' => '12', 'line-height' => '22', 'font-weight' => '400')),

			// Clock
			lc_general('.met_clock', 'Clock', array('width'=>'70','height'=>'70','background-color' => '#EFEEE9'))
        );

		$bg_options = array(
			array(
				'label' => __( 'Overlay Color', 'dslc_string' ),
				'id' => 'box_background_color',
				'std' => '255,202,7',
				'type' => 'color',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'section' => 'styling',
				'tab' => 'overlay'
			),
			array(
				'label' => __( 'Overlay Color Opacity', 'dslc_string' ),
				'id' => 'box_background_color_alpha',
				'std' => 0.7,
				'type' => 'slider',
				'min' => 0,
				'max' => 1,
				'increment' => .01,
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'section' => 'styling',
				'tab' => 'overlay'
			),
		);

		$dslc_options = array_merge($dslc_options,$bg_options);

		$clock_border_options = array(
			array(
				'label' => __( 'Clock Border Color', 'dslc_string' ),
				'id' => 'clock_border_color',
				'std' => get_met_option('met_color'),
				'type' => 'color',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_clock',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => 'clock'
			),
			array(
				'label' => __( 'Clock Border Width', 'dslc_string' ),
				'id' => 'clock_border_style',
				'std' => 5,
				'type' => 'slider',
				'min' => 0,
				'max' => 20,
				'ext' => 'px',
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_clock',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'tab' => 'clock'
			),

			array(
				'label' => __( 'Clock Opacity', 'dslc_string' ),
				'id' => 'clock_border_opacity',
				'std' => 0.4,
				'type' => 'slider',
				'min' => 0,
				'max' => 1,
				'increment' => .1,
				'refresh_on_change' => true,
				'affect_on_change_el' => '.met_clock',
				'affect_on_change_rule' => 'opacity',
				'section' => 'styling',
				'tab' => 'clock'
			),
		);

		$dslc_options = array_merge($dslc_options,$clock_border_options);

        $dslc_options = array_merge( $dslc_options, $this->presets_options() );
		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

    }

    function output( $options ) {

        global $dslc_active;

        if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
            $dslc_is_admin = true;
        else
            $dslc_is_admin = false;


        $this->module_start( $options );
        /* Module output starts here */

		$args = array(
			'posts_per_page' => 1,
			'p' => $options['event_id'],
			'post_type' => 'tribe_events'
		);
		$dslc_query = new WP_Query($args);

        $elementID = uniqid('timedpostbox_');

		$overlay_background_style_atts = 'style="background-color:rgba('.lc_clean_rgb($options['box_background_color']).','.$options['box_background_color_alpha'].')"';
        ?>

		<?php if ( class_exists( 'TribeEvents' ) ): ?>
			<?php if ( $dslc_query->have_posts() ) : ?>
				<?php while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); ?>
					<?php
						/**
						 * Manual Resize
						 */

						$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
						$thumb_url = $thumb_url[0];
                        $resizedImage['url'] = '';

                        if ( ! empty( $thumb_url ) ) :
                            $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);
                        endif;

						/* Event Start Date */
						$event_date_data = tribe_get_start_date(null,false,$options['date_format']);
						$event_date_data = str_replace('am','',$event_date_data);
						$event_date_data = str_replace('pm','',$event_date_data);

					?>
					<div class="met_timed_post_box">
						<?php if(!empty( $thumb_url )): ?>
						<a href="<?php the_permalink() ?>" class="met_timed_post_box_preview">
                            <img src="<?php echo $resizedImage['url'] ?>" alt="<?php echo esc_attr(get_the_title()) ?>" />
							<div class="met_timed_post_box_preview_overlay" <?php echo $overlay_background_style_atts ?>>
								<div class="met_clock">
									<span class="hand second"></span>
								</div>
							</div>
						</a>
						<?php endif; ?>
						<div class="met_timed_post_box_details">
							<a href="<?php the_permalink() ?>" class="met_timed_post_box_title"><?php the_title() ?></a>
							<div class="met_timed_post_box_time"><span><?php echo $event_date_data ?></div>
						</div>
					</div>
				<?php endwhile; wp_reset_query(); ?>

			<?php
			else : //there is no event

				if ( $dslc_is_admin ) :
					?><div class="dslc-notification dslc-red">You do not have events at the moment. Go to <strong>WP Admin &rarr; Events</strong> to add some. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
				endif;

			endif;
			?>

		<?php
		else : //event calendar plugin is not exist

			if ( $dslc_is_admin ) :
				?><div class="dslc-notification dslc-red">You do not have Event Calendar Plugin installed at the moment. You need to install it to use this module. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
			endif;

		endif;
		?>

        <?php

        /* Module output ends here */
        $this->module_end( $options );

    }

}