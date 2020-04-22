<?php

namespace ACFFormBuilder\FieldType;

class Fields {
	public function __construct() {
		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_5d51eb281abf8',
				'title' => 'Field Type',
				'fields' => array(
					array(
						'key' => 'field_5d51eb3420cd0',
						'label' => 'Required',
						'name' => 'required',
						'type' => 'true_false',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => '',
						'default_value' => 0,
						'ui' => 1,
						'ui_on_text' => '',
						'ui_off_text' => '',
					),
					array(
						'key' => 'field_5d51eb2e20ccf',
						'label' => 'Label',
						'name' => 'label',
						'type' => 'text',
						'instructions' => 'Enter a label for this field. It should be shown to the user.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '33.33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d51eb4720cd1',
						'label' => 'Name',
						'name' => 'name',
						'type' => 'text',
						'instructions' => 'Enter a unique, lowercase, dashed name for this field (ex. "first-name").',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '33.33',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d51eca13a6a2',
						'label' => 'Width',
						'name' => 'width',
						'type' => 'select',
						'instructions' => 'Choose a width for this field.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '33.33',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'half' => 'Half',
							'full' => 'Full',
						),
						'default_value' => array(
							0 => 'full',
						),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'return_format' => 'value',
						'ajax' => 0,
						'placeholder' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'acf-form-builder-placeholder',
							'operator' => '==',
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
