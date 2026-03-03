<?php
/**
 * Plugin Name:     WooCommerce Delivery Slots by Kadence [Custom Shipping Methods for WooCommerce]
 * Plugin URI:      https://iconicwp.com/products/woocommerce-delivery-slots/
 * Description:     Compatibility between WooCommerce Delivery Slots by Kadence and Custom Shipping Methods for WooCommerce by Tyche Softwares.
 * Author:          Kadence
 * Author URI:      https://www.kadencewp.com/
 * Text Domain:     iconic-woo-delivery-slots-compat-custom-shipping-methods
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Iconic_Woo_Delivery_Slots_Compat_Custom_Shipping_Methods
 */

/**
 * Is WooCommerce Custom Shipping Methods active?
 *
 * @return bool
 */
function iconic_compat_custom_shipping_is_active() {
	return class_exists( 'Alg_WC_Custom_Shipping_Methods' );
}

/**
 * Change the format of shipping method ID.
 *
 * @return array
 */
function iconic_compat_custom_shipping_replace_shipping_method_id( $shipping_method_options ) {
	if ( ! iconic_compat_custom_shipping_is_active() ) {
		return $shipping_method_options;
	}

	foreach ( $shipping_method_options as $key => $method_name ) {
		if ( 'alg_custom:' === substr( $key, 0, 11 ) ) {
			$parts       = explode( ':', $key );
			$instance_id = $parts[1];
			$new_key     = sprintf( 'alg_wc_shipping:%d', $instance_id );
			unset( $shipping_method_options[ $key ] );
			$shipping_method_options[ $new_key ] = $method_name;
		}
	}

	return $shipping_method_options;
}

add_filter( 'iconic_wds_shipping_method_options', 'iconic_compat_custom_shipping_replace_shipping_method_id', 10 );

