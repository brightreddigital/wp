<?php

/* 
--------
Add mimes support 
--------
*/

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  $mimes['ico'] = 'image/x-icon';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/* 
--------
Add Woocommerce support 
--------
*/

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}