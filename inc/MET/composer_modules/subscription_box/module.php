<?php

// Register Module
function register_subsbox_module() {
    return dslc_register_module( "MET_SubscriptionBox" );
}
add_action('dslc_hook_register_modules','register_subsbox_module');

class MET_SubscriptionBox extends DSLC_Module {

    var $module_id = 'MET_SubscriptionBox';
    var $module_title = 'Mailchimp Subscription';
    var $module_icon = 'info';
    var $module_category = 'met - socials & contact';

    function options() {

        $dslc_options = array(

            /**
             * Click to Edit Contents
             */
            array(
                'label' => __( 'Title', 'dslc_string' ),
                'id' => 'first_title',
                'std' => 'Click to edit.',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Second Title', 'dslc_string' ),
                'id' => 'second_title',
                'std' => 'Click to edit.',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'First Icon', 'dslc_string' ),
                'id' => 'first_icon_text',
                'std' => '+90 547 854 14 57',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Second Icon', 'dslc_string' ),
                'id' => 'second_icon_text',
                'std' => 'mail@yourdomain.com',
                'type' => 'text',
                'visibility' => 'hidden'
            ),



            /**
             * Elements Visibility Options
             */
            array(
                'label' => __( 'Elements', 'dslc_string' ),
                'id' => 'elements',
                'std' => 'subscription_box information_box first_title second_title phone_number mail_address',
                'type' => 'checkbox',
                'choices' => array(
                    array(
                        'label' => __( 'Subscription Box', 'dslc_string' ),
                        'value' => 'subscription_box'
                    ),
                    array(
                        'label' => __( 'Information Box', 'dslc_string' ),
                        'value' => 'information_box'
                    ),
                    array(
                        'label' => __( 'First Title', 'dslc_string' ),
                        'value' => 'first_title'
                    ),
                    array(
                        'label' => __( 'Second Title', 'dslc_string' ),
                        'value' => 'second_title'
                    ),
                    array(
                        'label' => __( 'Phone Number', 'dslc_string' ),
                        'value' => 'phone_number'
                    ),
                    array(
                        'label' => __( 'Mail Address', 'dslc_string' ),
                        'value' => 'mail_address'
                    ),
                )
            ),

            array(
                'label' => __( 'MailChimp URL', 'dslc_string' ),
                'id' => 'mailchimp_url',
                'std' => 'http://metcreative.us5.list-manage1.com/subscribe?u=55b3622776b1150a7da7f0392&id=a18b146e98',
                'type' => 'text',
				'help' => 'Right Click -> Open in new tab: <a href="https://www.screenr.com/kIXN" target="_blank">How to find MailChimp URL?</a>'
            ),

            /**
             * Icons
             */
            array(
                'label' => __( 'First Icon', 'dslc_string' ),
                'id' => 'first_icon',
                'std' => 'phone',
                'type' => 'icon',
                'section' => 'styling',
                'tab' => __( 'First Icon', 'dslc_string' )
            ),
            array(
                'label' => __( 'Second Icon', 'dslc_string' ),
                'id' => 'second_icon',
                'std' => 'envelope',
                'type' => 'icon',
                'section' => 'styling',
                'tab' => __( 'Second Icon', 'dslc_string' )
            ),
        );

        $dslc_options = array_merge(
            $dslc_options,

            // Input
            lc_general('form input', '', array('background-color' => '','font-size' => '12', 'line-height' => '20','color' => ''),'Input'),

            // Button
            lc_general('form button', '', array('background-color' => '','background-color:hover' => '', 'color' => '','color:hover' => '','font-size' => '12', 'line-height,height' => '40'),'Button'),

            // Subscription Box
            lc_general('form', 'Subscription Box', array('background-color' => '')),

            // Subscription Box Title
            lc_general('form h5', 'Subscription Box', array('font-size' => '16', 'line-height' => '17','color' => ''), 'Title'),

            // Subscription Box Paddings
            lc_paddings('form', 'Subscription Box', array('t' => '30', 'r' => '30', 'b' => '30', 'l' => '30'), 'Padding'),

            // Subscription Box Borders
            lc_borders('form', 'Subscription Box', array(), array(), '0', '#FFFFFF', 'solid', 'Border' ),

            // Subscription Box Border Radius
            lc_borderRadius('form', 'Subscription Box', 'Border Radius'),

            // Information Box
            lc_general('aside', 'Information Box', array('background-color' => '')),

            // Information Box Title
            lc_general('aside h5', 'Information Box', array('font-size' => '16', 'line-height' => '17','color' => ''), 'Title'),

            // Information Box Paddings
            lc_paddings('aside', 'Information Box', array('t' => '30', 'r' => '30', 'b' => '30', 'l' => '30'), 'Padding'),

            // Information Box Borders
            lc_borders('aside', 'Information Box', array(), array(), '0', '#FFFFFF', 'solid', 'Border' ),

            // Information Box Border Radius
            lc_borderRadius('aside', 'Information Box', 'Border Radius'),

            // First Icon
            lc_general('.first_icon i', 'First Icon', array('color' => '', 'color:hover' => '', 'font-size' => '18', 'width,height,line-height' => '20')),

            // First Icon Text
            lc_general('.first_icon span,.first_icon a', 'First Icon', array('font-size' => '12', 'line-height' => '22','color' => '', 'color:hover' => ''), 'Text'),

            // Second Icon
            lc_general('.second_icon i', 'Second Icon', array('color' => '', 'color:hover' => '', 'font-size' => '18', 'width,height,line-height' => '20')),

            // Second Icon Text
            lc_general('.second_icon span,.second_icon a', 'Second Icon', array('font-size' => '12', 'line-height' => '22','color' => '', 'color:hover' => ''), 'Text')
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

        // Main Elements
        $elements = $options['elements'];
        if ( ! empty( $elements ) )
            $elements = explode( ' ', trim( $elements ) );
        else
            $elements = array();

		$mailchimp_url = $options["mailchimp_url"];
		$mailchimp_s_url = '';
		$mailchimp_data = array('','');

		if( !empty( $options["mailchimp_url"] ) ){
			$mailchimp_data = explode('?u=', $mailchimp_url);
			if( isset($mailchimp_data[1]) ){
				$mailchimp_s_url = $mailchimp_data[0];
				$mailchimp_data = explode('&id=',$mailchimp_data[1]);
			}else{
				$mailchimp_data = array('','');
			}
		}
        ?>

        <div class="met_subscribe_box clearfix <?php echo $met_shared_options['classes'] ?>" <?php echo $met_shared_options['data-']; ?>>
            <?php if( in_array( 'subscription_box', $elements ) ) : ?>
            <form method="GET" action="<?php echo $mailchimp_s_url ?>" target="_blank">
                <?php if( in_array( 'first_title', $elements ) ) : ?><h5 class="dslca-editable-content" data-id="first_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['first_title']); ?></h5><?php endif; ?>
                <input type="email" required="" placeholder="<?php _e('Email Address','Jade') ?>" name="EMAIL">
				<input type="hidden" name="u" value="<?php echo $mailchimp_data[0] ?>">
				<input type="hidden" name="id" value="<?php echo $mailchimp_data[1] ?>">
                <button class="met_bgcolor_transition" type="submit"><i class="dslc-icon dslc-icon-chevron-right"></i></button>
            </form>
            <?php endif; ?>
            <?php if( in_array( 'information_box', $elements ) ) : ?>
            <aside>
                <?php if( in_array( 'second_title', $elements ) ) : ?><h5 class="dslca-editable-content" data-id="second_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['second_title']); ?></h5><?php endif; ?>

                <?php if( in_array( 'phone_number', $elements ) ) { ?>
                <?php if( $dslc_is_admin ): ?>
                    <div class="met_icon_text first_icon clearfix"><div class="met_icon_text_icon_box"><i class="dslc-icon dslc-icon-<?php echo $options['first_icon'] ?>"></i></div><span class="dslca-editable-content" data-id="first_icon_text" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['first_icon_text']); ?></span></div>
                <?php elseif( !empty($options['first_icon_text'] ) && !$dslc_is_admin): ?>
                    <div class="met_icon_text first_icon clearfix"><div class="met_icon_text_icon_box"><i class="dslc-icon dslc-icon-<?php echo $options['first_icon'] ?>"></i></div><span><?php echo stripslashes($options['first_icon_text']); ?></span></div>
                <?php endif; ?>
                <?php } ?>

                <?php if( in_array( 'mail_address', $elements ) ) { ?>
                <?php if( $dslc_is_admin ): ?>
                    <div class="met_icon_text second_icon clearfix"><div class="met_icon_text_icon_box"><i class="dslc-icon dslc-icon-<?php echo $options['second_icon'] ?>"></i></div><span class="dslca-editable-content" data-id="second_icon_text" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['second_icon_text']); ?></span></div>
                <?php elseif( !empty($options['second_icon_text'] ) && !$dslc_is_admin): ?>
                    <div class="met_icon_text second_icon clearfix"><div class="met_icon_text_icon_box"><i class="dslc-icon dslc-icon-<?php echo $options['second_icon'] ?>"></i></div><span><?php echo stripslashes($options['second_icon_text']); ?></span></div>
                <?php endif; ?>
                <?php } ?>
            </aside>
            <?php endif; ?>
        </div>

        <?php echo $met_shared_options['script']; ?>
        <?php

        /* Module output ends here */

        $this->module_end( $options );

    }

}