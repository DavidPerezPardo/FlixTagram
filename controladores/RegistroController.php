<?php
/**
 * @Author: David Pérez Pardo
 * Curso: 2019-2020 | 2º DAW - DWES
 * 
 * Controlador para registrar nuevo usuario
 * y hacer comprobaciones en formularios.
 * 
 * PETICIONES AJAX.
 *  
 * -Comprueba si existen el nick y el email
 *  introducidos tanto en el formulario de registro
 *  como el de editar perfil.
 * 
 */
require_once "BaseController.php" ;
require_once "modelos/Usuario.php" ;
require_once "libs/Sesion.php";
require_once "libs/Routing.php";

class RegistroController extends BaseController{

  public function __construct(){

    //Constructor BaseController - twig
    parent::__construct();

  }




  /**
   * Registro de nuevo usuario en la DB.
   * Se realiza previamente una comprobación
   * de nick y email para saber si ya existen en 
   * la DB.
   * 
   */
  public function registro(){

    $usuario = new Usuario();

    if(isset($_POST['nick']) && isset($_POST['email'])):

      // Se comprueba si existen nick y email en la DB.
      $rows = $usuario->checkExist($_POST['nick'] , $_POST['email']);

      if($rows):

        $error = "El nick o email introducido ya existe, pruebe con otro!";
        echo $this->twig->render("registro.php.twig" , ['errorNick' => $error]);
        return;

      else:

        $usuario->setNameUsu($_POST['name']);
        $usuario->setNick($_POST['nick']);
        $usuario->setEmail($_POST['email']);
        $usuario->setPassUsu($_POST['pass']);

        // Registra un nuevo usuario en la DB.
        $regOk = $usuario->save();

        // Mensajes de registro.
        ($regOk) ? $message = "Enhorabuena, se ha registrado con éxito!"
         : $message ="Se produjo un error al realizar el registro, inténtelo de nuevo o más tarde!";

        echo $this->twig->render("inicio.php.twig" , ['msnReg' => $message]);

      endif;

    else:
      echo $this->twig->render("registro.php.twig");
      return;
    endif;

  }


  /**
   * Comprueba si existe el nick en la db.
   * @return int 1 si existe.
   */
  public function existeNick(){

    if(isset($_POST['nick'])):

      $id = $_POST['id'] ?? 0;
      $nick = Usuario::checkNick($_POST['nick'] , $id);
      echo $nick;
      return;
      
    endif;

  }


  /**
   * Comprueba si existe el email en la db.
   * @return int 1 si existe.
   */
  public function existeEmail(){

    if(isset($_POST['email'])):

      $id = $_POST['id'] ?? 0;
      $email = Usuario::checkEmail($_POST['email'] , $id);
      echo $email;
      return;
      
    endif;

  }


  /**
   * Para cambiar la contraseña del usuario
   */
  public function cambioPass(){

    if(isset($_POST['passOld'])):

      $passOld = $_POST['passOld'];
      $passNew = $_POST['passNew'];
      $id = Sesion::getId();

      $ok = Usuario::changePass($id , $passOld , $passNew);
      route("index.php" , "Usuario" , "existeUser" , ['changePass' => $ok ]);

    endif;

    return;
  }


}
