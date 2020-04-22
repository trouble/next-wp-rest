<?php

namespace TRBLRest;

use TRBLRest\TRBLRest;
use WP_Post;
use WP_Query;
use stdClass;

class Utilities {
	public static function getPostTypes() : array {
		$post_types = array();
		$args = array(
				'_builtin'              => false,
				'publicly_queryable'    => true
		);

		foreach (get_post_types($args, 'object') as $post_type) {
				$post_types[$post_type->name] = $post_type->labels->name;
		}

		//These need to be added manually as they are builtin
		$post_types['page'] = 'Page';
		$post_types['post'] = 'Post';

		return $post_types;
	}

	public static function getTemplateSlug(WP_Post $post) : string {
		$id = $post->ID;

		if ($post->post_type === 'revision') {
				$id = $post->post_parent;
		}

		// Add template name to object
		$template = get_page_template_slug($id);
		// Clean up template filename
		$template = str_replace('.php', '', $template);
		$template = str_replace('page-', '', $template);
		if ($template === '') {
				$template = 'default';
		}

		return $template;
	}

	public static function formatPagedResults(WP_Query $query) {
		$response = new stdClass();
		$response->post_count = $query->post_count;
		$response->max_num_pages = $query->max_num_pages;
		$response->found_posts = $query->found_posts;
		$response->posts = [];

		if ($query->have_posts()) {
			foreach ($query->posts as $post) {
				array_push($response->posts, Factory::getEssentials($post));
			}
		}
		return $response;
	}

	public static function isREST() {
			$current_url = wp_parse_url( add_query_arg( array( ) ) );
			return strpos( $current_url['path'], TRBLRest::NAMESPACE) !== false;
	}
}
