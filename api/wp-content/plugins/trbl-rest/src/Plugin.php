<?php

namespace TRBLRest;

use TRBLRest\GetOne;
use TRBLRest\GetMany;
use TRBLRest\Query;
use TRBLRest\Fields;
use TRBLRest\Preview;
use TRBLRest\Setup\Dependencies;
use TRBLRest\Utilities;

class TRBLRest {

	public const NAMESPACE = 'trbl-rest/v1';

  public function __construct() {
		add_action('init', array($this, 'initACF'), 100);
		add_action('init', array($this, 'registerEndpoints'), 20);
		add_action('pre_get_posts', array($this, 'addMetaOrTitleSearch'));
  }

	public function initACF() {
		if (Dependencies::areMet()) {
			$this->registerOptions();
			$this->registerFields();

			// Only filter relationship and post object ACF fields
			// if responding to a REST request
			if (Utilities::isREST()) {
				new ACFFilters();
			}
		}
	}

	public function registerOptions() {
		acf_add_options_page(array(
			'page_title'    => 'TRBL REST API Settings',
			'menu_title'    => 'TRBL REST API Settings',
			'menu_slug'     => 'trbl_rest_api_settings',
			'post_id'       => 'trbl_rest_api_settings',
			'capability'    => 'edit_posts',
			'parent'        => 'options-general.php',
			'redirect'      => false
		));
	}

	public function registerFields() {
		new Fields();
	}

	public function registerEndpoints() {
		new Query();
		new Preview();

		$active_post_types = get_field('enabled_endpoints', 'trbl_rest_api_settings');

		if (is_array($active_post_types) && count($active_post_types)) {
			foreach($active_post_types as $type) {
				$post_type = get_post_type_object($type);
				if ($post_type->rest_base) {
					new GetOne($type, $post_type->rest_base);
					new GetMany($type, $post_type->rest_base);
				}
			}
		}
	}

	public function addMetaOrTitleSearch ($q) {
		if( $title = $q->get( '_meta_or_title' ) ) {
			add_filter( 'get_meta_sql', function( $sql ) use ( $title ) {
				global $wpdb;

				// Only run once:
				static $nr = 0; 
				if( 0 != $nr++ ) return $sql;

				// Modify WHERE part:
				$sql['where'] = sprintf(
					" AND ( %s OR %s ) ",
					$wpdb->prepare( "{$wpdb->posts}.post_title LIKE '%%%s%%'", $title ),
					mb_substr( $sql['where'], 5, mb_strlen( $sql['where'] ) )
				);

				return $sql;
			});
		}
	}
}

new TRBLRest();
