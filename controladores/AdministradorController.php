<?php
/**
 * @Author: David Pérez Pardo
 * Curso: 2019-2020 | 2º DAW - DWES
 * 
 * Controlador Administrador.
 * 
 */
require_once "BaseController.php";
require_once "modelos/Usuario.php";
require_once "modelos/Publicacion.php";
require_once "modelos/Foto.php";
require_once "modelos/Comentario.php";
require_once "libs/Sesion.php";
require_once "libs/Routing.php";


class AdministradorController extends BaseController{

  // para comprobar la sesión.
  private $ses;


  public function __construct(){

    //Constructor BaseController - twig
    parent::__construct();


    // Comprobamos si la sesion está activa.
    $this->ses = Sesion::checkSesion();
    // si inactiva y primera vez que se accede.
    if(!$this->ses):

      echo $this->twig->render("inicio.php.twig");    
      die;
    
    endif;

  }


  /**
   * Panel de administración.
   * Muestra en una tabla a todos los usuarios registrados
   * y nos permite acceder a sus publicaciones.
   */
  public function showAll(){

    $rol = Sesion::getRol();

    if($rol == 1):

      $modo = $_GET['modo'];
      switch ($modo):

        case 'usuarios':

          $usuarios = Usuario::findAll();
          echo $this->twig->render("admin/panelAdmin.php.twig" , ['usuarios' => $usuarios]);
          die;

        break;

        case 'publicaciones':
        
          $id   = $_GET['id']; // id usuario.
          $pubs = Publicacion::findAllUser($id);
          echo $this->twig->render("admin/adminPubli.php.twig" , ['pubs' => $pubs]);

        break;

        case 'comentarios':

          $idPub = $_GET['idPub'];  // id de la publicación
          $fotos = Foto::findAll($idPub);
          $comentarios = Comentario::findAll($idPub);

          
          echo $this->twig->render("admin/adminPhoto.php.twig" , ['fotos'       => $fotos ,
                                                                  'comentarios' => $comentarios]);

        break;

          default:
          echo "Debe elegir un modo de administración";
          die;

        break;

      endswitch;

    else:
      route("index.php" , "Usuario" , "existeUser");
      die;
    endif;
 

  }


  /**
   * Elimina un usuario de la DB.
   */
  public function eliminar(){

    if( isset($_GET['idUsu'])):

      Usuario::delete($_GET['idUsu']);
      route("index.php" , "Usuario" , "existeUser");

    endif;

    return;

  }


  /**
   * Filtra la búsqueda de usuarios para 
   * el panel de control.
   */
  public function filtrar(){

    if(isset($_GET['search'])):

      $filtro = $_GET['filtro'];
      $search = $_GET['search'];
      $usuarios = Usuario::search($filtro , $search);

      echo $this->twig->render("admin/panelAdmin.php.twig" , ['usuarios' => $usuarios]);


    endif;
  }


}