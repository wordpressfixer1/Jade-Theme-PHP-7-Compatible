<?php

// Register Module
function register_tboxfeed_module() {
    return dslc_register_module( "MET_TwitterBoxFeed" );
}
add_action('dslc_hook_register_modules','register_tboxfeed_module');

class MET_TwitterBoxFeed extends DSLC_Module {

    var $module_id = 'MET_TwitterBoxFeed';
    var $module_title = 'Twitter Feed Boxed';
    var $module_icon = 'info';
    var $module_category = 'met - socials & contact';

    function options() {

        $dslc_options = array(
            array(
                'label' => __( 'Title', 'dslc_string' ),
                'id' => 'head_title',
                'std' => '@johndoe',
                'type' => 'text',
                'visibility' => 'hidden'
            ),
            array(
                'label' => __( 'Username', 'dslc_string' ),
                'id' => 'username',
                'std' => 'envato',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Tweet Amount', 'dslc_string' ),
                'id' => 'amount',
                'std' => '20',
                'type' => 'text',
            ),
            array(
                'label' => __( 'Navigation', 'dslc_string' ),
                'id' => 'navigation',
                'std' => 'passive',
                'type' => 'select',
                'choices' => array(
                    array(
                        'label' => __( 'Passive', 'dslc_string' ),
                        'value' => 'passive',
                    ),
                    array(
                        'label' => __( 'Active', 'dslc_string' ),
                        'value' => 'active'
                    ),
                ),
            ),
        );

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

        /* Module output starts here */
        $asyncScripts = "[]";
        if ( $dslc_is_admin )
            $asyncScripts = '["'.get_template_directory_uri().'/js/jquery.bxslider.min.js"]';
        else
            wp_enqueue_script('metcreative-bxslider');

        if ( empty( $options['amount'] ) ) $options['amount'] = 20;

        $elementID = uniqid('twitter_box_feed_');

		$the_tweets = MC_Framework_Core::get_tweets($options['username'], $options['amount']);
        ?>

        <div id="<?php echo $elementID; ?>" class="met_twitter_box_feed_wrap" data-speed="1000" data-pause="6000" data-visible="4" data-autoplay="1">
            <header class="clearfix">
                <i class="dslc-icon dslc-icon-twitter"></i>
                <span>Our Stream</span>
                <nav>
                    <a href="#" class="next"><i class="dslc-icon dslc-icon-chevron-up"></i></a>
                    <a href="#" class="prev"><i class="dslc-icon dslc-icon-chevron-down"></i></a>
                </nav>
            </header>
            <section>
                <div class="met_twitter_box_feed_item clearfix">
                    <i class="dslc-icon dslc-icon-twitter"></i>
                    <div class="met_twitter_box_feed_item_content">Twitter test tweet.</div>
                </div>
                <div class="met_twitter_box_feed_item clearfix">
                    <i class="dslc-icon dslc-icon-twitter"></i>
                    <div class="met_twitter_box_feed_item_content">Twitter test tweet.</div>
                </div>
                <div class="met_twitter_box_feed_item clearfix">
                    <i class="dslc-icon dslc-icon-twitter"></i>
                    <div class="met_twitter_box_feed_item_content">Twitter test tweet.</div>
                </div>
                <div class="met_twitter_box_feed_item clearfix">
                    <i class="dslc-icon dslc-icon-twitter"></i>
                    <div class="met_twitter_box_feed_item_content">Twitter test tweet.</div>
                </div>
                <div class="met_twitter_box_feed_item clearfix">
                    <i class="dslc-icon dslc-icon-twitter"></i>
                    <div class="met_twitter_box_feed_item_content">Twitter test tweet.</div>
                </div>
            </section>
        </div>
        <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["twitter_box_feed|<?php echo $elementID ?>"]);});</script>
        <?php

        /* Module output ends here */
        $this->module_end( $options );

    }

}