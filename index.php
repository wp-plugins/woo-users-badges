<?php

/**
 * Plugin Name: Woocommerce Users Badges
 * Description: Let the admin add some badges for the users according to a specific rules added from the admin area
 * Author: Osama Ahmed Attia
 * Text Domain: os-woo-users-badges
 * Version: 1.0
 */

namespace WoocommerceUsersBadges;


// If this file is called directly, abort.
use WoocommerceUsersBadges\Setting\SettingPage;
use WoocommerceUsersBadges\Shortcode\UserShortcodeClass;

if ( ! defined( 'WPINC' ) ) {
	die;
}


class Woocommerce_Users_Badges {

	/**
	 * Version
	 */
	const VERSION = '1.0';

	/**
	 * Localization
	 */
	const TEXTDOMAIN = 'os-woo-users-badges';

	/**
	 * @var
	 */
	protected $database;

	/**
	 * Start the plugin
	 */
	public function __construct() {
		require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomains' ) );
		add_action('wp_enqueue_scripts', array( $this, 'load_scripts' ));


		new SettingPage();
		new UserShortcodeClass();
	}

	/**
	 * Load the plugin text domain
	 */
	public function load_plugin_textdomains() {

		load_plugin_textdomain(
			self::TEXTDOMAIN,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



	/**
	 * Add the generated table to the new sub menu
	 */
	public function users_badges_cb() {
		echo '<p>' . __( 'Here you can find the reserved product on your store', self::TEXTDOMAIN ) . '<p>';
	}

	public function load_scripts() {
		wp_enqueue_style( 'custom-script-badges', plugins_url( 'scripts/custom.css', __FILE__ ) );
	}
}

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	new Woocommerce_Users_Badges();
}

