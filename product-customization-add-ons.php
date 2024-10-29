<?php
/**
 * Plugin Name:       Product Customization Add-on
 * Plugin URI:        https://sarahjobs.com/plugins/product-customization-add-ons
 * Description:       Product Customization Add-ons for WooCommerce
 * Version:           0.1.2
 * Author:            Sarah Siqueira
 * Author URI:        https://sarahjobs.com/about
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl.html
 * Text Domain:       product-customization-add-ons
 *
 *  @package Product_Customization_Add-ons
 */

// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit;

/**
 * Bootstrap the plugin by including necessary class files.
 *
 * This section initializes the core classes required for the plugin's functionality.
 * It includes the classes responsible for managing admin settings, custom fields,
 * data handling, and display logic.
 */

// Include necessary class files.
require __DIR__ . '/inc/class-admin.php';
require __DIR__ . '/inc/class-fields-handler.php';
require __DIR__ . '/inc/class-connect.php';
require __DIR__ . '/inc/class-custom-field-data-handler.php';
require __DIR__ . '/inc/class-custom-field-display-manager.php';

// Use classes from the ProductFieldsAdmin\Inc namespace.
use ProductFieldsAdmin\Inc\Admin;
use ProductFieldsAdmin\Inc\FieldsHandler;
use ProductFieldsAdmin\Inc\Connect;
use ProductFieldsAdmin\Inc\CustomFieldDataHandler;
use ProductFieldsAdmin\Inc\CustomFieldDisplayManager;

// Instantiate the necessary classes to activate the plugin's functionality.
$fields_handler = new FieldsHandler();
$admin          = new Admin( $fields_handler );
$connect        = new Connect( $fields_handler );
$includes       = new CustomFieldDataHandler();
$display        = new CustomFieldDisplayManager();
