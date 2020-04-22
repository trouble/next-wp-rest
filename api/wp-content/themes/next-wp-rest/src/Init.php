<?php

namespace NextWPRest;

use NextWPRest\CORS;
use NextWPRest\Media;
use NextWPRest\Routes;
use NextWPRest\Preview;
use NextWPRest\SetupTheme;
use NextWPRest\SetupACF;
use NextWPRest\SetupREST;
use NextWPRest\Appearance;
use NextWPRest\Fields\Register as RegisterFields;

class NextWPRestTheme {
	public function __construct() {
		new CORS();
		new Media();
		new Routes();
		new Preview();
		new SetupTheme();
		new SetupREST();
		new SetupACF();
		new Appearance();
		new RegisterFields();
	}
}

new NextWPRestTheme();
