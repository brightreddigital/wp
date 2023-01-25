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

};

<!-- Load styles based on theme options -->

<?php if( get_field('sitetype', 'option') == 'eCommerce' ) { ?> 
  @import 'inc/css/sitetype/ecommerce.css'; 
<?php } ?>




