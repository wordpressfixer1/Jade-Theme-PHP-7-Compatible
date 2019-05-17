<?php
// Register Module
function register_blog_module() {
    return dslc_register_module( "MET_Blog" );
}
add_action('dslc_hook_register_modules','register_blog_module');

class MET_Blog extends DSLC_Module {

	var $module_id = 'MET_Blog';
	var $module_title = 'Full Featured Blog';
	var $module_icon = 'pencil';
	var $module_category = 'met - posts';

	function options() {

		// Options
        $dslc_options = array(
            array(
                'label' => __( 'Category IDs [Seperate with "," Comma]', 'dslc_string' ),
                'id' => 'category_ids',
                'std' => '',
                'type' => 'text',
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

            /**
             * Image Options
             */
            array(
                'label' => __( 'Thumbnail Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width_manual',
                'std' => '595',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Resize - Width', 'dslc_string' ),
                'id' => 'thumb_resize_width',
                'std' => '595',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Thumbnail Resize - Height', 'dslc_string' ),
                'id' => 'thumb_resize_height',
                'std' => '390',
                'type' => 'text'
            ),
		);

        $dslc_options = array_merge(
            $dslc_options,

            // Title
            lc_general('.entry-title a', 'Title', array('color:hover' => '')),
            lc_general('.entry-title', 'Title', array('color' => '#393939', 'font-family' => 'Open Sans', 'font-size' => '40','line-height' => '55','font-weightt' => '300')),

            // Content
            lc_general('.met_blog_module_details', 'Content', array('color' => '#393939', 'font-family' => 'Open Sans', 'font-size' => '20','line-height' => '30','font-weightt' => '300'))
        );

        $dslc_options = met_lc_extras($dslc_options, array('animation'), 'shared_options');

        $dslc_options = array_merge( $dslc_options, $this->presets_options() );
		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		global $dslc_active, $current_user, $dslc_is_admin, $preview_data;

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
			$dslc_is_admin = true;
		else
			$dslc_is_admin = false;

		$this->module_start( $options );
		/* CUSTOM START */

        /* Animation */
        

        $met_shared_options = met_lc_extras( $options, array(
            'groups'   => array('animation'),
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

        $preview_data['width'] = $options['thumb_resize_width_manual'];
        $preview_data['height'] = $options['thumb_resize_height'];
        $preview_data['hardcrop'] = true;

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
				'post_type' => 'post',
				'posts_per_page' => $options['amount'],
				'order' => $options['order'],
				'orderby' => $options['orderby'],
				'offset' => $options['offset']
			);

            // Category args
            if(!empty($options['category_ids'])) $args['category__in'] = explode(' ', $options['category_ids']);

			// Do the query
			$dslc_query = new WP_Query( $args );

        get_currentuserinfo();
		/**
		 * Posts ( output )
		 */
        if ( $dslc_query->have_posts() ) { ?>
            <div class="met_blog_module">
            <?php while ( $dslc_query->have_posts() ) : $dslc_query->the_post(); $get_post_format = get_post_format() ?>
                <?php get_template_part( 'inc/template_single/post_preview_data' ); ?>
                <div id="post-<?php the_ID() ?>" <?php post_class('met_blog_module_item clearfix '.$met_shared_options['classes']) ?> <?php echo $met_shared_options['data-']; ?>>

                    <?php get_template_part( 'inc/template_single/post_title', $get_post_format ) ?>

                    <div class="met_blog_module_contents">
                        <div class="met_blog_module_preview"><?php get_template_part('inc/template_single/post_preview', $get_post_format) ?></div>

                        <div class="met_blog_module_details"><?php get_template_part('inc/template_single/post_content') ?></div>

                        <?php $post_types = array('link', 'quote', 'status', 'video', 'audio', 'chat', 'aside'); if( !in_array( $get_post_format, $post_types ) ): ?>
                        <a href="<?php the_permalink() ?>" class="met_ghost_button"><?php _e('Read More','Jade') ?></a>
                        <?php endif ?>
                    </div>

                    <div class="met_blog_module_item_helpers">
                        <?php if(current_user_can( 'edit_others_posts', get_the_ID() ) || (get_the_author_meta('ID') == $current_user->ID)): ?>
                        <div class="met_blog_module_item_helper">
                            <?php edit_post_link( '<div class="met_blog_module_item_helper_icon_contents"><i class="dslc-icon dslc-icon-pencil"></i><div class="met_blog_module_item_helper_icon_title">'.__('Edit', 'Jade').'</div></div>', '<div class="met_blog_module_item_helper_icon met_blog_module_item_helper_author met_color2 met_vcenter">', '</div>' ); ?>
                        </div><!-- Edit Post Ends -->
                        <?php endif ?>
                        <div class="met_blog_module_item_helper">
                            <div class="met_blog_module_item_helper_icon met_blog_module_item_helper_author"><div class="met_blog_module_item_helper_icon_contents"><?php echo get_avatar( get_the_author_meta( 'ID' ), 58, '' ); ?></div></div>
                            <div class="met_blog_module_item_helper_details">
                                <span class="met_blog_module_item_helper_title"><?php _e('ABOUT THE AUTHOR', 'Jade') ?></span>
                                <?php get_template_part( 'inc/template_single/authorbox' ) ?>
                            </div>
                        </div><!-- Author Helper Ends -->
                        <div class="met_blog_module_item_helper">
                            <div class="met_blog_module_item_helper_icon met_blog_module_item_helper_date met_vcenter"><div class="met_blog_module_item_helper_icon_contents met_color"><?php the_time('j') ?> <?php the_time('M') ?> <?php the_time('Y') ?></div></div>
                            <div class="met_blog_module_item_helper_details">
                                <span class="met_blog_module_item_helper_title"><?php _e('BROWSE ARCHIVES FOR','Jade') ?></span>
                                <a href="<?php echo site_url('/'); the_time('Y/m') ?>" class="met_blog_module_item_helper_link" target="_blank"><?php the_time('F') ?></a> <a href="<?php echo site_url('/'); the_time('Y/d/m') ?>" class="met_blog_module_item_helper_link" target="_blank"><?php the_time('d') ?></a>, <a href="<?php echo site_url('/'); the_time('Y') ?>" class="met_blog_module_item_helper_link" target="_blank"><?php the_time('Y') ?></a>
                            </div>
                        </div><!-- Date Helper Ends -->
                        <?php if ( comments_open() ): ?>
                        <div class="met_blog_module_item_helper">
                            <div class="met_blog_module_item_helper_icon met_blog_module_item_helper_comments met_vcenter"><div class="met_blog_module_item_helper_icon_contents met_color"><i class="dslc-icon dslc-icon-send"></i><div class="met_blog_module_item_helper_icon_title"><?php _e('Comments', 'Jade'); ?></div></div></div>
                            <div class="met_blog_module_item_helper_details">
                                <span class="met_blog_module_item_helper_title"><?php if(get_comments_number() < 1 ) _e('No Comments Yet.', 'Jade'); else _e('LATEST COMMENT', 'Jade'); ?></span>
                                <?php
                                if(get_comments_number() > 0 ){
                                    $comments = get_comments(
                                        array(
                                            'status' => 'approve',
                                            'number' => '1',
                                            'post_id' => get_the_ID(),
                                        )
                                    );
                                    foreach($comments as $comment) :
                                        echo get_avatar( $comment->user_id, 16, '', $comment->comment_author );
                                        ?><a href="<?php the_permalink() ?>#comment-<?php echo $comment->comment_ID ?>" target="_blank"><?php echo $comment->comment_author ?></a><?php
                                    endforeach;
                                }
                                ?>
                                <a href="<?php the_permalink(); ?>#comments" class="met_blog_module_item_helper_link"><?php _e('Add Your Comment.', 'Jade') ?></a>
                            </div>
                        </div><!-- Comment Helper Ends -->
                        <?php endif; ?>
                        <div class="met_blog_module_item_helper">
                            <div class="met_blog_module_item_helper_icon met_blog_module_item_helper_taxonomy met_vcenter"><div class="met_blog_module_item_helper_icon_contents met_color"><i class="dslc-icon dslc-icon-tags"></i><div class="met_blog_module_item_helper_icon_title"><?php _e('Tags', 'Jade'); ?></div></div></div>
                            <div class="met_blog_module_item_helper_details">
                                <span class="met_blog_module_item_helper_title"><?php _e('POSTED IN', 'Jade') ?></span>
                                <?php $category = get_the_category(); echo $category[0] ? '<a class="met_blog_module_item_helper_link" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>' : '' ?>
                                <?php
                                $posttags = get_the_tags();
                                $posttaglinks = array();
                                if ($posttags) {
                                    ?><span class="met_blog_module_item_helper_title"><?php _e('TAGGED WITH', 'Jade') ?></span><?php
                                    foreach($posttags as $tag) {
                                        $posttaglinks[] = '<a href="'.get_tag_link($tag->term_id).'" class="met_blog_module_item_helper_link" target="_blank">'.$tag->name.'</a>';
                                    }
                                    echo implode(', ',$posttaglinks);
                                }
                                ?>
                            </div>
                        </div><!-- Taxonomy Helper Ends -->
                        <div class="met_blog_module_item_helper">
                            <div class="met_blog_module_item_helper_icon met_blog_module_item_helper_share met_vcenter"><div class="met_blog_module_item_helper_icon_contents met_color"><i class="dslc-icon dslc-icon-share-alt"></i><div class="met_blog_module_item_helper_icon_title"><?php _e('Share', 'Jade'); ?></div></div></div>
                            <div class="met_blog_module_item_helper_details">
                                <span class="met_blog_module_item_helper_title"><?php _e('LET THE OTHERS KNOW', 'Jade') ?></span>
                                <div class="met_blog_module_item_helper_socials">
                                    <?php
                                    $social_codes_output =  met_option('blog_detail_meta_socials_code');
                                    if($social_codes_markup = explode("\n",$social_codes_output)){
                                        foreach($social_codes_markup as $social_code_item){
                                            if($social_code_item_data = explode('|',$social_code_item,2)){
                                                $social_code_item_data[1] = str_replace('[post-title]',get_the_title(),$social_code_item_data[1]);
                                                $social_code_item_data[1] = str_replace('[permalink]',get_permalink(),$social_code_item_data[1]);

                                                printf('<a href="%2$s" class="met_blog_module_item_helper_social"><i class="fa %1$s"></i></a>',$social_code_item_data[0],$social_code_item_data[1]);
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div><!-- Social Share Helper Ends -->
                    </div><!-- Helpers Ends -->
                </div><!-- Blog Item Ends -->
            <?php endwhile; ?>
                <?php echo $met_shared_options['script']; ?>
            </div><!-- Blog Module Ends -->
            <?php
            /**
             * Pagination
             */
            if ( isset( $options['pagination_type'] ) && $options['pagination_type'] == 'numbered' ) {
                $num_pages = $dslc_query->max_num_pages;
                met_post_pagination( array( 'pages' => $num_pages ) );
            }
        }else{

        }

		wp_reset_query();
		$this->module_end( $options );

	}

}