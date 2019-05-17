<?php

// Register Module
function register_imgposttwo_module() {
    return dslc_register_module( "MET_ImagePost2" );
}
add_action('dslc_hook_register_modules','register_imgposttwo_module');

class MET_ImagePost2 extends DSLC_Module {

    var $module_id = 'MET_ImagePost2';
    var $module_title = 'Featured Image 2';
    var $module_icon = 'info';
    var $module_category = 'met - posts';

    function options() {

		$dslc_options = array(

			/**
			 * Elements Visibility Options
			 */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => 'title categories',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Title', 'dslc_string' ),
						'value' => 'title'
					),
					array(
						'label' => __( 'Categories', 'dslc_string' ),
						'value' => 'categories'
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
		);

		$dslc_options = array_merge(
			$dslc_options,

			// Wrapper
			lc_margins('.met_image_post_2', '', array('t' => '', 'r' => '', 'b' => '', 'l' => '')),

            // Caption
            lc_general('.met_image_post_2_caption', 'Caption', array('background-color' => 'rgba(255,202,7,0.8)')),

			// Caption Paddings
			lc_paddings('.met_image_post_2_caption', 'Caption', '30'),

			// Title
			lc_general('.met_image_post_2_caption > a', 'Title', array('color' => '#373B3D', 'color:hover' => '#FFFFFF', 'font-size' => '24','line-height' => '33','font-weight' => '600')),

			// Categories
			lc_general('.met_image_post_2_categories a', 'Second Title', array('color' => '#FFFFFF', 'color:hover' => '#373B3D', 'font-size' => '14','line-height' => '22','font-weight' => '400'))
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

        $elementID = uniqid('imagepost2_');

		$args = array(
			'posts_per_page' 	=> 1,
			'p' 				=> $options['pid'],
			'post_type' 		=> 'any'
		);

		$dslc_query = new WP_Query($args);
        ?>

		<?php
		if ( $dslc_query->have_posts() ){ $taxonomyStack = array();
			while ( $dslc_query->have_posts() ) : $dslc_query->the_post();

                $taxonomies = array();
                if(get_post()->post_type != 'post'){
                    $obj_taxonomies = get_object_taxonomies( get_post()->post_type, 'names' );
                    $taxCats = get_the_terms(get_the_ID(), end($obj_taxonomies));
                    if($taxCats){
                        foreach( get_the_terms(get_the_ID(), end($obj_taxonomies)) as $k => $v ):
                            $taxonomies[$k] = array('name' => $v->name, 'slug' => $v->slug, 'taxonomy' => $v->taxonomy);
                            if(!array_key_exists($k,$taxonomyStack)) $taxonomyStack[$k] = array('name' => $v->name, 'slug' => $v->slug, 'taxonomy' => $v->taxonomy);
                        endforeach;
                    }
                }else{
                    foreach( get_the_category( get_the_ID() ) as $v ):
                        $taxonomies[$v->term_id] = array('name' => $v->name, 'slug' => $v->slug, 'taxonomy' => $v->taxonomy);
                        if(!array_key_exists($v->term_id,$taxonomyStack)) $taxonomyStack[$v->term_id] = array('name' => $v->name, 'slug' => $v->slug, 'taxonomy' => $v->taxonomy, 'link' => get_category_link( $v->term_id ));
                    endforeach;
                }

				$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				$thumb_url = $thumb_url[0];
                $resizedImage['url'] = '';

                if(!empty($thumb_url)) $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);

                if( !empty($resizedImage['url']) ) { ?>

                    <div id="<?php echo $elementID ?>" class="met_image_post_2 <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
                        <a href="<?php the_permalink(); ?>"><img src="<?php echo $resizedImage['url'] ?>" alt="<?php esc_attr(get_the_title()) ?>"/></a>

                        <div class="met_image_post_2_caption">

                            <?php if (in_array('title', $elements)) : ?>
                                <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                            <?php endif; ?>

                            <?php if (in_array('categories', $elements)) : ?>
                                <div class="met_image_post_2_categories">
                                    <?php
                                    $categories = array();
                                    $z = 0;
                                    foreach ($taxonomies as $category) {
                                        $z++;
                                        $categories[] = '<a href="' . (array_key_exists('link', $category) ? $category['link'] : get_term_link($category["slug"], $category["taxonomy"])) . '">' . $category["name"] . (count($taxonomies) != $z ? ' ,' : '') . '</a>';
                                    }
                                    echo implode('', $categories);
                                    ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <?php echo $met_shared_options['script'];
                }else if( $dslc_is_admin ){ ?>
                    <div class="met_latest_blog_box clearfix"><div class="dslc-notification dslc-red">This module needs a Featured Image of the post. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></div></div><?php
                }
            endwhile;
		}else{
			if ( $dslc_is_admin ): ?>
				<div class="met_latest_blog_box clearfix"><div class="dslc-notification dslc-red">You do not have any post associated with this ID at the moment. Go to <strong>WP Admin</strong> to add some or make sure you get the right ID number. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div></div><?php
			endif;
		}

        /* Module output ends here */
		wp_reset_query();
        $this->module_end( $options );
    }
}