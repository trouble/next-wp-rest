<?php

namespace TRBLRest;

use TRBLRest\TRBLRest;
use WP_REST_Request;
use WP_REST_Response;

use WP_Query;

class Query {

	public const ARGS = array(
		'slug' => array(
			'required' => false,
			'type' => 'string',
			'description' => 'Specify a post by slug',
		),
		'term' => array(
			'required' => false,
			'description' => 'Get posts by term',
		),
		'search' => array(
			'required' => false,
			'type' => 'string',
			'description' => 'Enter a keyword-based term to search for'
		),
		'per_page' => array(
			'required' => false,
			'type' => 'string',
			'description' => 'Enter the max number of posts to be returned'
		),
		'offset' => array(
			'required' => false,
			'type' => 'string',
			'description' => 'How many posts to offset. Useful for pagination.'
		)
	);

	public function __construct() {
		add_action('rest_api_init', array($this, 'register'));
	}

	public function register() {

		$args = self::ARGS;

		$args['post_type'] = array(
			'required' => false,
			'description' => 'Specify which post types to search within.',
		);

		register_rest_route(TRBLRest::NAMESPACE, '/query', array(
			'methods' => 'GET',
			'callback' => array($this, 'callback'),
			'args' => $args,
		));
	}

	public function callback(WP_REST_Request $request) {

		$searchable_post_types = get_field('searchable_post_types', 'trbl_rest_api_settings');

		if (is_array($searchable_post_types) && count($searchable_post_types)) {

			$args = $this->makeQueryArgsFromRequest($request, array(
        'post_type' => array_column($searchable_post_types, 'value'),
        'post_status' => 'publish',
			));

			////////////////////////////////////////
			// Enable specifying post types to search on
			////////////////////////////////////////

			if (isset($request['post_type'])) {
				$allowed_types = [];

				$queried_types = $request['post_type'];

				// If commas present, split
				if (strpos($queried_types, ',') !== false) {
					$queried_types = explode(',', $queried_types);
				} else {
					$queried_types = array($queried_types);
				}

				foreach ($queried_types as $type) {
					$allowed = false;

					foreach ($searchable_post_types as $allowed_type) {
						if ($type === $allowed_type['value']) {
							$allowed = true;
						}
					}

					if ($allowed) array_push($allowed_types, $type);
				}

				$args['post_type'] = $allowed_types;
			}

			$query = new WP_Query($args);
			return new WP_REST_Response(Utilities::formatPagedResults($query), 200);
		} else {
			return new WP_REST_Response(array(
				'message' => 'Not Found',
			), 404);
		}
	}

	public static function makeQueryArgsFromRequest(WP_REST_Request $request, $args) {

		if (!is_array($args)) $args = array();

		////////////////////////////////////////
		// Enable searching by keyword on title and meta values
		////////////////////////////////////////

		if (isset($request['search'])) {
			$args['_meta_or_title'] = $request['search'];
			$args['meta_query'] = array(
				array(
					'value' => $request['search'],
					'compare' => 'LIKE'
				)
			);
		}

		////////////////////////////////////////
		// Enable searching by slug
		////////////////////////////////////////

		if (isset($request['slug'])) {
			$args['name'] = $request['slug'];
		}

		////////////////////////////////////////
		// Enable per page
		////////////////////////////////////////

		if (isset($request['per_page'])) {
			$args['posts_per_page'] = $request['per_page'];
		}

		////////////////////////////////////////
		// Enable offset
		////////////////////////////////////////

		if (isset($request['offset'])) {
			$args['offset'] = $request['offset'];
		}

		////////////////////////////////////////
		// Enable post ID exclusion
		////////////////////////////////////////

		if (isset($request['exclude'])) {
			$exclude = $request['exclude'];

			// If commas present, split
			if (strpos($exclude, ',') !== false) {
				$exclude = explode(',', $exclude);
			} else {
				$exclude = array($exclude);
			}

			$args['post__not_in'] = $exclude;
		}

		////////////////////////////////////////
		// Enable searching by multiple terms
		////////////////////////////////////////

		if (isset($request['term'])) {
			$terms_query = $request['term'];
			$args['tax_query'] = [];

			if (is_array($terms_query) && count($terms_query)) {
				foreach ($terms_query as $tax => $term) {
					$terms = $term;
					// If commas present, split
					if (strpos($term, ',') !== false) {
						$terms = explode(',', $term);
					}

					array_push($args['tax_query'], array(
						'include_children' => true,
						'operator' => 'IN',
						'taxonomy' => $tax,
						'field' => 'term_id',
						'terms' => $terms,
					));
				}
			}
		}

		return apply_filters('trbl_rest_api/query_args', $args, $request);
	}
}
