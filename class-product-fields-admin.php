<?php
/**
 *
 * Plugin Main Class File
 *
 * @package Product_Fields_Admin
 */

namespace ProductFieldsAdmin;

defined( 'ABSPATH' ) || exit;

class Init {

	protected static $instance = null;

	public function __construct() {

		add_action( 'woocommerce_product_data_panels', [ $this, 'register_wc_product_custom_fields' ] );
		add_filter( 'woocommerce_product_data_tabs', [ $this, 'settings_tabs' ] );
		add_action( 'woocommerce_process_product_meta', [ $this, 'save_wc_product_custom_fields' ] );
		add_action( 'woocommerce_before_add_to_cart_button', [ $this, 'display_wc_product_custom_fields' ] );
		add_filter( 'woocommerce_add_to_cart_validation', [ $this, 'validate_wc_custom_fields' ], 10, 3 );
		add_filter( 'woocommerce_add_cart_item_data', [ $this, 'add_wc_custom_field_to_cart_metadata' ], 10, 4 );
		add_filter( 'woocommerce_cart_item_name', [ $this, 'add_wc_custom_field_cart_checkout' ], 10, 3 );
		add_action( 'woocommerce_checkout_create_order_line_item', [ $this, 'add_wc_custom_field_to_order' ], 10, 4 );

	}

	/**
	 * Register Custom Fields
	 */
	public function register_wc_product_custom_fields() {
		global $woocommerce, $post;

		echo '<div id="product_add_ons" class="panel woocommerce_options_panel hidden">';

		woocommerce_wp_text_input(
			[
				'id'          => 'custom_product_text_field',
				'placeholder' => 'Custom Product Text Field',
				'label'       => 'Custom Product Text Field',
				'desc_tip'    => 'true',
			]
		);
		echo '</div>';
	}

	/**
	 * Save Fields
	 */
	public function save_wc_product_custom_fields( $post_id ) {

		$product = wc_get_product( $post_id );
		$title   = isset( $_POST['custom_product_text_field'] ) ? $_POST['custom_product_text_field'] : '';
		$product->update_meta_data( 'custom_product_text_field', sanitize_text_field( $title ) );
		$product->save();
	}

	/**
	 * Creates a custom tab for the custom fields
	 *
	 * @param array $tabs Custom Tab.
	 */
	public function settings_tabs( $tabs ) {

		$tabs['product_add_ons'] = [
			'label'    => 'Product Add-Ons',
			'target'   => 'product_add_ons',
			'class'    => [ 'show_if_simple' ],
			'priority' => 21,
		];
		return $tabs;

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
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
