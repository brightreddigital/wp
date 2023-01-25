:root {

  --body-font: <?php the_typography_field( 'body_font', 'font_family', 'option' ) ?>;
  --body-weight: <?php the_typography_field( 'body_font', 'font_weight', 'option' ) ?>;
  --body-colour: <?php the_field( 'body_colour', 'option' ) ?>;

  --link-colour: rgba(<?php the_field( 'link_colour', 'option' ) ?>);
  --link-weight: <?php the_typography_field( 'link_weight', 'font_weight' ,'option' ) ?>;
  --link-hover-colour: <?php the_field( 'link_hover_colour', 'option' ) ?>;

  --h1-font: <?php the_typography_field( 'h1_font', 'font_family', 'option' ) ?>;
  --h1-weight: <?php the_typography_field( 'h1_font', 'font_weight', 'option' ) ?>;
  --h1-colour: <?php the_field( 'h1_colour', 'option' ) ?>;

  --h2-font: <?php the_typography_field( 'h2_font', 'font_family', 'option' ) ?>;
  --h2-weight: <?php the_typography_field( 'h2_font', 'font_weight', 'option' ) ?>;
  --h2-colour: <?php the_field( 'h2_colour', 'option' ) ?>;

  --h3-font: <?php the_typography_field( 'h3_font', 'font_family', 'option' ) ?>;
  --h3-weight: <?php the_typography_field( 'h3_font', 'font_weight', 'option' ) ?>;
  --h3-colour: <?php the_field( 'h3_colour', 'option' ) ?>;

  --h4-font: <?php the_typography_field( 'h4_font', 'font_family', 'option' ) ?>;
  --h4-weight: <?php the_typography_field( 'h4_font', 'font_weight', 'option' ) ?>;
  --h4-colour: <?php the_field( 'h4_colour', 'option' ) ?>;

  --h5-font: <?php the_typography_field( 'h5_font', 'font_family', 'option' ) ?>;
  --h5-weight: <?php the_typography_field( 'h5_font', 'font_weight', 'option' ) ?>;
  --h5-colour: <?php the_field( 'h5_colour', 'option' ) ?>;

  --h6-font: <?php the_typography_field( 'h6_font', 'font_family', 'option' ) ?>;
  --h6-weight: <?php the_typography_field( 'h6_font', 'font_weight', 'option' ) ?>;
  --h6-colour: <?php the_field( 'h6_colour', 'option' ) ?>;

  --primary-colour: <?php the_field( 'primary_colour', 'option' ) ?> ;
  --second-colour: <?php the_field( 'second_colour', 'option' ) ?> ;
  --third-colour: <?php the_field( 'third_colour', 'option' ) ?>;
  --dark-colour: <?php the_field( 'dark_colour', 'option' ) ?>;
  --light-colour: <?php the_field( 'light_colour', 'option' ) ?>;

}

<?php 

if ( is_plugin_active( 'elementor-pro/elementor-pro.php' ) ) {

  /* 
--------
Theme options 
--------
*/

if( function_exists('acf_add_options_page') ) {
    
  /* Add theme options pages */
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

  // add_action( 'wp_enqueue_scripts', 'brightred_scripts' );

  function dynamic_style() {
      if( get_field('sitetype', 'option') == 'eCommerce' ) {
        wp_enqueue_style( 'ecommerce', get_template_directory_uri() . '/inc/css/sitetype/ecommerce.css' );
    }
    if( get_field('sitetype', 'option') == 'Brochure' ) {
        wp_enqueue_style( 'ecommerce', get_template_directory_uri() . '/inc/css/sitetype/brochure.css' );
    }
  }
  add_action('wp_enqueue_scripts', 'dynamic_style', 99);
}
