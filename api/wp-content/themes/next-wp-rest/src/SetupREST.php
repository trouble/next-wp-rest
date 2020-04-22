<?php

namespace NextWPRest;

use TRBLRest\Factory;
use WP_Query;

class SetupREST {
	public function __construct() {
		add_filter('trbl_rest_api/get_full_post', array($this, 'parseGutenbergBlocks'), 10, 1);
		add_filter('trbl_rest_api/get_full_post/page', array($this, 'addTemplateData'), 10, 1);
		add_filter('trbl_rest_api/get_essentials/acffb-form', array($this, 'addMetaToForm'), 10, 1);
    add_filter('trbl_rest_api/get_essentials', array($this, 'addFeaturedImage'), 10, 1);
	}

	public function parseGutenbergBlocks($post) {
		$content_post = get_post($post->ID);
		$post->content = parse_blocks($content_post->post_content);
		return $post;
	}

	public function addFeaturedImage($post) {
		$feature = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'feature');
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'search');

		if ($feature) {
			$post->featuredImage = $feature[0];
			$post->searchThumbnail = $thumbnail[0];
		}

		return $post;
	}

	public function addTemplateData($page) {
		if ($page->template === 'blog') {
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 6,
			);

			if ($page->acf['featuredPost']) {
				$args['post__not_in'] = array($page->acf['featuredPost']->ID);
			}

			$initialPosts = new WP_Query($args);

			$formattedInitialPosts = [];

			if ($initialPosts->have_posts()) {
				foreach ($initialPosts->posts as $post) {
					array_push($formattedInitialPosts, Factory::getEssentials($post));
				}

				$page->initialPosts = $formattedInitialPosts;
			}
		}

		if ($page->template === 'projects') {
			$args = array(
				'post_type' => 'project',
				'posts_per_page' => 6,
			);

			$initialProjects = new WP_Query($args);

			$formattedInitialProjects = [];

			if ($initialProjects->have_posts()) {
				foreach ($initialProjects->posts as $project) {
					array_push($formattedInitialProjects, Factory::getEssentials($project));
				}

				$page->initialProjects = $formattedInitialProjects;
			}
    }

		return $page;
	}

	public function addMetaToForm($form) {
		$form->acf = get_fields($form->ID);
		return $form;
  }
}
