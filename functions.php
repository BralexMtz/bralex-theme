<?php 

function init_template(){

    add_theme_support('post-thumbnails');
    add_theme_support( 'title-tag');
    register_nav_menus( array(
        'top_menu' => 'Menú Principal'
    ) ); //sirve para registrar una ubicación de menu

}
add_action('after_setup_theme','init_template');

// REGISTRO DE LOS ESTILOS Y SCRIPTS DE BOOSTRAP
function assets(){
    // register simplemente queda como dependencia guardada
    wp_register_style('bootstrap','https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', '', '4.4.1','all');
    wp_register_style('montserrat', 'https://fonts.googleapis.com/css?family=Montserrat&display=swap','','1.0', 'all');
    //enqueue ejecuta directamente los estilos 
                                // get stylesheet uri obtiene el style.css del tema
    wp_enqueue_style('estilos', get_stylesheet_uri(), array('bootstrap','montserrat'),'1.0', 'all');
    // register simplemente queda como dependencia guardada   
    wp_register_script('popper','https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js','','1.16.0', true);// is footer?=true
    wp_enqueue_script('boostraps', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery','popper'),'4.4.1', true);
    
    //registramos un script personalizado para el tema
    wp_enqueue_script('custom', get_template_directory_uri().'/assets/js/custom.js', '', '1.0', true);

    // nos permite agregar objetos con data a un determinado script. 
    // wp_add_inline_script() es otra opcion
    wp_localize_script( 'custom', 'pg', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'apiurl' => home_url( 'wp-json/pg/v1/' )
        ));

}

add_action('wp_enqueue_scripts','assets');

// REGISTRAR UN NUEVO WIDGET
function sidebar(){
    register_sidebar( // esta funcion nos sirve para registrar un widget que sera despues llamado en el frontend para mostrarlo
                      // con la funcion dynamic_sidebar, la cual necesita el id registrado
        array(
            'name' => 'Pie de página', // nombre de la zona de widgets a registrar
            'id' => 'footer', // id con el cual se mostrará
            'description' => 'Zona de Widgets para pie de página', // descripcion de la zona de widget
            'before_title' => '<p class="d-none">', // html antes del titulo de la zona del widget
            'after_tile' => '</p>',  // html de fin del titulo
            'before_widget' => '<div id="%1$s" class="%2$s">', // devuelve las clases y id pertinentes por si solo wordpress
            'after_widget' => '</div>'
        )
    );
}
    
add_action( 'widgets_init', 'sidebar');

// REGISTRO DE CUSTOM POST TYPE PRODUCTO
function add_product_type(){
    $labels= array(
        'name' => 'Productos',
        'singular_name' => 'Producto',
        'menu_name'     => 'Productos'
    );
    
    $args= array(
        'label' => 'Productos',
        'description' => 'Productos de platzi',
        'labels'  => $labels,
        'supports'  => array('title','editor','thumbnail','revisions'),
        'public'    => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-cart',
        'can_export'    => true,
        'publicly_queryable' => true,
        'rewrite'       => true,
        'show_in_rest'  => true

    );

    register_post_type( "producto", $args );
}


add_action( 'init', 'add_product_type' );


// REGISTRO DE NUEVAS TAXONOMIAS
function pgRegisterTax(){
    $args = array(
        'hierarchical' => true,
        'labels ' => array(
            'name' =>'Categorias de Productos',
            'singular_name' => 'Categoría de productos',
        ),
        'show_in_nav_menu' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug'=>'categoria-productos'),
    );
    register_taxonomy('categoria-productos',array('producto'),$args);
}

add_action( 'init', 'pgRegisterTax' );



// ajax function to respond
function pgFiltroProductos(){
    $args = array(
        'post_type'     => 'producto',
        'post_per_page' => -1, //para devolver todos los elementos
        'order'         =>'ASC',
        'orderby'       =>'title'
      );

    if($_POST['categoria']){ //si la categoria es recibida en la petición
        $args['tax_query'] = array( //Se crea una query para las taxonomias.
            array(
                'taxonomy' => 'categoria-productos', //nombre de la taxonomia
                'field' => 'slug', // la forma de filtrar
                'terms' => $_POST['categoria'] //filtramos por el slug de la categoria contenido en la taxonomia
            )
        );    
    } // sino se obtienen todos los productos sin filtrar la taxonomia

    $productos = new WP_Query($args);

    if($productos->have_posts( )){ 

        $return = array();

        while($productos->have_posts( )){

            $productos->the_post(); //recorre
            $return[] = array(
                'imagen' => get_the_post_thumbnail( get_the_id(), 'medium',array('class'=>'card-img-top') ),
                'link' => get_the_permalink(),
                'titulo' => get_the_title()
            );
        }

        wp_send_json( $return ); //devuelve el array en objeto json

    }

}

add_action( 'wp_ajax_nopriv_pgFiltroProductos', 'pgFiltroProductos'); //para usuarios sin registro
add_action( 'wp_ajax_pgFiltroProductos', 'pgFiltroProductos'); // para usuarios registrados

// funcion para registrar la ruta del api 
function novedadesAPI(){ //register route
    register_rest_route( 
        'pg/v1', 
        '/novedades/(?P<cantidad>\d+)', 
        array(
            'methods' => 'GET',
            'callback' => 'pedidoNovedades'
        )
    );
}

add_action( 'rest_api_init', 'novedadesAPI' );

// funcion para obtener las novedades 
function pedidoNovedades($data){
    $args = array(
        'post_type'     => 'post',
        'post_per_page' => $data['cantidad'], //para devolver la cantidad que se recibe como parametro
        'order'         =>'ASC',
        'orderby'       =>'title'
      );

    $novedades = new WP_Query($args);

    if($novedades->have_posts( )){ 

        $return = array();

        while($novedades->have_posts( )){

            $novedades->the_post(); //recorre
            $return[] = array(
                'imagen' => get_the_post_thumbnail( get_the_id(), 'medium',array('class'=>'card-img-top') ),
                'link' => get_the_permalink(),
                'titulo' => get_the_title()
            );
        }
    }

    // en este casi la api se encarga de convertirlo en json
    return $return ; 

}


function pgRegisterBlock(){
    // get configurations of new block
    $assets = include_once get_template_directory(  ).'/blocks/build/index.asset.php';

    //register script asociado al bloque nuevo
    wp_register_script( 
        'pg-block', 
        get_template_directory_uri().'/blocks/build/index.js', 
        $assets['dependencies'], 
        $assets['version'] 
    );

    // link the block with a script
    register_block_type(
        'pg/basic',
        array(
            'editor_script' => 'pg-block', // Handler del Script que registramos arriba
            'attributes'      => array( // Repetimos los atributos del bloque, pero cambiamos los objetos por arrays
                'content' => array(
                    'type'    => 'string',
                    'default' => 'Hello world'
                )
            ),
            'render_callback' => 'pgRenderDinamycBlock' // Función de callback para generar el SSR (Server Side Render)
        )
    );

}
add_action( 'init', 'pgRegisterBlock' );


// function para bloque dinamico
function pgRenderDinamycBlock($attributes,$content){
    return '<h2>'.$attributes['content'].'</h2>';
}