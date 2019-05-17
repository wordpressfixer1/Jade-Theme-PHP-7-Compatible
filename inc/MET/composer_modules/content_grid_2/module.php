<?php
// Register Module
function register_cgtwo_module() {
    return dslc_register_module( "MET_ContentGrid2" );
}
add_action('dslc_hook_register_modules','register_cgtwo_module');

class MET_ContentGrid2 extends DSLC_Module {

	var $module_id = 'MET_ContentGrid2';
	var $module_title = 'Showcase Masonry 2';
	var $module_icon = 'pencil';
	var $module_category = 'met - post grids';

	function options() {

        $post_type_categoryArgs = categoryArgs('', '', 1);

		// Options
        $dslc_options = array(
			array(
				'label' => __( 'Post Type', 'dslc_string' ),
				'id' => 'post_type',
				'std' => $post_type_categoryArgs[0]['value'],
				'type' => 'select',
				'choices' => $post_type_categoryArgs
			),
            array(
                'label' => __( 'Category IDs [Seperate with "," Comma]', 'dslc_string' ),
                'id' => 'category_ids',
                'std' => '',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Filter', 'dslc_string' ),
                'id' => 'filters',
                'std' => 'disabled',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => __( 'Disabled', 'dslc_string' ),
                        'value' => 'disabled',
                    ),
                    array(
                        'label' => __( 'On Breadcrumb', 'dslc_string' ),
                        'value' => 'on_breadcrumb',
                    ),
                    array(
                        'label' => __( 'Classic', 'dslc_string' ),
                        'value' => 'classic',
                    )
                ),
            ),
			array(
				'label' => __( 'Posts Per Page', 'dslc_string' ),
				'id' => 'amount',
				'std' => '6',
				'type' => 'text',
			),
			array(
				'label' => __( 'Pagination', 'dslc_string' ),
				'id' => 'pagination_type',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'dslc_string' ),
						'value' => 'disabled',
					),
					array(
						'label' => __( 'Numbered', 'dslc_string' ),
						'value' => 'numbered',
					)
				),
			),
			array(
				'label' => __( 'Posts Per Row', 'dslc_string' ),
				'id' => 'columns',
				'std' => '2',
				'type' => 'select',
				'choices' => array(
                    array(
                        'label' => '6',
                        'value' => '6',
                    ),
                    array(
                        'label' => '4',
                        'value' => '4',
                    ),
                    array(
                        'label' => '3',
                        'value' => '3',
                    ),
                    array(
                        'label' => '2',
                        'value' => '2',
                    ),
                    array(
                        'label' => '1',
                        'value' => '1',
                    ),
                ),
			),
			array(
				'label' => __( 'Order By', 'dslc_string' ),
				'id' => 'orderby',
				'std' => 'date',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Publish Date', 'dslc_string' ),
						'value' => 'date'
					),
					array(
						'label' => __( 'Modified Date', 'dslc_string' ),
						'value' => 'modified'
					),
					array(
						'label' => __( 'Random', 'dslc_string' ),
						'value' => 'rand'
					),
					array(
						'label' => __( 'Alphabetic', 'dslc_string' ),
						'value' => 'title'
					),
					array(
						'label' => __( 'Comment Count', 'dslc_string' ),
						'value' => 'comment_count'
					),
				)
			),
			array(
				'label' => __( 'Order', 'dslc_string' ),
				'id' => 'order',
				'std' => 'DESC',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Ascending', 'dslc_string' ),
						'value' => 'ASC'
					),
					array(
						'label' => __( 'Descending', 'dslc_string' ),
						'value' => 'DESC'
					)
				)
			),
            array(
                'label' => __( 'Grid Gap', 'dslc_string' ),
                'id' => 'grid_gap',
                'std' => '',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => __( 'Default', 'dslc_string' ),
                        'value' => ''
                    ),
                    array(
                        'label' => __( 'No Gap', 'dslc_string' ),
                        'value' => 'no_gap'
                    )
                )
            ),
			array(
				'label' => __( 'Offset', 'dslc_string' ),
				'id' => 'offset',
				'std' => '0',
				'type' => 'text',
			),

            /**
             * Image Options
             */
            array(
                'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '570',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '570',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '380',
                'type' => 'text'
            ),

			/* Styling */

            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'thumbnail title categories first_icon_link second_icon_link',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Thumbnail', 'dslc_string' ),
                        'value' => 'thumbnail'
                    ),
                    array(
                        'label' => __( 'Title', 'dslc_string' ),
                        'value' => 'title'
                    ),
                    array(
                        'label' => __( 'Categories', 'dslc_string' ),
                        'value' => 'categories'
                    ),
                    array(
                        'label' => __( 'First Icon Link', 'dslc_string' ),
                        'value' => 'first_icon_link'
                    ),
                    array(
                        'label' => __( 'Second Icon Link', 'dslc_string' ),
                        'value' => 'second_icon_link'
                    ),
                ),
                'section' => 'styling',
            ),

		);

        $dslc_options = array_merge(
            $dslc_options,

            // Box
            lc_general('.met_portfolio_item_details_2', 'Detail Box', array('background-color' => '')),

            // Box Paddings
            lc_paddings('.met_portfolio_item_details_2', 'Detail Box'),

            // Box Borders
            lc_borders('.met_portfolio_item_details_2', 'Detail Box', array(), array(), '0', '#000000', 'solid' ),

            // Box Border Radius
            lc_borderRadius('.met_portfolio_item_details_2', 'Detail Box'),


            // Title And Category Box
            lc_general('.met_portfolio_item_details_2_title_cats', 'Title And Category Box', array('background-color' => '')),

            // Title And Category Box Paddings
            lc_paddings('.met_portfolio_item_details_2_title_cats', 'Title And Category Box', array('t' => '20', 'r' => '20', 'b' => '20', 'l' => '20')),

            // Title And Category Box Borders
            lc_borders('.met_portfolio_item_details_2_title_cats', 'Title And Category Box', array(), array(), '0', '#000000', 'solid' ),

            // Title And Category Box Border Radius
            lc_borderRadius('.met_portfolio_item_details_2_title_cats', 'Title And Category Box'),

            // Title
            lc_general('.met_portfolio_item_title h3', 'Title', array('color' => '', 'color:hover' => '','font-size' => '18','line-height' => '20','font-weight' => '400')),

            // Categories
            lc_general('.met_portfolio_item_categories, .met_portfolio_item_categories a', 'Category Links', array('color' => '', 'font-size' => '12','line-height' => '22')),

            // Icon Links
            lc_general('.met_portfolio_item_links a', 'Icon Links', array('color' => '', 'color:hover' => '', 'font-size' => '18')),

            // Icon Links
            lc_general('.first_icon_link', 'Icon Links', array('background-color' => '','background-color:hover' => ''), 'First Icon'),

            lc_general('.second_icon_link', 'Icon Links', array('background-color' => '','background-color:hover' => ''), 'Second Icon'),

            // Classic Filter
            lc_general('.met_filters li a', 'Classic Filter', array('color' => '', 'color:hover' => '', 'background-color' => '', 'background-color:hover' => '', 'font-size' => '15','line-height' => '22')),

            lc_general('.met_filters li a.activePortfolio', 'Classic Filter', array('color' => '', 'color:hover' => '', 'background-color' => '', 'color:hover' => '','font-size' => '15','line-height' => '22'), 'Active Item')
        );

		$dslc_options = met_lc_extras($dslc_options, array('animation'), 'shared_options');

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
		//$met_lc_animation = ($options['parallax_activation'],$options['parallax_speed'],$options['parallax_vertical_offset'],$dslc_is_admin, $options['met_css_anim'], $options['met_css_anim_duration'], $options['met_css_anim_delay'], $options['met_css_anim_offset'], true, false, true, true);

		$met_shared_options = met_lc_extras( $options, array(
			'groups'   => array('animation'),
			'params'   => array(
				'js'           => true,
				'css'          => false,
				'external_run' => true,
				'is_grid'      => true,
			),
			'is_admin' => $dslc_is_admin,
		), 'shared_options_output' );

		$asyncScripts = "[]";
        if ( $dslc_is_admin ){
            $asyncScripts = '["'.get_template_directory_uri().'/js/imagesLoaded.js","'.get_template_directory_uri().'/js/isotope.js"'.$met_shared_options['js'].']';
        }else{
            wp_enqueue_script('metcreative-isotope');
            wp_enqueue_script('metcreative-imagesLoaded');

            if( $met_shared_options['activity'] ){
                wp_enqueue_script('metcreative-wow');
                wp_enqueue_style('metcreative-animate');
            }
        }
		/* CUSTOM START */

		if ( ! isset( $options['excerpt_length'] ) ) $options['excerpt_length'] = 20;

		/**
		 * Query
		 */

			// Fix for pagination
            if ( isset( $options['pagination_type'] ) && $options['pagination_type'] == 'numbered' ) {
                if( is_front_page() ) { $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; } else { $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; }
            }else{
                $paged = 1;
            }

            $options['amount'] = $options['amount'] == '' ? -1 : $options['amount'];
			// General args
			$args = array(
				'paged' => $paged,
				'post_type' => $options['post_type'],
				'posts_per_page' => $options['amount'],
				'order' => $options['order'],
				'orderby' => $options['orderby'],
				'offset' => $options['offset']
			);

            // Category args
            if($options['post_type'] != 'post'){
                $args = array_merge($args, categoryArgs($options['post_type'], $options['category_ids']));
            }else{
                if(!empty($options['category_ids'])) $args['category__in'] = explode(' ', $options['category_ids']);
            }

			// Do the query
			$dslc_query = new WP_Query( $args );

		/**
		 * Elements to show
		 */

			// Main Elements
			$elements = $options['elements'];
			if ( ! empty( $elements ) )
				$elements = explode( ' ', trim( $elements ) );
			else
				$elements = 'all';

		/**
		 * Columns
		 */
			switch ( $options['columns'] ) {
                case 6 :
                    $columns = 2;
                    break;
				case 4 :
					$columns = 3;
					break;
				case 3 :
                    $columns = 4;
					break;
				case 2 :
                    $columns = 6;
					break;
				case 1 :
                    $columns = 12;
                    break;
				default:
                $columns = 4;
					break;
			}

		/**
		 * Posts ( output )
		 */

			if ( $dslc_query->have_posts() ) {

                $taxonomyStack = array();
                $grid = uniqid('grid_');
				?><div id="<?php echo $grid; ?>" class="row met_portfolio grid isotope columns_<?php echo $options['columns']; ?> <?php echo $options['grid_gap']; ?> effect-<?php echo $met_shared_options['animation'].' '.$met_shared_options['grid_check']; ?>" data-unique-class="<?php echo $met_shared_options['uniqueClass']; ?>"><?php

					while ( $dslc_query->have_posts() ) : $dslc_query->the_post();
						$taxonomies = array();
						if($options['post_type'] != 'post'){
							$tax_obj_names = get_object_taxonomies( get_post()->post_type, 'names' );
							$taxCats = get_the_terms(get_the_ID(), end($tax_obj_names));
							if($taxCats){
								foreach( get_the_terms(get_the_ID(), end($tax_obj_names)) as $k => $v ):
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
						?>

						<div class="col-md-<?php echo $columns; ?> met_portfolio_item met_isotope_item <?php if(!empty($taxonomies)){foreach($taxonomies as $taxonomy) echo $taxonomy['slug'].' ';} ?> <?php echo $met_shared_options['classes'].' '.$met_shared_options['uniqueClass']; ?>" <?php echo $met_shared_options['data-']; ?>>
                            <?php
                            $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                            $thumb_url = $thumb_url[0];
                            $resizedImage['url'] = '';

                            if ( ! empty( $thumb_url ) ) :
                                $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']);
                            endif;
                            ?>

							<?php if ( ($elements == 'all' || in_array( 'thumbnail', $elements )) && !empty($thumb_url) ) : ?>
                                <a href="<?php the_permalink(); ?>" class="met_portfolio_item_preview"><img src="<?php echo $resizedImage['url']; ?>" alt="<?php the_title(); ?>" /></a>
							<?php endif; ?>

                            <div class="met_portfolio_item_details_2 clearfix">
                                <?php if ( $elements == 'all' || in_array( 'title', $elements ) || in_array( 'categories', $elements ) ) : ?>
                                    <div class="met_portfolio_item_details_2_title_cats">
                                        <?php if ( $elements == 'all' || in_array( 'title', $elements ) ) : ?>
                                            <a href="<?php the_permalink(); ?>" class="met_portfolio_item_title"><h3><?php the_title(); ?></h3></a>
                                        <?php endif; ?>
                                        <?php if( ($elements == 'all' || in_array( 'categories', $elements )) && !empty($taxonomies) ) : ?>
                                            <div class="met_portfolio_item_categories">
                                                <?php
                                                $categories = array();
                                                foreach($taxonomies as $category)
                                                    $categories[] = '<a href="'.(array_key_exists('link',$category) ? $category['link'] : get_term_link( $category["slug"], $category["taxonomy"] )).'" class="met_color2">'.$category["name"].'</a>';

                                                echo implode(', ',$categories);
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <?php

                                $secondLinkWidth = '';
                                if ( $elements != 'all' && !in_array( 'first_icon_link', $elements ) ){
                                    $secondLinkWidth = 'style="width: 100%;"';
                                }

                                $firstLinkWidth = '';
                                if ( $elements != 'all' && !in_array( 'second_icon_link', $elements ) ){
                                    $firstLinkWidth = 'style="width: 100%;"';
                                }


                                $lbBox = $media_file = '';
                                $mfp_src = uniqid('u_');
                                $media_type = rwmb_meta('met_content_media_type');

                                $linkBox = ( $elements == 'all' || in_array( 'first_icon_link', $elements ) ) ? '<a href="'.get_permalink().'" class="met_vcenter first_icon_link" '.$firstLinkWidth.'><i class="dslc-icon dslc-icon-link"></i></a>' : '';
                                $secondLinkIf = ( $elements == 'all' || in_array( 'second_icon_link', $elements ) );

                                if($secondLinkIf){
	                                switch($media_type):
		                                case 'html5_video':
			                                $mp4     = rwmb_meta('met_html5_video_file_mp4','type=file_advanced');
			                                $webm    = rwmb_meta('met_html5_video_file_webm','type=file_advanced');
			                                $ogg     = rwmb_meta('met_html5_video_file_ogv','type=file_advanced');
			                                $loop    = rwmb_meta('met_html5_media_loop');
			                                $autoplay= rwmb_meta('met_html5_media_autoplay');

			                                $media_file['mp4']      = !empty($mp4)      ? $mp4[key($mp4)]['url']   : '';
			                                $media_file['webm']     = !empty($webm)     ? $webm[key($webm)]['url'] : '';
			                                $media_file['ogg']      = !empty($ogg)      ? $ogg[key($ogg)]['url']   : '';
			                                $media_file['loop']     = !empty($loop)     ? $loop : 'false';
			                                $media_file['autoplay'] = !empty($autoplay) ? $autoplay : 'false';

			                                $lbBox = '<a href="#" class="met_vcenter second_icon_link" rel="inline_lb_'.$mfp_src.'" data-mfp-src="#'.$mfp_src.'" '.$secondLinkWidth.'><i class="dslc-icon dslc-icon-play-circle"></i></a>'; ?>

			                                <div id="<?php echo $mfp_src; ?>" class="mfp-hide met_vcenter"><?php do_action('met_wp_video_shortcode', $media_file); ?></div><?php
			                                break;

		                                case 'html5_audio':
			                                $mp3     = rwmb_meta('met_html5_audio_file_mp3','type=file_advanced');
			                                $loop    = rwmb_meta('met_html5_media_loop');
			                                $autoplay= rwmb_meta('met_html5_media_autoplay');

			                                $media_file['mp3']      = !empty($mp3)      ? $mp3[key($mp3)]['url']   : '';
			                                $media_file['loop']     = !empty($loop)     ? $loop : 'false';
			                                $media_file['autoplay'] = !empty($autoplay) ? $autoplay : 'false';

			                                $lbBox = '<a href="#" class="met_vcenter second_icon_link" rel="inline_lb_'.$mfp_src.'" data-mfp-src="#'.$mfp_src.'" '.$secondLinkWidth.'><i class="dslc-icon dslc-icon-volume-up"></i></a>'; ?>

			                                <div id="<?php echo $mfp_src; ?>" class="mfp-hide met_vcenter"><?php do_action('met_wp_audio_shortcode', $media_file); ?></div><?php
			                                break;

		                                case 'slider':
			                                $slider_images = rwmb_meta('met_slider_images','type=plupload_image');

			                                if(count($slider_images) > 0) $firstItem = reset($slider_images);

			                                $lbBox = '<a href="'.$firstItem['full_url'].'" class="met_vcenter second_icon_link" rel="lb_portfolio_'.$mfp_src.'" '.$secondLinkWidth.'><i class="dslc-icon dslc-icon-picture-o"></i></a>'; ?>

			                                <div class="met_portfolio_item_lightbox_content">
			                                <?php
			                                if(count($slider_images) > 0){
				                                $g='f';
				                                foreach($slider_images as $slider_image){
					                                if($g != 'f') echo '<a href="'.$slider_image['full_url'].'" title="'.esc_attr($slider_image['title']).'" rel="lb_portfolio_'.$mfp_src.'"></a>';
					                                $g = 'z';
				                                }
			                                }
			                                ?>
			                                </div><?php
			                                break;

		                                case 'oembed':
			                                $lbBox = '<a href="#" class="met_vcenter second_icon_link" rel="inline_lb_'.$mfp_src.'" data-mfp-src="#'.$mfp_src.'" '.$secondLinkWidth.'><i class="dslc-icon dslc-icon-play"></i></a>'; ?>

			                                <div id="<?php echo $mfp_src; ?>" class="mfp-hide met_vcenter"><?php echo wp_oembed_get(rwmb_meta('met_oembed_link')); ?></div><?php
			                                break;
	                                endswitch;
                                }

                                if( empty($media_type) && !empty($thumb_url) && $secondLinkIf ){
                                    $lbBox = '<a href="'.$thumb_url.'" class="met_vcenter second_icon_link" rel="lb_portfolio_'.$mfp_src.'" title="'.esc_attr(get_the_title()).'" '.$secondLinkWidth.'><i class="dslc-icon dslc-icon-search"></i></a>';
                                }
                                if( $linkBox != '' || $lbBox != '' ){ ?><div class="met_portfolio_item_links"><?php echo $linkBox.$lbBox; ?></div><!-- .met_portfolio_item_links --><?php } ?>

                            </div><!-- .met_portfolio_item_details -->

						</div><!-- .met_portfolio_item -->

						<?php

					endwhile;

				?></div><!-- .dslc-cpt-posts -->
                <script>
                    jQuery(function(){
                        <?php if( $dslc_is_admin ): ?>CoreJS.lightbox();<?php endif; ?>
                        <?php $async_callBacks = '["theGrid|'.$grid.'"]';  ?>

                        CoreJS.loadAsync(<?php echo $asyncScripts; ?>,<?php echo $async_callBacks; ?>);

                        <?php if( $options["filters"] == 'on_breadcrumb' || $options["filters"] == 'classic' ): ?>
                        if(jQuery('.<?php echo $grid; ?>_filters_bind').get(0)) jQuery('.<?php echo $grid; ?>_filters_bind').remove();
                        CoreJS.insertFilterInBreadcrumb('<?php echo $grid; ?>', '<?php echo 'All//*(split)'; if(!empty($taxonomyStack)){foreach($taxonomyStack as $taxonomy) echo $taxonomy['name'].'//'.$taxonomy['slug'].'(split)';} ?>','<?php echo $options["filters"]; ?>');
                        <?php endif; ?>
                    });
                </script>
                <?php echo $met_shared_options['script']; ?>
            <?php
			} else {

				if ( $dslc_is_admin ) :
					?><div class="dslc-notification dslc-red">You do not have any posts of that post type at the moment. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
				endif;

			}

		/**
		 * Pagination
		 */

			if ( isset( $options['pagination_type'] ) && $options['pagination_type'] == 'numbered' ) {
				$num_pages = $dslc_query->max_num_pages;
                met_post_pagination( array( 'pages' => $num_pages ) );
			}

		wp_reset_query();
		$this->module_end( $options );

	}

}