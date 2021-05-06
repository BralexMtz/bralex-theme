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
            
            <button class="btn btn-success">Comprar</button>
            </div>
          </div>
          
        <?php
        }
      }
    ?>
  <?php 
    $taxonomy = get_the_terms( get_the_ID(), 'categoria-productos' ); // obtiene un array con las taxonomias asignadas
  ?>
      <!-- Productos Relacionados -->
  <?php
    $ID_producto_actual = get_the_ID();
    $args = array(
      'post_type'       => 'producto',
      'posts_per_page'  => 6,
      'order'           => 'ASC',
      'orderby'         => 'title',
      'tax_query'       => array(
          array(
            'taxonomy'  => 'categoria-productos',
            'field'     => 'slug',
            'terms'     =>  $taxonomy[0]->slug
          )
      ),
      'post__not_in'    => array($ID_producto_actual)
    );
    $productos = new WP_Query($args);
  ?>
  <!-- Ejecutar el loop con el objeto $productos -->
  <?php if($productos->have_posts()) { ?>
    <div class="row justify-content-center productos-relacionados">
      <div class="col-12">
        <h3 class="my-3 text-center">Productos relacionados</h3>
      </div>
      <?php while($productos->have_posts()) { ?>
        <?php $productos->the_post(); ?>
        
        <?php //if(get_the_ID() != $ID_producto_actual) { ?>
          <div class="col-2 my-3 text-center text-light">
            <?php the_post_thumbnail('thumbnail'); ?>
            <h4>
              <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
              </a>
            </h4>
          </div>
        <?php //} ?>
      <?php } ?>
    </div>
  <?php } ?>

</main>
<?php get_footer(); ?>