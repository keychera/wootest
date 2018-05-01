<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*
Plugin Name:  Woo, Hello Socif!
Description:  Test untuk Makalah tentang Life-long learning
Version:      0.1
Author:       Kevin Erdiza
Author URI:   github.com/keychera
*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    function declare_test_classes() {
        require_once('includes/test-debugger.php');
        require_once('includes/class-wc-gateway-bank-bootstrapper.php');
        require_once('includes/class-wc-gateway-test.php');

        require_once('includes/class-wc-admin-test-menu.php');
        new WC_Admin_Test_Menu();
    }

    add_action( 'plugins_loaded', 'declare_test_classes', 1000);

    function add_gateway_class( $methods ) {
        $methods[] = 'WC_Gateway_Test'; 
        return $methods;
    }

    add_filter( 'woocommerce_payment_gateways', 'add_gateway_class' );
}