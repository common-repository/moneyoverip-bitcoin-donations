<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin admin area. This file also includes all of the dependencies used by
 * the plugin, registers the activation and deactivation functions, and defines
 * a function that starts the plugin.
 *
 * @link              https://moneyoverip.io
 * @since             1.0.0
 * @package           Moneyoverip_Bitcoin_Donations
 *
 * @wordpress-plugin
 * Plugin Name:       MoneyOverIP Bitcoin Donations
 * Plugin URI:        https://moneyoverip.io/donations
 * Description: An easy to install, simple to use Donation button that launches a popup for sending Bitcoins. Generates secure single-use bitcoin payment address (different payment addresses for each user and each transaction). Completely protects your transaction history from prying eyes. Contact us to get more answers to your detailed questions :)
 * Version:          1.0.2
 * Author:          MoneyOverIP
 * Author URI:      https://moneyoverip.io/
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     moneyoverip-bitcoin-donations
 * Domain Path:     /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MONEYOVERIP_BITCOIN_DONATIONS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in
 * includes/class-moneyoverip-bitcoin-donations-activator.php
 */
function activate_moneyoverip_bitcoin_donations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-moneyoverip-bitcoin-donations-activator.php';
	Moneyoverip_Bitcoin_Donations_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in
 * includes/class-moneyoverip-bitcoin-donations-deactivator.php
 */
function deactivate_moneyoverip_bitcoin_donations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-moneyoverip-bitcoin-donations-deactivator.php';
	Moneyoverip_Bitcoin_Donations_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_moneyoverip_bitcoin_donations' );
register_deactivation_hook( __FILE__, 'deactivate_moneyoverip_bitcoin_donations' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-moneyoverip-bitcoin-donations.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_moneyoverip_bitcoin_donations() {

	$plugin = new Moneyoverip_Bitcoin_Donations();
	$plugin->run();

}
run_moneyoverip_bitcoin_donations();

/**
 * Generates the contents for our shortcode.
 *
 * @return string
 */
function moipbd_button_shortcode() {

	$plugin_name = "moneyoverip-bitcoin-donations";
	$options     = get_option( $plugin_name );

	$xpub_id            = $options['moipbd_form_xpub_id'];
	$notification_email = $options['moipbd_form_notif_email'];
	$test_mode          = $options['moipbd_form_test_mode'];
	$selected_btn_style = $options['moipbd_form_svg_btn_style'];

	if ( !$test_mode || current_user_can( 'administrator' ) ) {
		return "<div class='moip-one-line-include-wrapper'><script
				src='https://cdn.moneyoverip.io/donations/cdn/moip-donate-button-app.js'
				id='moneyoverip-donation-button'
				data-email='$notification_email'
				data-bg-img-style='$selected_btn_style'
				data-xpub-id='$xpub_id'></script></div>";
	}
	else {
		return '';
	}
}

add_shortcode( "moneyoverip_bitcoin_donation_button", "moipbd_button_shortcode" );
