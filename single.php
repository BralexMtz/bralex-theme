<?php
// sirve para dar vista a las entradas o post, asi como los Custom Post Type
get_header(); ?>

<main class='container my-3'>
    <?php
      if(have_posts(  )){
        while(have_posts(  )){
          the_post(  );
        ?>  
          <h1 class="my-3"><?php the_title( ); ?></h1>
          <div class="row">
            <div class="col-5">
              <?php
              // para traer la imagen destacada con el tamaño deseado
              the_post_thumbnail( 'large' );
              ?>
            </div>
            <div class="col-7">
              <?php
                the_content();
              ?>
            
            </div>
          </div>
          <?php 
            get_template_part( "template-parts/post", "navigation" );
          ?>
        <?php
        }
      }
    ?>

</main>

<?php get_footer(); ?>