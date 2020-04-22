<?php

namespace ACFFormBuilder\Submission;

class PostType {
	public function __construct() {
		add_action('init', array( $this, 'registerPostType' ));
	}

	public function registerPostType() {
		$post_type_labels = array(
			'name'               => __('Submissions', 'brt'),
			'singular_name'      => __('Submission', 'brt'),
			'add_new'            => __('Add New', 'brt'),
			'add_new_item'       => __('Add New Submission', 'brt'),
			'edit_item'          => __('Edit Submission', 'brt'),
			'new_item'           => __('New Submission', 'brt'),
			'view_item'          => __('View Submission', 'brt'),
			'view_items'         => __('View Submissions', 'brt'),
			'search_items'       => __('Search Submissions', 'brt'),
			'not_found'          => __('No submissions found', 'brt'),
			'not_found_in_trash' => __('No submissions found in trash', 'brt'),
			'all_items'          => __('All Submissions', 'brt'),
			'archives'           => __('Submission Archives', 'brt'),
			'attributes'         => __('Submission Attributes', 'brt'),
		);

		$post_type_args = array(
				'label'                 => __('Form Submissions', 'brt'),
				'labels'                => $post_type_labels,
				'description'           => __('All BRT Submissions', 'brt'),
				'public'                => false,
				'menu_icon'             => 'dashicons-admin-comments',
				'supports'              => array( 'title', 'revisions' ),
		);

		register_post_type('acffb-submission', $post_type_args);
	}
}
