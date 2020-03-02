<?php
/**
 * @Author: David Pérez Pardo
 * Curso: 2019-2020 | 2º DAW - DWES
 * 
 * Controlador Publicación.
 * 
 */
require_once "BaseController.php";
require_once "modelos/Publicacion.php";
require_once "modelos/Foto.php";
require_once "modelos/Comentario.php";
require_once "libs/Sesion.php";
require_once "libs/procesaImagen.php";
require_once "libs/Routing.php" ;


class PublicacionController extends BaseController{

  private $ses;

  public function __construct(){

    parent::__construct();

    // Comprobamos si la sesion está activa.
    $this->ses = Sesion::checkSesion();
    // si no hay sesión iniciada, mostramos página de inicio.
    if(!$this->ses):

      echo $this->twig->render("inicio.php.twig");    
      die;
    
    endif; 

  }


  /**
   * Muestra la publicación
   * con su foto y sus comentarios.
   */
  public function showPubli(){

    if(isset($_GET['id'])): // id publicación

      $idUsu = Sesion::getId(); // id del usuario
      $id = $_GET['id'];
      $fotos = Foto::findAll($id);

      // Para insertar un 'show',si el usuario
      // que ve la publicación no es su dueño.
      if($fotos[0]->getIdUsu() != $idUsu):

        Foto::addShow($id);

      endif;

      $comentarios = Comentario::findAll($id);

      echo $this->twig->render("user/showPhoto.php.twig" , ['fotos'       => $fotos ,
                                                            'comentarios' => $comentarios,
                                                            'id'          => $idUsu]);

    endif;

    return;
  }


  /**
   * Muestra todas las publicaciones de todos
   * los usuarios registrados, menos la del
   * propio usuario.
   * 
   */
  public function explorar(){

    if(isset($_GET['id'])):

      $pubs = Publicacion::findAllOthers($_GET['id']);

      echo $this->twig->render("user/showExplorer.php.twig", ['pubs' => $pubs]);
      return;

    endif;
    return;
  }


  /**
   * Añade una publicación en la DB.
   * Almacena el nombre y ruta de la imágen en la DB.
   * Procesa y sube la imágen al servidor.
   * 
   */
  public function publicar(){

    if(isset($_FILES['img'])):
   
      // Obtengo id del usuario desde la sesión.
      $idUsu = Sesion::getId();
      // procesamos img, obtenemos nombre y la subimos al servidor.
      $img = subeImg($idUsu , 'publicacion' , $_FILES['img']);

      // Si hay algún error al procesar img, no se publica y mostramos mensaje.
      if($img['error'] != 0):

        // volvemos con el mensaje de error.
        route("index.php" , "Usuario" , "existeUser" , ['error' => $img['error'] ]);
        return;

      endif;

      // Inserto publicación y obtengo id insertado.
      $idPub = Publicacion::save($idUsu);

      $foto = new Foto();
      $foto->setDescription($_POST['description']);
      $foto->setNameFoto($img['name']);
      $foto->setPlace($_POST['place']);
      $foto->setIdUsu($idUsu);
      $foto->setIdPub($idPub);
      $foto->save();
      route("index.php" , "Usuario" , "existeUser");
      return;

    endif;

    return;
  }

  
  /**
   * Edita la foto de una publicación.
   * place y description de la 
   * imágen.
   */
  public function editar(){

    if(isset($_POST['id'])): // id publicación.

      $idPub = $_POST['id'];
      $foto = new Foto();
      $foto->setPlace($_POST['place']);
      $foto->setDescription($_POST['description']);
      $foto->setIdPub($idPub);
      $foto->update();

      route("index.php" , "Publicacion" , "showPubli" , ['id' => $idPub]);

    endif;

  }


  /**
   * ADMINISTRADOR SOLO.
   * 
   * Elimina la publicación.
   */
  public function eliminar(){

    // id de la publicación
    if(isset($_GET['id'])):

      Publicacion::delete($_GET['id']);
      route("index.php" , "Usuario" , "existeUser");
      return;

    endif;

    return;
  }


}