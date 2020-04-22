<?php

namespace ACFFormBuilder\Form;

class PostType {
	public function __construct() {
		add_action('init', array( $this, 'registerPostType' ));
	}

	public function registerPostType() {
		$post_type_labels = array(
			'name'               => __('Forms', 'brt'),
			'singular_name'      => __('Form', 'brt'),
			'add_new'            => __('Add New', 'brt'),
			'add_new_item'       => __('Add New Form', 'brt'),
			'edit_item'          => __('Edit Form', 'brt'),
			'new_item'           => __('New Form', 'brt'),
			'view_item'          => __('View Form', 'brt'),
			'view_items'         => __('View Forms', 'brt'),
			'search_items'       => __('Search Forms', 'brt'),
			'not_found'          => __('No forms found', 'brt'),
			'not_found_in_trash' => __('No forms found in trash', 'brt'),
			'all_items'          => __('All Forms', 'brt'),
			'archives'           => __('Form Archives', 'brt'),
			'attributes'         => __('Form Attributes', 'brt'),
		);

		$post_type_args = array(
				'label'                 => __('Forms', 'brt'),
				'labels'                => $post_type_labels,
				'description'           => __('All BRT Forms', 'brt'),
				'public'                => true,
				'menu_icon'             => 'dashicons-feedback',
				'supports'              => array( 'title', 'revisions' ),
		);

		register_post_type('acffb-form', $post_type_args);
	}
}
