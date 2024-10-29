<?php
/**
 *
 * Admin Class
 *
 * Handles the customization options for WooCommerce products.
 *
 * @package Product_Customization_Add-ons
 */

namespace ProductCustomizationAddons\Inc;

/**
 * Class Admin
 *
 * This class manages the WooCommerce admin product customization settings,
 * including adding custom tabs and saving custom fields.
 */
class Admin {
	/**
	 * Fields handler instance.
	 *
	 * @var FieldsHandler
	 */
	private $fields_handler;

	/**
	 * Admin constructor.
	 *
	 * Initializes the class and sets up the necessary hooks for WooCommerce.
	 *
	 * @param FieldsHandler $fields_handler An instance of FieldsHandler to manage custom fields.
	 */
	public function __construct( FieldsHandler $fields_handler ) {
		$this->fields_handler = $fields_handler;

		add_filter( 'woocommerce_product_data_tabs', [ $this, 'settings_tabs' ] );
		add_action( 'woocommerce_product_data_panels', [ $this, 'render_product_tab_content' ] );
		add_action( 'woocommerce_process_product_meta', [ $this, 'save_product_fields' ] );
		add_action( 'woocommerce_product_data_panels', [ $this, 'render_existing_fields' ] );

	}

	/**
	 * Creates a custom tab in the WooCommerce product data panel.
	 *
	 * @param array $tabs Existing product data tabs.
	 * @return array Modified product data tabs with the new customization options tab.
	 */
	public function settings_tabs( $tabs ) {

		$tabs['customization_options'] = [
			'label'    => 'Customization Options',
			'target'   => 'customization_options',
			'class'    => [ 'show_if_simple' ],
			'priority' => 21,
		];
		return $tabs;

	}

	/**
	 * Renders the content of the Customization Options tab.
	 */
	public function render_product_tab_content() {
		?>
		<div id="customization_options" class="panel woocommerce_options_panel">
			<h3><?php esc_html_e( 'Customization Options' ); ?></h3>
				<?php
				$this->fields_handler->register_product_fields();
				$this->render_existing_fields();
				?>
		</div>
		<?php

	}

	/**
	 * Saves the customized fields when the product is saved.
	 *
	 * @param int $post_id The ID of the product being saved.
	 */
	public function save_product_fields( $post_id ) {

			// Process form data.
			$product = wc_get_product( $post_id );
			$title   = isset( $_POST['customized_option_text'] ) ? sanitize_text_field( wp_unslash( $_POST['customized_option_text'] ) ) : '';
			$title   = sanitize_text_field( $title );

			// Update product meta data.
			$product->update_meta_data( 'customized_option_text', $title );
			$product->save();

	}

	/**
	 * Renders existing fields based on saved custom fields.
	 */
	public function render_existing_fields() {
		// Logic to render existing custom fields will be added here.
	}

}
