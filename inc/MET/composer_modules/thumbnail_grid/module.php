<?php
// Register Module
function register_thumbgrid_module() {
	return dslc_register_module( "MET_ThumbnailGrid" );
}
add_action('dslc_hook_register_modules','register_thumbgrid_module');

class MET_ThumbnailGrid extends DSLC_Module {

	var $module_id = 'MET_ThumbnailGrid';
	var $module_title = 'Elegant Effected';
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
				'label' => __( 'Hover Effect', 'dslc_string' ),
				'id' => 'hover_effect',
				'std' => 'mixed',
				'type' => 'select',
				'choices' => met_lc_hover_effects(),
			),
			array(
				'label' => __( 'Posts Per Page', 'dslc_string' ),
				'id' => 'amount',
				'std' => '12',
				'type' => 'text',
			),
			array(
				'label' => __( 'Posts Per Row', 'dslc_string' ),
				'id' => 'columns',
				'std' => '3',
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
                    )
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
                'std' => 'no_gap',
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
                'label' => __( 'Excerpt Length', 'dslc_string' ),
                'id' => 'excerpt_length',
                'std' => '50',
                'type' => 'text',
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
                'std' => '369',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '467',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '467',
                'type' => 'text'
            ),

	        array(
		        'label' =>__( 'Thumbnail Opacity', 'dslc_string' ),
		        'id' => 'thumbnail_opacity',
		        'std' => 0.35,
		        'min' => 0,
		        'max' => 1.00,
		        'increment' => 0.05,
		        'type' => 'slider',
		        'section' => 'styling',
		        'refresh_on_change' => false,
		        'affect_on_change_el' => '.met_hover_effect .og-grid-link',
		        'affect_on_change_rule' => 'opacity',
	        )

			/* Styling */

           /* array(
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
            ),*/
		);

        $dslc_options = array_merge(
            $dslc_options,

            // Box
            lc_general('.og-expander', 'Detail Box', array('background-color' => '#DDDDDD')),

            // Box Paddings
            lc_paddings('.og-expander-inner', 'Detail Box', array('t' => '50', 'r' => '30', 'b' => '50', 'l' => '30')),

            // Thumbnail Title
            lc_general('.og-details h3', 'Detail Box', array('color' => '#393939', 'font-size' => '52'),'Title'),

            // Thumbnail Description
            lc_general('.og-details p', 'Detail Box', array('color' => '#999999', 'font-size' => '16', 'line-height' => '22'),'Description'),

            // Thumbnail Description Button
            lc_general('.og-details > a', 'Detail Box', array('color' => '#333333', 'color:hover' => '#393939', 'font-size' => '16', 'line-height' => '22', 'border-color' => '#333333'),'Description'),

            // Thumbnail BG
            lc_general('.met_hover_effect', '', array('background-color' => '#3085a3')),

            // Thumbnail Title
            lc_general('.met_hover_effect figcaption h2', 'Thumbnail Title', array('color' => '#FFFFFF', 'font-size' => '32','line-height' => '35')),

            // Thumbnail Summary
            lc_general('.met_hover_effect p', 'Thumbnail Summary', array('color' => '#FFFFFF', 'font-size' => '14','line-height' => '22')),

            // Thumbnail Border
            lc_general('.met_hover_effect.effect-roxy figcaption:before,.met_hover_effect.effect-bubba figcaption:before,.met_hover_effect.effect-bubba figcaption:after,.met_hover_effect.effect-layla figcaption:before,.met_hover_effect.effect-layla figcaption:after,.met_hover_effect.effect-oscar figcaption:before,.met_hover_effect.effect-ruby p,.met_hover_effect.effect-milo p,.met_hover_effect.effect-dexter figcaption:after,.met_hover_effect.effect-chico figcaption:before', 'Thumbnail Border', array('border-color' => '#FFFFFF'))


            /*// Icon Links
            lc_general('.met_portfolio_item_links', 'Icon Links', array('text-align' => 'center')),

            // Icon Links
            lc_general('.met_portfolio_item_links a', 'Icon Links', array('color' => '', 'color:hover' => '', 'font-size' => '18', 'width,height,line-height' => '45')),

            // Icon Links
            lc_general('.first_icon_link', 'Icon Links', array('background-color' => ''), 'First Icon'),

            lc_general('.second_icon_link', 'Icon Links', array('background-color' => ''), 'Second Icon'),

            // Classic Filter
            lc_general('.met_filters li a', 'Classic Filter', array('color' => '', 'color:hover' => '', 'background-color' => '', 'background-color:hover' => '', 'font-size' => '15','line-height' => '22')),

            lc_general('.met_filters li a.activePortfolio', 'Classic Filter', array('color' => '', 'color:hover' => '', 'background-color' => '', 'color:hover' => '','font-size' => '15','line-height' => '22'), 'Active Item')*/
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
				'external_run' => true,
				'is_grid'      => true,
			),
			'is_admin' => $dslc_is_admin,
		), 'shared_options_output' );

        $asyncScripts = "[]";
        if ( $dslc_is_admin ){
            $asyncScripts = $met_shared_options['js'];
        }else{
            if( $met_shared_options['activity'] ){
                wp_enqueue_script('metcreative-wow');
                wp_enqueue_style('metcreative-animate');
            }
        }

		/**
		 * Query
		 */
            $options['amount'] = $options['amount'] == '' ? -1 : $options['amount'];
			// General args
			$args = array(
				'paged' => 1,
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
			/*$elements = $options['elements'];
			if ( ! empty( $elements ) )
				$elements = explode( ' ', trim( $elements ) );
			else
				$elements = 'all';*/

		/**
		 * Posts ( output )
		 */
		 
		 $hover_effects = $options['hover_effect'] == 'mixed' ? met_lc_hover_effects(true) : $options['hover_effect'];
		
		if ( $dslc_query->have_posts() ) {
			$anim_delay = 0;
			if( $met_shared_options['activity'] && !empty($options['met_css_anim_delay_increment']) ){
			    
			    if( preg_match('/data-wow-delay="(\d.\d+)s"/', $met_shared_options['data-'], $anim_delay) && count($anim_delay) > 1 ){
				    $anim_delay_ = $anim_delay[1] * 1000;
			    }
			}

            $taxonomyStack = array();
            $grid = 'og-grid'/*uniqid('met_thumbnail_grid_')*/;
            $anim_delay_counter = 0;
			?><ul id="<?php echo $grid; ?>" class="og-grid met_thumbnail_grid <?php echo 'columns_'.$options['columns'].' '.$options['grid_gap']; ?>"><?php
				while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); ?>
					<li>
                        <?php
                        
                        if( $met_shared_options['activity'] && $anim_delay ){
                        	if( $anim_delay_counter == $options['columns'] ) $anim_delay_counter = 0;
                        	$anim_delay = ($options['met_css_anim_delay_increment'] * $anim_delay_counter + $anim_delay_)/1000;
                        	
                        	$met_shared_options['data-'] = preg_replace( '/data-wow-delay="(.*)"/', 'data-wow-delay="'.$anim_delay.'s"', $met_shared_options['data-']);
                        }
                        
                        
                        
                        $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                        $thumb_url = $thumb_url[0];
                        $resizedImage['url'] = '';
                        
                        $excerpt = wp_trim_words( get_the_excerpt(), $options['excerpt_length'] );
                        $short_excerpt = wp_trim_words( $excerpt, 5 );
                        
                        $title = get_the_title();
                        $parted_title = explode(' ', $title);
                        for($i = 0; $i < count($parted_title); $i++){
	                        if( $i % 2 != 0 ) $parted_title[$i] = '<span>'.$parted_title[$i].'</span>';
                        }
						$parted_title = implode(' ', $parted_title);
                        if ( ! empty( $thumb_url ) ) $resizedImage = imageResizing($thumb_url,$options['thumb_resize_height'],$options['thumb_resize_width_manual']); ?>
                        
						<figure class="met_hover_effect effect-<?php echo !is_array($hover_effects) ? $hover_effects : $hover_effects[array_rand($hover_effects)] ?> <?php if( $met_shared_options['activity'] ): ?>met_run_animations<?php endif; ?> <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
							<div class="met_hover_effect_preview_caption">
								<a class="og-grid-link" href="<?php the_permalink(); ?>" data-largesrc="<?php echo $thumb_url ?>" data-title="<?php echo $title; ?>" data-description="<?php echo $excerpt; ?>">
									<img src="<?php echo $thumb_url ?>" alt="img01"/>
								</a>
							</div>
							<figcaption>
								<h2><?php echo $parted_title; ?></h2>
								<p><?php echo $short_excerpt; ?></p>
							</figcaption>
						</figure>
					</li><!-- .met_portfolio_item -->
					<?php
					$anim_delay_counter++;
				endwhile;
			?></ul><!-- .dslc-cpt-posts -->
            <script>
                jQuery(function(){
                    <?php $async_callBacks = '[]'; ?>
                    CoreJS.loadAsync(<?php echo $asyncScripts; ?>,<?php echo $async_callBacks; ?>);
                });
            </script>
            <?php echo $met_shared_options['script']; ?>
        <?php
		} else {
			if ( $dslc_is_admin ) :
				?><div class="dslc-notification dslc-red">You do not have any posts of that post type at the moment. <span class="dslca-refresh-module-hook dslc-icon dslc-icon-refresh"></span></span></div><?php
			endif;
		}
		
		if ( isset( $options['pagination_type'] ) && $options['pagination_type'] == 'numbered' ) {
			$num_pages = $dslc_query->max_num_pages;
		    met_post_pagination( array( 'pages' => $num_pages ) );
		}

		wp_reset_query();
		$this->module_end( $options );

	}

}