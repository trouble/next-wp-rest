<?php

namespace ACFFormBuilder\Endpoints;

use WP_REST_Request;
use WP_REST_Response;

class Post {
	public $namespace = 'acf-form-builder/v1';

	public function __construct() {
		add_action('rest_api_init', array($this, 'register'));
	}

	public function register() {
		register_rest_route($this->namespace, 'forms/(?P<id>\d+)/', array(
			'methods' => 'POST',
			'callback' => array($this, 'callback')
		));
	}

	public function getRequiredFields($field) {
		return $field['required'];
	}

	public function replacePlaceholders($input, $fields) {
		$formatted = $input;

		foreach ($fields as $key => $value) {
			$formatted = str_replace('{{' . $key . '}}', $value, $formatted);
		};

		return $formatted;
	}

	public function callback(WP_REST_Request $request) {
		$id = $request->get_param('id');
		$body = $request->get_body_params();

		$form = get_post($id);

		if (!empty($body['comment'])) {
			return new WP_REST_Response(array(
				'message' => 'Sorry, it seems like you are a robot.'
			), 200);
		}

		if (!$form) {
			return new WP_REST_Response(array(
				'message' => 'Form not found.'
			), 404);
		}

		if ($form && $form->post_type === 'acffb-form') {
			$form_data = get_fields($form->ID);
			$required_fields = array_filter($form_data['fields'], array($this, 'getRequiredFields'));

			$valid = true;
			$errors = [];

			foreach ($required_fields as $field) {
				$name = $field['name'];
				if (!$body[$name]) {
					$valid = false;
					array_push($errors, $name);
				}
			}

			if ($valid) {
				$to = $form_data['sendTo'];
				$subject = $this->replacePlaceholders($form_data['emailSubject'], $body);
				$body = '<html><body>' . $this->replacePlaceholders($form_data['emailBody'], $body) . '</body></html>';
				$headers = array('Content-Type: text/html; charset=UTF-8', 'From: Custer Website <wordpress@wp.custerinc.com>');

				$result = wp_mail( $to, $subject, $body, $headers );

				if ($result) {
					return new WP_REST_Response(array(
						'message' => $form_data['successMessage']
					), 200);
				} else {
					return new WP_REST_Response(array(
						'message' => 'Sorry, your submission can\'t be received right now. Please try again later.'
					), 500);
				}
			} else {
				return new WP_REST_Response(array(
					'message' => 'Some fields are not correct. Please check your submission for errors and try again.',
					'errors' => $errors
				), 400);
			}
		}

		return new WP_REST_Response(array(
			'message' => 'Bad request.'
		), 400);
	}
}
