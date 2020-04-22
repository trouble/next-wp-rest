<?php

namespace NextWPRest;

class CORS {
	public function __construct() {
		/**
		 * Allow GET requests from SSR and dev CRA origins
		 * Thanks to https://joshpress.net/access-control-headers-for-the-wordpress-rest-api/
		 */
		add_action('rest_api_init', function () {
			remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
			add_filter('rest_pre_serve_request', function ($value) {
				// Site URL defined in WP
				$origin = get_home_url();
				header('Access-Control-Allow-Origin: ' . $origin);
				// header('Access-Control-Allow-Origin: *');
				header('Access-Control-Allow-Methods: GET');
				header('Access-Control-Allow-Credentials: true');
				return $value;
			});
		}, 15);
	}
}
