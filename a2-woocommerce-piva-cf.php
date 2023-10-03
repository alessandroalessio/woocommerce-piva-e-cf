<?php
/*
Plugin Name: A2 Woocommerce P.IVA e C.F.
Plugin URI: https://www.a2area.it
Description: Aggiunge Partita IVA e Codice Fiscale su Woocommerce
Version: 1.1
Author: Alessandro Alessio
Author URI: https://www.a2area.it
Text Domain: a2woo_piva_cf
Domain Path: /lang
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

require __DIR__ . '/vendor/autoload.php';

// Localization
load_plugin_textdomain( 'a2woo_piva_cf', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 

// Admin interface
require __DIR__ . '/admin/plugin-options.php';

// Plugin scripts
add_action('woocommerce_after_checkout_billing_form', 'a2_woopivacf_checkout_field');
function a2_woopivacf_checkout_field( $checkout ) {
    
	$a2woo_piva_cf_show_pec_field = cmb2_get_option('a2woo_piva_cf_main_options', 'a2woo_piva_cf_show_pec_field');
	$a2woo_piva_cf_show_vat_field = cmb2_get_option('a2woo_piva_cf_main_options', 'a2woo_piva_cf_show_vat_field');
	$a2woo_piva_cf_show_cf = cmb2_get_option('a2woo_piva_cf_main_options', 'a2woo_piva_cf_show_cf');
	$a2woo_piva_cf_required = cmb2_get_option('a2woo_piva_cf_main_options', 'a2woo_piva_cf_required');
	$a2woo_piva_cf_show_sdi = cmb2_get_option('a2woo_piva_cf_main_options', 'a2woo_piva_cf_show_sdi');

	if ( $a2woo_piva_cf_show_pec_field && $a2woo_piva_cf_show_pec_field=='on' ) :
		woocommerce_form_field( 'a2_field_pec', array( 
			'type' 			=> 'text', 
			'class' 		=> array('a2-pec orm-row-wide'), 
			'label' 		=> __('Certified Mail', 'a2woo_piva_cf'),
			'required'		=> false,
			'placeholder' 	=> __(''),
		), $checkout->get_value( 'a2_field_pec' ));
	endif;

	if ( $a2woo_piva_cf_show_vat_field && $a2woo_piva_cf_show_vat_field=='on' ) :
		woocommerce_form_field( 'a2_field_piva', array( 
			'type' 			=> 'text', 
			'class' 		=> array('a2-piva orm-row-wide form-row form-row-first'), 
			'label' 		=> __('Vat Number', 'a2woo_piva_cf'),
			'required'		=> false,
			'placeholder' 	=> __(''),
		), $checkout->get_value( 'a2_field_piva' ));
	endif;

	if ( $a2woo_piva_cf_show_cf && $a2woo_piva_cf_show_cf=='on' ) :
		woocommerce_form_field( 'a2_field_cf', array( 
			'type' 			=> 'text', 
			'class' 		=> array('a2-cf orm-row-wide form-row form-row-last'), 
			'label' 		=> __('Fiscal Code', 'a2woo_piva_cf'),
			'required'		=> ( $a2woo_piva_cf_required=='on' ) ? true : false,
			'placeholder' 	=> __(''),
		), $checkout->get_value( 'a2_field_cf' ));
	endif;
        	
	if ( $a2woo_piva_cf_show_sdi && $a2woo_piva_cf_show_sdi=='on' ) :
		woocommerce_form_field( 'a2_field_sdi', array( 
			'type' 			=> 'text', 
			'class' 		=> array('a2-sdi orm-row-wide'), 
			'label' 		=> __('SDI for electronic invoices', 'a2woo_piva_cf'),
			'required'		=> false,
			'placeholder' 	=> __(''),
		), $checkout->get_value( 'a2_field_sdi' ));
	endif;

}

/**
 * Process the checkout
 **/
add_action('woocommerce_checkout_process', 'a2_woopivacf_checkout_field_process');
function a2_woopivacf_checkout_field_process() {
	global $woocommerce;
	
	$a2woo_piva_cf_required = ( cmb2_get_option('a2woo_piva_cf_main_options', 'a2woo_piva_cf_required') =='on' ) ? true : false;
	if ( $a2woo_piva_cf_required && $_POST['a2_field_cf']=='' ) {
	    wc_add_notice( '<strong>'.__('Fiscal Code', 'a2woo_piva_cf').'</strong> '.__('is a required field', 'a2woo_piva_cf'), 'error' );	
	}

	// if ( ! $_POST['a2_field_pec'] )
    //     wc_add_notice( __( 'Compila' ), 'error' );
}

/**
 * Update the user meta with field value
 **/
add_action('woocommerce_checkout_update_user_meta', 'a2_woopivacf_field_update_user_meta');
function a2_woopivacf_field_update_user_meta( $user_id ) {
	if ($user_id && $_POST['a2_field_pec']) update_user_meta( $user_id, 'a2_field_pec', esc_attr($_POST['a2_field_pec']) );
	if ($user_id && $_POST['a2_field_piva']) update_user_meta( $user_id, 'a2_field_piva', esc_attr($_POST['a2_field_piva']) );
	if ($user_id && $_POST['a2_field_cf']) update_user_meta( $user_id, 'a2_field_cf', esc_attr($_POST['a2_field_cf']) );
	if ($user_id && $_POST['a2_field_sdi']) update_user_meta( $user_id, 'a2_field_sdi', esc_attr($_POST['a2_field_sdi']) );
}

/**
 * Update the order meta with field value
 **/
add_action('woocommerce_checkout_update_order_meta', 'a2_woopivacf_checkout_field_update_order_meta');
function a2_woopivacf_checkout_field_update_order_meta( $order_id ) {
	if ($_POST['a2_field_pec']) update_post_meta( $order_id, 'PEC', esc_attr($_POST['a2_field_pec']));
	if ($_POST['a2_field_piva']) update_post_meta( $order_id, 'P.IVA', esc_attr($_POST['a2_field_piva']));
	if ($_POST['a2_field_cf']) update_post_meta( $order_id, 'Cod. Fiscale', esc_attr($_POST['a2_field_cf']));
	if ($_POST['a2_field_sdi']) update_post_meta( $order_id, 'SDI', esc_attr($_POST['a2_field_sdi']));
}

/**
 * Custom CSS for field in checkout
 */
function a2_woopivacf_styles_method() {
	echo '<style>
	.form-row.a2-cf{ clear: right; }
	.form-row.a2-sdi{ clear: both; }
	</style>';
}
add_action( 'wp_head', 'a2_woopivacf_styles_method', 100 );
