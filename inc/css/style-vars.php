:root {

  --body-font: '<?php the_field( 'body_font', 'option' ) ?>;', sans-serif;
  --body-weight: <?php the_field( 'body_weight', 'option' ) ?>;
  --body-colour: <?php the_field( 'body_colour', 'option' ) ?>;
  --body-size: <?php the_field( 'body_size', 'option' ) ?>;

  --link-colour: rgba(<?php the_field( 'link_colour', 'option' ) ?>);
  --link-weight: <?php the_field( 'link_font_weight' ,'option' ) ?>;
  --link-hover-colour: <?php the_field( 'link_hover_colour', 'option' ) ?>;
  --link-style: <?php the_field( 'link_style', 'option' ) ?>;

  --h1-font: <?php the_field( 'h1_font', 'option' ) ?>;
  --h1-weight: <?php the_field('h1_font_weight', 'option' ) ?>;
  --h1-colour: <?php the_field( 'h1_colour', 'option' ) ?>;
  --h1-style: <?php the_field( 'h1_style', 'option' ) ?>;
  --h1-size-d: <?php the_field( 'h1_font_size_desktop', 'option' ) ?>;
  --h1-size-m: <?php the_field( 'h1_font_size_mobile', 'option' ) ?>;

  --h2-font: <?php the_field( 'h2_font', 'option' ) ?>;
  --h2-weight: <?php the_field('h2_font_weight', 'option' ) ?>;
  --h2-colour: <?php the_field( 'h2_colour', 'option' ) ?>;
  --h2-style: <?php the_field( 'h2_style', 'option' ) ?>;
  --h2-size-d: <?php the_field( 'h2_font_size_desktop', 'option' ) ?>;
  --h2-size-m: <?php the_field( 'h2_font_size_mobile', 'option' ) ?>;

  --h3-font: <?php the_field( 'h3_font', 'option' ) ?>;
  --h3-weight: <?php the_field('h3_font_weight', 'option' ) ?>;
  --h3-colour: <?php the_field( 'h3_colour', 'option' ) ?>;
  --h3-style: <?php the_field( 'h3_style', 'option' ) ?>;
  --h3-size-d: <?php the_field( 'h3_font_size_desktop', 'option' ) ?>;
  --h3-size-m: <?php the_field( 'h3_font_size_mobile', 'option' ) ?>;

  --h4-font: <?php the_field( 'h4_font', 'option' ) ?>;
  --h4-weight: <?php the_field('h4_font_weight', 'option' ) ?>;
  --h4-colour: <?php the_field( 'h4_colour', 'option' ) ?>;
  --h4-style: <?php the_field( 'h4', 'option' ) ?>;
  --h4-size-d: <?php the_field( 'h4_font_size_desktop', 'option' ) ?>;
  --h4-size-m: <?php the_field( 'h4_font_size_mobile', 'option' ) ?>;

  --h5-font: <?php the_field( 'h5_font', 'option' ) ?>;
  --h5-weight: <?php the_field('h5_font_weight', 'option' ) ?>;
  --h5-colour: <?php the_field( 'h5_colour', 'option' ) ?>;
  --h5-style: <?php the_field( 'h5_style', 'option' ) ?>;
  --h5-size-d: <?php the_field( 'h5_font_size_desktop', 'option' ) ?>;
  --h5-size-m: <?php the_field( 'h5_font_size_mobile', 'option' ) ?>;

  --h6-font: <?php the_field( 'h6_font', 'option' ) ?>;
  --h6-weight: <?php the_field('h6_font_weight', 'option' ) ?>;
  --h6-colour: <?php the_field( 'h6_colour', 'option' ) ?>;
  --h6-style: <?php the_field( 'h6_style', 'option' ) ?>;
  --h6-size-d: <?php the_field( 'h6_font_size_desktop', 'option' ) ?>;
  --h6-size-m: <?php the_field( 'h6_font_size_mobile', 'option' ) ?>;

  --primary-colour: <?php the_field( 'primary_colour', 'option' ) ?> ;
  --second-colour: <?php the_field( 'second_colour', 'option' ) ?> ;
  --third-colour: <?php the_field( 'third_colour', 'option' ) ?>;
  --dark-colour: <?php the_field( 'dark_colour', 'option' ) ?>;
  --light-colour: <?php the_field( 'light_colour', 'option' ) ?>;

}

<!-- Load styles based on theme options -->

<?php if( get_field('sitetype', 'option') == 'eCommerce' ) { ?> 
  @import 'inc/css/sitetype/ecommerce.css'; 
<?php } ?>




