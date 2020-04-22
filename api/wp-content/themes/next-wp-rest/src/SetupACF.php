<?php

namespace NextWPRest;

class SetupACF {
	public function __construct() {
		add_filter('acf/fields/flexible_content/layout_title', array($this,'addLayoutTitle'), 10, 4);
		add_filter('acf/location/rule_types', array($this, 'addDeveloperLocation'));
	}

	public function addLayoutTitle($title, $field, $layout, $i) {
		if ($value = get_sub_field('layoutTitle')) {
			return $value . ' - ' . $layout['label'];
		}

		return $title;
	}

	public function addDeveloperLocation($choices) {
		$choices['Developer']['placeholder'] = 'Placeholder';
		return $choices;
	}
}
