<?php
	require_once get_template_directory() . '/inc/MET/metabox_handler.php'; // If page specific options set via metabox, overwrite theme options
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php if(met_option('responsive')): ?><meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1" /><?php endif; ?>

	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php echo met_option('custom_head_codes') ?>
	<?php wp_head(); ?>
</head>

<?php global $mb_fsc_options,$dslc_active,$mb_pl_options,$custom_preloader_options; ?>
<?php
	$pageLoadingOverlay = isset($mb_fsc_options) && !empty($mb_fsc_options) && $mb_fsc_options['fullscreen_scrolling'] == 'true' && !$dslc_active ? '<div class="met_page_loading_overlay"></div>' : '';
	$pageLoadingPadding = !empty($pageLoadingOverlay) && !$dslc_active ? 'met_page_loading_padding' : '';

	$fontSmoothing = met_option('font_smoothing');
	$fontSmoothing = $fontSmoothing === true || $fontSmoothing == '1' ? 'met_font_smoothing' : '';

	$pagePlOverlay = '';
	if( isset($mb_pl_options) && !empty($mb_pl_options['barColor']) && !$dslc_active && $custom_preloader_options ){
		$pagePlOverlay = '<div id="met_page_pl_overlay" style="background-color:'.$mb_pl_options['backgroundColor'].';"></div>';
	}
?>

<body <?php body_class($pageLoadingPadding.' '.$fontSmoothing); ?>>
<?php echo $pageLoadingOverlay; ?>
<?php echo $pagePlOverlay; ?>

<?php if(met_option('scroll_up')): ?>
    <a href="#" id="met_scroll_up"><i class="fa fa-angle-up"></i></a>
    <script>jQuery(document).ready(function(){CoreJS.scrollUp()});</script>
<?php endif; ?>

<?php if(met_option('responsive')) get_template_part('inc/template_responsive/menu') ?>

<div class="met_wrapper">

	<?php if(met_option('sidenav_status') && ( !isset($mb_fsc_options) || empty($mb_fsc_options) || $mb_fsc_options['fullscreen_scrolling'] != 'true' ) ) get_template_part('inc/template_sidenav/layout') ?>

	<?php if( met_option('loading_bar') && !$custom_preloader_options ): wp_enqueue_script('metcreative-page-loader-bar') ?><div id="met_page_loading_bar"></div><?php endif; ?>

	<?php met_page_slider('above'); ?>

	<?php
		$stickyOptions = '';
		if(met_option('header_layout') != '2' && met_option('sticky_header')){
			$stickyOptions = ' data-stickyheight="'.met_option('sticky_header_height').'px"';
		}
	?>

	<?php if( $header_display_status ): ?>

	<?php
		$is_header_sticky = met_option('sticky_header');
		if($is_header_sticky) echo '<script>jQuery(document).ready(function(){CoreJS.stickyHeader()});</script>';
	?>

	<!-- .met_header_wrap | Start -->
	<div class="met_header_wrap met_header_id_<?php echo met_option('header_layout') ?> <?php echo ( (met_option('header_wide')) ? 'met_fixed_wide_header' : '' ) ?> <?php echo ( ($is_header_sticky) ? 'met_fixed_header' : '' ) ?> <?php global $dslc_active; echo ( (((isset($header_on_content_status) && $header_on_content_status) || met_option('header_on_content')) && !$dslc_active) ? 'met_header_on_content' : '' ) ?>" <?php echo $stickyOptions ?>>
		<?php if( $header_tb_display_status && met_option('header_layout') != '4' ) get_template_part('inc/template_header/top_bar') ?>

		<header class="met_content clearfix">
			<?php get_template_part('inc/template_header/layout',met_option('header_layout')) ?>
		</header>

		<?php if(met_option('header_layout') == '4') get_template_part('inc/template_header/menu','1'); ?>

		<?php if(met_option('header_search')): ?>
		<div class="met_header_search_wrap">
			<div class="met_content">
				<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="clearfix">
					<input type="text" class="met_header_search_term" name="s" placeholder="<?php _e('Type and Hit Enter','Jade') ?>" />
					<div class="closer">X</div>
				</form>
			</div>
		</div>
		<script>jQuery(document).ready(function(){CoreJS.headerSearch()});</script>
		<?php endif; ?>
	</div>
	<!-- .met_header_wrap | End -->

	<?php endif; //$header_display_status ?>

<div class="met_page_wrapper">

    <?php if ( get_post_meta( get_the_ID(), 'dslc_code', true ) || isset( $_GET['dslc'] ) ) {} else { ?> <div class="met_content"> <?php } ?>
    <?php if(met_option('pib_status')) metcrative_pib(); ?>
	<?php met_page_slider('below'); ?>
