<?php

namespace NextWPRest;

class Preview {
	public function __construct() {
		add_filter('preview_post_link', array($this, 'init_preview_post_link'), 10, 2);
	}

  public function init_preview_post_link($link, $post) {
    $permalink_url = get_permalink($post);
    if ($post->post_status === 'draft' || $post->post_status === 'auto-draft' || $post->post_status === 'future') {
        // post is a draft
        $permalink_url = get_home_url();
        $post_type = get_post_type($post);
        $permalink_url = '/wp-draft';

        if ($post->post_type !== 'page') {
            $permalink_url = '/' . $post_type . $permalink_url;
        }
    }

    return add_query_arg(
      array(
        'preview_id' => $post->ID,
        '_wpnonce' => wp_create_nonce('wp_rest')
      ),
      $permalink_url
    );
	}
}
