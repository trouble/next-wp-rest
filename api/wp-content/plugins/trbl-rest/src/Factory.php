<?php

namespace TRBLRest;

use WP_Post;
use TRBLRest\Utilities;

use stdClass;

class Factory {

	public static function getTerms(WP_Post $post) {
		$taxonomies = get_post_taxonomies($post);
		if (is_array($taxonomies) && count($taxonomies)) {
			$terms = [];
			foreach ($taxonomies as $tax) {
				$terms[$tax] = wp_get_post_terms($post->ID, $tax);
			}
			return $terms;
		}
		return [];
	}

	public static function getEssentials(WP_Post $post) {
		$formatted = new stdClass();
		$formatted->ID = $post->ID;
		$formatted->date = $post->post_date;
		$formatted->title = $post->post_title;
		$formatted->name = $post->post_name;
		$formatted->type = $post->post_type;
		$formatted->permalink = get_permalink($post->ID);
		$formatted->featuredImage = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
		$formatted->template = Utilities::getTemplateSlug($post);
		$formatted->terms = self::getTerms($post);
		$formatted = apply_filters('trbl_rest_api/get_essentials', $formatted);
		$formatted = apply_filters('trbl_rest_api/get_essentials/' . $formatted->type, $formatted);
		return $formatted;
	}

	public static function getFullPost(WP_Post $post) {
		$formatted = self::getEssentials($post);
		$formatted->content = apply_filters('the_content', get_post_field('post_content', $post->ID));
		$formatted->acf = get_fields($post->ID);
		$formatted = apply_filters('trbl_rest_api/get_full_post', $formatted);
		$formatted = apply_filters('trbl_rest_api/get_full_post/' . $formatted->type, $formatted);
		return $formatted;
	}
}
