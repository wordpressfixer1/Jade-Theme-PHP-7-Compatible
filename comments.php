<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to metcreative_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package metcreative
 */
?>

<?php
	/*
	 * If the current post is protected by a password and
	 * the visitor has not yet entered the password we will
	 * return early without loading the comments.
	 */
	if ( post_password_required() )
		return;
?>

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>

        <h4>
            <?php
                printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'Jade' ),
                    number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
            ?>
        </h4>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="navigation-comment" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'Jade' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'Jade' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'Jade' ) ); ?></div>
		</nav><!-- #comment-nav-before -->
		<?php endif; // check for comment navigation ?>

		<?php
			/* Loop through and list the comments. Tell wp_list_comments()
			 * to use metcreative_comment() to format the comments.
			 * If you want to overload this in a child theme then you can
			 * define metcreative_comment() and that will be used instead.
			 * See metcreative_comment() in inc/template-tags.php for more.
			 */
			wp_list_comments( array( 'callback' => 'metcreative_comment' ) );
		?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation-comment" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'Jade' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'Jade' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'Jade' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>

	<p class="no-comments"><?php _e( 'Comments are closed.', 'Jade' ); ?></p>

	<?php endif; ?>

	<div class="clearfix"></div>
    <?php if( comments_open() ): ?>
	<div class="met_content_box">
		<header><span><?php _e( 'Leave a Reply', 'default' ) ?></span></header>
		<section>
			<?php
			$commenter = wp_get_current_commenter();
			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );

			$comment_args = array(

				'fields' => apply_filters( 'comment_form_default_fields',

					array(
						'author' => '<input id="author" class="met_half_size" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" placeholder="'.( $req ? '*' : '' ).__('Name').'"' . $aria_req . ' />',

						'email'  => '<input id="email" class="met_half_size met_input_margin" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" placeholder="'.( $req ? '*' : '' ).__('E-Mail').'"' . $aria_req . ' />',

						'url'   => ''
					)
				),

				'comment_field' => '<textarea id="comment" class="met_full_size" name="comment" '.$aria_req.' placeholder="'._x( 'Comment', 'noun' ).'"></textarea>',

			);

			comment_form($comment_args);
			?>
		</section>
	</div>
    <?php endif; ?>