<?php

// Register Module
function register_postlist_module() {
	return dslc_register_module( "MET_PostList" );
}
add_action('dslc_hook_register_modules','register_postlist_module');

class MET_PostList extends DSLC_Module {

    var $module_id = 'MET_PostList';
    var $module_title = 'Vertical Product List';
    var $module_icon = 'info';
    var $module_category = 'met - posts';

    function options() {

        $post_type_categoryArgs = categoryArgs( '', '', 1 );

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
				'std' => '5',
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
				'std' => 'thumbnail title date category',
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
						'label' => __( 'Category', 'dslc_string' ),
						'value' => 'category'
					),
					array(
						'label' => __( 'Date', 'dslc_string' ),
						'value' => 'date'
					),
				),
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
				'std' => 'thumbnail title category date',
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
						'label' => __( 'Category', 'dslc_string' ),
						'value' => 'category'
					),
					array(
						'label' => __( 'Date', 'dslc_string' ),
						'value' => 'date'
					),
				),
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
			lc_general('.met_post_list', '', array('background-color' => ''), 'Box'),

			// Wrapper
			lc_margins('.met_post_list', '', array('t' => '', 'r' => '', 'b' => '', 'l' => '')),

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
            $post_type_categoryArgs = categoryArgs($options['post_type'], $options['category_ids']);
			$args = array_merge($args, $post_type_categoryArgs);
		}else{
			if(!empty($options['category_ids'])) $args['cat'] = $options['category_ids'];
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

				$post_data[$post_index]['date'] = get_the_time( get_option( 'date_format' ) );

				$category_term = '';
				$taxonomy = categoryArgs( $options['post_type'], 'single', 1 );
				if($options['post_type'] == 'post') $taxonomy['cat'] = 'category';

				$category_term = get_the_terms( $post_data[$post_index]['ID'], $taxonomy['cat'] );
				$category_term = $category_term[key($category_term)];
				$term_link = get_term_link( $category_term );

				$post_data[$post_index]['cat_name'] = $category_term->name;
				$post_data[$post_index]['cat_link'] = $term_link;

				$post_index++;
			endwhile;
		}
		wp_reset_query();

		$featured_post_status = ( in_array( 'featured_post', $elements ) ) ? true : false;
		$sub_posts_index = ( $featured_post_status ) ? 1 : 0;

		$category_term = $term_link = '';
		if(!empty($options['category_ids']) AND !strpos($options['category_ids'], ',')){
			$taxonomy = categoryArgs( $options['post_type'], 'single', 1 );
			if($options['post_type'] == 'post') $taxonomy['cat'] = 'category';

			$category_term = get_the_terms( $post_data[0]['ID'], $taxonomy['cat'] );

			if( isset($category_term[$options['category_ids']]) ){
				$category_term = $category_term[$options['category_ids']];
			}

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
		}

        $elementID = uniqid('tabbedverticalposts_');
        ?>

        <div id="<?php echo $elementID; ?>" class="met_post_list met_bgcolor clearfix <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>

			<?php if( $featured_post_status ) : ?>
				<div class="met_post_list_part">
					<div class="met_simple_post_box">
					<?php if( in_array( 'thumbnail', $f_elements ) AND isset($post_data[0]['thumbnail']['url']) AND !empty($post_data[0]['thumbnail']['url']) ): ?>
						<a href="<?php echo $post_data[0]['permalink'] ?>" class="met_simple_post_box_image"><img src="<?php echo $post_data[0]['thumbnail']['url'] ?>" alt="<?php echo esc_attr($post_data[0]['title']) ?>" /></a>
					<?php endif; ?>

					<?php if( in_array( 'category', $f_elements ) ): ?>
						<a href="<?php echo $post_data[0]['cat_link'] ?>" class="met_simple_post_box_misc met_simple_post_box_cat"><?php echo $post_data[0]['cat_name'] ?></a>
					<?php endif; ?>

					<?php if( in_array( 'date', $f_elements ) ): ?>
						<a href="#" class="met_simple_post_box_misc met_simple_post_box_date">| <?php echo $post_data[0]['date'] ?></a>
					<?php endif; ?>

					<?php if( in_array( 'title', $f_elements ) ): ?>
						<a href="<?php echo $post_data[0]['permalink'] ?>" class="met_simple_post_box_title"><?php echo $post_data[0]['title'] ?></a>
					<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

            <div class="met_post_list_part met_vertical_post_list_part">
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
				 ?>
                <div href="<?php echo $post_data[$i]['permalink'] ?>" class="met_vertical_post met_post_title_only clearfix">
                    <?php if( !empty( $post_data[$i]['thumbnail']['url'] ) ): ?><a href="<?php echo $post_data[$i]['permalink'] ?>" class="met_vertical_post_image_caption"><img class="met_vertical_post_image" src="<?php echo $post_data[$i]['thumbnail']['url'] ?>" alt="<?php echo esc_attr($post_data[$i]['title']) ?>" /></a><?php endif; ?>
					<?php if(in_array( 'date', $s_elements ) OR in_array( 'title', $s_elements ) OR in_array( 'category', $s_elements )): ?>
                    <div class="met_vertical_post_details">
						<?php if(in_array( 'category', $s_elements )): ?>
                        <a href="<?php echo $post_data[$i]['cat_link'] ?>" class="met_simple_post_box_misc met_simple_post_box_cat"><?php echo $post_data[$i]['cat_name'] ?></a>
						<?php endif; ?>

						<?php if(in_array( 'date', $s_elements )): ?>
                        <a href="<?php echo $post_data[$i]['permalink'] ?>" class="met_simple_post_box_misc met_simple_post_box_date">| <?php echo $post_data[$i]['date'] ?></a>
						<?php endif; ?>

						<?php if(in_array( 'title', $s_elements )): ?>
                        <a href="<?php echo $post_data[$i]['permalink'] ?>" class="met_simple_post_box_title"><?php echo $post_data[$i]['title'] ?></a>
						<?php endif; ?>
                    </div>
					<?php endif; ?>
                </div>
			 <?php endfor; endif; ?>
            </div>

        </div>

        <?php echo $met_shared_options['script']; ?>
        <?php
        /* Module output ends here */
        $this->module_end( $options );
    }
}