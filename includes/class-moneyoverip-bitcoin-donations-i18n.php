<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://moneyoverip.io
 * @since      1.0.0
 *
 * @package    Moneyoverip_Bitcoin_Donations
 * @subpackage Moneyoverip_Bitcoin_Donations/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Moneyoverip_Bitcoin_Donations
 * @subpackage Moneyoverip_Bitcoin_Donations/includes
 * @author     Andy Hoebeke <andy@moneyoverip.io>
 */
class Moneyoverip_Bitcoin_Donations_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'moneyoverip-bitcoin-donations',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

}
