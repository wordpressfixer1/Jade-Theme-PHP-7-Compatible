<div class="footer_wrap">
	<footer class="footer">
		<div class="met_content">

			<?php if(met_option('footer_widgets_area')): ?>
				<div class="row">
					<?php
						for($i = 1; $i <= met_option('footer_column_no'); $i++){
							$current_column_size = met_option('footer_column_'.$i.'_width');
							echo '<div class="col-md-'.$current_column_size.' clear_margin_bottom">';
							( ( is_active_sidebar( 'footer-sidebar-'.$i ) ) ? dynamic_sidebar( 'footer-sidebar-'.$i ) : '' );
							echo '</div>';
						}
					?>
				</div>
			<?php endif; ?>

			<?php if(met_option('footer_bar')): ?>
				<div class="row">
					<div class="col-md-12 clear_margin_bottom">
						<div class="met_footer_bar clearfix">
							<?php if(met_option('footer_bar_area_one_type') == 1): ?>
								<?php get_template_part('inc/template_footer/menu') ?>
							<?php else: ?>
								<div class="met_footer_bar_content pull-left"><?php get_template_part('inc/template_footer/custom_text') ?></div>
							<?php endif; ?>

							<?php get_template_part('inc/template_footer/socials') ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

		</div>
	</footer>
</div>