(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	// GET  -> moip_ajax_action(url, callback, "GET", null)
	// POST -> moip_ajax_action(url, callback, "POST", data)
	function moip_ajax_action(url, callback, _method, _data) {
		let xmlhttp                = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				console.log('responseText:' + xmlhttp.responseText);
				try {
					var data = JSON.parse(xmlhttp.responseText);
				} catch(err) {
					console.log(err.message + " in " + xmlhttp.responseText);
					return;
				}
				callback(data);
			}
		};
		xmlhttp.open(_method, url, true);
		xmlhttp.send(_data);
	}

	/**
	 * Using the Xpub key, request a MoneyOverIP xpub ID,
	 * which is needed to generate unique payment addresses for users.
	 *
	 * @param xpubKeyTarget
	 * @param notifEmailTarget
	 * @param xpubIdTarget
	 * @param currencyTarget
	 * @param adminEmail
	 */
	function getMoipXpubId(xpubKeyTarget, notifEmailTarget, xpubIdTarget, currencyTarget, adminEmail) {
		const xpubKeyNode = document.getElementById(xpubKeyTarget);
		const notifEmailNode = document.getElementById(notifEmailTarget);
		// const currencyNode = document.getElementById(currencyTarget);

		if (!xpubIdNode || !xpubKeyNode || !notifEmailNode)
			return;

		console.debug('Values used to get Xpub ID : ', xpubKeyNode.value, notifEmailNode.value, adminEmail);

		let notifEmail = adminEmail;
		if (notifEmailNode.value && notifEmailNode.value.indexOf('@') > 2) {
			notifEmail = notifEmailNode.value;
		}

		const xpubKey = xpubKeyNode.value;
		// const currency = currencyNode.value;
		const currency = 'BTC';

		const data = JSON.stringify({
			pub: xpubKey,
			currency: currency,
			return_email: notifEmail,
		});

		const url = 'https://moneyoverip.io/api/add_pub';

		moip_ajax_action(url, function(result) {
			setMoipXpubId(result, xpubIdTarget);
		}, "POST", data);
	}


	/**
	 * Once a MoneyOverIP xpub ID is received, update the settings form.
	 *
	 * @param result
	 * @param xpubIdTarget
	 * @returns {string}
	 */
	function setMoipXpubId(result, xpubIdTarget) {
		const xpubIdNode = document.getElementById(xpubIdTarget);

		let xpubId = '';

		if (result && result.data && result.data.pub_id) {
			xpubId = result.data.pub_id;
			console.debug('Received XPUB ID: ', xpubId);
		}

		if (xpubIdNode) {
			xpubIdNode.value = xpubId;
			console.debug('');
		}
	}

})( jQuery );
