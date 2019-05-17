<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package metcreative
 */

/*
 * Page Information Bar (The PIB)
 * */
function metcrative_pib (){

	if(function_exists( 'breadcrumb_trail' )){

		$breadcrumb_defaults = array(
			'container'       => 'ul',   // container element
			'separator'       => '&#47;', // separator between items
			'before'          => '',      // HTML to output before
			'after'           => '',      // HTML to output after
			'show_on_front'   => true,    // whether to show on front
			'network'         => false,   // whether to create trail back to main site (multisite)
			'show_title'      => true,    // whether to show the current page title
			'show_browse'     => false,    // whether to show the "browse" text
			'echo'            => true,    // whether to echo or return the breadcrumbs

			/* Post taxonomy (examples follow). */
			'post_taxonomy' => array(
				'dslc_projects'  => 'dslc_projects_cats', // 'post' post type and 'post_tag' taxonomy
				// 'book'  => 'genre',    // 'book' post type and 'genre' taxonomy
			),
		);

	}

	$breadcrumb_trail_items = breadcrumb_trail_items($breadcrumb_defaults);

	$the_title 	= array_pop($breadcrumb_trail_items);
	$pib_desc = '';
	$pib_nav = false;

	$pib_category = '';
	if(is_single() AND get_post_type() == 'dslc_projects'){
		$project_term = wp_get_post_terms( get_the_ID(), 'dslc_projects_cats' );
		if($project_term){
			$pib_category = '<div class="met_portfolio_filters_wrap met_bgcolor"><span>'.$project_term[0]->name.'</span></div>';
		}

		$the_title = met_option('projects_item_label');
		$pib_desc 	= array_pop($breadcrumb_trail_items);

		$prev_project = get_adjacent_post( true, '', true, 'dslc_projects_cats' );
		$next_project = get_adjacent_post( true, '', false, 'dslc_projects_cats' );
		$listing_page_id = met_option('projects_listing_page');

		$pib_nav = '<div class="pib_nav">';
        if(!empty($prev_project)) $pib_nav .= '<a class="pib_nav_prev" href="'.get_permalink($prev_project->ID).'"><i class="fa fa-angle-left"></i></a>';
        if(!empty($listing_page_id)) $pib_nav .= '<a class="pib_nav_list" href="'.get_permalink($listing_page_id).'"><i class="fa fa-th"></i></a>';
		if(!empty($next_project)) $pib_nav .= '<a class="pib_nav_next" href="'.get_permalink($next_project->ID).'"><i class="fa fa-angle-right"></i></a>';
		$pib_nav .= '</div>';
	}

	if(is_404()){
		$the_desc 	= __('Page not found','Jade');
	}else{
		if(is_page()){
			$pib_desc = rwmb_meta('met_pib_description');
		}
		$the_desc 	= $pib_desc;
	}

	echo '
	<div class="met_content met_page_head_wrap">
        <div class="met_fullwidth_item">
            <div class="met_content">
                <div class="met_page_head clearfix">
                    <h1>'.$the_title.'</h1>
                    '.$pib_category.'
                    <h2 class="hidden-360">'.$the_desc.'</h2>';
					if($pib_nav === false){
						if(met_option('pib_breadcrumb')) breadcrumb_trail($breadcrumb_defaults);
					}else{
						echo $pib_nav;
					}
                echo '</div>
            </div>
        </div>
    </div>
	';
}

if ( ! function_exists( 'metcreative_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function metcreative_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<nav class="<?php echo $nav_class; ?>" id="<?php echo esc_attr( $nav_id ); ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'metcreative' ); ?></h1>
		<ul class="pagination met_pagination">
	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<li class="nav-previous">%link</li>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'metcreative' ) . '</span> %title' ); ?>
		<?php next_post_link( '<li class="nav-next">%link</li>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'metcreative' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<li class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'metcreative' ) ); ?></li>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<li class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'metcreative' ) ); ?></li>
		<?php endif; ?>

	<?php endif; ?>
		</ul><!-- #<?php echo esc_html( $nav_id ); ?> -->
	</nav>
	<?php
}
endif; // metcreative_content_nav

if(!function_exists('met_post_pagination')):
	/**
	 * Display navigation to numeric pages when applicable
	 */
	function met_post_pagination( $atts ) {
		if( is_front_page() ) { $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1; } else { $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; }

		if ( ! isset( $atts['force_number'] ) ) $force_number = false; else $force_number = $atts['force_number'];
		if ( ! isset( $atts['pages'] ) ) $pages = false; else $pages = $atts['pages'];
		$range = 2;

		$showitems = ($range * 2)+1;

		if ( empty ( $paged ) ) { $paged = 1; }

		if ( $pages == '' ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if( ! $pages ) {
				$pages = 1;
			}
		}

		if( 1 != $pages ) {

			?>
			<ul class="met_pagination pagination">
				<?php
				if($paged > 2 && $paged > $range+1 && $showitems < $pages) { echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>"; }
				if($paged > 1 && $showitems < $pages) { echo "<li><a href='".get_pagenum_link($paged - 1)."' >&lsaquo;</a></li>"; }

				for ($i=1; $i <= $pages; $i++){
					if (1 != $pages &&(!($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems)){
						echo ($paged == $i)? "<li class='active'><a href='".get_pagenum_link($i)."'>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
					}
				}

				if ($paged < $pages && $showitems < $pages) { echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>"; }
				if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) { echo "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>"; }

				?>
			</ul><!-- .dslc-pagination --><?php
		}

	}
endif; // met_post_pagination

if ( ! function_exists( 'metcreative_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function metcreative_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' : ?>
            <div class="n_comment_box post pingback">
                <blockquote><?php _e( 'Pingback:', 'metcreative' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'metcreative' ), ' -- <span class="edit-link">', '<span>' ); ?></blockquote>
            </div><?php
            break;
            default : ?>
                <div id="div-comment-<?php comment_ID(); ?>" class="met_comment_box <?php if ($comment->comment_author_email == get_the_author_meta('email')){echo 'bypostauthor';} ?>">
                    <div class="met_comment clearfix" id="comment-<?php comment_ID(); ?>">
                        <div class="met_comment_wrapper">
                            <?php echo get_avatar( $comment, 50 ); ?>

                            <div class="clearfix met_comment_descr">
                                <h5><?php printf( __( '%s <span class="says">says:</span>', 'metcreative' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?></h5>

                                <div class="met_comment_reply_link met_bgcolor met_bgcolor_transition2"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>
                                <div class="met_comment_text"><?php comment_text(); ?></div>

                                <span class="met_comment_date met_color2">
                                    <time datetime="<?php comment_time( 'c' ); ?>">
                                        <?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'metcreative' ), get_comment_date(), get_comment_time() ); ?>
                                    </time>
                                </span>

                                <div class="met_comment_edit_link met_color"><?php edit_comment_link( __( 'Edit', 'metcreative' ) ); ?></div>
                            </div>
                        </div>
                    </div>
                </div><?php
			break;
	endswitch;
}
endif; // ends check for metcreative_comment()

if ( ! function_exists( 'metcreative_post_meta_date' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time
 */
function metcreative_post_meta_date() {
	printf( '<a href="%1$s" title="%2$s" rel="bookmark" class="met_post_meta_date"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
}
endif;

if ( ! function_exists( 'metcreative_post_meta_author' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function metcreative_post_meta_author() {
		printf( __( '<span class="byline"> by <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></span>', 'metcreative' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'metcreative' ), get_the_author() ) ),
			get_the_author()
		);
	}
endif;
/**
 * Returns true if a blog has more than 1 category
 */
function metcreative_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so metcreative_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so metcreative_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in metcreative_categorized_blog
 */
function metcreative_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'metcreative_category_transient_flusher' );
add_action( 'save_post', 'metcreative_category_transient_flusher' );