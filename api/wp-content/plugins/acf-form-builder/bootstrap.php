<?php

/**
 * Plugin Name: ACF Form Builder
 * Description: Exposes a Form custom post type as well as endpoints for retrieving form data. Useful in headless WordPress instances.
 * Version: 1.0
 * Author: Keen
 * Author URI: https://keen-studio.com
 */

if( ! defined( 'ABSPATH' ) ) {
	return;
}

require dirname( __FILE__ ) . '/vendor/autoload.php';
require dirname( __FILE__ ) . '/src/Plugin.php';
