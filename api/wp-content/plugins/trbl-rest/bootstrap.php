<?php

/**
 * Plugin Name: TRBL REST API
 * Description: Exposes REST API endpoints w/ ACF fields in a more predictable and ideal manner.
 * Version: 0.1
 * Author: TRBL
 * Author URI: https://trbl.design
 */

if( ! defined( 'ABSPATH' ) ) {
	return;
}

require dirname( __FILE__ ) . '/vendor/autoload.php';
require dirname( __FILE__ ) . '/src/Plugin.php';
