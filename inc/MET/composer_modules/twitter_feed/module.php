<?php

// Register Module
function register_twitterfeed_module() {
    return dslc_register_module( "MET_TwitterFeed" );
}
add_action('dslc_hook_register_modules','register_twitterfeed_module');

class MET_TwitterFeed extends DSLC_Module {

    var $module_id = 'MET_TwitterFeed';
    var $module_title = 'Twitter Feed Rotator';
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

        $dslc_options = array_merge(
            $dslc_options,
            // Title
            lc_general('h4', 'Title', array('text-align' => 'center', 'color' => '#393F49', 'font-size' => '24', 'line-height' => '27', 'font-weight' => '600')),

            // Content
            lc_general('.met_twitter_feed_item', '', array('text-align' => 'center', 'color' => '#393F49', 'font-size' => '24', 'line-height' => '27', 'font-weight' => '400')),

            // Links
            lc_general('.met_twitter_feed_item a', 'Links', array('color' => '#000000', 'color:hover' => '#000000', 'font-size' => '24', 'line-height' => '27', 'font-weight' => '600'))
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

        $elementID = uniqid('twitter_feed_');

		$the_tweets = MC_Framework_Core::get_tweets($options['username'], $options['amount']);
        ?>
        <?php if( $dslc_is_admin ): ?>
            <h4 class="met_twitter_feed_title dslca-editable-content" data-id="head_title" data-type="simple" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php echo stripslashes($options['head_title']); ?></h4>
        <?php elseif( !empty($options['head_title'] ) && !$dslc_is_admin): ?>
            <h4 class="met_twitter_feed_title"><?php echo stripslashes($options['head_title']); ?></h4>
        <?php endif; ?>
        <div id="<?php echo $elementID ?>" class="met_twitter_feed">
            <?php
            if(count($the_tweets) > 0){
                foreach($the_tweets as $the_tweet_item){
                    echo '<div class="met_twitter_feed_item">'.$the_tweet_item.'</div>';
                }
            }
            ?>
        </div>
        <?php if( $options['navigation'] == 'active' ) : ?>
        <nav id="<?php echo $elementID ?>_nav" class="met_twitter_feed_nav">
            <a href="#" class="prev met_color_transition"><i class="dslc-icon dslc-icon-chevron-left"></i></a>
            <a href="#" class="next met_color_transition"><i class="dslc-icon dslc-icon-chevron-right"></i></a>
        </nav>
        <?php endif; ?>
        <script>jQuery(document).ready(function(){CoreJS.loadAsync(<?php echo $asyncScripts; ?>,["twitter_feed|<?php echo $elementID ?>"]);});</script>
        <?php

        /* Module output ends here */
        $this->module_end( $options );

    }

}