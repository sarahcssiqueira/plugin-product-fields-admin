<?php
/**
 *
 * Plugin Main Class File
 *
 * @package Product_Fields_Admin
 */

namespace ProductFieldsAdmin\Inc;

defined( 'ABSPATH' ) || exit;

class Checkout {

	protected static $instance = null;

	public function __construct() {

		add_filter( 'woocommerce_add_cart_item_data', [ $this, 'add_wc_custom_field_to_cart_metadata' ], 10, 4 );
		add_filter( 'woocommerce_cart_item_name', [ $this, 'add_wc_custom_field_cart_checkout' ], 10, 3 );
		add_action( 'woocommerce_checkout_create_order_line_item', [ $this, 'add_wc_custom_field_to_order' ], 10, 4 );

	}

	/**
	 * Add the user input from the previous custom field to cart meta data
	 */
	public function add_wc_custom_field_to_cart_metadata( $cart_item_data, $product_id, $variation_id, $quantity ) {
		if ( ! empty( $_POST['wc-custom-field'] ) ) {
			$cart_item_data['title_field'] = $_POST['wc-custom-field'];
		}
		return $cart_item_data;
	}

	/**
	 * Display the value from the custom field to the cart && checkout pages
	 */
	public function add_wc_custom_field_cart_checkout( $name, $cart_item, $cart_item_key ) {
		if ( isset( $cart_item['title_field'] ) ) {
			$name .= sprintf(
				'<p>%s</p>',
				esc_html( $cart_item['title_field'] )
			);
		}
		return $name;
	}

	/**
	 * Add custom field to order object
	 */
	public function add_wc_custom_field_to_order( $item, $cart_item_key, $values, $order ) {
		foreach ( $item as $cart_item_key => $values ) {
			if ( isset( $values['title_field'] ) ) {
				$item->add_meta_data( 'Custom Field', $values['title_field'], true );
			}
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
