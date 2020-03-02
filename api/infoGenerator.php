<?php
/**
 * @Author: David Pérez Pardo
 * Curso: 2019-2020 | 2º DAW - DWES
 * 
 * Genera la información de la API
 * y la devuelve en formato JSON.
 * 
 */
require_once "ApiMethods.php";


if(!isset($_GET['apiKey']) || !$_GET['apiKey']):
  
  echo "ERROR:API KEY NO ENCONTRADA!";
  die;

endif;

$apiKey = $_GET['apiKey'] ?? false;

// comprobamos si existe la apikey.
$idUsu = ApiMethods::checkApi($apiKey);

if(!$idUsu):

  $data = ['Error'   => 1,
           'Mensaje' => 'ApiKey no válida, usted no tiene permiso!'
          ];

  else:


  $op = $_GET['op'] ?? '';

  $data = [];

  switch ($op) {

    case 'publicaciones':
      
      $pubs = ApiMethods::getPublicaciones($idUsu);

      // formato 
      foreach ($pubs as $key => $value):

        $pubs =  ['ID publicacion'       => $value->idPub,
                  'Fecha de publicacion' => $value->datePub,
                  'Lugar'                => $value->place,
                  'Descripcion'          => $value->description
                  ];
        // array de publicaciones         
        array_push( $data , $pubs);

      endforeach;

      break;

    case 'comentarios':

      $idPub   = $_GET['id'] ?? 0;
      $coments = ApiMethods::getComentarios($idPub , $idUsu);
      
      if(empty($coments)):
      // si no hay comentarios
        $data = ['Error' => 'Nada que mostrar'];

      else:

        foreach ($coments as $key => $value):

          $coments = ['Fecha de publicacion' => $value->dateCom,
                      'Comentario'           => $value->textCom,
                      'Usuario:'             => $value->nick,
                      ];
                    
          // array de comentarios.         
          array_push( $data , $coments);
  
        endforeach;
      endif;

      break;
    
    default:
      
      $data = 'Error: operación no permitida';
      
      break;
  }

endif;


// devolvemos el contenido especificando que es JSON
header("Content-Type: application/json") ;
echo json_encode($data);