<?php
/*
 * Plugin Name: Hyper-Idlik
 * Version: 1
 * Plugin URI: http://gratech.ir/
 * Description: توابع عمومی سیستم
 * Author: Gratech Team
 * Author URI: http://gratech.ir/
 * Text Domain: idlik
 */
defined('ABSPATH') || exit('No Direct Access!!');
define('GTGLOBAL_DIR',plugin_dir_path(__FILE__));
define('GTGLOBAL_URL',plugin_dir_URL(__FILE__));
define('GTGLOBAL_CSS_URL', trailingslashit(GTGLOBAL_URL.'assets/css'));
define('GTGLOBAL_JS_URL', trailingslashit(GTGLOBAL_URL.'assets/js'));
define('GTGLOBAL_IMG_URL', trailingslashit(GTGLOBAL_URL.'assets/img'));
define('GTGLOBAL_INC', trailingslashit(GTGLOBAL_DIR.'include'));
define('GTGLOBAL_ADMIN_DIR', trailingslashit(GTGLOBAL_DIR.'admin'));
require_once( ABSPATH . "wp-includes/pluggable.php" );
include GTGLOBAL_INC . "/posttype/news.php";
include GTGLOBAL_INC . "/metabox/metabox.php";
include GTGLOBAL_INC . "/option/manage.php";
include GTGLOBAL_INC . "/posttype/products.php";
include GTGLOBAL_INC . "/taxonomy/glob.php";
include GTGLOBAL_INC . "/panel/user_meta_fields.php";
function gtglobal_add_theme_scripts() {
	wp_enqueue_style('global-style', GTGLOBAL_CSS_URL.'/style.css');
	wp_enqueue_script('global-script', GTGLOBAL_JS_URL. 'global.js', array ('jquery'));
	wp_enqueue_script('payment-script', GTGLOBAL_JS_URL. 'payment.js', array ('jquery'));
	wp_enqueue_script('chained-script', GTGLOBAL_JS_URL. 'jquery.chained.min.js', array ('jquery'));
	wp_enqueue_script('gt-component', GTGLOBAL_JS_URL. 'component.js', array ('jquery'));
	wp_enqueue_script('gt-script', GTGLOBAL_JS_URL. 'script.js', array ('jquery'));
}
add_action('wp_enqueue_scripts', 'gtglobal_add_theme_scripts' );

