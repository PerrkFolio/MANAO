<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/L0L1K1510/yoomoney-wp
 * @since      1.0.0
 *
 * @package    Yoomoney-WP
 * @subpackage Yoomoney-WP/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Yoomoney-WP
 * @subpackage Yoomoney-WP/admin
 * @author     Maxim <parkin01@inbox.ru>
 */
class yoomoney_wp_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $yoomoney_wp    The ID of this plugin.
	 */
	private $yoomoney_wp;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $yoomoney_wp       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $yoomoney_wp, $version ) {

		$this->yoomoney_wp = $yoomoney_wp;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in yoomoney_wp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The yoomoney_wp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->yoomoney_wp, plugin_dir_url( __FILE__ ) . 'css/yoomoney-wp-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in yoomoney_wp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The yoomoney_wp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->yoomoney_wp, plugin_dir_url( __FILE__ ) . 'js/yoomoney-wp-admin.js', array( 'jquery' ), $this->version, false );

	}

}
