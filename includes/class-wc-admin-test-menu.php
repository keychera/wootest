<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class WC_Admin_Test_Menu extends WC_Settings_API {
    public function __construct() {
		$this->id = 'test';
        add_action( 'admin_menu', array( $this, 'admin_menu' ), 1000 );
	}

    /**
	 * Add menu items.
	 */
	public function admin_menu() {
		// Load the settings.
		add_submenu_page( 'woocommerce', __( 'Test', 'woocommerce' ), __( 'Test', 'woocommerce' ), 'manage_woocommerce', 'test', array( $this, 'test_page' ) );
    }

    /**
	 * Init the test page.
	 */
	function test_page() {
        $test_data =  self::get_filtered_customers_data();
		echo "<h1> Hello, Test </h1>";
		echo '<div class="wrap woocommerce">';
		self::output_test_page($test_data);
		echo '</div>';
    }

    function get_filtered_customers_data() {
		$users = get_users();
		$filtered_customers = array();
		foreach ($users as $user) {
			$customer_id = $user->ID;
			$filtered_customers[$customer_id] = self::filter_customer_data_from($user);
		}
		return $filtered_customers;
    }
    
    public function filter_customer_data_from($user) {
		$customer = new WC_Customer($user->ID);
		return array(
			'name' => $customer->get_first_name() . ' ' . $customer->get_last_name(),
			'total_spent' => $customer->get_total_spent()
		);
	}
    
    function output_test_page($customers) {
		echo "<h2>Cek customer</h2>";
		echo '
			<table class="wc_status_table widefat" cellspacing="0" style="width:70%;table-layout:fixed">
				<col style="width:10%" span="5"/>
				<thead>
					<tr>
						<th colspan="1"><h2> Nama customer</h2></th>
						<th colspan="2"><h2> Total Pembelian </h2></th>
						<th colspan="2"><h2> test Yang Didapat </h2></th>
					</tr>
				</thead>
				<tbody>';
		foreach ($customers as $customer_id => $customer_data) {
			$test_hasil = self::test_calculate($customer_data['total_spent']);
			echo '
			<tr>
				<td colspan="1">'.$customer_data['name'].' </td>
				<td colspan="2">'.wc_price($customer_data['total_spent']).' </td>
				<td colspan="2">'.wc_price($test_hasil).' </td>
			</tr>';
		}
		echo '</tbody></table>';
    }
    
    function test_calculate($total_spent) {
        return 0.5 * $total_spent;
    }
}