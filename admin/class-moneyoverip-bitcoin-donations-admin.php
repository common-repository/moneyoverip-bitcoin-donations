<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://moneyoverip.io
 * @since      1.0.0
 *
 * @package    Moneyoverip_Bitcoin_Donations
 * @subpackage Moneyoverip_Bitcoin_Donations/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Moneyoverip_Bitcoin_Donations
 * @subpackage Moneyoverip_Bitcoin_Donations/admin
 * @author     Andy Hoebeke <andy@moneyoverip.io>
 */
class Moneyoverip_Bitcoin_Donations_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name     The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param    string    $plugin_name       The name of this plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
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
		 * defined in Moneyoverip_Bitcoin_Donations_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Moneyoverip_Bitcoin_Donations_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/moneyoverip-bitcoin-donations-admin.css', array(), $this->version, 'all' );
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
		 * defined in Moneyoverip_Bitcoin_Donations_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Moneyoverip_Bitcoin_Donations_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/moneyoverip-bitcoin-donations-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 */
		add_options_page( __('MoneyOverIP Bitcoin Donations plugin - Settings', $this->plugin_name), __('Bitcoin Donations', $this->plugin_name), 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
		);
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {
		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Bitcoin Donation Settings', $this->plugin_name) . '</a>',
		);
		return array_merge(  $settings_link, $links );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_setup_page() {
		include_once( 'partials/moneyoverip-bitcoin-donations-admin-display.php' );
	}

	/**
	 * Using this to save/update our options.
	 */
	public function options_update() {
		register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	}

	/**
	 * Validate the values provided on the settings page.
	 *
	 * @param $input
	 *
	 * @return array
	 */
	public function validate($input) {
		// All checkboxes inputs
		$valid = array();

		//Cleanup
		if (strpos($input['moipbd_form_xpub_key'],'*') > 0) {
			$valid['moipbd_form_xpub_key'] = $input['moipbd_form_xpub_key'];
		}
		elseif (!empty($input['moipbd_form_xpub_key']) && strlen($input['moipbd_form_xpub_key']) > 10 && strpos($input['moipbd_form_xpub_key'],'xpub') !== FALSE && strpos($input['moipbd_form_xpub_key'],'xpub') === 0) {
			// looks like a valid xpub string
			$valid['moipbd_form_xpub_key'] = substr($input['moipbd_form_xpub_key'],0,12) . str_pad('',8,'*') . substr($input['moipbd_form_xpub_key'],-2,2);
		}
		else {

			add_settings_error(
				'moipbd_form_xpub_key', // Setting title
				'moipbd_form_xpub_key_texterror', // Error ID
				'Please enter a valid XPub key. If unsure, contact MoneyOverIP staff at contact@moneyoverip.io ', // Error message
				'error' // Type of message
			);

			$valid['moipbd_form_xpub_key'] = '';
		}

		$valid['moipbd_form_xpub_id'] = $input['moipbd_form_xpub_id'];

		if ( strpos($input['moipbd_form_notif_email'], '@') === FALSE || strpos($input['moipbd_form_notif_email'], '@') < 2) {
			$valid['moipbd_form_notif_email'] = '';

			add_settings_error(
				'moipbd_form_notif_email', // Setting title
				'moipbd_form_notif_email_texterror', // Error ID
				'Please enter a valid email address. This is important for payment notifications!', // Error message
				'error' // Type of message
			);
		}
		else {
			$valid['moipbd_form_notif_email'] = $input['moipbd_form_notif_email'];
		}

		$valid['moipbd_form_test_mode'] = $input['moipbd_form_test_mode'] ? 1 : 0;

		$valid['moipbd_form_svg_btn_style'] = $input['moipbd_form_svg_btn_style'];

		return $valid;
	}
}
