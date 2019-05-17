<?php
	$logo_spacing = met_option('logo_spacing');
	$logo_text = met_option('logo_text');
	$logo = met_option('logo');
?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="met_logo" style="padding-top: <?php echo $logo_spacing['padding-top'] ?>; padding-bottom: <?php echo $logo_spacing['padding-bottom'] ?>"  data-padding-top="<?php echo $logo_spacing['padding-top'] ?>" data-padding-bottom="<?php echo $logo_spacing['padding-bottom'] ?>">
	<div>
		<?php if( !empty($logo['url']) ): ?><img src="<?php echo met_option('logo','url') ?>" data-retina="<?php echo met_option('logo_retina','url') ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" height="<?php echo met_option('logo_height','height') ?>"/><?php endif ?>
		<?php if(!empty($logo_text)): ?><span><?php echo $logo_text ?></span><?php endif; ?>
	</div>
</a>