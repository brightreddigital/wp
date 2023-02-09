<?php

/**
* Functions and definitions
* @link https://developer.wordpress.org/themes/basics/theme-functions/
* @package brightred
*/

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.1' );
}

/* ---
Load partials
---*/

$roots_includes = array(
  '/inc/functions/defaults.php',
  '/inc/functions/plugins.php',
  '/inc/functions/styles.php',
  '/inc/functions/clean.php',
  '/inc/functions/theme-options.php',
);

foreach($roots_includes as $file){
  if(!$filepath = locate_template($file)) {
    trigger_error("Error locating `$file` for inclusion!", E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

	



