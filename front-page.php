<?php
/** Este archivo hace una personalización de la página principal desde el backend. 
 *  Por lo tanto si definimos una pagina estatica de inicio, se mostrara el contenido y bloques
 *  de la misma, pero además el código que pudiesemos poner aqui.
 */

 get_header(); ?>

<main class='container '>
    <?php
      if(have_posts(  )){
        while(have_posts(  )){
          the_post(  );
          ?>
          <!-- <h2 class="my-3"><?php #the_title( );?></h2> -->
          <br>
          <?php the_content( ); ?>
          <?php
        }

      }
    ?>
    <div class="lista-productos my-5">
      <h2 class="text-center text-light">PRODUCTOS</h2>
      <div class="row">
      <?php
        $args = array(
          'post_type'     => 'producto',
          'post_per_page' => -1,
          'order'         =>'ASC',
          'orderby'       =>'title'
        );
        $productos= new WP_Query($args); // el WPQuery puede llevar muchisimos más argumentos para traer diferentes posts.
        if($productos->have_posts()){
          while($productos->have_posts(  )){
            $productos->the_post(  );
            ?>
            <div class="col-4">
              <div class="card my-3 text-white bg-dark">
                  <?php
                  the_post_thumbnail('medium',array('class'=>'card-img-top'));
                  ?>
                <div class="card-body ">
                  <h5 class="card-title"><?php the_title( ) ?></h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="<?php the_permalink() ?>" class="btn btn-primary">ver más</a>
                </div>
              </div>
            </div>
            
            <?php
          }

        }
      
      ?>
      </div>
    </div>

</main>

<?php get_footer(); ?>