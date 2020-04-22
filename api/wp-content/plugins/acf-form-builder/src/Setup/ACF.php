<?php

namespace ACFFormBuilder\Setup;

class ACF
{
    public function __construct()
    {
		add_filter('acf/location/rule_types', array($this, 'addPlaceholderLocation'));
		add_filter('acf/format_value/type=post_object', array($this, 'formatFormValue'), 20, 3);
    }

    public function addPlaceholderLocation($choices)
    {
        $choices['ACF Form Builder']['acf-form-builder-placeholder'] = 'ACF Form Builder Placeholder';
        return $choices;
	}
	
	public function formatFormValue($value) {
		$post_object = get_post($value);

		if ($post_object && $post_object->post_type === 'acffb-form') {
			$post_object->acf = array(
				'fields' => get_field('fields', $value),
				'submitLabel' => get_field('submitLabel', $value),
				'successMessage' => get_field('successMessage', $value)
			);
			return $post_object;
		}

		return $value;
	}
}
