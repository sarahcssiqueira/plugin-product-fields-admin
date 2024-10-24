<?php
/**
 *
 * Plugin Main Class File
 *
 * @package Product_Fields_Admin
 */

namespace ProductFieldsAdmin\Inc;

defined( 'ABSPATH' ) || exit;

class Validations {

	protected static $instance = null;

	public function __construct() {

		add_filter( 'woocommerce_add_to_cart_validation', [ $this, 'validate_wc_custom_fields' ], 10, 3 );

	}

	/**
	 * Validate user input
	 */
	public function validate_wc_custom_fields( $passed, $product_id, $quantity ) {
		if ( empty( $_POST['wc-custom-field'] ) ) {
			$passed = false;
			wc_add_notice( 'Please enter a value into the text field', 'error' );
		}
		return $passed;

	}

	/**
	 * Return the single class instance
	 */
	public static function singleton() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
