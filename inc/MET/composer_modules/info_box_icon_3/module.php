<?php

// Register Module
function register_iboxthree_module() {
	return dslc_register_module( "MET_InfoBoxIcon3" );
}
add_action('dslc_hook_register_modules','register_iboxthree_module');

class MET_InfoBoxIcon3 extends DSLC_Module {

    var $module_id = 'MET_InfoBoxIcon3';
    var $module_title = 'Side Icon';
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

            array(
                'label' => __( 'Icon Box Position', 'dslc_string' ),
                'id' => 'icon_position',
                'std' => 'left',
                'type' => 'select',
                'section' => 'styling',
                'tab' => __( 'Icon', 'dslc_string' ),
                'choices' => array(
                    array(
                        'label' => __( 'Left', 'dslc_string' ),
                        'value' => 'left',
                    ),
                    array(
                        'label' => __( 'Right', 'dslc_string' ),
                        'value' => 'right'
                    ),
                ),
                'refresh_on_change' => true,
            ),

		);

		$dslc_options = array_merge(
			$dslc_options,

			// Box
			lc_general('.met_info_box_icon_3', '', array('background-color' => 'transparent'), 'Box'),
			lc_margins('.met_info_box_icon_3', '', array('t' => '', 'r' => '', 'b' => '', 'l' => '')),

			// Icon
			lc_general('figcaption', 'Icon', array('width' => '45', 'height' => '45', 'text-align' => 'center', 'font-size' => '24', 'line-height' => '45' , 'color' => '#373B3E','background-color' => '#EFEDE9'), 'Icon'),

			// Border Radius
			lc_borderRadius('figcaption', 'Icon', array('tl' => '10', 'tr' => '10', 'br' => '10', 'bl' => '10')),

            // Icon Borders
            lc_borders('figcaption', 'Icon', array(), array(), '0', '', 'solid' ),

			// Title
			lc_general('article > a', 'Title', array('color' => '','color:hover' => '','text-align' => '','font-size' => '18', 'line-height' => '19')),

			// Content
			lc_general('.met_p', 'Content', array('text-align' => '','font-size' => '14', 'line-height' => '22','color' => '','text-shadow' => '#FFFFFF')),

			// Paddings
			lc_margins('article', 'Content', array('t' => '', 'r' => '', 'b' => '', 'l' => '66'))
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

		<figure class="met_info_box_icon_3 clearfix <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
			<?php if( in_array( 'icon', $elements ) ) : ?>
				<figcaption class="<?php echo $options['icon_position']; ?>"><i class="dslc-icon dslc-icon-<?php echo $options['icon'] ?> <?php echo $options['icon_hover_effect'] ?>"></i></figcaption>
			<?php endif; ?>

			<article style="margin-<?php echo $options['icon_position']; ?>: <?php echo str_replace('px','',$options['igcaption_width']) + 20; ?>px; margin-<?php echo $options['icon_position'] == 'left' ? 'right' : 'left'; ?>: auto;">
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