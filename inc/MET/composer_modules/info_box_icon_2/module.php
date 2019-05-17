<?php

// Register Module
function register_iboxicontwo_module() {
	return dslc_register_module( "MET_InfoBoxIcon2" );
}
add_action('dslc_hook_register_modules','register_iboxicontwo_module');

class MET_InfoBoxIcon2 extends DSLC_Module {

    var $module_id = 'MET_InfoBoxIcon2';
    var $module_title = 'Half InfoBox Icon';
    var $module_icon = 'info';
    var $module_category = 'met - info boxes';

    function options() {

		$dslc_options = array(

			/**
			 * Click to Edit Contents
			 */
			array(
				'label' => __( 'Title', 'dslc_string' ),
				'id' => 'title',
				'std' => 'CLICK TO EDIT TITLE',
				'type' => 'text',
				'visibility' => 'hidden'
			),
			array(
				'label' => __( 'Content', 'dslc_string' ),
				'id' => 'content',
				'std' => 'Vivamus id nulla in nunc euismod laoreet. Nunc volutpat augue id hendrerit adipiscing. Morbi in massa quam.',
				'type' => 'textarea',
				'visibility' => 'hidden'
			),

			/**
			 * Elements Visibility Options
			 */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => 'icon title content',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Icon', 'dslc_string' ),
						'value' => 'icon'
					),
					array(
						'label' => __( 'Title', 'dslc_string' ),
						'value' => 'title'
					),
					array(
						'label' => __( 'Content', 'dslc_string' ),
						'value' => 'content'
					),
				)
			),

			/**
			 * General Options
			 */
			array(
				'label' => __( 'Icon', 'dslc_string' ),
				'id' => 'icon',
				'std' => 'cloud-download',
				'type' => 'icon',
			),

			array(
				'label' => __( 'Title Link URL', 'dslc_string' ),
				'id' => 'box_link_url',
				'std' => '#',
				'type' => 'text'
			),
			array(
				'label' => __( 'Open in', 'dslc_string' ),
				'id' => 'button_target',
				'std' => '_self',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Same Tab', 'dslc_string' ),
						'value' => '_self',
					),
					array(
						'label' => __( 'New Tab', 'dslc_string' ),
						'value' => '_blank',
					),
				)
			),


			array(
				'label' => __( 'Icon Hover Effect', 'dslc_string' ),
				'id' => 'icon_hover_effect',
				'std' => '',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'None', 'dslc_string' ),
						'value' => '',
					),
					array(
						'label' => __( 'Bottom -> Top', 'dslc_string' ),
						'value' => 'toBottomFromTop',
					),
					array(
						'label' => __( 'Top -> Bottom', 'dslc_string' ),
						'value' => 'toTopFromBottom',
					),
					array(
						'label' => __( 'Right -> Left', 'dslc_string' ),
						'value' => 'toRightFromLeft',
					),
					array(
						'label' => __( 'Left -> Right', 'dslc_string' ),
						'value' => 'toLeftFromRight',
					),
					array(
						'label' => __( 'Spin Around', 'dslc_string' ),
						'value' => 'spinAround',
					),
				)
			),

		);

		$dslc_options = array_merge(
			$dslc_options,

			// Box
			lc_general('.met_info_box_icon_2', '', array('background-color' => '#EFEDE9'), 'Box'),

			// Paddings
			lc_paddings('.met_info_box_icon_2', 'Paddings', array('t' => '', 'r' => '30', 'b' => '30', 'l' => '30')),

			// Box Borders
			lc_borders('.met_info_box_icon_2', 'Borders', array(), array(), '0', '#FFFFFF', 'solid' ),

			// Border Radius
			lc_borderRadius('.met_info_box_icon_2', 'Border Radius'),

			// Icon Wrapper
			lc_general('figcaption', 'Icon', array('text-align' => 'center'), 'Icon'),

			// Icon
			lc_general('figcaption span', 'Icon', array('width' => '80', 'height' => '80', 'font-size' => '47', 'line-height' => '80' , 'color' => '#FFFFFF','background-color' => ''), 'Icon'),

			// Border Radius
			lc_borderRadius('figcaption span', 'Icon', array('tl' => '100', 'tr' => '100', 'br' => '100', 'bl' => '100')),

			// Title
			lc_general('article > a h4', 'Title', array('color' => '','color:hover' => '','text-align' => 'center','font-size' => '18', 'line-height' => '19', 'font-weight' => '400')),

			// Content
			lc_general('.met_p', 'Content', array('text-align' => 'center','font-size' => '14', 'line-height' => '22','color' => '','text-shadow' => 'rgba(255,255,255,0)'))
		);

		$dslc_options = met_lc_extras($dslc_options, array('animation','parallax'), 'shared_options');

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

        /* Animation */
        

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

		// Main Elements
		$elements = $options['elements'];
		if ( ! empty( $elements ) )
			$elements = explode( ' ', trim( $elements ) );
		else
			$elements = array();

        ?>

		<figure class="met_info_box_icon_2 <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>

		<?php if( in_array( 'icon', $elements ) ) : ?>
			<figcaption>
				<span class="met_bgcolor"><i class="dslc-icon dslc-icon-<?php echo $options['icon'] ?> <?php echo $options['icon_hover_effect'] ?>"></i></span>
			</figcaption>
		<?php endif; ?>

			<article>
				<?php if( in_array( 'title', $elements ) ) : ?>
					<?php if( $dslc_is_admin ): ?>
						<a href="<?php echo $options['box_link_url'] ?>" target="<?php echo $options['button_target'] ?>"><h4 class="dslca-editable-content" data-id="title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['title']); ?></h4></a>
					<?php elseif( !empty($options['title'] ) && !$dslc_is_admin): ?>
						<a href="<?php echo $options['box_link_url'] ?>" target="<?php echo $options['button_target'] ?>"><h4><?php echo stripslashes($options['title']); ?></h4></a>
					<?php endif; ?>
				<?php endif; ?>

				<?php if( in_array( 'content', $elements ) ) : ?>
					<div style="text-shadow: -1px -1px 0 <?php echo $options['met_p_text_shadow'] ?>" class="met_p">

						<?php if ( $dslc_active ): ?> <div class="dslca-editable-content" data-id="content"> <?php endif; ?>

							<?php
								$output_content = stripslashes( $options['content'] );
								$output_content = do_shortcode( $output_content );
								echo $output_content;
							?>

						<?php if ( $dslc_active ) : ?></div> <div class="dslca-wysiwyg-actions-edit"><span class="dslca-wysiwyg-actions-edit-hook"><?php _e('Edit Content','dslc_string') ?></span></div> <?php endif; ?>

					</div>
				<?php endif; ?>
			</article>
		</figure>
        <?php echo $met_shared_options['script']; ?>
        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}