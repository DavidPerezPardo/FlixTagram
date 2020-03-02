<?php
/**
 * @Author: David Pérez Pardo
 * Curso: 2019-2020 | 2º DAW - DWES
 * 
 * Controlador Comentario.
 * 
 */
require_once "BaseController.php";
require_once "modelos/Comentario.php";
require_once "libs/Sesion.php" ;
require_once "libs/Routing.php" ;


class ComentarioController extends BaseController{


  public function __construct(){

    parent::__construct();
  }


  /**
   * Inserta el comentario en la DB.
   * Redirecciona a la misma página.
   */
  public function comentar(){

    if(isset($_POST['idPub'])):

      $idPubli = $_POST['idPub'];
      $id = Sesion::getId();

      $comentario = new Comentario();
      $comentario->setTextCom($_POST['coment']);
      $comentario->setIdUsu($id);
      $comentario->setIdPub($idPubli);
      $comentario->save();

      route("index.php" , "Publicacion" , "showPubli" , ['id' => $idPubli , 'idUsu' => $id]);
      return;

    endif;

  }


  /**
   * ADMINISTRADOR SOLO.
   * Elimina un comentario.
   */
  public function eliminar(){

    // id comentario
    if(isset($_GET['idCom'])):

      $idUsu = $_GET['idUsu'];
      $idPub = $_GET['idPub'];
      Comentario::delete($_GET['idCom']);
      route("index.php" , "Administrador" , "showAll" , ['modo'  => 'comentarios',
                                                         'idUsu' => $idUsu,
                                                         'idPub' => $idPub]);

      return;

    endif;
  }


  /**
   * Actualiza un comentario del usuario.
   * 
   */
  public function editCom(){

    if(isset($_POST['com'])):

      $idCom   = $_POST['idCom'];
      $comText = $_POST['com'];
      $idPub   = $_POST['idPub'];
      Comentario::update($comText , $idCom);
      Comentario::updateDate($idCom); // actualizamos fecha de edición.
      route("index.php" , "Publicacion" , "showPubli" , ['id' => $idPub]);

    endif;
  }

   
}