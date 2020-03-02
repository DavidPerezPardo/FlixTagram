$(document).ready(function () {
  
  /**
   * 
   * PETICIONES AJAX.
   * 
   */


  /**
   * Para filtrar las busquedas por nick,email e id
   * y obtener los datos de la DB.
   * Realiza la peticion ajax al pulsar la tecla enter
   * sobre el input de filtrado.
   * 
   * Refresca el contenido de la página.
   */
  $("#search").keypress(function (e) {

    // tecla enter
    if (e.which == 13) {

      filtro = $('#filtro').val();
      busqueda = $("#search").val();
      console.log(e);


      $.ajax({

        type: "get",
        url: "index.php",
        data: { con: 'Administrador', ope: 'filtrar', filtro: filtro, search: busqueda },
        cache: false,
        success: function (response) {

          $("body").html(response);
          $("#search").focus();

        }// success

      });// ajax

    }//if

  });


});