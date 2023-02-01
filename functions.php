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

/* Remove Gutenberg Block Library CSS from loading on the frontend */
function smartwp_remove_wp_block_library_css(){

	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS

} 

add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

/* Disable WooCommerce bloat */
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

/* ----
Favicon 
-------*/

// Place favicon in root directory
function acf_upload_dir_prefilter($errors, $file, $field) {

// Only allow editors and admins, change capability as you see fit
if( !current_user_can('edit_pages') ) {
    $errors[] = 'Only Editors and Administrators may upload attachments';
}

// This filter changes directory just for item being uploaded
add_filter('upload_dir', 'acf_upload_dir');

}

/* 
--------
Add Woocommerce support 
--------
*/

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

/* ---
Disable Google Fonts in Elementor
---- */

add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );


/* ------- Check ACF -------- */ 
add_action( 'acf/init', 'checkACF' );

function checkACF() {

	// Add favicion link to <head>

	function add_favicon(){ ?>

		<link rel="icon" type="image/png" href="<?php echo the_field('favicon', 'option'); ?>">
		<link rel="shortcut icon" type="image/png" href="<?php echo the_field('favicon', 'option'); ?>">
		<link rel="apple-touch-icon" type="image/png" href="<?php echo the_field('favicon', 'option'); ?>">
		<link rel="apple-touch-icon-precomposed" type="image/png" href="<?php echo the_field('favicon', 'option'); ?>">

	<?php }

	add_action('wp_head','add_favicon');
    
  // Add theme options

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
    'page_title'  => 'Post Types',
    'menu_title'  => 'Post Types',
    'parent_slug' => 'theme-general-settings',
  ));
  
  acf_add_options_sub_page(array(
    'page_title'  => 'Theme Footer Settings',
    'menu_title'  => 'Footer',
    'parent_slug' => 'theme-general-settings',
  ));

  /* Change Site Indentiy */

  add_action('acf/init', 'siteDetails'); 
  add_action('acf/init', 'dynamic_style'); 

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

	/* ---
Custom post types 
---- */

if( have_rows('post_type', 'option') ):

	    // Loop through rows.
	    while( have_rows('post_type','option') ) : the_row();

				// $ptName = get_sub_field('pt_name','option');
				
				// You'll want to replace the values below with your own.
				register_post_type( 'test',
					array(
						'labels' => array(
							'name' => __( 'test' ), // change the name
							'singular_name' => __( 'genstarter' ), // change the name
						),
						'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
						'exclude_from_search' => true,  // you should exclude it from search results
						'has_archive' => false,  // it shouldn't have archive page
						'supports' => array ( 'title', 'editor', 'custom-fields', 'page-attributes', 'thumbnail' ), // do you need all of these options?
						'taxonomies' => array( 'category', 'post_tag' ), // do you need categories and tags?
						// 'menu_icon' => get_bloginfo( 'template_directory' ) . "/images/icon.png",
						'rewrite' => array ( 'slug' => __( 'genstarters' ) ) // change the name
					)
				);

	    // End loop.
	    endwhile;
	
	else :

endif;



	/* ----
	Shortcodes 
	----*/

	// Social shortcode
	function social() {
		
		ob_start();

		if( have_rows('platforms' , 'option') ):
			echo '<ul class="social-icons">';
			while( have_rows('platforms' , 'option') ) : the_row();
				echo '<li>'; ?>
					
					<a href="<?php the_sub_field('link'); ?>"></a>
					
					<object data="<?php the_sub_field('icon'); ?>" type="image/svg+xml" ></object>
					
				<?php echo '</li>';
			endwhile;
			echo '</ul>';
		endif;

		$content = ob_get_clean();
	    return $content;

	}

	add_shortcode('social', 'social');

	// Phone shortcode
	function phone() {
		
		ob_start(); ?>

			<a class="icon-text-inline" href="tel:<?php the_field('phone','option'); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
					<path d="M511.2 387l-23.25 100.8c-3.266 14.25-15.79 24.22-30.46 24.22C205.2 512 0 306.8 0 54.5c0-14.66 9.969-27.2 24.22-30.45l100.8-23.25C139.7-2.602 154.7 5.018 160.8 18.92l46.52 108.5c5.438 12.78 1.77 27.67-8.98 36.45L144.5 207.1c33.98 69.22 90.26 125.5 159.5 159.5l44.08-53.8c8.688-10.78 23.69-14.51 36.47-8.975l108.5 46.51C506.1 357.2 514.6 372.4 511.2 387z"/>
				</svg>
				<?php the_field('phone','option'); ?>
			</a>

		<?php $content = ob_get_clean();
	    return $content;

	}

	add_shortcode('phone', 'phone');

	// Email shortcode
	function email() {
		
		ob_start(); ?>

			<a class="icon-text-inline" href="mailto:<?php the_field('email_address','option'); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
					<path d="M207.8 20.73c-93.45 18.32-168.7 93.66-187 187.1c-27.64 140.9 68.65 266.2 199.1 285.1c19.01 2.888 36.17-12.26 36.17-31.49l.0001-.6631c0-15.74-11.44-28.88-26.84-31.24c-84.35-12.98-149.2-86.13-149.2-174.2c0-102.9 88.61-185.5 193.4-175.4c91.54 8.869 158.6 91.25 158.6 183.2l0 16.16c0 22.09-17.94 40.05-40 40.05s-40.01-17.96-40.01-40.05v-120.1c0-8.847-7.161-16.02-16.01-16.02l-31.98 .0036c-7.299 0-13.2 4.992-15.12 11.68c-24.85-12.15-54.24-16.38-86.06-5.106c-38.75 13.73-68.12 48.91-73.72 89.64c-9.483 69.01 43.81 128 110.9 128c26.44 0 50.43-9.544 69.59-24.88c24 31.3 65.23 48.69 109.4 37.49C465.2 369.3 496 324.1 495.1 277.2V256.3C495.1 107.1 361.2-9.332 207.8 20.73zM239.1 304.3c-26.47 0-48-21.56-48-48.05s21.53-48.05 48-48.05s48 21.56 48 48.05S266.5 304.3 239.1 304.3z"/>
				</svg>
				<?php the_field('email_address','option'); ?>
			</a>

		<?php $content = ob_get_clean();
	    return $content;

	}

	add_shortcode('email', 'email');

	// Sitewide offers shortcode
	function sitewideoffers() {
		
		ob_start();

		if( have_rows('sitewideoffers' , 'option') ):
			echo '<ul class="sitewideoffers-icons">';
			while( have_rows('sitewideoffers' , 'option') ) : the_row();
				echo '<li>'; ?>
					
					<object data="<?php the_sub_field('icon'); ?>" type="image/svg+xml" ></object>
					<span><?php the_sub_field('label'); ?></span>
					
				<?php echo '</li>';
			endwhile;
			echo '</ul>';
		endif;

		$content = ob_get_clean();
	    return $content;

}
	

add_shortcode('sitewideoffers', 'sitewideoffers');

/* Check ACF END */ };	



