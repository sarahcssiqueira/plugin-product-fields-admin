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
require __DIR__ . '/inc/class-admin.php';
require __DIR__ . '/inc/class-fields-handler.php';
require __DIR__ . '/inc/class-connect.php';
require __DIR__ . '/inc/class-custom-field-data-handler.php';
require __DIR__ . '/inc/class-custom-field-display-manager.php';


use ProductFieldsAdmin\Inc\Admin;
use ProductFieldsAdmin\Inc\FieldsHandler;
use ProductFieldsAdmin\Inc\Connect;
use ProductFieldsAdmin\Inc\CustomFieldDataHandler;
use ProductFieldsAdmin\Inc\CustomFieldDisplayManager;


$fields_handler = new FieldsHandler();
$admin          = new Admin( $fields_handler );
$connect        = new Connect( $fields_handler );
$includes       = new CustomFieldDataHandler();
$display        = new CustomFieldDisplayManager();
