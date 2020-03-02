<?php
/**
 * Clase para el control de sesión.
 * 
 */

if(!isset($_SESSION)){

  session_start();
 
 }
 
class Sesion{

  private static $expire = 1200; // segundos

  public function __construct(){

  }

  /**
   * Creamos la sesión del usuario.
   * @return true
   */
  public static function sesion($id , $nick , $email , $rol , $nombre):bool{




    $_SESSION['usuario'] =  ['time'   => time(),
                             'id'     => $id,
                             'nick'   => $nick,
                             'email'  => $email,
                             'rol'    => $rol,
                             'nombre' => $nombre
                            ];

    return true;

  }


  /**
   * Getter id usuario.
   * @return int id usuario.
   */
  public static function getId(){

    return $_SESSION['usuario']['id'];
  }


  /**
   * Getter email usuario.
   * @return string  email usuario.
   */
  public static function getEmail(){

    return $_SESSION['usuario']['email'];
  }


  /**
   * Getter rol usuario.
   * @return int $id id usuario.
   */
  public static function getRol(){

    return $_SESSION['usuario']['rol'];
  }



  /**
   * Cierra la sesión del usuario.
   * 
   */
  public static function close(){

    session_destroy();
    $_SESSION = [];
  }


  /**
   * Comprueba si la sesión del usuario
   * está activa.
   * Si está activa,refresca también el tiempo de actividad.
   * @return boolean
   */
  public static function checkSesion():bool{

    if(isset($_SESSION['usuario'])):

      if(self::checkExpired()):

        self::close();
        route("index.php" , 'Usuario' , 'existeUser');
        die;

      endif;

      //refresco tiempo de actividad
      $_SESSION['usuario']['time'] = time();

      return true;

    endif;

    return false;
  }


  /**
   * Comprueba si ha expirado el tiempo de sesión.
   * @return bool
   */
  public static function checkExpired(){

    return (time() - $_SESSION['usuario']['time'] > self::$expire );

  }

 }