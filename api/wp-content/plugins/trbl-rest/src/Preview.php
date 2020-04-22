<?php

namespace TRBLRest;

use TRBLRest\TRBLRest;
use TRBLRest\Factory;
use WP_REST_Request;
use WP_REST_Response;

class Preview {

	public function __construct() {
    add_action('rest_api_init', array($this, 'register'));
  }

	public function register() {
		register_rest_route(TRBLRest::NAMESPACE, '/preview/(?P<id>[0-9]+)/', array(
			'methods' => 'GET',
      'callback' => array($this, 'callback'),
      'permission_callback' => function () {
        return current_user_can('edit_posts');
      }
    ));
	}

	public function callback(WP_REST_Request $request) {
		// Revisions are drafts so here we remove the default 'publish' status
		remove_action('pre_get_posts', 'set_default_status_to_publish');
    $id = $request->get_param('id');
		if ($revisions = wp_get_post_revisions($id, array( 'check_enabled' => false ))) {
      $last_revision = reset($revisions);
      $rev_post = wp_get_post_revision($last_revision->ID);
      $formatted = Factory::getFullPost($rev_post);
      $formatted->featuredImage = wp_get_attachment_url(get_post_thumbnail_id($rev_post->post_parent));
      return new WP_REST_Response($formatted, 200);
		} elseif ($post = get_post($id)) {
      // There are no revisions, just return the saved parent post
      return new WP_REST_Response(Factory::getFullPost($post), 200);
		} else {
			return new WP_REST_Response(array(
				'message' => 'Not Found',
			), 404);
		}
	}
}
