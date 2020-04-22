<?php

namespace TRBLRest;

use TRBLRest\Utilities;

class Fields {
	public function __construct() {
		$this->registerFields();
	}

	public function registerFields() {
		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_5d9c85572620f',
				'title' => 'TRBL REST API Settings',
				'fields' => array(
					array(
						'key' => 'field_5d9c85630b1dd',
						'label' => 'Enabled Endpoints',
						'name' => 'enabled_endpoints',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => Utilities::getPostTypes(),
						'default_value' => [],
						'allow_null' => 0,
						'multiple' => 1,
						'ui' => 1,
						'ajax' => 0,
						'return_format' => 'array',
						'placeholder' => '',
					),
					array(
						'key' => 'field_5d9c858174618',
						'label' => 'Searchable Post Types',
						'name' => 'searchable_post_types',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => Utilities::getPostTypes(),
						'default_value' => array(
						),
						'allow_null' => 0,
						'multiple' => 1,
						'ui' => 1,
						'ajax' => 0,
						'return_format' => 'array',
						'placeholder' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'trbl_rest_api_settings',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));
			
			endif;
	}
}
