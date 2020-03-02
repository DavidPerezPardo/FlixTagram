<?php
/**
 * @Author: David Pérez Pardo
 * Curso: 2019-2020 | 2º DAW - DWES
 * 
 * Controlador frontal.
 * 
 */
  require_once "libs/Database.php";

  // Controlador y tipo de operación/método envío.
  if(!empty($_POST)):

    // Login con post.
    $con = $_POST['con'];
    $ope = $_POST['ope'];
  
  else:

    $con = $_GET['con'] ?? "Usuario";
    $ope = $_GET['ope'] ?? "existeUser";
  
  endif;


  // Se forma el nombre del controlador completo.
  $nomController = "{$con}Controller";

  // Importados el controlador creado anteriormente.
  require_once "controladores/{$nomController}.php";

  // Instanciamos dicho controlador.
  $controller = new $nomController();

  // Operación realizar.
  $controller->$ope();


  /*
  //TEST DB

  $db = new Database();
  $db->query("SELECT * FROM usuario");
  var_dump ($db->getObject());


  
  */



