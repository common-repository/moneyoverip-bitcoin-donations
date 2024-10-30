=== TripleA Bitcoin Donations ===
Contributors: tripleatechnology,moneyoverip
Donate link: https://triple-a.io
Tags: donation,money,bitcoin,crypto,payment,gateway,triplea,charity,tippings,tips
Requires at least: 4.6
Tested up to: 5.1
Stable tag: 1.0.2
Requires PHP: 5.4.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

An easy to install, simple to use Donation button that launches a popup for sending Bitcoins. No login, no fees, single-use QR payment addresses.

== Description ==

An easy to install, simple to use Donation button that displays a Bitcoin payment popup.
To use it, you need a Bitcoin wallet that is either BIP32 or BIP44 compatible. (When in doubt, use one of the recommended wallets on the [TripleA Donations](https://triple-a.io/donations/) website.)

Our Bitcoin Donation popup generates secure single-use payment addresses (that is, a different payment address for each user and each transaction). This protects your transaction history from prying eyes.

Features:

* Use a simple shortcode to place the donation button.
* Many button styles to choose from.
* Email notifications when a payment is made (in addition to your own bitcoin wallet notifications).
* No login or registration needed.
* No commissions charged since these are direct P2P payments.

Planned:

* Place several buttons on a page (currently just 1).
* Backend page showing all received donations.
* Export transactions to CSV file.

**Note regarding the Bitcoin wallet compatibility**

We currently support regular Bitcoin payment addresses, those that *start with 1*.
This means we are not compatible with wallets that provide addresses starting with 3 (Segwit), 'bch' or other.


== Installation and Configuration ==

1. Upload the folder containing the plugin files to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress.
1. Use the `Settings -> Bitcoin Donations` screen to configure the plugin.
1. **You will need a bitcoin wallet's XPub key** to configure it. Find instructions for specific wallets at our [TripleA Bitcoin donations homepage](https://triple-a.io/donations/).
1. Copy-paste the shortcode, place it where you want the Donation button to appear.

Then try out your Bitcoin donation button!


== Frequently Asked Questions ==

= Where can I find documentation? =

You can contact us at contact@triple-a.io or visit [our Donations webpage](https://triple-a.io/donations/).

= What is an XPub key? =

An XPub key allows generating payment addresses. It all HD wallets you will be able to view and copy that XPub key.

= Where can I find the XPub key? =

Find instructions for specific wallets at our [TripleA Bitcoin donations homepage](https://triple-a.io/donations/).


== Screenshots ==

1. Install the TripleA Bitcoin Donations plugin.
2. Configure the plugin via the settings page.
3. Use the shortcode to place the Donation button where you want it.
4. Visit your website and try out bitcoin donations!

== Changelog ==

= 1.0.2 =
Improved FAQ and instructions.

= 1.0.1 =
* Added proper readme.txt
* Added error messages on settings page.

= 1.0.0 =
* First useable version!

== Upgrade Notice ==

= 1.0.1 =
First public version. If you're using this, you are one of our early adopters!

= 1.0.2 =
Improved FAQ and instructions.
