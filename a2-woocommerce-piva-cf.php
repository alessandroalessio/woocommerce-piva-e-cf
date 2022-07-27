<?php
/*
Plugin Name: A2 Woocommerce P.IVA e C.F.
Plugin URI: https://www.a2area.it
Description: Aggiunge Partita IVA e Codice Fiscale su Woocommerce
Version: 1.0
Author: Alessandro Alessio
Author URI: https://www.a2area.it
Text Domain: a2-woopivacf
Domain Path: /lang
*/

add_action('woocommerce_after_checkout_billing_form', 'a2_woopivacf_checkout_field');
function a2_woopivacf_checkout_field( $checkout ) {
    				
    woocommerce_form_field( 'a2_field_pec', array( 
        'type' 			=> 'text', 
        'class' 		=> array('a2-pec orm-row-wide'), 
        'label' 		=> __('PEC'),
        'required'		=> false,
        'placeholder' 	=> __(''),
        ), $checkout->get_value( 'a2_field_pec' ));

	woocommerce_form_field( 'a2_field_piva', array( 
		'type' 			=> 'text', 
		'class' 		=> array('a2-piva orm-row-wide form-row form-row-first'), 
		'label' 		=> __('Partita IVA'),
		'required'		=> false,
		'placeholder' 	=> __(''),
		), $checkout->get_value( 'a2_field_piva' ));
        
	woocommerce_form_field( 'a2_field_cf', array( 
		'type' 			=> 'text', 
		'class' 		=> array('a2-cf orm-row-wide form-row form-row-last'), 
		'label' 		=> __('Cod. Fiscale'),
		'required'		=> false,
		'placeholder' 	=> __(''),
		), $checkout->get_value( 'a2_field_cf' ));
    
}

/**
 * Process the checkout
 **/
add_action('woocommerce_checkout_process', 'a2_woopivacf_checkout_field_process');
function a2_woopivacf_checkout_field_process() {
	global $woocommerce;
	
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
}

/**
 * Update the order meta with field value
 **/
add_action('woocommerce_checkout_update_order_meta', 'a2_woopivacf_checkout_field_update_order_meta');
function a2_woopivacf_checkout_field_update_order_meta( $order_id ) {
	if ($_POST['a2_field_pec']) update_post_meta( $order_id, 'PEC', esc_attr($_POST['a2_field_pec']));
	if ($_POST['a2_field_piva']) update_post_meta( $order_id, 'P.IVA', esc_attr($_POST['a2_field_piva']));
	if ($_POST['a2_field_cf']) update_post_meta( $order_id, 'Cod. Fiscale', esc_attr($_POST['a2_field_cf']));
}

/**
 * Add the field to order emails
 */
 /*
add_filter('woocommerce_email_order_meta_keys', 'my_custom_checkout_field_order_meta_keys');
function my_custom_checkout_field_order_meta_keys( $keys ) {
	$keys[] = 'My Field';
	return $keys;
}
*/