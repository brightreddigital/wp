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

// function my_acf_save_post($post_id) {

function create_posttype() {

if( have_rows('post_type', 'option') ):

	while( have_rows('post_type','option') ) : the_row();
  
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => __( get_sub_field('pt_name','options') ),
        'singular_name'       => __( get_sub_field('pt_singular','options') ),
        'menu_name'           => __( get_sub_field('pt_name','options') ),
        'parent_item_colon'   => __( 'Parent ' . get_sub_field('pt_singular','options') ),
        'all_items'           => __( 'All ' . get_sub_field('pt_name','options') ),
        'view_item'           => __( 'View ' . get_sub_field('pt_singular','options') ),
        'add_new_item'        => __( 'Add New ' . get_sub_field('pt_singular','options') ),
        'add_new'             => __( 'Add New ' . get_sub_field('pt_singular','options') ),
        'edit_item'           => __( 'Edit ' . get_sub_field('pt_singular','options') ),
        'update_item'         => __( 'Update ' . get_sub_field('pt_singular','options') ),
        'search_items'        => __( 'Search ' . get_sub_field('pt_singular','options') ),
        'not_found'           => __( 'Not Found' ),
        'not_found_in_trash'  => __( 'Not found in Trash' ),
    );
      
    $args = array(
        'label'               => __( get_sub_field('pt_slug','options') ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'excerpt', 'author', 'editor', 'comments', 'thumbnail', 'revisions', ),
        'taxonomies'          => array( 'category', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => ( get_sub_field('pt_archive','options') ),
        'exclude_from_search' => ( get_sub_field('pt_search','options') ),
        'publicly_queryable'  => ( get_sub_field('pt_public','options') ),
        'capability_type'     => 'post',
        'show_in_rest' => true,
        'menu_icon' => ( get_sub_field('pt_icon','options') ),
  
    );
      
    // Registering your Custom Post Type
    register_post_type( get_sub_field('pt_slug','options'), $args );

	endwhile;

endif;


}
				// Hooking up our function to theme setup
				add_action( 'init', 'create_posttype' );


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