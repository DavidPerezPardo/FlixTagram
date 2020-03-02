<?php
/**
 * Procesa la imágen subida desde formulario de editar perfil
 * o publicación y la sube al servidor en sus respectivos
 * directorios.
 * 
 * @param int $id id de usuario.
 * @param string tipo: para perfil o publicación.
 * @param $_FILES[] la imágen a subir.
 * @return string[]|false nombre de la imágen 
 * y posibles errores.
 */
  function subeImg($id , $tipo , $img){

    //$_FILES para los archivos subidos por formulario

      if($tipo === 'perfil'):

        $dirFoto = "images/perfil/";

        elseif($tipo === 'publicacion'):

        $dirFoto = "images/publicaciones/";
        
        else:

          return false;

      endif;


      // procesamos img (tamaño y formato).
      $error = procesaImg($img);

      // si hay algun error, no subimos la img y devolvemos el error.
      if($error !=0 ):
        
        return [ 'error' => $error];
        
      else:

        $tmpName = $img['tmp_name'];         // Ruta temporal de la imágen subida.
        $nameFoto = $id . '_' . $img['name'];// Nombre de la imágen subida.
                     // Ruta de las imágenes en el servidor.
        $name = "{$dirFoto}{$nameFoto}";               // Nombre de la imágen subida. 
  
        //función para mover la imágen en el sistema.
        if(!move_uploaded_file($tmpName, $name)):
  
          // Si error al mover imágen...       
          return ['error' => 'Error servidor'];
  
        endif;
  
        return ['name' => $dirFoto . $nameFoto , 'error' => $error];        

      endif;

      return;

  }




  /**
   * Comprueba formatos de img
   * y su tamaño máximo.
   * @param $_FILES['img'] El archivo subido.
   */
  function procesaImg($img){

    // tipos admitidos
    $tipos = [0 => 'image/jpeg',
              1 => 'image/jpg',
              2 => 'image/png',
              3 => 'image/gif'
             ];

    // En MB
    $size = 8;

    // Convertido a bytes, comprueba el tamaño.
    if($img['size'] > $size * 1024**2):

      return 1;

    endif;
    
    // comprueba si es del tipo correcto.
    if(!in_array($img['type'] , $tipos , true)):

      return 2;

    endif;

    return 0;

  }