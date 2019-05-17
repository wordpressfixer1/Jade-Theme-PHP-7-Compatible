<?php
// Register Module
function register_cgthree_module() {
    return dslc_register_module( "MET_ContentGrid3" );
}
add_action('dslc_hook_register_modules','register_cgthree_module');

class MET_ContentGrid3 extends DSLC_Module {

	var $module_id = 'MET_ContentGrid3';
	var $module_title = 'Informative Masonry';
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
				'std' => '12',
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
            array(
                'label' => __( 'Max Length ( amount of words )', 'dslc_string' ),
                'id' => 'excerpt_length',
                'std' => '20',
                'type' => 'text'
            ),

            /**
             * Image Options
             */
            array(
                'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '370',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '370',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '',
                'type' => 'text'
            ),

			/* Styling */

            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'thumbnail head title categories summary bottom social_share comments read_more',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Thumbnail', 'dslc_string' ),
                        'value' => 'thumbnail'
                    ),
                    array(
                        'label' => __( 'Head', 'dslc_string' ),
                        'value' => 'head'
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
                        'label' => __( 'Summary', 'dslc_string' ),
                        'value' => 'summary'
                    ),
                    array(
                        'label' => __( 'Bottom', 'dslc_string' ),
                        'value' => 'bottom'
                    ),
                    array(
                        'label' => __( 'Social Share', 'dslc_string' ),
                        'value' => 'social_share'
                    ),
                    array(
                        'label' => __( 'Comments', 'dslc_string' ),
                        'value' => 'comments'
                    ),
                    array(
                        'label' => __( 'Read More', 'dslc_string' ),
                        'value' => 'read_more'
                    ),
                ),
                'section' => 'styling',
            ),
		);

        $dslc_options = array_merge(
            $dslc_options,

            // Box
            lc_general('.met_portfolio_item_layout_5_details', 'Detail Box', array('background-color' => '')),

            // Box Borders
            lc_borders('.met_portfolio_item_layout_5_details', 'Detail Box', array(), array(), '0', '#000000', 'solid' ),

            // Box Border Radius
            lc_borderRadius('.met_portfolio_item_layout_5_details', 'Detail Box'),

            /*--------------*/

            // Head
            lc_general('header', 'Head', array('background-color' => '')),

            // Title
            lc_general('.met_portfolio_item_title h3', 'Head', array('color' => '', 'color:hover' => '','font-size' => '18','line-height' => '20'), 'Title'),

            // Categories
            lc_general('.met_portfolio_item_layout_5_details header div a', 'Head', array('color' => '', 'color:hover' => '', 'font-size' => '12','line-height' => '16'), 'Categories'),

            // Head Paddings
            lc_paddings('header', 'Head', array('t' => '20', 'r' => '30', 'b' => '20', 'l' => '30')),

            // Head Borders
            lc_borders('header', 'Head', array(), array(), '0', '#000000', 'solid' ),

            // Head Border Radius
            lc_borderRadius('header', 'Head'),

            /*--------------*/

            // Summary
            lc_general('.met_p', 'Summary', array('color' => '', 'font-size' => '14', 'line-height' => '22', 'text-shadow' => '')),

            // Summary Paddings
            lc_paddings('article', 'Summary', array('t' => '30', 'r' => '30', 'b' => '30', 'l' => '30')),

            // Summary Borders
            lc_borders('article', 'Summary', array(), array(), '0', '#000000', 'solid' ),

            // Summary Border Radius
            lc_borderRadius('article', 'Summary'),

            /*--------------*/

            // Footer
            lc_general('footer', 'Footer', array('background-color' => '')),

            // Footer Borders
            lc_borders('footer', 'Footer', array(
                't' => array('width' => '1', 'color' => 'rgba(0,0,0,0.05)', 'style' => 'solid'),
                'r' => array('width' => '', 'color' => '', 'style' => ''),
                'b' => array('width' => '', 'color' => '', 'style' => ''),
                'l' => array('width' => '', 'color' => '', 'style' => ''),
            ) ),

            // Footer Inner Box Paddings
            lc_paddings('footer section', 'Footer Inner Box', array('t' => '0', 'r' => '28', 'b' => '0', 'l' => '28')),

            // Footer Inner Box Borders
            lc_borders('footer section', 'Footer Inner Box', array(
                't' => array('width' => '', 'color' => '', 'style' => ''),
                'r' => array('width' => '1', 'color' => 'rgba(0,0,0,0.05)', 'style' => 'solid'),
                'b' => array('width' => '', 'color' => '', 'style' => ''),
                'l' => array('width' => '', 'color' => '', 'style' => ''),
            ) ),

            // Social Icons
            lc_general('.met_pf_item_socials a', 'Social Icons', array('color' => '', 'color:hover' => '', 'font-size' => '18')),

            // Comments
            lc_general('.met_pf_item_comments i', 'Comments', array('color' => '', 'font-size' => '14'), 'Icon'),

            // Comments Digit
            lc_general('.met_pf_item_comments span', 'Comments Digit', array('color' => '', 'font-size' => '14'), 'Digit'),

            // Read More
            lc_general('.met_pf_item_readmore a', 'Read More', array('color' => '', 'color:hover' => '', 'font-size' => '11'))

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
				?><div id="<?php echo $grid; ?>" class="row met_portfolio met_portfolio_grid_3 grid isotope columns_<?php echo $options['columns']; ?> <?php echo $options['grid_gap']; ?> effect-<?php echo $met_shared_options['animation'].' '.$met_shared_options['grid_check']; ?>" data-unique-class="<?php echo $met_shared_options['uniqueClass']; ?>"><?php

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

                            <div class="met_portfolio_item_layout_5_details">
                                <?php if ( ($elements == 'all' || in_array( 'head', $elements )) && ( in_array( 'title', $elements ) || in_array( 'categories', $elements ) ) ) : ?>
                                <header>
                                    <?php if ( $elements == 'all' || in_array( 'categories', $elements ) ) : ?>
                                    <div>
                                        <?php
                                        $categories = array();
                                        foreach($taxonomies as $category)
                                            $categories[] = '<a href="'.(array_key_exists('link',$category) ? $category['link'] : get_term_link( $category["slug"], $category["taxonomy"] )).'" class="met_color2">'.$category["name"].'</a>';

                                        echo implode(', ',$categories);
                                        ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ( $elements == 'all' || in_array( 'title', $elements ) ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="met_portfolio_item_title"><h3><?php the_title(); ?></h3></a>
                                    <?php endif; ?>
                                </header>
                                <?php endif; ?>

                                <?php if ( $elements == 'all' || in_array( 'summary', $elements ) ) : ?>
                                <article>
                                    <?php if ( ! isset( $options['excerpt_length'] ) ) $options['excerpt_length'] = 20; ?>
                                    <div class="met_p" style="text-shadow: -1px -1px 0 <?php echo $options['met_p_text_shadow'] ?>"><?php echo wp_trim_words( get_the_excerpt(), $options['excerpt_length'] ); ?></div>
                                </article>
                                <?php endif; ?>

                                <?php if ( ($elements == 'all' || in_array( 'bottom', $elements )) && ( in_array( 'social_share', $elements ) || in_array( 'comments', $elements ) || in_array( 'read_more', $elements ) ) ) : ?>
                                <footer class="clearfix">
                                    <?php if ( $elements == 'all' || in_array( 'social_share', $elements ) ) : ?>
                                    <section class="met_pf_item_socials">
                                        <?php
                                        $social_codes_output =  met_option('blog_detail_meta_socials_code');
                                        if($social_codes_markup = explode("\n",$social_codes_output)){
                                            foreach($social_codes_markup as $social_code_item){
                                                if($social_code_item_data = explode('|',$social_code_item,2)){
                                                    $social_code_item_data[1] = str_replace('[post-title]',get_the_title(),$social_code_item_data[1]);
                                                    $social_code_item_data[1] = str_replace('[permalink]',get_permalink(),$social_code_item_data[1]);

                                                    printf('<a href="%2$s"><i class="fa %1$s"></i></a>',$social_code_item_data[0],$social_code_item_data[1]);
                                                }
                                            }
                                        }
                                        ?>
                                    </section>
                                    <?php endif; ?>
                                    <?php if ( $elements == 'all' || in_array( 'comments', $elements ) ) : ?>
                                    <section class="met_pf_item_comments"><i class="dslc-icon dslc-icon-comment"></i> <span><?php comments_number( '0', '1', '%' ); ?></span></section>
                                    <?php endif; ?>
                                    <?php if ( $elements == 'all' || in_array( 'read_more', $elements ) ) : ?>
                                    <section class="met_pf_item_readmore">
                                        <a href="<?php the_permalink(); ?>" class="met_color2"><?php echo __( 'Read More', 'dslc_string' ) ?></a>
                                    </section>
                                    <?php endif; ?>
                                </footer>
                                <?php endif; ?>
                            </div><!-- .met_portfolio_item_layout_5_details -->

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