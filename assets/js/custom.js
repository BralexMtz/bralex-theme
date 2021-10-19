(function($){
  $('#categorias-productos').change(function(){
    $.ajax({ 
      url: pg.ajaxurl,
      method:"POST",
      data:{
        "action":'pgFiltroProductos',
        "categoria": $(this).find(':selected').val()
      },
      beforeSend: function(){
        $('#resultado-productos').html("Cargando ...")
      },
      success: function(data){
        let html ='';
        data.forEach(item => {
          html += `<div class="col-4">
          <div class="card my-3 text-white bg-dark">
              ${item.imagen}
            <div class="card-body ">
              <h5 class="card-title">${item.titulo}</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <a href="${item.link}" class="btn btn-primary">ver más</a>
            </div>
          </div>
        </div>`})
        $('#resultado-productos').html(html);

      },
      error: function(error){
        console.log(error);
      }
    })

  })

  $(document).ready(function(){
    $.ajax({
      url: pg.apiurl+"novedades/3",
      method:"GET",
      beforeSend: function(){
        $('#resultado-novedades').html("Cargando ...")
      },
      success: function(data){
        let html ='';
        data.forEach(item => {
          html += `<div class="col-4">
          <div class="card my-3 text-white bg-dark">
              ${item.imagen}
            <div class="card-body ">
              <h5 class="card-title">${item.titulo}</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <a href="${item.link}" class="btn btn-primary">ver más</a>
            </div>
          </div>
        </div>`})
        $('#resultado-novedades').html(html);

      },
      error: function(error){
        console.log(error);
      }
    })

  })

})(jQuery);