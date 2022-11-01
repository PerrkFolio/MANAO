<?php

require __DIR__ . '/yookassa/lib/autoload.php';
use YooKassa\Client;
/**
 * Fired during plugin activation
 *
 * @link       https://github.com/L0L1K1510/yoomoney-wp
 * @since      1.0.0
 *
 * @package    Yoomoney-WP
 * @subpackage Yoomoney-WP/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Yoomoney-WP
 * @subpackage Yoomoney-WP/includes
 * @author     Maxim <parkin01@inbox.ru>
 */
class yoomoney_wp_Activator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $wpdb;
		$sql = "CREATE TABLE IF NOT EXISTS wp_payments (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,post_data VARCHAR(128),payment_id VARCHAR(64),payment_user_id VARCHAR(64),payment_status VARCHAR(64),payment_created_at TIMESTAMP,payment_updated_at TIMESTAMP,payment_title VARCHAR(64),payment_amount VARCHAR(8),payment_data VARCHAR(128))";

		$wpdb->query($sql);

		// $client = new Client();
		// $client->setAuth(get_option('shopid'), get_option('secretkey'));

		// require_once __DIR__ . '/payment/pay-yoomoney-wp-create.php';
		
	}

}
