<?php
/**
 * @Author: David Pérez Pardo
 * Curso: 2019-2020 | 2º DAW - DWES
 * 
 * Métodos para la api.
 * 
 */
require_once __DIR__ . "/../libs/Database.php";


 class ApiMethods{

  private $apiKey = null;

  public function __construct(){}


    /**
     * Comprueba si existe la api key recibida
     * y obtiene el id del usuario dueño.
     * 
     */
  public static function checkApi($key){

    $db = new Database();
    $prepared = $db->prepare("SELECT idUsu FROM usuario WHERE apiKey = :key");
    $prepared->bindValue(":key" , $key , PDO::PARAM_STR);
    $prepared->execute();
    return $db->getColumn();

  }


  /**
   * Obtiene todas las publicaciones del usuario.
   * @param int $id id de del usuario.
   */
  public static function getPublicaciones($id){

    $db = new Database();
    $sql = "SELECT p.idPub , CONCAT( DAY(p.datePub) , ' de ' , MONTHNAME(p.datePub) , ' del ' ,
            YEAR(p.datePub) ) AS 'datePub' , f.place , f.description
            FROM publicacion p JOIN foto f ON p.idPub = f.idPub
            WHERE p.idUsu = :id ORDER BY 1 DESC";

    $prepared = $db->prepare($sql);

    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    $db->execute();
    return $db->getAll();

  }


  /**
   * Obtiene todos los comentarios de una 
   * publicación del usuario.
   * @param int $idPub id de la publicación.
   * @param int $idUsu id del usuario.
   */
  public static function getComentarios($idPub , $idUsu){

    $db = new Database();
    // Para obtener la fecha en español.
    $db->query("SET lc_time_names = 'es_VE'");

    $sql = "SELECT CONCAT( DAY(c.dateCom) , '-' , MONTHNAME(c.dateCom) ,'-' ,
            YEAR(c.dateCom) , ' ' , TIME(c.dateCom) ) AS 'dateCom' , u.nick , c.textCom
            FROM comentario c 
            JOIN publicacion p ON c.idPub = p.idPub
            JOIN usuario u ON  u.idUsu = c.idUsu 
            WHERE c.idPub = :idPub AND p.idUsu = :idUsu ORDER BY dateCom DESC";

    $prepared = $db->prepare($sql);
    $prepared->bindValue(":idUsu" , $idUsu , PDO::PARAM_INT);
    $prepared->bindValue(":idPub" , $idPub , PDO::PARAM_INT);

    $db->execute();
    return $db->getAll();

  }


 }