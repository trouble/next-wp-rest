<?php

namespace TRBLRest;

class ACFFilters {
	public function __construct() {
		add_filter('acf/format_value/type=relationship', array($this, 'setupRelationships'), 40, 3);
		add_filter('acf/format_value/type=post_object', array($this, 'setupPostObjects'), 40, 3);
	}

	public function setupRelationships($values) {
		if (is_array($values) && count($values)) {
			$formatted = [];
	
			foreach ($values as $value) {
				array_push($formatted, Factory::getEssentials($value));
			}
	
			return $formatted;
		}
	
		return $values;
	}
	
	public function setupPostObjects($values, $post_id, $field) {
		if (is_array($values) && count($values)) {
			$formatted = [];
			foreach ($values as $value) {
				array_push($formatted, Factory::getEssentials($value));
			}
			return $formatted;
		}
		if ($values) {
			return Factory::getEssentials($values);
		} else {
			return false;
		}
	}
}
