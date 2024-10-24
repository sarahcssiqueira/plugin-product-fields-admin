<?php
/**
 *
 * Plugin Main Class File
 *
 * @package Product_Fields_Admin
 */

namespace ProductFieldsAdmin\Inc;

defined( 'ABSPATH' ) || exit;

class Register {

    /**
     * @var singleton
     */    
	protected static $instance = null;

	public function __construct() {

		add_action( 'woocommerce_product_data_panels', [ $this, 'register_product_fields' ] );
		add_action( 'woocommerce_process_product_meta', [ $this, 'save_product_fields' ] );
        add_filter( 'woocommerce_product_data_tabs', [ $this, 'settings_tabs' ] );

	}

    /*
    * get products method
    */

	/**
	 * Register Custom Fields
	 */
	public function register_product_fields() {
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
	public function save_product_fields( $post_id ) {

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
	 * Return the single class instance
	 */
	public static function singleton() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
