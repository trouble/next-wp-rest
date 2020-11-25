<?php

namespace NextWPRest;

use stdClass;

class Routes {
	public $namespace = '/next-wp-rest/v1';

	public function __construct() {
			add_action('rest_api_init', function () {
					register_rest_route($this->namespace, '/global-data', array(
							'methods' => 'GET',
							'callback' => array($this, 'globalData')
					));
			});
	}

	public function globalData() {
			return array(
					'megaMenu' => get_field('megaMenu', 'option') ? get_field('megaMenu', 'option') : new stdClass(),
			);
	}
}
