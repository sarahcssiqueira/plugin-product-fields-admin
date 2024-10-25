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
require __DIR__ . '/inc/class-render.php';
require __DIR__ . '/inc/class-register.php';
require __DIR__ . '/inc/class-validations.php';


use ProductFieldsAdmin\Inc\Register;
use ProductFieldsAdmin\Inc\Render;
// use ProductFieldsAdmin\Inc\Validations;


Register::singleton();
Render::singleton();
// Validations::singleton();
