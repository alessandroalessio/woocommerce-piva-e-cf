<?php
function a2_woocommerce_piva_cf_register_main_options_metabox() {

	$args = array(
		'id'           => 'a2woo_piva_cf_main_options_page',
		'title'        => __('Vat & Fiscal Code', 'a2woo_piva_cf'),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'a2woo_piva_cf_main_options',
		'tab_group'    => 'a2woo_piva_cf_main_options',
		'tab_title'    => 'Checkout',
        'parent_slug'  => 'options-general.php',
	);

	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'a2woo_piva_cf_options_display_with_tabs';
	}

	$main_options = new_cmb2_box( $args );
	
    // PEC
    $main_options->add_field( array(
		'name'    => __('Display PEC', 'a2woo_piva_cf'),
		'desc'    => __('Show PEC field in Checkout Page', 'a2woo_piva_cf'),
		'id'      => 'a2woo_piva_cf_show_pec_field',
		'type'    => 'checkbox'
	) );

    // Vat Number
    $main_options->add_field( array(
		'name'    => __('Display VAT Number', 'a2woo_piva_cf'),
		'desc'    => __('Show VAT Number field in Checkout Page', 'a2woo_piva_cf'),
		'id'      => 'a2woo_piva_cf_show_vat_field',
		'type'    => 'checkbox'
	) );

    // Fiscal Code
    $main_options->add_field( array(
		'name'    => __('Display Fiscal Code', 'a2woo_piva_cf'),
		'desc'    => __('Show Fiscal Code field in Checkout Page', 'a2woo_piva_cf'),
		'id'      => 'a2woo_piva_cf_show_cf',
		'type'    => 'checkbox'
	) );

    // SDI for invoices
    $main_options->add_field( array(
		'name'    => __('Display SDI for invoices', 'a2woo_piva_cf'),
		'desc'    => __('Show SDI for invoices field in Checkout Page', 'a2woo_piva_cf'),
		'id'      => 'a2woo_piva_cf_show_sdi',
		'type'    => 'checkbox'
	) );

	/**
	 * Registers secondary options page, and set main item as parent.
	 */
	// $args = array(
	// 	'id'           => 'a2woo_piva_cf_secondary_options_page',
	// 	'menu_title'   => 'Secondary Options', // Use menu title, & not title to hide main h2.
	// 	'object_types' => array( 'options-page' ),
	// 	'option_key'   => 'a2woo_piva_cf_secondary_options',
	// 	'parent_slug'  => 'a2woo_piva_cf_main_options',
	// 	'tab_group'    => 'a2woo_piva_cf_main_options',
	// 	'tab_title'    => 'Secondary',
	// );
	// if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
	// 	$args['display_cb'] = 'a2woo_piva_cf_options_display_with_tabs';
	// }
	// $secondary_options = new_cmb2_box( $args );
	// $secondary_options->add_field( array(
	// 	'name'    => 'Test Radio',
	// 	'desc'    => 'field description (optional)',
	// 	'id'      => 'radio',
	// 	'type'    => 'radio',
	// 	'options' => array(
	// 		'option1' => 'Option One',
	// 		'option2' => 'Option Two',
	// 		'option3' => 'Option Three',
	// 	),
	// ) );

	/**
	 * Registers tertiary options page, and set main item as parent.
	 */
	// $args = array(
	// 	'id'           => 'a2woo_piva_cf_tertiary_options_page',
	// 	'menu_title'   => 'Tertiary Options', // Use menu title, & not title to hide main h2.
	// 	'object_types' => array( 'options-page' ),
	// 	'option_key'   => 'a2woo_piva_cf_tertiary_options',
	// 	'parent_slug'  => 'a2woo_piva_cf_main_options',
	// 	'tab_group'    => 'a2woo_piva_cf_main_options',
	// 	'tab_title'    => 'Tertiary',
	// );
	// if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
	// 	$args['display_cb'] = 'a2woo_piva_cf_options_display_with_tabs';
	// }
	// $tertiary_options = new_cmb2_box( $args );
	// $tertiary_options->add_field( array(
	// 	'name' => 'Test Text Area for Code',
	// 	'desc' => 'field description (optional)',
	// 	'id'   => 'textarea_code',
	// 	'type' => 'textarea_code',
	// ) );

}
add_action( 'cmb2_admin_init', 'a2_woocommerce_piva_cf_register_main_options_metabox' );
