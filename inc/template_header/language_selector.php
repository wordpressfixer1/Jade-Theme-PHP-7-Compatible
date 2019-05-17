<?php
$lang_selector_wrapper_class = '';
if(met_option('header_layout') == 1 OR met_option('header_layout') == 4){
	$lang_selector_wrapper_class = 'met_vcenter met_header_box_right hidden-768';
}elseif(met_option('header_layout') == 2 OR met_option('header_layout') == 3 OR met_option('header_layout') == 5){
	$lang_selector_wrapper_class = 'pull-right';
}
?>

<?php if(met_option('header_lang_selector') AND function_exists('icl_get_languages')): ?>

	<?php
	$languages = icl_get_languages('skip_missing=0&orderby=code');
	if(!empty($languages)):

		//Get active language
		foreach($languages as $l){
			if($l['active']){
				$activeLang = $l;
			}
		}

		/*
		 * @since: v1.2.0
		 * */
		$langLabelStatus = met_option('header_lang_selector_label', false, true);
		if( !$langLabelStatus ){
			$lang_selector_wrapper_class .= ' met_header_language_min';
		}

		?>

		<div class="met_header_language <?php echo $lang_selector_wrapper_class ?>">

			<a href="<?php echo $activeLang['url'] ?>" class="met_active_language met_vcenter">
				<img src="<?php echo $activeLang['country_flag_url'] ?>" alt="<?php echo $activeLang['language_code'] ?>" />

				<?php if( $langLabelStatus ): ?>
					<span><?php echo icl_disp_language($activeLang['native_name'], $activeLang['translated_name']) ?></span>
				<?php endif; ?>

				<i class="fa fa-sort-down"></i>
			</a>

			<?php
			echo '<ul class="met_clean_list">';
			foreach($languages as $l){
				echo '<li>';

				echo '<a ';
				if(!$l['active']) echo 'href="'.$l['url'].'"';
				echo '>';

				echo icl_disp_language($l['native_name'], $l['translated_name']);

				if($l['country_flag_url']){
					echo '<img src="'.$l['country_flag_url'].'" alt="'.$l['language_code'].'" />';
				}

				if(!$l['active']) echo '</a>';

				echo '</li>';
			}
			echo '</ul>';
			?>
		</div>
	<?php endif; ?>
<?php endif; ?>
