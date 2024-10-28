<?php
/**
 *
 * Admin
 *
 * @package Product_Fields_Admin
 */

namespace ProductFieldsAdmin\Inc;

/**
 *
 */
class Admin {

	/**
	 *
	 */
	private $fields_handler;

	/**
	 *
	 */
	public function __construct( FieldsHandler $fields_handler ) {
		$this->fields_handler = $fields_handler;

		add_filter( 'woocommerce_product_data_tabs', [ $this, 'settings_tabs' ] );
		add_action( 'woocommerce_product_data_panels', [ $this, 'render_product_tab_content' ] );
		add_action( 'woocommerce_process_product_meta', [ $this, 'save_product_fields' ] );
		add_action( 'woocommerce_product_data_panels', [ $this, 'render_existing_fields' ] );

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
	 * Register Custom Fields
	 */
	public function render_product_tab_content() {
		?>
		<div id="product_add_ons" class="panel woocommerce_options_panel">
			<h3><?php esc_html_e( 'Custom Product Fields' ); ?></h3>
				<?php
				$this->fields_handler->register_product_fields();
				$this->render_existing_fields();
				?>
		</div>
		<?php

	}

	/**
	 * Save Fields
	 */
	public function save_product_fields( $post_id ) {

			// Process form data.
			$product = wc_get_product( $post_id );
			$title   = isset( $_POST['custom_product_text_field'] ) ? sanitize_text_field( wp_unslash( $_POST['custom_product_text_field'] ) ) : '';
			$title   = sanitize_text_field( $title );

			// Update product meta data.
			$product->update_meta_data( 'custom_product_text_field', $title );
			$product->save();

	}

	/**
	 *  Render existing fields based on saved custom fields.
	 */
	public function render_existing_fields() {
	}

}
