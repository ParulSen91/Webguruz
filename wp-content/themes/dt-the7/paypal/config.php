<?php

  //start session in all pages
  if (session_status() == PHP_SESSION_NONE) { session_start(); } //PHP >= 5.4.0
  //if(session_id() == '') { session_start(); } //uncomment this line if PHP < 5.4.0 and comment out line above

	// sandbox or live
	define('PPL_MODE', 'live');

	if(PPL_MODE=='sandbox'){
		
		define('PPL_API_USER', 'anujk275_api1.gmail.com');
		define('PPL_API_PASSWORD', '5NFGSK8GMX79A5UN');
		define('PPL_API_SIGNATURE', 'AFcWxV21C7fd0v3bYYYRCpSSRl31Aor3NRbLoPZHFohAp9Qc.2RGGg.p');
	}
	else{
		
		define('PPL_API_USER', 'info_api1.webguruz.in');
		define('PPL_API_PASSWORD', 'TW2N7R77WHQNHALX');
		define('PPL_API_SIGNATURE', 'AFcWxV21C7fd0v3bYYYRCpSSRl31A-yQtXaZwhr1i7RWoTVPCl6iptTE');
	}
	
	define('PPL_LANG', 'EN');
	
	define('PPL_LOGO_IMG', 'https://webguruz.in/wp-content/themes/dt-the7/paypal/amazon-shirt-on-demand.jpg');
	
	define('PPL_RETURN_URL', 'https://webguruz.in/wp-content/themes/dt-the7/paypal/process.php');
	/*define('PPL_CANCEL_URL', 'https://webguruz.in/wp-content/themes/dt-the7/paypal/cancel_url.php');
*/
	define('PPL_CURRENCY_CODE', 'USD');
