<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/L0L1K1510/yoomoney-wp
 * @since             1.0.0
 * @package           Yoomoney-WP
 *
 * @wordpress-plugin
 * Plugin Name:       Yoomoney-WP
 * Plugin URI:        https://github.com/L0L1K1510/yoomoney-wp
 * Description:       Yoomoney payment system plugin
 * Version:           1.0.0
 * Author URI:        https://github.com/L0L1K1510/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'YK_PLUGIN_FILE', __FILE__ );

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'yoomoney_wp_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-yoomoney-wp-activator.php
 */
function activate_yoomoney_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-yoomoney-wp-activator.php';
	yoomoney_wp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-yoomoney-wp-deactivator.php
 */
function deactivate_yoomoney_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-yoomoney-wp-deactivator.php';
	yoomoney_wp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_yoomoney_wp' );
register_deactivation_hook( __FILE__, 'deactivate_yoomoney_wp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-yoomoney-wp.php';
require_once plugin_dir_path(__FILE__) . 'includes/functions/func-yoomoney-wp-general.php';
require_once plugin_dir_path(__FILE__) . 'includes/payment/pay-yoomoney-wp-create.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_yoomoney_wp() {

	$plugin = new yoomoney_wp();
	$plugin->run();

}
run_yoomoney_wp();
