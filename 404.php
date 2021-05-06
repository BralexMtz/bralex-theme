<?php get_header() ?>

<main class='container h-75'>
    <div class="pagina404 my-5">
        <div class="row">
            <div class="col-6">
                <img src="<?php echo get_template_directory_uri().'/assets/img/astronauta.png'?>" class="w-75" alt="">
            </div>
            <div class="col-6">
                <h1>404 PÁGINA NO ENCOTRADA</h1>
                <br>
                <h2>Haga <a href="<?php echo home_url(); ?>" class="btn btn-success">click aquí</a>  para volver a la página principal</h2>    
            </div>
        </div>
        
    </div>
</main>

<?php get_footer() ?>