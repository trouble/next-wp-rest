<?php

namespace TRBLRest;

use TRBLRest\TRBLRest;
use TRBLRest\Factory;
use WP_REST_Request;
use WP_REST_Response;

class GetOne {
	private $post_type;
	private $path;

	public function __construct(string $post_type, string $path) {
		$this->post_type = $post_type;
		$this->path = $path;
		add_action('rest_api_init', array($this, 'register'));
	}

	public function register() {
		register_rest_route(TRBLRest::NAMESPACE, '/' . $this->path . '/(?P<id>[0-9a-zA-Z-_\/]+)/', array(
			'methods' => 'GET',
			'callback' => array($this, 'callback'),
		));
	}

	public function callback(WP_REST_Request $request) {
		$id = $request->get_param('id');

		if (is_numeric($id)) {
			$post = get_post($id);
		} else {
			$post = get_page_by_path($id, 'object', $this->post_type);
		}

		if ($post && $post->post_status === 'publish') {
			return new WP_REST_Response(Factory::getFullPost($post), 200);
		} else {
			return new WP_REST_Response(array(
				'message' => 'Not Found',
			), 404);
		}
	}
}
