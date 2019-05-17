<?php

// Register Module
function register_imgpost_module() {
	return dslc_register_module( "MET_ImagePost" );
}
add_action('dslc_hook_register_modules','register_imgpost_module');

class MET_ImagePost extends DSLC_Module {

    var $module_id = 'MET_ImagePost';
    var $module_title = 'Featured Image';
    var $module_icon = 'info';
    var $module_category = 'met - posts';

    function options() {

		$dslc_options = array(
			/**
			 * Click to Edit Contents
			 */
			array(
				'label' => 'Second Title',
				'id' => 'second_title',
				'std' => 'CLICK TO EDIT',
				'type' => 'text',
				'visibility' => 'hidden'
			),

			/**
			 * Elements Visibility Options
			 */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => 'title second_title content',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Title', 'dslc_string' ),
						'value' => 'title'
					),
					array(
						'label' => __( 'Second Title', 'dslc_string' ),
						'value' => 'second_title'
					),
					array(
						'label' => __( 'Content', 'dslc_string' ),
						'value' => 'content'
					),
				)
			),
			array(
				'label' => __( 'Post ID', 'dslc_string' ),
				'id' => 'pid',
				'std' => '',
				'type' => 'text'
			),

			/**
			 * Image Options
			 */
			array(
				'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
				'id' => 'thumb_resize_height',
				'std' => '',
				'type' => 'text'
			),
            array(
                'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
			array(
				'label' => __( 'Crop Thumbnail', 'dslc_string' ),
				'id' => 'thumb_crop',
				'std' => true,
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => true
					),
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => false
					),
				)
			),

			array(
				'label' => __( 'Content Source', 'dslc_string' ),
				'id' => 'content_source',
				'std' => true,
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Excerpt', 'dslc_string' ),
						'value' => 'excerpt'
					),
					array(
						'label' => __( 'Content', 'dslc_string' ),
						'value' => 'content'
					),
				),
				'tab' => 'content'
			),
			array(
				'label' => __( 'Trim Html', 'dslc_string' ),
				'id' => 'trim_html',
				'std' => true,
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Enabled', 'dslc_string' ),
						'value' => true
					),
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => false
					),
				),
				'tab' => 'content'
			),
			array(
				'label' => __( 'Content Length ( amount of words )', 'dslc_string' ),
				'id' => 'excerpt_length',
				'std' => 55,
				'type' => 'text',
				'tab' => 'content'
			),

			array(
				'label' => __( 'Second Title Source', 'dslc_string' ),
				'id' => 'second_title_source',
				'std' => 'date',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Date', 'dslc_string' ),
						'value' => 'date'
					),
					array(
						'label' => __( 'Custom Text', 'dslc_string' ),
						'value' => 'custom'
					),
				),
				'tab' => 'second title'
			),

			array(
				'label' => __( 'Caption Overlay Color', 'dslc_string' ),
				'id' => 'caption_bg_color',
				'std' => '#000000',
				'type' => 'color',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'section' => 'styling',
				'tab' => 'caption'
			),
			array(
				'label' => __( 'Caption Overlay Opacity', 'dslc_string' ),
				'id' => 'caption_bg_color_opacity',
				'std' => '40',
				'min' => '0',
				'max' => '100',
				'type' => 'slider',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'section' => 'styling',
				'tab' => 'caption'
			),

			array(
				'label' => __( 'Content Overlay Color', 'dslc_string' ),
				'id' => 'content_bg_color',
				'std' => '#000000',
				'type' => 'color',
				'section' => 'styling',
				'tab' => 'content',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
			),
			array(
				'label' => __( 'Content Overlay Opacity', 'dslc_string' ),
				'id' => 'content_bg_color_opacity',
				'std' => '40',
				'min' => '0',
				'max' => '100',
				'type' => 'slider',
				'tab' => 'content',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'section' => 'styling',
			),
		);

		$dslc_options = array_merge(
			$dslc_options,

			// Wrapper
			lc_margins('.met_image_post', '', array('t' => '', 'r' => '', 'b' => '', 'l' => '')),

			// Caption Paddings
			lc_paddings('.met_image_post_titles', 'Caption', array('t' => '20', 'r' => '20', 'b' => '20', 'l' => '20')),

			// Title
			lc_general('.met_image_post_titles h4', 'Title', array('color' => '#FFFFFF','font-size' => '36','line-height' => '43','font-weight' => '600'), 'Title'),

			// Date
			lc_general('.met_image_post_titles h5', 'Second Title', array('color' => '','font-size' => '18','line-height' => '22','font-weight' => '600'), 'Second Title'),

			// Content
			lc_general('.met_image_post_caption .met_p', 'content', array('color' => '#FFFFFF','font-size' => '14','line-height' => '22','font-weight' => '400'), 'Content'),

			// Content Paddings
			lc_paddings('.met_image_post_caption .met_p', 'content', array('t' => '20', 'r' => '20', 'b' => '20', 'l' => '20'))


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

        $elementID = uniqid('imagepost_');

		$args = array(
			'posts_per_page' 	=> 1,
			'p' 				=> $options['pid'],
			'post_type' 		=> 'any'
		);

		$dslc_query = new WP_Query($args);

		if($options['caption_bg_color_opacity'] == '100'){
			$caption_bg_color_opacity = 1;
		}elseif($options['caption_bg_color_opacity'] == '0'){
			$caption_bg_color_opacity = 0;
		}else{
			$caption_bg_color_opacity = '0.'.$options['caption_bg_color_opacity'];
		}

		$caption_style_atts = '';
		$caption_style_atts .= 'style="';
		$caption_style_atts .= 'background-color:rgba('.hex2rgb(lc_rgb_to_hex($options['caption_bg_color'])).','.$caption_bg_color_opacity.');';
		$caption_style_atts .= '"';

		if($options['content_bg_color_opacity'] == '100'){
			$content_bg_color_opacity = 1;
		}elseif($options['content_bg_color_opacity'] == '0'){
			$content_bg_color_opacity = 0;
		}else{
			$content_bg_color_opacity = '0.'.$options['content_bg_color_opacity'];
		}

		$content_style_atts = '';
		$content_style_atts .= 'style="';
		$content_style_atts .= 'background-color:rgba('.hex2rgb(lc_rgb_to_hex($options['content_bg_color'])).','.$content_bg_color_opacity.');';
		$content_style_atts .= '"';
        ?>

		<?php
		if ( $dslc_query->have_posts() ){
			while ( $dslc_query->have_posts() ) : $dslc_query->the_post();

				$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				$thumb_url = $thumb_url[0];
                $resizedImage['url'] = '';

                if(!empty($thumb_url))
                    $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);


				if($options['content_source'] == 'excerpt'){
					$content_text = wp_trim_words( get_the_excerpt(), $options['excerpt_length'] );
				}else{
					$content_text = wp_trim_words( get_the_content(), $options['excerpt_length'] );
				}

				if($options['trim_html']) wp_strip_all_tags($content_text);

                if( !empty($resizedImage['url']) ){ ?>

                    <a id="<?php echo $elementID ?>" class="met_image_post" href="<?php the_permalink(); ?> <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
                        <img src="<?php echo $resizedImage['url'] ?>" alt="<?php esc_attr(get_the_title()) ?>" />
                        <div class="met_image_post_caption" <?php echo $content_style_atts ?>>
                            <div class="met_image_post_titles" <?php echo $caption_style_atts ?>>

                            <?php if( in_array( 'title', $elements ) ) : ?>
                                <h4><?php the_title() ?></h4>
                            <?php endif; ?>

                            <?php if( in_array( 'second_title', $elements ) ) : ?>
                                <?php if($options['second_title_source'] == 'date'): ?>
                                <h5 class="met_color"><?php the_time( get_option( 'date_format' ) ); ?></h5>
                                <?php endif; ?>

                                <?php if($options['second_title_source'] == 'custom'): ?>
                                    <?php if( $dslc_is_admin ): ?>
                                        <h5 class="met_color dslca-editable-content" data-id="second_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['second_title']); ?></h5>
                                    <?php elseif( !empty($options['second_title'] ) && !$dslc_is_admin): ?>
                                        <h5 class="met_color"><?php echo stripslashes($options['second_title']); ?></h5>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>

                            </div>
                            <?php if( in_array( 'content', $elements ) ) : ?>
                            <div class="met_p"><?php echo $content_text; ?></div>
                            <?php endif; ?>
                        </div>
                    </a>
                    <?php echo $met_shared_options['script'];
                }else if( $dslc_is_admin ){ ?>
                    <div class="met_latest_blog_box clearfix"><div class="dslc-notification dslc-red">This module needs a Featured Image of the post. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></div></div><?php
                }
            endwhile;
		}else{
			if ( $dslc_is_admin ): ?>
				<div class="met_latest_blog_box clearfix"><div class="dslc-notification dslc-red">You do not have any post associated with this ID at the moment. Go to <strong>WP Admin</strong> to add some or make sure you get the right ID number. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></div></div><?php
            endif;
		}

        /* Module output ends here */
		wp_reset_query();
        $this->module_end( $options );
    }
}