<?php

namespace TRBLRest;

use TRBLRest\TRBLRest;
use TRBLRest\Utilities;
use TRBLRest\Query;
use WP_REST_Request;
use WP_REST_Response;

use WP_Query;

class GetMany {
	private $post_type;
	private $path;

	public function __construct(string $post_type, string $path) {
		$this->post_type = $post_type;
		$this->path = $path;
		add_action('rest_api_init', array($this, 'register'));
	}

	public function register() {
		register_rest_route(TRBLRest::NAMESPACE, '/' . $this->path, array(
			'methods' => 'GET',
			'callback' => array($this, 'callback'),
			'args' => Query::ARGS,
		));
	}
	
	public function callback(WP_REST_Request $request) {
		$args = Query::makeQueryArgsFromRequest($request, array(
			'post_type' => $this->post_type
		));

		$query = new WP_Query($args);
		return new WP_REST_Response(Utilities::formatPagedResults($query), 200);
	}
}
