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

/* 
------------
Theme defaults and support for various WordPress features 
------------
*/

function brightred_setup() {
	
	// Translation
	load_theme_textdomain( 'brightred', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Post Thumbnails on posts and pages		
	add_theme_support( 'post-thumbnails' );

	// Uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu' => esc_html__( 'Primary', 'brightred' ),
		)
	);

	// Switch default core markup for search form, comment form, and comments to output valid HTML5
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'brightred_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Custom logo
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}

add_action( 'after_setup_theme', 'brightred_setup' );

/*
--------- 
Register the required plugins 
----------
*/

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'register_required_plugins' );

function register_required_plugins() {

	$plugins = array(

		// Plugins from external sources
		array(
			'name'         => 'Elementor Pro', 
			'slug'         => 'elementor-pro',
			'required'     => true,
			'external_url' => 'https://my.elementor.com/subscriptions/',
		),

		array(
			'name'         => 'Advanced Custom Fields PRO',
			'slug'         => 'advanced-custom-fields-pro',
			'required'     => true,
			'external_url' => 'https://www.advancedcustomfields.com/my-account/',
		),

		// Plugins from the WordPress Plugin Repository

		array(
			'name'      => 'Classic Editor',
			'slug'      => 'classic-editor',
			'required'  => true,
		),

		array(
			'name'      => 'WP Pusher',
			'slug'      => 'wppusher',
			'required'  => true,
		),

	);

	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'install-plugins',       // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                   // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                    // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

	);

	tgmpa( $plugins, $config );
}

// Check ACF  

if( function_exists('acf_add_options_page') ) {
    
  /* Add theme options  */

  acf_add_options_page(array(
    'page_title'  => 'Theme General Settings',
    'menu_title'  => 'Theme Settings',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));
  
  acf_add_options_sub_page(array(
    'page_title'  => 'Theme Typography Settings',
    'menu_title'  => 'Typography',
    'parent_slug' => 'theme-general-settings',
  ));
  
  acf_add_options_sub_page(array(
    'page_title'  => 'Theme Footer Settings',
    'menu_title'  => 'Footer',
    'parent_slug' => 'theme-general-settings',
  ));

  /* Change Site Indentiy */

  add_action('acf/init', 'siteDetails'); 

  function siteDetails() {

    $sitetitle = get_field('site_title', 'option');   
    
    if ($sitetitle) {
      update_option('blogname', $sitetitle);
    } else {
      update_option( 'blogname', '' );  
    }

    $tagline = get_field('tagline', 'option');    
    
    if ($tagline) {
      update_option('blogdescription', $tagline);
    } else {
      update_option( 'blogdescription', '' ); 
    }

    $adminemail = get_field('admin_email', 'option');   
    
    if ($adminemail) {
      update_option('admin_email', $adminemail);
    } else {
      update_option( 'admin_email', '' ); 
    }

  }

  /* Enqueue site type specific styles */

	function dynamic_style() {
	  	if( get_field('sitetype', 'option') == 'eCommerce' ) {
	    wp_enqueue_style( 'ecommerce', get_template_directory_uri() . '/inc/css/sitetype/ecommerce.css' );
		}
		if( get_field('sitetype', 'option') == 'Brochure' ) {
	    wp_enqueue_style( 'ecommerce', get_template_directory_uri() . '/inc/css/sitetype/brochure.css' );
		}
	}
	add_action('wp_enqueue_scripts', 'dynamic_style', 99);

//ACF Check
}


/* 
--------
Parse style variables
--------
*/

function generate_options_css() {
    $ss_dir = get_stylesheet_directory();
    ob_start(); // Capture all output into buffer
    require($ss_dir . '/inc/css/style-vars.php'); // Grab the custom styles file
    $css = ob_get_clean(); // Store output in a variable, then flush the buffer
    file_put_contents($ss_dir . '/inc/css/style-vars.css', $css, LOCK_EX); // Save it as a css file
}
add_action( 'acf/save_post', 'generate_options_css', 20 ); //Parse the output and write the CSS file on save

/**
---------
* Enqueue scripts and styles
---------
 */

function brightred_scripts() {
	
	wp_enqueue_style( 'style-variables', get_template_directory_uri() . '/inc/css/style-vars.css' );
	wp_enqueue_style( 'brightred-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'brightred-style', 'rtl', 'replace' );
	wp_enqueue_script( 'brightred-theme-style', get_template_directory_uri() . '/js/theme.js', array(), _S_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'brightred_scripts' );

/* 
---------
Clean up
---------
*/

/* Disable emojis */
function disable_emojis() {
	
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );	
	// Remove from TinyMCE
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}

add_action( 'init', 'disable_emojis' );

/* Filter out the tinymce emoji plugin. */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

//Remove Gutenberg Block Library CSS from loading on the frontend
function smartwp_remove_wp_block_library_css(){

	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS

} 

add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

// Disable WooCommerce bloat
add_filter( 'woocommerce_admin_disabled', '__return_true' );
add_filter( 'jetpack_just_in_time_msgs', '__return_false', 20 );
add_filter( 'jetpack_show_promotions', '__return_false', 20 );
add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false', 999 );
add_filter( 'woocommerce_helper_suppress_admin_notices', '__return_true' );
add_filter( 'woocommerce_marketing_menu_items', '__return_empty_array' );
add_filter( 'woocommerce_background_image_regeneration', '__return_false' );
add_filter( 'wp_lazy_loading_enabled', '__return_false' );
add_filter( 'woocommerce_menu_order_count', 'false' );
add_filter( 'woocommerce_enable_nocache_headers', '__return_false' );
add_filter( 'woocommerce_include_processing_order_count_in_menu', '__return_false' );
add_action( 'admin_menu', function() { remove_menu_page( 'skyverge' ); }, 99 );
add_action( 'admin_enqueue_scripts', function() { wp_dequeue_style( 'sv-wordpress-plugin-admin-menus' ); }, 20 );
add_action( 'wp_dashboard_setup', function () { remove_meta_box( 'e-dashboard-overview', 'dashboard', 'normal'); }, 40);
add_action( 'admin_menu', function () { remove_submenu_page( 'woocommerce', 'wc-addons'); }, 999 );

add_filter( 'woocommerce_admin_features', function ( $features ) {

	$marketing = array_search('marketing', $features);
	unset( $features[$marketing] );
	return $features;

} );

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



/* Upload Favion */

	// Place favicon in root directory
	function acf_upload_dir_prefilter($errors, $file, $field) {
    
    // Only allow editors and admins, change capability as you see fit
    if( !current_user_can('edit_pages') ) {
        $errors[] = 'Only Editors and Administrators may upload attachments';
    }
    
    // This filter changes directory just for item being uploaded
    add_filter('upload_dir', 'acf_upload_dir');
    
}

// Add favicion link to <head>
	function add_favicon(){ ?>

		<link rel="icon" type="image/png" href="<?php echo the_field('favicon', 'option'); ?>">
		<link rel="shortcut icon" type="image/png" href="<?php echo the_field('favicon', 'option'); ?>">
		<link rel="apple-touch-icon" type="image/png" href="<?php echo the_field('favicon', 'option'); ?>">
		<link rel="apple-touch-icon-precomposed" type="image/png" href="<?php echo the_field('favicon', 'option'); ?>">

	<?php }

	add_action('wp_head','add_favicon');
	

/* 
--------
Add Woocommerce support 
--------
*/

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

// Disable Google Fonts in Elementor
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );

/* ----
Includes
-----*/

include '../inc/shortcodes.php';




