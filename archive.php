<?php
	/**
	 * Template Name: Blog
	 * The template for displaying Archive pages.
	 *
	 * Learn more: http://codex.wordpress.org/Template_Hierarchy
	 *
	 * @package metcreative
	 */
	
	get_header();

	global $blog_listing_post_animation, $blog_listing_post_animation_data, $masonry_column_no, $grid_unique_class, $met_options, $wp_query, $custom_blog_args;

	/* BLOG SIDEBAR | START */
	ob_start();
	generated_dynamic_sidebar();
	$sidebar = ob_get_clean();
	/* BLOG SIDEBAR | END */
	
	/* BLOG LAYOUT | START */
	$masonry_column_no 			 = met_option('blog_listing_masonry_column_no');
	$blog_listing_post_animation = met_option('blog_listing_post_animation');
	$blog_layout 				 = met_option('blog_listing_layout');
	$sidebar_position 			 = met_option('blog_sidebar_position');
	$sidebar        			 = '<div class="col-md-4">'.$sidebar.'</div>';
	$sidebarLeft    			 = $sidebar_position == 'left'   ? $sidebar : '';
	$sidebarRight   			 = $sidebar_position == 'right'  ? $sidebar : '';
	$content_size_class 		 = $sidebar_position == 'disable' ? 'col-md-12' : 'col-md-8';
	$wrapper_html 				 = 
	$wrapper_html_middle 		 = 
	$wrapper_html_closing 		 = 
	$grid_unique_class   		 = 
	$blog_listing_post_animation_data = '';
	
	if($blog_listing_post_animation != 'none'){
	    wp_enqueue_script('metcreative-wow');
	    wp_enqueue_style('metcreative-animate');
	    
	    $grid_unique_class = uniqid('met_');
	    
	    $blog_listing_post_animation_data = 'data-wow-iteration="1" data-wow-duration="'.met_option('blog_listing_post_animation_duration').'s" data-wow-delay="'.met_option('blog_listing_post_animation_delay').'s" data-wow-offset="'.met_option('blog_listing_post_animation_offset').'"';
	}
	
	if($blog_layout == 'masonry'){
		$template_part = 'content_masonry';
	
		$wrapper_html			= '<div class="row">
									'.$sidebarLeft.'
										<div class="'.$content_size_class.'">
											<div id="blog_masonry" class="row grid met_blog_masonry columns_'.$masonry_column_no.' '.($blog_listing_post_animation != 'none' ? 'met_anim_grid' : 'effect-none').'" data-unique-class="'.$grid_unique_class.'">';
	
		$wrapper_html_middle 	=			'</div>';
		$wrapper_html_closing 	= 		'</div>
									'.$sidebarRight.'
								</div>';
	
		$extra = "<script>jQuery(document).ready(function(){CoreJS.theGrid('blog_masonry');})</script>";
	
		wp_enqueue_script('metcreative-isotope');
		wp_enqueue_script('metcreative-imagesLoaded');
	}else{
		$template_part = 'content';
	
		$wrapper_html			= '<div class="row">
									'.$sidebarLeft.'
										<div class="'.$content_size_class.'">';
	
		$wrapper_html_closing	=		'</div>
									'.$sidebarRight.'
									</div>';
		$extra = '';
	}
	/* BLOG LAYOUT | END */ ?>

	<?php
		if( is_page() ){
			if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
			elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
			else { $paged = 1; }

			$args['paged'] = $paged;

			/* ### - posts_per_page - ### */
			$args['posts_per_page'] = get_option('posts_per_page');
			$mb_blog_query_limit = rwmb_meta(MET_MB_PREFIX.'blog_query_limit');
			if( !empty($mb_blog_query_limit) ){
				$args['posts_per_page'] = $mb_blog_query_limit;
			}

			/* ### - blog_query_cat - ### */
			$mb_blog_query_cat = rwmb_meta(MET_MB_PREFIX.'blog_query_cat','type=taxonomy&taxonomy=category');
			if( !empty($mb_blog_query_cat) AND is_array($mb_blog_query_cat) ){
				foreach($mb_blog_query_cat as $mb_blog_query_cat_term){
					$blog_custom_cats[] = $mb_blog_query_cat_term->term_id;
				}
				$args['category__in'] = $blog_custom_cats;
			}

			/* ### - blog_query_orderby - ### */
			$args['orderby'] = 'date';
			$mb_blog_query_orderby = rwmb_meta(MET_MB_PREFIX.'blog_query_orderby');
			if( !empty($mb_blog_query_orderby) AND $mb_blog_query_orderby != '0' ){
				$args['orderby'] = $mb_blog_query_orderby;
			}

			$wp_query = new WP_Query( $args );
		}
	?>

	<?php echo $wrapper_html ?>

	<?php if ( have_posts() ) : ?>
	
		<?php /* Start the Loop */ ?>
		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
	
			<?php
			/* Include the Post-Format-specific template for the content.
			 * If you want to overload this in a child theme then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( $template_part, get_post_format() );
			?>
	
		<?php endwhile; ?>
	
		<?php echo $wrapper_html_middle ?>

		<?php
			if( !isset($met_options['blog_pagination_layout']) OR empty( $met_options['blog_pagination_layout'] ) OR met_option('blog_pagination_layout') == 'classic' ):

			metcreative_content_nav( 'nav-below' );

			else:

			$num_pages = $wp_query->max_num_pages;
			met_post_pagination( array( 'pages' => $num_pages ) );
		?>

		<?php wp_reset_query(); wp_reset_postdata(); ?>

		<?php endif; ?>
	
	<?php else : ?>
	
		<?php get_template_part( 'no-results', 'archive' ); ?>
	
	<?php endif; ?>
	
	<?php echo $wrapper_html_closing; ?>
	
	<?php echo $extra; ?>
	
	<?php get_footer(); ?>