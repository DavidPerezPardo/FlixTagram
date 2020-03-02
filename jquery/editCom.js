/**
 * Para incluir datos en el formulario de editar comentario.
 */
$(document).ready(function(){

  // icono de editar comentario.
  $("button[name=modalCom]").click(function(e){

    var comentario = $(this).data('text');
    var idCom      = $(this).data('idcom');

    // incluimos datos en los inputs del formulario.
    $("#modalComEdit input[name=idCom]").val(idCom);
    // mostramos comentario a editar en el textarea.
    $("#comentEdit").val(comentario);
    $("#modalComEdit").modal('show');

  });


});