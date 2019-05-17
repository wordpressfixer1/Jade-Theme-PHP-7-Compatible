<?php

// Register Module
function register_verticalposts_module() {
	return dslc_register_module( "MET_VerticalPosts" );
}
add_action('dslc_hook_register_modules','register_verticalposts_module');

class MET_VerticalPosts extends DSLC_Module {

    var $module_id = 'MET_VerticalPosts';
    var $module_title = 'Tree';
    var $module_icon = 'info';
    var $module_category = 'met - posts';

    function options() {

        $post_type_categoryArgs = categoryArgs('', '', 1);

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
				'label' => __( 'Post Limit', 'dslc_string' ),
				'id' => 'amount',
				'std' => '3',
				'min' => '1',
				'max' => '10',
				'refresh_on_change' => true,
				'affect_on_change_el' => '',
				'affect_on_change_rule' => '',
				'type' => 'slider',
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
				'label' => __( 'Offset', 'dslc_string' ),
				'id' => 'offset',
				'std' => '0',
				'type' => 'text',
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

		$dslc_options = array_merge(
			$dslc_options,

			// Wrapper
			lc_general('.met_vertical_posts', '', array('background-color' => '#F7F6F4'), 'Box'),

			// Wrapper
			lc_margins('.met_vertical_posts', '', array('t' => '', 'r' => '', 'b' => '', 'l' => '')),

			// Featured Post Category
			lc_general('.met_vertical_posts_highlighted_cat_date', 'Category', array('background-color' => ''), 'Category'),

			// Featured Post Category
			lc_general('.met_vertical_posts_highlighted_cat_date a', 'Category', array('color' => '#FFFFFF','color:hover' => '','font-size' => '14','line-height' => '30','font-weight' => '400'), 'Category'),

			// Featured Post Category
			lc_paddings('.met_vertical_posts_highlighted_cat_date a', 'Category', array('t' => '0', 'r' => '10', 'b' => '0', 'l' => '10')),

			// Featured Post Title
			lc_general('.met_vertical_posts_highlighted_title', 'Featured Post', array('color' => '#000000','color:hover' => '','font-size' => '19','font-weight' => '400'), 'Title'),

			// Featured Post Title
			lc_paddings('.met_vertical_posts_highlighted_title', 'Featured Post', array('t' => '22', 'r' => '30', 'b' => '22', 'l' => '30')),

			// Featured Post Excerpt
			lc_general('.met_vertical_posts_highlighted_summary', 'Featured Post', array('color' => '#888381','font-size' => '14','line-height' => '22','font-weight' => '400'), 'Excerpt'),

			// Featured Post Excerpt
			lc_paddings('.met_vertical_posts_highlighted_summary', 'Featured Post', array('t' => '30', 'r' => '30', 'b' => '30', 'l' => '30')),

			// Sub Post Date
			lc_general('.met_vertical_post_details_date', 'Sub Posts', array('color' => '','font-size' => '12','line-height' => '16','font-weight' => '400'), 'Date'),

			// Sub Post Title
			lc_general('.met_vertical_post_details_title', 'Sub Posts', array('color' => '#000000','color:hover'=> get_met_option('met_color'),'font-size' => '14','line-height' => '18','font-weight' => '400'), 'Title'),

			// Sub Post Excerpt
			lc_general('.met_vertical_post_details_summary.met_p', 'Sub Posts', array('color' => '','font-size' => '12','line-height' => '22','font-weight' => '400'), 'Excerpt'),

			// Sub Post Paddings
			lc_paddings('.met_vertical_post', 'Sub Posts', array('t' => '10', 'r' => '10', 'b' => '10', 'l' => '10')),

			// Wrapper
			lc_margins('.met_vertical_post_details', 'Sub Post Details', array('t' => '0', 'r' => '', 'b' => '', 'l' => '160'))
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

        $elementID = uniqid('verticalposts_');

		/* WP_Query */
		$options['amount'] = $options['amount'] == '' ? -1 : $options['amount'];

		$args = array(
			'post_type' 		=> $options['post_type'],
			'posts_per_page'	=> $options['amount'],
			'order' 			=> $options['order'],
			'orderby' 			=> $options['orderby'],
			'offset' 			=> $options['offset']
		);

		// Category args
		if($options['post_type'] != 'post'){
			$args = array_merge($args, categoryArgs($options['post_type'], $options['category_ids']));
		}else{
			if(!empty($options['category_ids'])) $args['category__in'] = explode(' ', $options['category_ids']);
		}


		$dslc_query = new WP_Query( $args );
		/* WP_Query */

		if ( $dslc_query->have_posts() ) {
			$post_index = 0;
			while ( $dslc_query->have_posts() ) : $dslc_query->the_post();
				$post_data[$post_index]['ID'] = get_the_ID();
				$post_data[$post_index]['title'] = get_the_title();
				$post_data[$post_index]['permalink'] = get_permalink();

				$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				$thumb_url = (get_post_thumbnail_id() > 0) ? $thumb_url[0] : false;
				$post_data[$post_index]['thumbnail'] = $thumb_url;

				$post_data[$post_index]['excerpt'] = get_the_excerpt();
				$post_data[$post_index]['date'] = get_the_time( get_option( 'date_format' ) );

				$post_index++;
			endwhile;
		}
		wp_reset_query();

		$featured_post_status = ( in_array( 'featured_post', $elements ) ) ? true : false;
		$sub_posts_index = ( $featured_post_status ) ? 1 : 0;

		$category_term = '';
		if(!empty($options['category_ids']) AND !strpos($options['category_ids'], ',')){
			$taxonomy = categoryArgs( $options['post_type'], 'single', 1 );
			if($options['post_type'] == 'post') $taxonomy['cat'] = 'category';
			$category_term = get_the_terms( $post_data[0]['ID'], $taxonomy['cat'] );
			$category_term = $category_term[$options['category_ids']];
			$term_link = get_term_link( $category_term );
		}

		if($featured_post_status){
			if($post_data[0]['thumbnail'] != false){
				$thumb_url = $post_data[0]['thumbnail'];

				if ( !empty( $options['f_thumb_resize_width'] ) AND !empty( $options['f_thumb_resize_height'] ) ) :
					$post_data[0]['thumbnail'] = imageResizing( $thumb_url, $options['f_thumb_resize_height'], $options['f_thumb_resize_width'], $options['f_thumb_crop'] );
					if($post_data[0]['thumbnail'] === false): $post_data[0]['thumbnail'] = array('url' => $thumb_url, 'sizing' => ''); endif;
				else :
					$post_data[0]['thumbnail'] = array('url' => $thumb_url, 'sizing' => '');
				endif;
			}

			$post_data[0]['excerpt'] = wp_trim_words( $post_data[0]['excerpt'], $options['f_excerpt_length'] );
		}

        ?>

         <div class="met_vertical_posts <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
			 <?php if( $featured_post_status ) : ?>
				 <div class="met_vertical_posts_highlighted">
					 <?php if( in_array( 'thumbnail', $f_elements ) && !empty($post_data[0]['thumbnail']['url']) ): ?>
					 <a href="<?php echo $post_data[0]['permalink'] ?>" class="met_vertical_posts_highlighted_image"><img src="<?php echo $post_data[0]['thumbnail']['url'] ?>" alt="<?php echo esc_attr($post_data[0]['title']) ?>" /></a>
					<?php endif; ?>
					 <?php if(is_object($category_term) AND in_array( 'category', $f_elements )): ?>
					 <div class="met_vertical_posts_highlighted_cat_date met_bgcolor clearfix">
						 <a href="<?php echo $term_link; ?>" class="met_vertical_posts_highlighted_cat"><?php echo $category_term->name ?></a>
						 <a href="<?php echo $term_link; ?>" class="met_vertical_posts_highlighted_date"><?php echo $category_term->count ?></a>
					 </div>
					 <?php endif; ?>

					<?php if(in_array( 'title', $f_elements )): ?>
						<a href="<?php echo $post_data[0]['permalink'] ?>" class="met_vertical_posts_highlighted_title met_color_transition"><?php echo $post_data[0]['title'] ?></a>
					<?php endif; ?>

					<?php if(in_array( 'excerpt', $f_elements )): ?>
						<div class="met_p met_vertical_posts_highlighted_summary"><?php echo $post_data[0]['excerpt'] ?></div>
					<?php endif; ?>
				 </div>
			 <?php endif; ?>

			 <?php
			 	$have_sub_posts = false;
			 	if($featured_post_status AND count($post_data) > 1) $have_sub_posts = true;
			 	if(!$featured_post_status AND count($post_data) > 0) $have_sub_posts = true;
			 	$have_sub_posts = ( in_array( 'sub_posts', $elements ) ) ? true : false;
			 ?>

			 <?php if($have_sub_posts): for($i = $sub_posts_index; $i < count($post_data); $i++): ?>
				 <?php
				 if($post_data[$i]['thumbnail'] != false){
					 $thumb_url = $post_data[$i]['thumbnail'];

					 if ( !empty( $options['s_thumb_resize_width'] ) AND !empty( $options['s_thumb_resize_height'] ) ) :
						 $post_data[$i]['thumbnail'] = imageResizing( $thumb_url, $options['s_thumb_resize_height'], $options['s_thumb_resize_width'], $options['s_thumb_crop'] );
						 if($post_data[$i]['thumbnail'] === false): $post_data[$i]['thumbnail'] = array('url' => $thumb_url, 'sizing' => ''); endif;
					 else :
						 $post_data[$i]['thumbnail'] = array('url' => $thumb_url, 'sizing' => '');
					 endif;
				 }

				 $post_data[$i]['excerpt'] = wp_trim_words( $post_data[$i]['excerpt'], $options['s_excerpt_length'] );
				 ?>
             <a href="<?php echo $post_data[$i]['permalink'] ?>" class="met_vertical_post clearfix">
				<?php if(in_array( 'thumbnail', $s_elements ) && !empty( $post_data[$i]['thumbnail']['url'] ) ): ?>
					<img class="met_vertical_post_image" src="<?php echo $post_data[$i]['thumbnail']['url'] ?>" alt="<?php echo esc_attr($post_data[$i]['title']) ?>" />
				<?php endif; ?>

				<?php if(in_array( 'date', $s_elements ) OR in_array( 'title', $s_elements ) OR in_array( 'excerpt', $s_elements )): ?>
				<div class="met_vertical_post_details">

					<?php if(in_array( 'title', $s_elements )): ?>
						<span class="met_vertical_post_details_title"><?php echo $post_data[$i]['title'] ?></span>
					<?php endif; ?>
					<?php if(in_array( 'excerpt', $s_elements )): ?>
						<span class="met_vertical_post_details_summary met_p"><?php echo $post_data[$i]['excerpt'] ?></span>
					<?php endif; ?>
					<?php if(in_array( 'date', $s_elements )): ?>
						<span class="met_vertical_post_details_date met_color"><?php echo $post_data[$i]['date'] ?></span>
					<?php endif; ?>
                </div>
				<?php endif; ?>
             </a>
			<?php endfor; endif; ?>
         </div>
        <?php echo $met_shared_options['script']; ?>
        <?php

        /* Module output ends here */
        $this->module_end( $options );
    }
}