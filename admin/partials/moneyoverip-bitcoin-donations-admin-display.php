<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://moneyoverip.io
 * @since      1.0.0
 *
 * @package    Moneyoverip_Bitcoin_Donations
 * @subpackage Moneyoverip_Bitcoin_Donations/admin/partials
 */
?>

<?php

//Grab all options
$options = get_option($this->plugin_name);

$xpub_key           = $options['moipbd_form_xpub_key'];
$xpub_id            = $options['moipbd_form_xpub_id'];
$notification_email = $options['moipbd_form_notif_email'];
$test_mode          = $options['moipbd_form_test_mode'];
$selected_btn_style = $options['moipbd_form_svg_btn_style'];

$btn_style_images = [
	'darkblue-btclogo-bitcoin-newline-donate',
   'darkblue-btclogo-donate',
   'darkblue-donate-w-bitcoin',
   'darkblue-donate-w-btclogo-bitcoin',
   'darkblue-donate-w-newline-btclogo-bitcoin',
   'liteblue-btclogo-bitcoin-newline-donate',
   'liteblue-btclogo-donate',
   'liteblue-donate-w-bitcoin',
   'liteblue-donate-w-btclogo-bitcoin',
   'liteblue-donate-w-newline-btclogo-bitcoin',
   'silver-btclogo-bitcoin-newline-donate',
   'silver-btclogo-donate',
   'silver-donate-w-bitcoin',
   'silver-donate-w-btclogo-bitcoin',
   'silver-donate-w-btclogo-bitcoin-big',
   'silver-donate-w-newline-btclogo-bitcoin',
];
$btn_style_images_extra = [
	'moip-round-donation-button-1',
	'moip-round-donation-button-2',
	'moip-round-donation-button-3',
	'moip-round-donation-button-4',
	'moip-round-donation-button-5',
	'moip-round-donation-button-6',
	'moip-round-donation-button-7',
];


?>

<div class="wrap">
   <script>
      // Loading this style sheet, so we can display all available button styles with the use of CSS classes.
      let head  = document.getElementsByTagName('head')[0];
      let link  = document.createElement('link');
      // link.id   = cssId;
      link.rel  = 'stylesheet';
      link.type = 'text/css';
      link.href = 'https://cdn.moneyoverip.io/donations/cdn/moip-donate-style.css';
      link.media = 'all';
      head.appendChild(link);
   </script>
   <script>
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
      * @param adminEmail
      */
     function getMoipXpubId(xpubKeyTarget, notifEmailTarget, xpubIdTarget, adminEmail) {
       const xpubKeyNode = document.getElementById(xpubKeyTarget);
       const notifEmailNode = document.getElementById(notifEmailTarget);
       if (!xpubKeyNode || !notifEmailNode)
         return;
       let notifEmail = adminEmail;
       if (notifEmailNode.value && notifEmailNode.value.indexOf('@') > 2) {
         notifEmail = notifEmailNode.value;
       }
       const xpubKey = xpubKeyNode.value;
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
       if (result && result && result.pub_id) {
         xpubId = result.pub_id;
         // console.debug('Received XPUB ID: ', xpubId);
         if (xpubIdNode) {
           xpubIdNode.value = xpubId;
           // console.debug('value set');
         }
       }
     }
   </script>

   <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

   <form action="options.php" method="post" name="<?php echo $this->plugin_name; ?>_options">

	   <?php
      settings_fields($this->plugin_name);
      do_settings_sections($this->plugin_name);
      ?>

      <table class="form-table">

         <tbody>

            <tr>
               <th scope="row">
                  <label for="moipbd_form_notif_email">
                     <?php _e('Notification email', $this->plugin_name)?>
                  </label>
               </th>
               <td>
                  <input
                        type="email"
                        name="<?php echo $this->plugin_name; ?>[moipbd_form_notif_email]"
                        id="<?php echo $this->plugin_name; ?>-moipbd_form_notif_email"
                        value="<?php if (!empty($notification_email)) echo $notification_email; ?>"
                        class="regular-text">
                  <p class="description">
	                  <?php _e('Each time a Bitcoin donation is made, you will be notified by email.', $this->plugin_name)?>
                  </p>
               </td>
            </tr>

            <tr>
               <th scope="row">
                  <label for="moipbd_form_xpub_key"><?php _e('Your XPUB key', $this->plugin_name)?></label>
               </th>
               <td>
                  <input type="text"
                         name="<?php echo $this->plugin_name; ?>[moipbd_form_xpub_key]"
                         id="<?php echo $this->plugin_name; ?>-moipbd_form_xpub_key"
                         data-name="moipbd_form_xpub_key"
                         value="<?php if (!empty($xpub_key)) echo $xpub_key; ?>"
                         placeholder="xpub....."
                         class="regular-text">
                  <p class="description">
	                  <?php _e('Your <u>XPub <strong>key</strong></u> will be used to retrieve an <u><strong>ID</strong></u> generated by MoneyOverIP, which serves to hide and protect your XPub key.', $this->plugin_name)?>
                     <br>
	                  <?php _e('Your XPub key does not get stored in its entirety (only the first and last few characters, to allow you to remember later on which XPub you used here).<br>
                     Even if your WordPress site gets hacked, your transaction history will remain safe.', $this->plugin_name)?>
                  </p>
               </td>
            </tr>

            <tr>
               <th scope="row">
                  <label for="moipbd_form_xpub_id"><?php _e('MoneyOverIP ID', $this->plugin_name)?></label>
               </th>
               <td>
                  <input type="button"
                         value="<?php _e('Request a MoneyOverIP ID', $this->plugin_name)?>"
                         onclick="getMoipXpubId('<?php echo $this->plugin_name; ?>-moipbd_form_xpub_key', '<?php echo $this->plugin_name; ?>-moipbd_form_notif_email', '<?php echo $this->plugin_name; ?>-moipbd_form_xpub_id', '<?php echo get_option('admin_email'); ?>')">
                  <input type="text"
                         name="<?php echo $this->plugin_name; ?>[moipbd_form_xpub_id]"
                         id="<?php echo $this->plugin_name; ?>-moipbd_form_xpub_id"
                         readonly="readonly"
                         value="<?php if (!empty($xpub_id)) echo $xpub_id; ?>"
                         placeholder=" - "
                         class="regular-text">
                  <p class="description">
	                  <?php _e('This is what allows MoneyOverIP to generate <strong>unique payment addresses</strong> while hiding your XPub master key.', $this->plugin_name)?>
                  </p>
                  <p class="description">
	                  <?php _e('No API key is required. No login on our platform is required! You\'re welcome :)', $this->plugin_name)?>
                  </p>
               </td>
            </tr>

            <tr>
               <th scope="row">
                  <label for="moipbd_form_test_mode"><?php _e('Test mode', $this->plugin_name)?></label>
               </th>
               <td>
                  <label for="moipbd_form_test_mode">
                     <input
                        name="<?php echo $this->plugin_name; ?>[moipbd_form_test_mode]"
                        id="<?php echo $this->plugin_name; ?>-moipbd_form_test_mode"
                        <?php checked($test_mode,1) ?>
                        type="checkbox">
	                  <?php _e('If checked, only the Admin user can see the Donate button', $this->plugin_name)?>
                  </label>
               </td>
            </tr>
            <tr>
               <th>
                  <hr>
               </th>
               <td>
                  <hr>
               </td>
            </tr>
            <tr>
               <th>
                  <label for="">How to use</label>
               </th>
               <td>
                  <p>
                     Insert the Donate button anywhere, using this shortcode
                     <pre><code>[moneyoverip_bitcoin_donation_button/]</code></pre>
                  </p>
               </td>
            </tr>
            <tr>
               <th scope="row">
                  <label><?php _e('Image style', $this->plugin_name)?></label>
               </th>
               <td>

				   <?php foreach ( $btn_style_images as $btn_style_image ): ?>
                   <label class="btn-style-label moip-donate-btn" for="<?php echo $this->plugin_name; ?>-<?php echo $btn_style_image; ?>">
                      <input
                         type="radio"
                         name="<?php echo $this->plugin_name; ?>[moipbd_form_svg_btn_style]"
                         id="<?php echo $this->plugin_name; ?>-<?php echo $btn_style_image; ?>"
                         <?php echo( $selected_btn_style === $btn_style_image ? 'selected="selected" checked="checked"' : '' ); ?>
                         value="<?php echo $btn_style_image; ?>">
                      <div
                         data-old-src="<?php echo trailingslashit( plugins_url() ) . $this->plugin_name .'/assets/svg/' . $btn_style_image; ?>"
                         class="moip-any-donate-btn <?php echo $btn_style_image; ?>"
                         style="display: inline-block;">
                      </div>
                   </label>
				   <?php endforeach; ?>
                  <hr>
               <?php foreach ( $btn_style_images_extra as $btn_style_image ): ?>
                   <label class="btn-style-label moip-donate-btn" for="<?php echo $this->plugin_name; ?>-<?php echo $btn_style_image; ?>">
                      <input
                            type="radio"
                            name="<?php echo $this->plugin_name; ?>[moipbd_form_svg_btn_style]"
                            id="<?php echo $this->plugin_name; ?>-<?php echo $btn_style_image; ?>"
                       <?php echo( $selected_btn_style === $btn_style_image ? 'selected="selected" checked="checked"' : '' ); ?>
                            value="<?php echo $btn_style_image; ?>">
                      <div
                            data-old-src="<?php echo trailingslashit( plugins_url() ) . $this->plugin_name .'/assets/svg/' . $btn_style_image; ?>"
                            class="moip-any-donate-btn <?php echo $btn_style_image; ?>"
                            style="display: inline-block;">
                      </div>
                   </label>
               <?php endforeach; ?>
               </td>
            </tr>

         </tbody>
      </table>

	   <?php submit_button( __('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>
   </form>
</div>
