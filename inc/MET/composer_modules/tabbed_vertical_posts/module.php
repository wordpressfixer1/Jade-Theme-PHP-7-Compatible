<?php

// Register Module
function register_tverticalposts_module() {
	return dslc_register_module( "MET_TabbedVerticalPosts" );
}
add_action('dslc_hook_register_modules','register_tverticalposts_module');

class MET_TabbedVerticalPosts extends DSLC_Module {

    var $module_id = 'MET_TabbedVerticalPosts';
    var $module_title = 'Tabbed';
    var $module_icon = 'info';
    var $module_category = 'met - posts';

    function options() {

		$dslc_options = array(
			/* Main Elements */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'elements',
				'std' => 'featured_post sub_posts',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Featured Post', 'dslc_string' ),
						'value' => 'featured_post'
					),
					array(
						'label' => __( 'Sub Posts', 'dslc_string' ),
						'value' => 'sub_posts'
					),
				),
			),

			array(
				'label' => __( 'Tab Count', 'dslc_string' ),
				'id' => 'tab_count',
				'std' => 3,
				'min' => 1,
				'max' => 3,
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'type' => 'slider',
			),

			array(
				'label' => __( 'Active Tab', 'dslc_string' ),
				'id' => 'active_tab',
				'std' => 1,
				'min' => 1,
				'max' => 3,
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'type' => 'slider',
			),

			/* Featured Post Options */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'featured_elements',
				'std' => 'thumbnail title excerpt category',
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
						'label' => __( 'Excerpt', 'dslc_string' ),
						'value' => 'excerpt'
					),
					array(
						'label' => __( 'Category', 'dslc_string' ),
						'value' => 'category'
					),
				),
				'tab' => 'featured post'
			),

			array(
				'label' => __( 'Excerpt Length ( amount of words )', 'dslc_string' ),
				'id' => 'f_excerpt_length',
				'std' => 20,
				'type' => 'text',
				'tab' => 'featured post'
			),

			array(
				'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
				'id' => 'f_thumb_resize_width',
				'std' => '',
				'type' => 'text',
				'tab' => 'featured post'
			),
			array(
				'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
				'id' => 'f_thumb_resize_height',
				'std' => '',
				'type' => 'text',
				'tab' => 'featured post'
			),
			array(
				'label' => __( 'Crop Thumbnail', 'dslc_string' ),
				'id' => 'f_thumb_crop',
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
				'tab' => 'featured post'
			),

			/* Sub Posts Options */
			array(
				'label' => __( 'Elements', 'dslc_string' ),
				'id' => 'sub_elements',
				'std' => 'thumbnail title excerpt date',
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
						'label' => __( 'Excerpt', 'dslc_string' ),
						'value' => 'excerpt'
					),
					array(
						'label' => __( 'Date', 'dslc_string' ),
						'value' => 'date'
					),
				),
				'tab' => 'sub posts'
			),

			array(
				'label' => __( 'Excerpt Length ( amount of words )', 'dslc_string' ),
				'id' => 's_excerpt_length',
				'std' => 7,
				'type' => 'text',
				'tab' => 'sub posts'
			),

			array(
				'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
				'id' => 's_thumb_resize_width',
				'std' => '',
				'type' => 'text',
				'tab' => 'sub posts'
			),
			array(
				'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
				'id' => 's_thumb_resize_height',
				'std' => '',
				'type' => 'text',
				'tab' => 'sub posts'
			),
			array(
				'label' => __( 'Crop Thumbnail', 'dslc_string' ),
				'id' => 's_thumb_crop',
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
				'tab' => 'sub posts'
			),
		);

        $post_type_categoryArgs = categoryArgs( '', '', 1 );

		for($i = 1; $i<=3; $i++){
			$tab_prefix = 't'.$i.'_';
			$tab_query_options = array(
				array(
					'label' => __( 'Tab Title', 'dslc_string' ),
					'id' => $tab_prefix.'tab_title',
					'std' => 'Tab '.$i,
					'type' => 'text',
					'tab' => 'Tab '.$i
				),
				array(
					'label' => __( 'Post Type', 'dslc_string' ),
					'id' => $tab_prefix.'post_type',
					'std' => $post_type_categoryArgs[0]['value'],
					'type' => 'select',
					'choices' => $post_type_categoryArgs,
					'tab' => 'Tab '.$i
				),
				array(
					'label' => __( 'Category IDs [Seperate with "," Comma]', 'dslc_string' ),
					'id' => $tab_prefix.'category_ids',
					'std' => '',
					'type' => 'text',
					'tab' => 'Tab '.$i
				),
				array(
					'label' => __( 'Post Limit', 'dslc_string' ),
					'id' => $tab_prefix.'amount',
					'std' => '3',
					'min' => '1',
					'max' => '10',
					'refresh_on_change' => true,
					'affect_on_change_el' => '',
					'affect_on_change_rule' => '',
					'type' => 'slider',
					'tab' => 'Tab '.$i
				),
				array(
					'label' => __( 'Order By', 'dslc_string' ),
					'id' => $tab_prefix.'orderby',
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
					),
					'tab' => 'Tab '.$i
				),
				array(
					'label' => __( 'Order', 'dslc_string' ),
					'id' => $tab_prefix.'order',
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
					),
					'tab' => 'Tab '.$i
				),
				array(
					'label' => __( 'Offset', 'dslc_string' ),
					'id' => $tab_prefix.'offset',
					'std' => '0',
					'type' => 'text',
					'tab' => 'Tab '.$i
				),
			);

			$dslc_options = array_merge($dslc_options,$tab_query_options);
		}

		$dslc_options = array_merge(
			$dslc_options,

			// Wrapper
			lc_general('.met_vertical_posts', '', array('background-color' => '#F7F6F4'), 'Box'),

			// Wrapper
			lc_margins('.met_vertical_posts', '', array('t' => '', 'r' => '', 'b' => '', 'l' => '')),

			// Nav
			lc_general('.met_tabbed_posts .nav-tabs', 'Tabs', array('background-color' => '#F3F2EF'), 'Tabs'),

			// Nav Item
			lc_general('.met_tabbed_posts .nav-tabs > li:not(.active)', 'Tab Item', array('background-color' => '','background-color:hover' => get_met_option('met_color')), 'Tab'),

			// Nav Item
			lc_general('.met_tabbed_posts .nav-tabs > li > a', 'Tab Item', array('color' => '#868E8E','color:hover' => '#ffffff','font-size' => '14','line-height' => '50','font-weight' => '400'), 'Tab'),

			// Nav Item .active
			lc_general('.met_tabbed_posts .nav-tabs > li.active', 'Tab Item', array('background-color' => '#FFCA07'), 'Active Tab'),

			// Nav Item .active
			lc_general('.met_tabbed_posts .nav-tabs > li.active a', 'Tab Item', array('color' => '#ffffff'), 'Active Tab'),

			// Nav Item
			lc_paddings('.met_tabbed_posts .nav-tabs > li > a', 'Tab Item', array('t' => '0', 'r' => '15', 'b' => '0', 'l' => '15')),

			// Featured Post Cat
			lc_general('.met_simple_post_box .met_simple_post_box_cat', 'Featured Post', array('color' => '#F9FFA3','color:hover' => '#ffffff','font-size' => '12','line-height' => '22','font-weight' => '400'), 'Category '),

			// Featured Post Date
			lc_general('.met_simple_post_box .met_simple_post_box_date', 'Featured Post', array('color' => '#000000','color:hover' => '#ffffff','font-size' => '12','line-height' => '22','font-weight' => '400'), 'Date '),

			// Featured Post Title
			lc_general('.met_simple_post_box_title', 'Featured Post', array('color' => '#ffffff','color:hover' => '#000000','font-size' => '18','line-height' => '23','font-weight' => '400'), 'Title '),

			// Featured Post
			lc_paddings('.met_simple_post_box', 'Featured Post', array('t' => '20', 'r' => '20', 'b' => '20', 'l' => '20')),

			// Sub Post Cat
			lc_general('.met_vertical_post .met_simple_post_box_cat', 'Sub Posts', array('color' => '#F9FFA3','color:hover' => '#ffffff','font-size' => '12','line-height' => '22','font-weight' => '400'), 'Category '),

			// Sub Post Date
			lc_general('.met_vertical_post .met_simple_post_box_date', 'Sub Posts', array('color' => '#000000','color:hover' => '#ffffff','font-size' => '12','line-height' => '22','font-weight' => '400'), 'Date '),

			// Sub Post Title
			lc_general('.met_vertical_post .met_simple_post_box_title', 'Sub Posts', array('color' => '#ffffff','color:hover' => '#000000','font-size' => '14','line-height' => '17','font-weight' => '400'), 'Title '),

			// Sub Post
			lc_paddings('.met_vertical_post', 'Sub Posts', array('t' => '20', 'r' => '20', 'b' => '20', 'l' => '20'))

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

		// Featured Elements
		$f_elements = $options['featured_elements'];
		if ( ! empty( $f_elements ) )
			$f_elements = explode( ' ', trim( $f_elements ) );
		else
			$f_elements = array();

		// Sub Elements
		$s_elements = $options['sub_elements'];
		if ( ! empty( $s_elements ) )
			$s_elements = explode( ' ', trim( $s_elements ) );
		else
			$s_elements = array();

		$tab_count = $options['tab_count'];

		$featured_post_status = ( in_array( 'featured_post', $elements ) ) ? true : false;
		$sub_posts_index = ( $featured_post_status ) ? 1 : 0;

		for($i = 1; $i<=$tab_count; $i++){
			$tab_prefix = 't'.$i.'_';
			/* WP_Query */
			$options[$tab_prefix.'amount'] = $options[$tab_prefix.'amount'] == '' ? -1 : $options[$tab_prefix.'amount'];

			$args = array(
				'post_type' 		=> $options[$tab_prefix.'post_type'],
				'posts_per_page'	=> $options[$tab_prefix.'amount'],
				'order' 			=> $options[$tab_prefix.'order'],
				'orderby' 			=> $options[$tab_prefix.'orderby'],
				'offset' 			=> $options[$tab_prefix.'offset']
			);

			// Category args
			if($options[$tab_prefix.'post_type'] != 'post'){
                $post_type_categoryArgs = categoryArgs( $options[$tab_prefix.'post_type'], $options[$tab_prefix.'category_ids'] );
				$args = array_merge($args, $post_type_categoryArgs);
			}else{
				if(!empty($options[$tab_prefix.'category_ids'])) $args['category__in'] = explode(' ', $options[$tab_prefix.'category_ids']);
			}


			$dslc_query = new WP_Query( $args );
			/* WP_Query */

			if ( $dslc_query->have_posts() ) {
				$post_index = 0;
				while ( $dslc_query->have_posts() ) : $dslc_query->the_post();
					$post_data[$i][$post_index]['ID'] = get_the_ID();
					$post_data[$i][$post_index]['title'] = get_the_title();
					$post_data[$i][$post_index]['permalink'] = get_permalink();

					$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
					$thumb_url = (get_post_thumbnail_id() > 0) ? $thumb_url[0] : false;
					$post_data[$i][$post_index]['thumbnail'] = $thumb_url;

					$post_data[$i][$post_index]['excerpt'] = get_the_excerpt();
					$post_data[$i][$post_index]['date'] = get_the_time( get_option( 'date_format' ) );

					$category_term = '';
					$taxonomy = categoryArgs( $options[$tab_prefix.'post_type'], 'single', 1 );
					if($options[$tab_prefix.'post_type'] == 'post') $taxonomy['cat'] = 'category';

					$category_term = get_the_terms( $post_data[$i][$post_index]['ID'], $taxonomy['cat'] );
					$category_term = $category_term[key($category_term)];
					$term_link = get_term_link( $category_term );

					$post_data[$i][$post_index]['cat_name'] = $category_term->name;
					$post_data[$i][$post_index]['cat_link'] = $term_link;

					$post_index++;
				endwhile;
			}
			wp_reset_query();



			if($featured_post_status){
				if($post_data[$i][0]['thumbnail'] != false){
					$thumb_url = $post_data[$i][0]['thumbnail'];

					if ( !empty( $options['f_thumb_resize_width'] ) AND !empty( $options['f_thumb_resize_height'] ) ) :
						$post_data[$i][0]['thumbnail'] = imageResizing( $thumb_url, $options['f_thumb_resize_height'], $options['f_thumb_resize_width'], $options['f_thumb_crop'] );
						if($post_data[$i][0]['thumbnail'] === false): $post_data[$i][0]['thumbnail'] = array('url' => $thumb_url, 'sizing' => ''); endif;
					else :
						$post_data[$i][0]['thumbnail'] = array('url' => $thumb_url, 'sizing' => '');
					endif;
				}

				$post_data[$i][0]['excerpt'] = wp_trim_words( $post_data[$i][0]['excerpt'], $options['f_excerpt_length'] );
			}
		}

        $elementID = uniqid('tabbedverticalposts_');
        ?>

        <div id="<?php echo $elementID; ?>" class="met_tabbed_posts <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
            <ul class="nav nav-tabs">
				<?php
					for($i = 1; $i<=$tab_count; $i++){
						$tab_prefix = 't'.$i.'_';
						$tab_title_id = $tab_prefix.'tab_title';
						$active_class = ($i == $options['active_tab']) ? 'class="active"' : '';
						echo '<li '.$active_class.'><a href="#'.$elementID.$tab_prefix.'" data-toggle="tab">'.$options[$tab_title_id].'</a></li>';
					}
				?>
            </ul>
            <div class="tab-content">
				<?php for($i = 1; $i<=$tab_count; $i++): ?>
				<?php
					$tab_prefix = 't'.$i.'_';
				?>
                <div class="tab-pane fade in <?php echo ($i == $options['active_tab']) ? "active" : "" ?>" id="<?php echo $elementID.$tab_prefix ?>">

					<?php if( $featured_post_status ) : ?>
                    <div class="met_simple_post_box met_bgcolor">
                        <?php if(!empty($post_data[$i][0]['thumbnail']['url'])): ?>
                        <a href="<?php echo $post_data[$i][0]['permalink'] ?>" class="met_simple_post_box_image"><img src="<?php echo $post_data[$i][0]['thumbnail']['url'] ?>" alt="<?php echo esc_attr($post_data[$i][0]['title']) ?>" /></a>
                        <?php endif; ?>
                        <a href="<?php echo $post_data[$i][0]['cat_link'] ?>" class="met_simple_post_box_misc met_simple_post_box_cat"><?php echo $post_data[$i][0]['cat_name'] ?></a>
                        <a href="<?php echo $post_data[$i][0]['permalink'] ?>" class="met_simple_post_box_misc met_simple_post_box_date">| <?php echo $post_data[$i][0]['date'] ?></a>

                        <a href="<?php echo $post_data[$i][0]['permalink'] ?>" class="met_simple_post_box_title"><?php echo $post_data[$i][0]['title'] ?></a>
                    </div>
					<?php endif; ?>

					<?php
						$have_sub_posts = false;
						if($featured_post_status AND count($post_data[$i]) > 1) $have_sub_posts = true;
						if(!$featured_post_status AND count($post_data[$i]) > 0) $have_sub_posts = true;
						$have_sub_posts = ( in_array( 'sub_posts', $elements ) ) ? true : false;
					?>

					<?php if($have_sub_posts): for($si = $sub_posts_index; $si < count($post_data[$i]); $si++): ?>
					<?php
						if($post_data[$i][$si]['thumbnail'] != false){
							$thumb_url = $post_data[$i][$si]['thumbnail'];

							if ( !empty( $options['s_thumb_resize_width'] ) AND !empty( $options['s_thumb_resize_height'] ) ) :
								$post_data[$i][$si]['thumbnail'] = imageResizing( $thumb_url, $options['s_thumb_resize_height'], $options['s_thumb_resize_width'], $options['s_thumb_crop'] );
								if($post_data[$i][$si]['thumbnail'] === false): $post_data[$i][$si]['thumbnail'] = array('url' => $thumb_url, 'sizing' => ''); endif;
							else :
								$post_data[$i][$si]['thumbnail'] = array('url' => $thumb_url, 'sizing' => '');
							endif;
						}

						$post_data[$i][$si]['excerpt'] = wp_trim_words( $post_data[$i][$si]['excerpt'], $options['s_excerpt_length'] );
					?>

                    <div class="met_vertical_post met_post_title_only met_bgcolor clearfix">
                        <?php if(!empty($post_data[$i][$si]['thumbnail']['url'])): ?>
                        <a href="<?php echo $post_data[$i][$si]['permalink'] ?>" class="met_vertical_post_image_caption"><img class="met_vertical_post_image" src="<?php echo $post_data[$i][$si]['thumbnail']['url'] ?>" alt="<?php echo esc_attr($post_data[$i][$si]['title']) ?>" /></a>
                        <?php endif; ?>
                        <div <?php if(empty($post_data[$i][$si]['thumbnail']['url'])): ?>style="margin-left: 0"<?php endif; ?> class="met_vertical_post_details">
                            <a href="<?php echo $post_data[$i][$si]['cat_link'] ?>" class="met_simple_post_box_misc met_simple_post_box_cat"><?php echo $post_data[$i][$si]['cat_name'] ?></a>
                            <a href="<?php echo $post_data[$i][$si]['permalink'] ?>" class="met_simple_post_box_misc met_simple_post_box_date">| <?php echo $post_data[$i][$si]['date'] ?></a>

                            <a href="<?php echo $post_data[$i][$si]['permalink'] ?>" class="met_simple_post_box_title"><?php echo $post_data[$i][$si]['title'] ?></a>
                        </div>
                    </div>
					<?php endfor; endif; ?>

                </div>
				<?php endfor; ?>
            </div>
        </div>
        <?php echo $met_shared_options['script']; ?>

        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}