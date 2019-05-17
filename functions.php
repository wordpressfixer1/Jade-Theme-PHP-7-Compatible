<?php
/*
 * Define Theme Constants
 * **************************************/
define('MET_DEV_MODE', false);
define('MET_MB_PREFIX','met_');
define('MET_TEXTDOMAIN','Jade');
//define('THEME_LC_VER', '1.1.7' );

global $met_dev_log;
$met_dev_log = array();

/*
 * Locale
 * **************************************/
load_theme_textdomain('Jade', get_template_directory() . '/languages' );

/*
 * Content Width
 * **************************************/
if ( ! isset( $content_width ) ) $content_width = 1170;

/*
 * Shortcodes
 * **************************************/
require_once get_template_directory() . '/inc/MET/shortcodes_init.php';

/*
 * Custom Widgets
 * **************************************/
require_once get_template_directory() . '/inc/MET/widgets/twitter.php';
require_once get_template_directory() . '/inc/MET/widgets/custom_menu.php';
require_once get_template_directory() . '/inc/MET/widgets/post_tabs.php';
require_once get_template_directory() . '/inc/MET/widgets/flickr.php';

/*
 * Classes / Helper Functions
 * **************************************/
require_once get_template_directory() . '/inc/MET/helper_functions.php';
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
require_once get_template_directory() . '/inc/class-aq-resizer.php';
require_once get_template_directory() . '/inc/class-breadcrumb-trail.php';
require_once get_template_directory() . '/inc/class-sidebar-generator.php';

/*
 * Redux INIT
 * **************************************/
require_once get_template_directory() . '/inc/MET/admin/admin-init.php';

/*
 * Meta-Box INIT
 * *************************************/
define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/inc/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/inc/meta-box' ) );

require_once RWMB_DIR . 'meta-box.php';

require_once get_template_directory() . '/inc/MET/metabox_config.php';
require_once get_template_directory() . '/inc/MET/metabox_config.php';

/*
 * METCreative INIT
 * **************************************/
require_once get_template_directory() . '/inc/MET/class-mc-framework.php';

/*
 * Core Customizations
 * **************************************/
require_once get_template_directory() . '/inc/MET/extend_nav.php';

/*
 * Live Composer INIT
 * **************************************/
require_once get_template_directory() . '/inc/MET/live_composer_init.php';

/*
 * WooCommerce INIT
 * **************************************/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require_once get_template_directory() . '/inc/MET/woocommerce_init.php';
}

/*
 * Automatic Theme Updates
 * **************************************/
require_once get_template_directory() . '/inc/wp-updates-theme.php';
new WPUpdatesThemeUpdater_936( 'http://wp-updates.com/api/2/theme', basename( get_template_directory() ), met_option('envato_purchase_code', false, null) );
