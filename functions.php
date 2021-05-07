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
    
    wp_enqueue_script('custom', get_template_directory_uri().'/assets/js/custom.js', '', '1.0', true);
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


// REGISTRO DE CUSTOM POST FIELDS
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_60935e34da9c9',
        'title' => 'Campos personalizados para plantilla institucional',
        'fields' => array(
            array(
                'key' => 'field_6095860026e39',
                'label' => 'Titulo',
                'name' => 'titulo',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_6095861326e3a',
                'label' => 'imagen',
                'name' => 'imagen',
                'type' => 'image',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'template-institucional.php',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    
    endif;