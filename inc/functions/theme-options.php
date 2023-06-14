<?php 

/* ------- Check ACF -------- */ 
add_action( 'acf/init', 'checkACFtheme' );

function checkACFtheme() {

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

	// Add fields to theme options
	add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key' => 'group_62e7b2a64acc9',
		'title' => 'Brand Colours',
		'fields' => array(
			array(
				'key' => 'field_62e7b2b662265',
				'label' => 'Primary Colour',
				'name' => 'primary_colour',
				'aria-label' => '',
				'type' => 'color_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '#000000',
				'enable_opacity' => 0,
				'return_format' => 'string',
			),
			array(
				'key' => 'field_62e7b2fb62266',
				'label' => 'Second Colour',
				'name' => 'second_colour',
				'aria-label' => '',
				'type' => 'color_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '#000000',
				'enable_opacity' => 0,
				'return_format' => 'string',
			),
			array(
				'key' => 'field_62e7b31462267',
				'label' => 'Third Colour',
				'name' => 'third_colour',
				'aria-label' => '',
				'type' => 'color_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '#000000',
				'enable_opacity' => 0,
				'return_format' => 'string',
			),
			array(
				'key' => 'field_62e7b33b62268',
				'label' => 'Dark Colour',
				'name' => 'dark_colour',
				'aria-label' => '',
				'type' => 'color_picker',
				'instructions' => 'Should be same as primary brand colour if legible. Needs to work with white text overlaid.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '#000000',
				'enable_opacity' => 0,
				'return_format' => 'string',
			),
			array(
				'key' => 'field_62ea3e6c4db39',
				'label' => 'Light Colour',
				'name' => 'light_colour',
				'aria-label' => '',
				'type' => 'color_picker',
				'instructions' => 'Used for tinted backgrounds. Should be approx 0.1 (10%) to 0.15 (15%) of brand colour.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'enable_opacity' => 1,
				'return_format' => 'string',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'theme-general-settings',
				),
			),
		),
		'menu_order' => 2,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	) );
} );


	// Change Site Title, Descriptions and Email 

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

	// Custom post types 

	function create_posttype() {

		if( have_rows('post_type', 'option') ):

			while( have_rows('post_type','option') ) : the_row();

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

				register_post_type( get_sub_field('pt_slug','options'), $args );

			endwhile;

		endif;

	}
	
	add_action( 'init', 'create_posttype' );

	// Add favicion link to <head>

	function add_favicon(){ ?>

		<link rel="icon" type="image/png" href="<?php echo the_field('favicon', 'option'); ?>">
		<link rel="shortcut icon" type="image/png" href="<?php echo the_field('favicon', 'option'); ?>">
		<link rel="apple-touch-icon" type="image/png" href="<?php echo the_field('favicon', 'option'); ?>">
		<link rel="apple-touch-icon-precomposed" type="image/png" href="<?php echo the_field('favicon', 'option'); ?>">

	<?php }

	add_action('wp_head','add_favicon');

// Check ACF END
};