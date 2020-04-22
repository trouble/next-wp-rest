<?php

namespace ACFFormBuilder;

use ACFFormBuilder\Setup\ACF;
use ACFFormBuilder\FieldType\Fields as FieldTypeFields;
use ACFFormBuilder\Form\PostType as FormPostType;
use ACFFormBuilder\Form\Fields as FormFields;
use ACFFormBuilder\Submission\PostType as SubmissionPostType;
use ACFFormBuilder\Endpoints\Post;
use ACFFormBuilder\Setup\Dependencies;

class Plugin {
    public function __construct() {
		add_action('plugins_loaded', array($this, 'initACF'));
		$this->registerPostTypes();
		$this->registerEndpoints();
  }

  public function registerPostTypes() {
		new FormPostType();
		new SubmissionPostType();
	}

	public function initACF() {
		if (Dependencies::areMet()) {
			new ACF();
			$this->registerFields();
		}
	}
	
	public function registerFields() {
		new FormFields();
		new FieldTypeFields();
	}

	public function registerEndpoints() {
		new Post();
	}
}

new Plugin();
