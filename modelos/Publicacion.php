<?php
/**
 * @Author: David Pérez Pardo
 * Curso: 2019-2020 | 2º DAW - DWES
 * 
 * Modelo Publicacion.
 * 
 */
require_once "libs/Database.php";


class Publicacion{


  private $idPub = null;
  private $datePub;
  private $idUsu;

  public function __construct(){}

  
  /**
   * Get the value of idPub
   */ 
  public function getIdPub()
  {
    return $this->idPub;
  }

  /**
   * Get the value of datePub
   */ 
  public function getDatePub()
  {
    return $this->datePub;
  }

  /**
   * Get the value of idUsu
   */ 
  public function getIdUsu()
  {
    return $this->idUsu;
  }


  /**
   * Busca y devuelve una publicación en particular.
   * si no exieste,devolverá null.
   * @param int $id id de la publicación.
   * @return Publicacion|null Objeto publicación.
   */
  public static function find($id){

    $db = new Database();
    $prepared = $db->prepare("SELECT * FROM publicacion WHERE idPub = :id");
    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    $prepared->execute();
    var_dump($db->getObject('Publicacion'));
    die;
  
  }

  /**
   * Busca y devuelve todas las publicaciones del
   * 'Propio usuario'.
   * Devuelve tambien una foto de cada publicación
   * Devuelve null si no hay ninguna publicacion.
   * @return Publicacion[]|null array de objetos Publicación.
   */
  public static function findAllUser($idUsu){

    $db = new Database();

    // Para obtener la fecha en español.
    $db->query("SET lc_time_names = 'es_VE'");
    
    $sql = "SELECT CONCAT( DAY(p.datePub) , ' de ' , MONTHNAME(p.datePub) ,' del ' ,
                           YEAR(p.datePub) ) AS 'datePub',
                           p.idPub, p.idUsu , f.nameFoto , f.shows , f.idFoto ,u.nick FROM publicacion p JOIN foto f
                           ON p.idPub = f.idPub  JOIN usuario u ON p.idUsu = u.idUsu
                           WHERE p.idUsu = :id 
                           ORDER BY p.idPub DESC";

    $prepared = $db->prepare($sql);
    $prepared->bindValue(":id" , $idUsu , PDO::PARAM_INT);
    $db->execute();
    return $db->getAll("Publicacion");

  }


  /**
   * Busca y devuelve todas las publicaciones de
   * la APP,menos las del propio usuario conectado.
   * Devuelve tambien una foto de cada publicación
   * para poner de portada y el nick del usuario
   * que la publicó.
   * Devuelve null si no hay ninguna publicacion.
   * @param int $id id del usuario.
   * @return Publicacion[]|null array de objetos Publicación.
   */
  public static function findAllOthers($id){

    $db = new Database();

    // Para obtener la fecha en español.
    $db->query("SET lc_time_names = 'es_VE'");
    
    $sql = "SELECT CONCAT( DAY(p.datePub) , ' de ' , MONTHNAME(p.datePub) ,' del ' ,
                           YEAR(p.datePub) ) AS 'datePub',
                           p.idPub, p.idUsu , f.nameFoto , f.shows , f.idFoto , u.nick
                           FROM publicacion p 
                           JOIN foto f
                           ON p.idPub = f.idPub
                           JOIN usuario u
                           ON p.idUsu = u.idUsu WHERE p.idUsu != :id
                           ORDER BY p.idPub DESC";

    $prepared = $db->prepare($sql);
    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    $db->execute();
    return $db->getAll("Publicacion");
  }


  /**
   * Guarda una nueva publicación en la DB.
   * @return int id de la publicación insertada.
   * @param int $id id del usuario.
   */
  public static function save($id){

    $db = new Database();
    $prepared = $db->prepare("INSERT INTO publicacion (idUsu) VALUES (:id)");
    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    $db->execute();
    return $db->insertId();

  }


  /**
   * Elimina una publiación de la DB.
   * @param int $id id de la publicación.
   */
  public static function delete($id){

    $db = new Database();
    $prepared = $db->prepare("DELETE FROM publicacion WHERE idPub = :id");
    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    return $db->execute();

  }

 


}