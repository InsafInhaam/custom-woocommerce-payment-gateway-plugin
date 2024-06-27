<?php

/**
 * 
 * Plugin name: Payleo Payment for Woocommerce
 * Plugin URI: http://www.insafinhaam.com/custom-woocommerce-payment-gateway-plugin
 * Author: Insaf Inhaam
 * Author URI: https://insafinhaam.com/
 * Description: This Plugin allows for local content payment system
 * Version: 1.0.0
 * License: 0.1.0
 * Text Domain: payleo-payments-woo
 * 
 */

/**
 * Class WC_Gateway_Payleo file.
 *
 * @package WooCommerce\Gateways
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
	return;

add_action('plugins_loaded', 'payleo_payment_init', 11);
add_filter('woocommerce_currencies', 'payleo_add_lkr_currencies');
add_filter('woocommerce_currency_symbol', 'payleo_add_lkr_currency_symbol', 10, 2);
add_filter('woocommerce_payment_gateways', 'add_to_woo_payleo_payment_gateway');

function payleo_payment_init()
{
	if (class_exists(('WC_Payment_Gateway'))) {
		require_once plugin_dir_path( __FILE__ ) . '/includes/class-wc-payment-gateway-payleo.php';
		require_once plugin_dir_path( __FILE__ ). '/includes/payleo-order-statuses.php';
		require_once plugin_dir_path( __FILE__ ). '/includes/payleo-checkout-description-fields.php';
	}
}

function add_to_woo_payleo_payment_gateway($gateways)
{
	$gateways[] = 'WC_Gateway_Payleo';
	return $gateways;
}

// Add Sri Lankan Rupees (LKR) to WooCommerce Currencies
function payleo_add_lkr_currencies($currencies)
{
	$currencies['LKR'] = __('Sri Lankan Rupees', 'payleo-payments-woo');
	return $currencies;
}

// Add Sri Lankan Rupees (LKR) symbol to WooCommerce Currencies
function payleo_add_lkr_currency_symbol($currency_symbol, $currency)
{
	switch ($currency) {
		case 'LKR':
			$currency_symbol = 'Rs';
			break;
	}
	return $currency_symbol;
}

