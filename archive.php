<?php //para las categorias y taxonomias
get_header( ); ?>
<div class="container">
  <div class="row">
    <div class="col-12 text-center">
      <h1><?php the_archive_title(  ); ?></h1>
    </div>
  </div>
  <div class="row my-4">

  <?php 
    if(have_posts(  )){
      while(have_posts(  )){
        the_post(  );
  ?>
    <div class="card mb-3 bg-dark">
      <div class="row no-gutters">
        <div class="col-4 ">
          <?php
            the_post_thumbnail('medium',array('class'=>'card-img '));
          ?>
        </div>
        <div class="col-8 ">
          <div class="card-body">
            <a href="<?php the_permalink();?>">
              <h3 class="card-title text-uppercase text-success">
                <?php the_title(); ?>
              </h3>
            </a>
            <p class="card-text .text-truncate ">
              <?php
                the_excerpt();
              ?>
            </p>
          </div>
        </div>
      </div>
    </div>

  <?php

      }// ENDWHILE  
    } // ENDIF
  ?>
  </div>
</div>



<?php get_footer( );?>