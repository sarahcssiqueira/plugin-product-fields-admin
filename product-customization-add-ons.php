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
 * Composer Autoload
 */
require __DIR__ . '/vendor/autoload.php';

// Use classes from the ProductCustomizationAddons\Inc namespace.
use ProductCustomizationAddons\Inc\FieldsHandler;
use ProductCustomizationAddons\Inc\Admin;
use ProductCustomizationAddons\Inc\Connect;
use ProductCustomizationAddons\Inc\CustomFieldDataHandler;
use ProductCustomizationAddons\Inc\CustomFieldDisplayManager;

// Instantiate the necessary classes to activate the plugin's functionality.
$fields_handler = new FieldsHandler();
$admin          = new Admin( $fields_handler );
$connect        = new Connect( $fields_handler );
$includes       = new CustomFieldDataHandler();
$display        = new CustomFieldDisplayManager();
