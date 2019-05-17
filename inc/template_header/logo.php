<?php
$the_logo = array(
	'wrapper_class' 		=> '',
	'logo_url' 				=> met_option('logo', 'url'),
	'logo_retina_url' 		=> met_option('logo_retina', 'url'),
	'logo_text' 			=> met_option('logo_text'),
	'sticky_logo_url' 		=> met_option('logo', 'url'),
	'sticky_logo_text' 		=> met_option('logo_text')
);

if(met_option('header_layout') == 2){
	$the_logo['wrapper_class'] = 'met_logo_big clearfix';
}elseif(met_option('header_layout') == 3){
	$the_logo['wrapper_class'] = 'clearfix';
}

if( met_option('sticky_logo_options') === true ){
	$the_logo['sticky_logo_url'] 	= met_option('sticky_logo', 'url');
	$the_logo['sticky_logo_text'] 	= met_option('sticky_logo_text');
}
?>

<!-- Logo Starts -->
<?php if(met_option('header_layout') == 2): ?><div class="met_logo_container clearfix"><?php endif; ?>

	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="met_logo <?php echo $the_logo['wrapper_class'] ?>" data-sticky-src="<?php echo $the_logo['sticky_logo_url'] ?>" data-sticky-text="<?php echo $the_logo['sticky_logo_text'] ?>">

		<?php if( !empty($the_logo['logo_url']) ): ?><img src="<?php echo $the_logo['logo_url'] ?>" data-retina="<?php echo $the_logo['logo_retina_url'] ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/><?php endif ?>

		<?php if( !empty($the_logo['logo_text']) ): ?><span><?php echo $the_logo['logo_text'] ?></span><?php endif; ?>
	</a>

<?php if(met_option('header_layout') == 2): ?></div><?php endif; ?>
<!-- Logo Ends -->