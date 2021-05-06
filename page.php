<?php 
/**
 * Este archivo sirve para crear la vista de las páginas creadas con gutenberg de wordpress
 */
get_header(); ?>

<main class='container text-light'>
    <?php 
    if(have_posts()){
      while(have_posts( )){
        the_post( ); // simplemente sirve para iterar el indice de los posts
    ?>
      <h1 class="my-3"><?php the_title( );?></h1>
      <?php
        the_content( );
      ?>
    <?php  
      }
    }else{
      echo "esta página no tiene contenido";
    }
    
    ?>

</main>

<?php get_footer(); ?>