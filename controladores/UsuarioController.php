<?php
/**
 * @Author: David Pérez Pardo
 * Curso: 2019-2020 | 2º DAW - DWES
 * 
 * Controlador Usuario.
 * 
 */
require_once "BaseController.php" ;
require_once "modelos/Usuario.php" ;
require_once "modelos/Publicacion.php" ;
require_once "libs/Sesion.php" ;
require_once "libs/procesaImagen.php";
require_once "libs/Routing.php";


class UsuarioController extends BaseController{

  // para comprobar la sesión.
  private $ses;


  public function __construct(){

    //Constructor BaseController - twig
    parent::__construct();


    // Comprobamos si la sesion está activa.
    $this->ses = Sesion::checkSesion();
    // si es inactiva y primera vez que se accede.
    if(!$this->ses && !isset($_POST['user'])):

      echo $this->twig->render("inicio.php.twig");    
      die;
    
    endif;

  }




  /**
   * 
   * Comprueba si existe el usuario que intenta
   * acceder consultando el nick,email y contraseña
   * con la BD.
   * Si no existe,vuelve a la vista de login mostrando error.
   * 
   * Crea la sesión de usuario,si los datos de accesos son correctos.
   * 
   * Redirige a la vista correspendiente según rol de usuario.
   * 
   * Si el usuario ya se encuentra con la sesion iniciada,
   * se le redirige a su vista correspondiente.
   * 
   */
  public function existeUser(){

    // si sesión ya iniciada.
    if($this->ses):

      // Id del usuario conectado-sesion.
      $id = Sesion::getId();

    endif; 

    // Nuevo inicio de sesión.
    if(isset($_POST['user'])):

      $user = $_POST['user'];
      $pass = $_POST['pass'];
      //Se comprueba si existe y coincide password.
      $id = Usuario::checkUser($user , $pass);

    endif;


    if($id):

      // Obtenemos usuario de la DB.
      $usuario = Usuario::find($id);
      $idUsu  = $usuario->getIdUsu();
      $nick   = $usuario->getNick();
      $email  = $usuario->getEmail();
      $nombre = $usuario->getNameUsu();
      $rol    = $usuario->getRol();
      $img    = $usuario->getImgUser();
      $bio    = $usuario->getBioUser();

      // Si no existe la sesión, la Creamos.
      if(!$this->ses):
        Sesion::sesion($id , $nick , $email , $rol , $nombre);
      endif;

      // ROLES
      if($rol == 0 ):
      
        // mensaje si hay error al subir img.
        $errorImg  = $_GET['error'] ?? null;
        
        // mensaje cambio password.
        $errorPass = $_GET['changePass'] ?? 'nan';

        // api key ?
        $apiKey = Usuario::getApi($idUsu);

        // Obtenemos Publicaciones del usuario.
        $pubs = Publicacion::findAllUser($idUsu);
        echo $this->twig->render("user/showPubli.php.twig" , ['nick'      => $nick,
                                                              'nombre'    => $nombre,
                                                              'email'     => $email,
                                                              'bio'       => $bio,
                                                              'img'       => $img,
                                                              'pubs'      => $pubs,
                                                              'apiKey'    => $apiKey,
                                                              'errorImg'  => $errorImg,
                                                              'changePass'=> $errorPass
                                                              ]);
        die;

      // Panel admin
      else:  

        route("index.php" , "Administrador" , "showAll" , ['modo'  => 'usuarios']);
        //echo $this->twig->render("admin/panelAdmin.php.twig");
        return;  
        die;
        
      endif;   
    // No existe usuario.
    else:

      $error = "El usuario introducido no existe o la contraseña es incorrecta!";
      echo $this->twig->render("inicio.php.twig" , ['errorLog' => $error ] );
      return; 

    endif;

  }


  /**
   * Actualiza los datos del usuario en la DB.
   * Datos obtenidos del formulario de editar perfil.
   * 
   * -Usa librería procesaImagen en caso de cambiar la 
   *  imágen de perfil.
   */
  public function editar(){

    if(isset($_POST['nick']) && isset($_POST['email'])):

      $usuario = new Usuario();
      $id = Sesion::getId();

      // Si se sube una imágen nueva.(siempre contiene código de error)
      // se comprueba con el error, 0 = todo ok
      if(($_FILES['newImg']['error'] == 0)):

        // subimos y procesamos imágen.
        $img = subeImg($id , 'perfil' , $_FILES['newImg'] );

      endif;

      $usuario->setIdUsu($id);
      $usuario->setNameUsu($_POST['name']);
      $usuario->setNick($_POST['nick']);
      $usuario->setEmail($_POST['email']);
      $usuario->setBioUser($_POST['bio']);
      $usuario->setImgUser($img['name'] ?? $_POST['img']);
      
      $update = $usuario->update();
      route("index.php" , "Usuario" , "existeUser" , ['error' => $img['error'] ?? 'nan' ]);

      return;

    endif;
  }


  /**
   * Cierra la sesión.
   * 
   * -Librería Sesion.
   */
  public function cierraSesion(){

    Sesion::close();
    route("index.php" , "Usuario" , "existeUser");
    return;

  }


  /**
   * Genera una API Key al usuario.
   */
  public static function generaKey(){

    if(Sesion::checkSesion()):

      $email = Sesion::getEmail();
      $id    = Sesion::getId();
      $cadena = $email . '$$$' . time();
      $key = md5($cadena);
      Usuario::saveKey($id , $key);
      route("index.php" , "Usuario" , "existeUser");
      
    endif;
  }
  

}