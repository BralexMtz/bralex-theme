<?php 
// Template Name: Página institucional
/**
 * Este archivo sirve para hacer una plantilla o template
 */
get_header(); ?>

<?php
// obtener los campos personalizados del template
$my_title = get_post_meta( get_the_ID(), 'titulo', true);
$my_image = get_post_meta( get_the_ID(), 'imagen', true);
?>
<main class='container text-light'>
    <?php 
    if(have_posts()){
      while(have_posts( )){
        the_post( ); // simplemente sirve para iterar el indice de los posts
    ?>
      <h1 class="my-3"><?php echo $my_title;?></h1>
      <img src="<?php echo $my_image; ?>" />
      <hr>
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