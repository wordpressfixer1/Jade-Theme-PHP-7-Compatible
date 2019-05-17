<div class="met_hard_line_split"></div>
<div class="met_about_author clearfix">
	<?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
	<div>
		<h4><?php echo get_the_author_link(); ?></h4>
		<p><?php the_author_meta('user_description') ?>&nbsp;</p>
	</div>
</div>