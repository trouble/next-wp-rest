<?php

namespace NextWPRest;

class SetupTheme {
	public function __construct() {
		add_action('after_setup_theme', array($this, 'setup'));
		add_action('admin_menu', array($this, 'removeMenus'));
		add_action('upload_mimes', array($this, 'customMIMETypes'), 10, 1);
		add_filter('rest_url', array($this, 'updateRESTURL'), 10, 4);
		add_filter('mce_buttons_2', array($this, 'addStyleSelectButtons'));		
		add_filter('allowed_block_types', array($this, 'restrictBlockTypes'), 10, 2);
	}

	public function setup() {
		add_theme_support( 'post-thumbnails' );
	}

	public function removeMenus() {
		remove_submenu_page('themes.php', 'nav-menus.php');
		remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
		unregister_taxonomy_for_object_type('post_tag', 'post');
	}

	public function customMIMETypes($mime_types) {
		$mime_types['svg'] = 'image/svg+xml'; //Adding svg extension
		return $mime_types;
	}

	public function updateRESTURL($url) {
		$newUrl = str_replace(get_home_url(), get_site_url(), $url);
		return $newUrl;
	}

	public function addStyleSelectButtons($buttons) {
		array_unshift($buttons, 'styleselect');
		return $buttons;
	}

	public function restrictBlockTypes($allowed_block_types, $post) {
		return $allowed_block_types;
	}
}
