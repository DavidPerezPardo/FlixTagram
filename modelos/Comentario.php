<?php
/**
 * @Author: David Pérez Pardo
 * Curso: 2019-2020 | 2º DAW - DWES
 * 
 * Modelo Comentario.
 * 
 */
require_once "libs/Database.php";


class Comentario{

  private $idCom = null;
  private $textCom;
  private $dateCom;
  private $idUsu = null;
  private $idPub = null;
  private $update_at;
  
  public function __construct(){}

  
  /**
   * Get the value of idCom
   */ 
  public function getIdCom()
  {
    return $this->idCom;
  }

  /**
   * Get the value of textCom
   */ 
  public function getTextCom()
  {
    return $this->textCom;
  }

  /**
   * Get the value of dateCom
   */ 
  public function getDateCom()
  {
    return $this->dateCom;
  }

  /**
   * Get the value of idUsu
   */ 
  public function getIdUsu()
  {
    return $this->idUsu;
  }

  /**
   * Get the value of idPub
   */ 
  public function getIdPub()
  {
    return $this->idPub;
  }
  
    /**
   * Set the value of textCom
   *
   * @return  self
   */ 
  public function setTextCom($textCom)
  {
    $this->textCom = $textCom;

    return $this;
  }

  /**
   * Set the value of idUsu
   *
   * @return  self
   */ 
  public function setIdUsu($idUsu)
  {
    $this->idUsu = $idUsu;

    return $this;
  }

  /**
   * Set the value of idPub
   *
   * @return  self
   */ 
  public function setIdPub($idPub)
  {
    $this->idPub = $idPub;

    return $this;
  }

  /**
   * Get the value of update_at
   */ 
  public function getUpdate_at()
  {
    return $this->update_at;
  }

  
  /**
   * Buscamos y obtenemos todos los comentarios de una publicación
   * determinada junto al nick e imágen de perfil del usuario que 
   * hace el comentario.
   * 
   * para sumar una hora,ya que el host tiene
   * una de zona horaria distinta
   * DATE_ADD(TIME(dateCom),INTERVAL 1 hour)
   * 
   * @param int $id id de la publicación.
   * @return Comentario[]|null
   * 
   */
  public static function findAll($id){

    $db = new Database();
    // Para obtener la fecha en español.
    $db->query("SET lc_time_names = 'es_VE'");

    $sql = "SELECT c.idCom , c.idUsu , c.idPub , c.textCom , CONCAT( DAY(c.dateCom) , ' ' , MONTHNAME(c.dateCom) ,' ' ,
            YEAR(c.dateCom) , ' ' , TIME(c.dateCom ) ) AS 'dateCom' ,
            CONCAT( DAY(c.update_at) , ' ' , MONTHNAME(c.update_at) ,' ' ,
            YEAR(c.update_at) , ' ' , TIME(c.update_at ) ) AS 'update_at' ,  u.nick , u.imgUser
            FROM usuario u JOIN comentario c on u.idUsu=c.idUsu
            AND c.idPub = :id ORDER BY c.idCom DESC";

    $prepared = $db->prepare($sql);
    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    $db->execute();
    return $db->getAll('Comentario');

  }


  /**
   * Inserta un comentario en la DB.
   * @param string $textCom
   * @param int $idUsu
   * @param int $idUsu
   * @return bool
   */
  public function save(){

    $db = new Database();
    $sql = "INSERT INTO comentario (textCom , idUsu , idPub) VALUES 
            (:textCom , :idUsu , :idPub )";

    $prepared = $db->prepare($sql);
    $prepared->bindValue(":textCom" , $this->getTextCom() , PDO::PARAM_STR);
    $prepared->bindValue(":idUsu" , $this->getIdUsu() , PDO::PARAM_INT);
    $prepared->bindValue(":idPub" , $this->getIdPub() , PDO::PARAM_INT);
    return $db->execute();

  }


  /**
   * ADMINISTRADOR SOLO.
   * 
   * Elimina un comentario de la DB.
   * @param int $id id deL comentario.
   */
  public static function delete($id){

    $db = new Database();
    $prepared = $db->prepare("DELETE FROM comentario WHERE idCom = :id");
    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    return $db->execute();

  }


  /**
   * Actualiza un comentario en la DB.
   * @param string $com comentario.
   * @param int $idCom id comentario.
   */
  public static function update($com ,$idCom){

    $db = new Database();
    $prepared = $db->prepare("UPDATE comentario SET textCom = :com WHERE idCom = :idCom");
    $prepared->bindValue(":com" , $com , PDO::PARAM_STR);
    $prepared->bindValue(":idCom" , $idCom , PDO::PARAM_INT);
    return $db->execute();

  }


  /**
   * Actualizamos la fecha de edición del comentario.
   * @param int $idCom id comentario.
   */
  public static function updateDate($idCom){

    $db = new Database();
    $prepared = $db->prepare("UPDATE comentario SET update_at = NOW() WHERE idCom = :idCom");
    $prepared->bindValue(":idCom" , $idCom , PDO::PARAM_INT);
    return $db->execute();

  }




}