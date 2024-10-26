<?php
/**
 * Plugin Name:       Product Fields Admin
 * Plugin URI:        https://sarahjobs.com/wordpress/plugins/product-fields-admin
 * Description:       Product Fields Admin for WooCommerce
 * Version:           0.1.0
 * Author:            Sarah Siqueira
 * Author URI:        https://sarahjobs.com/about
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl.html
 * Text Domain:       product-fields-admin
 *
 *  @package Product_Fields_Admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Bootstraps the plugin.
 */
// require __DIR__ . '/inc/class-render.php';
// require __DIR__ . '/inc/class-register.php';
// require __DIR__ . '/inc/class-validations.php';
require __DIR__ . '/inc/class-admin.php';
require __DIR__ . '/inc/class-fields-handler.php';
require __DIR__ . '/inc/class-connect.php';


// use ProductFieldsAdmin\Inc\Register;
// use ProductFieldsAdmin\Inc\Render;
// use ProductFieldsAdmin\Inc\Validations;
use ProductFieldsAdmin\Inc\Admin;
use ProductFieldsAdmin\Inc\FieldsHandler;
use ProductFieldsAdmin\Inc\Connect;


// Register::singleton();
// Render::singleton();
// new Admin( new Render() );
// FieldsHandler::singleton();
// Validations::singleton();


$fields_handler = new FieldsHandler();
$admin          = new Admin( $fields_handler );
$connect        = new Connect( $fields_handler );


// Hook into the admin_enqueue_scripts action
add_action( 'admin_enqueue_scripts', 'admin_script' );

function admin_script() {
	// Check if we are on the product edit page
	global $pagenow;
	if ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) {
		// Only enqueue on the product edit pages
		if ( isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) {
			wp_enqueue_script(
				'custom-fields-admin', // Handle for your script
				plugin_dir_url( __DIR__ ) . 'assets/js/custom-fields-admin.js', // Path to your script
				[ 'jquery' ], // Dependencies
				'1.0.0', // Version number
				true // Load in footer
			);
		}
	}
}
