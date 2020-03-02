$(document).ready(function () {

  //Abrir modal para editar perfil.
  $("#btnEdit").click(function () {

    $("#modalEdit").modal('show');

  });

  //Abrir modal para editar perfil.
  $("#btnPass").click(function () {

    $("#modalPass").modal('show');

  });



  /**
   * Jquery validator para la validación
   * del formulario de editar perfil de usuario.
   */
  $("#edit").validate({

    rules: {

      name: {
        required: true
      },

      nick: {
        required: true,
        minlength: 3
      },

      email: {
        required: true
      },

      pass: {
        required: true,
        minlength: 6
      },

      confirmPass: {
        required: true,
        equalTo: "#pass"
      }

    },//rules

    //mensajes
    messages: {

      name: "<div class='alert alert-danger' role='alert'>Por favor, ingrese su nombre</div>",

      nick: {
        required: "<div class='alert alert-danger' role='alert'>Por favor, ingrese un nick de usuario</div>",
        minlength: "<div class='alert alert-danger' role='alert'>Su nick debe contener al menos 3 carácteres</div>"
      },

      email: {
        required: "<div class='alert alert-danger' role='alert'>Debe ingresar su email</div>",
        email: "<div class='alert alert-danger' role='alert'>Debe introducir un email válido</div>"

      },

      pass: {
        required: "<div class='alert alert-danger' role='alert'>Por favor, ingrese una contraseña</div>",
        minlength: "<div class='alert alert-danger' role='alert'>Su contraseña debe contener al menos 6 carácteres</div>"
      },

      confirmPass: {
        required: "<div class='alert alert-danger' role='alert'>Por favor, repita la contraseña</div>",
        minlength: "<div class='alert alert-danger' role='alert'>Su contraseña debe contener al menos 6 carácteres</div>",
        equalTo: "<div class='alert alert-danger' role='alert'>Las contraseñas deben coincidir</div>"
      }
    }

  });//validator


    /**
   * Jquery validator para la validación
   * del formulario de cambiar contraseña.
   */
  $("#changePass").validate({

    rules: {

      passOld: {
        required: true,
        minlength: 6
      },

      passNew: {
        required: true,
        minlength: 6
      },

      confirmPass: {
        required: true,
        equalTo: "#passNew"
      }

    },//rules

    //mensajes
    messages: {

      passOld: {
        required: "<div class='alert alert-danger' role='alert'>Por favor, ingrese una contraseña</div>",
        minlength: "<div class='alert alert-danger' role='alert'>Su contraseña debe contener al menos 6 carácteres</div>"
      },

      passNew: {
        required: "<div class='alert alert-danger' role='alert'>Por favor, ingrese una contraseña</div>",
        minlength: "<div class='alert alert-danger' role='alert'>Su contraseña debe contener al menos 6 carácteres</div>"
      },

      confirmPass: {
        required: "<div class='alert alert-danger' role='alert'>Por favor, repita la contraseña</div>",
        minlength: "<div class='alert alert-danger' role='alert'>Su contraseña debe contener al menos 6 carácteres</div>",
        equalTo: "<div class='alert alert-danger' role='alert'>Las contraseñas deben coincidir</div>"
      }
    }

  });//validator




/**
 * PARA COMPROBACIONES AJAX 
 */

  // mensaje nick registrado
  var existeNick = "<div id='msgNick'class='alert alert-danger'role='alert'>Éste nick ya se encuentra registrado</div>";
  // mensaje email registrado
  var existeEmail = "<div id='msgEmail'class='alert alert-danger'role='alert'>Éste email ya se encuentra registrado</div>";
  // 
  var emailOk = true;
  var nickOk  = true;
  // id usuario.
  var id = $("#edit #id").val();

  // añadimos y ocultamos la primera vez los mensajes.
  $("#nick").parent().append(existeNick);
  $("#msgNick").hide();
  $("#email").parent().append(existeEmail);
  $("#msgEmail").hide();



/**
 * 
 * PETICIONES AJAX.
 * 
 */


  /**
   * Comprueba si existe el nick introducido, en la base de datos.
   * 
   * -sin tener en cuenta el usuario que realiza dicha petición.
   * -Al editar perfil de usuario, se comprueba el nick con el resto
   *  de los usuarios registrados.
   * -Se envía el id del usuario que lo realiza.
   */
  $("#nick").keyup(function (e) {

    nick = $(e.target).val();

    $.ajax({

      type: "post",
      url: "index.php",
      data: { con: 'Registro', ope: 'existeNick', nick: nick, id: id },
      success: function (response) {
        //mensajes
        if (response > 0) {

          $("#msgNick").show();
          nickOk = false;
        } else {

          $("#msgNick").hide();
          nickOk = true;
        }

      }// success

    });// ajax

  });


  /**
   * Comprueba si existe el email en la base de datos.
   * 
   * -sin tener en cuenta el usuario que realiza dicha petición.
   * -Al editar perfil de usuario, se comprueba el email con el resto
   *  de los usuarios registrados.
   * -Se envía el id del usuario que lo
   */
  $("#email").keyup(function (e) {

    email = $(e.target).val();
    $.ajax({

      type: "post",
      url: "index.php",
      data: { con: 'Registro', ope: 'existeEmail', email: email, id: id },
      success: function (response) {
        //mensajes
        console.log(response);
        if (response > 0) {

          $("#msgEmail").show();
          emailOk = false;
        } else {

          $("#msgEmail").hide();
          emailOk = true;
        }
      }
    });

  });


  // si existe email o nick, desactivamos submit.
  $("#edit").submit(function (e) {

    if (!(emailOk && nickOk)) {
      e.preventDefault();
    }

  });




});// ready document


