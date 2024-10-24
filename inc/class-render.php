<?php
/**
 *
 * Plugin Main Class File
 *
 * @package Product_Fields_Admin
 */

namespace ProductFieldsAdmin\Inc;

defined( 'ABSPATH' ) || exit;

class Render {

	protected static $instance = null;

	public function __construct() {

		add_action( 'woocommerce_before_add_to_cart_button', [ $this, 'display_wc_product_custom_fields' ] );

	}

	/**
	 * Display the fields in the product page
	 */
	public function display_wc_product_custom_fields() {
		global $post;

		$product = wc_get_product( $post->ID );

		$title = $product->get_meta( 'custom_product_text_field' );

		if ( $title ) {
			printf(
				'<div><label for="">%s</label>
                    <input type="text" id="wc-custom-field" name="wc-custom-field" value="">
                </div>',
				esc_html( $title )
			);
		}
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
