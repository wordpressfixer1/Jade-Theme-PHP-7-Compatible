<?php

// Register Module
function register_cfseven_module() {
	return dslc_register_module( "MET_ContactForm7" );
}
add_action('dslc_hook_register_modules','register_cfseven_module');

class MET_ContactForm7 extends DSLC_Module {

	var $module_id = 'MET_ContactForm7';
	var $module_title = 'Contact Form 7';
	var $module_icon = 'envelope';
	var $module_category = 'met - socials & contact';

	function options() {

		$args = array(
			'post_type' => 'wpcf7_contact_form',
			'posts_per_page' => -1,
		);

		$choices = array();

		$choices[] = array(
			'label' => __( '-- Select --', 'dslc_string' ),
			'value' => 'not_set',
		);

		$dslc_query = new WP_Query( $args );

		if($dslc_query->have_posts()) {

			while ( $dslc_query->have_posts() ) { $dslc_query->the_post();
				$choices[] = array(
					'label' => get_the_title(),
					'value' => get_the_ID()
				);
			}

		}

		wp_reset_query();

		$dslc_options = array(
			array(
				'label' => __( 'Contact Form', 'dslc_string' ),
				'id' => 'form_id',
				'std' => 'not_set',
				'type' => 'select',
				'choices' => $choices
			)
		);

		$dslc_options = met_lc_extras($dslc_options, array('animation','parallax'), 'shared_options');

		$dslc_options = array_merge( $dslc_options, $this->presets_options() );
		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		global $dslc_active;

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
			$dslc_is_admin = true;
		else
			$dslc_is_admin = false;

		$this->module_start( $options );

        /* Animation */
        

		$met_shared_options = met_lc_extras( $options, array(
			'groups'   => array('animation', 'parallax'),
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

		if ( ! isset( $options['form_id'] ) || $options['form_id'] == 'not_set' ) {

			if ( $dslc_is_admin ) :
				?><div class="dslc-notification dslc-red"><?php _e( 'Click the cog icon on the right of this box to choose which form to show.', 'dslc_string' ); ?> <span class="dslca-module-edit-hook dslc-icon dslc-icon-cog"></span></span></div><?php
			endif;

		} else {

			if ( $dslc_active ) :
				?><div class="dslc-notification dslc-green"><?php _e( 'Save changes and disable composer to show form.', 'dslc_string' ); ?> </div><?php
			endif;

			if(!$dslc_active){
                echo '<div class="'.$met_shared_options['classes'].'"'.$met_shared_options['data-'].'>'.do_shortcode('[contact-form-7 id="'.$options['form_id'].'" title=""]').'</div>';
                echo $met_shared_options['script'];
            }



		}


		/* Module output ends here */

		$this->module_end( $options );

	}

}