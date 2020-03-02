$(document).ready(function(){

  /**
   * Jquery validator para la validación
   * del formulario de editar perfil de usuario.
   */
  $("#registro").validate({

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




  // mensaje nick registrado
  var existeNick  = "<div id='msgNick'class='alert alert-danger'role='alert'>Éste nick ya se encuentra registrado</div>";
  // mensaje email registrado
  var existeEmail = "<div id='msgEmail'class='alert alert-danger'role='alert'>Éste email ya se encuentra registrado</div>";
  // 
  var nickOk  = true;
  var emailOk = true;


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
   * Comprueba si existe el email introducido, en la base de datos,
   * realizará la comprobación para el formulario de registro.
   */
  $("#nick").keyup(function (e) {

    nick = $(e.target).val();

    $.ajax({

      type: "post",
      url: "index.php",
      data: { con: 'Registro', ope: 'existeNick', nick: nick},
      success: function (response) {
        //mensajes
        if (response > 0) {

          $("#msgNick").show();
          nickOk = false;
        } else {

          $("#msgNick").hide();
          nickOk = true;
        }
        console.log("nick " + nickOk);

      }// success
      
    });// ajax

  });


  /**
   * Comprueba si existe el email introducido, en la base de datos,
   * realizará la comprobación para el formulario de registro.
   */
  $("#email").keyup(function (e) {

    email = $(e.target).val();

    $.ajax({

      type: "post",
      url: "index.php",
      data: { con: 'Registro', ope: 'existeEmail', email: email},
      success: function (response) {
        //mensajes
        if (response > 0) {
          
          $("#msgEmail").show();
          emailOk = false;
        } else {

          $("#msgEmail").hide();
          emailOk = true;
        }
        console.log("email " + emailOk);

      }     
    });
    
  });

  // si existe email o nick, desactivamos submit.
  $("#registro").submit(function (e) {

    if ( (!emailOk || !nickOk)) {
      e.preventDefault();
    }

  });



});