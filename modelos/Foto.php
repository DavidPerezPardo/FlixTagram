<?php
/**
 * @Author: David Pérez Pardo
 * Curso: 2019-2020 | 2º DAW - DWES
 * 
 * Modelo Foto.
 * 
 */
require_once "libs/Database.php";


class Foto{


  private $idFoto = null;
  private $shows;
  private $description;
  private $place;
  private $nameFoto;
  private $dateFoto;
  private $idUsu = null;
  private $idPub = null;

  public function __construct(){}


  /**
   * Get the value of likes
   */ 
  public function getShows()
  {
    return $this->shows;
  }

  /**
   * Get the value of description
   */ 
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Get the value of place
   */ 
  public function getPlace()
  {
    return $this->place;
  }

  /**
   * Get the value of nameFoto
   */ 
  public function getNameFoto()
  {
    return $this->nameFoto;
  }

  /**
   * Get the value of dateFoto
   */ 
  public function getDateFoto()
  {
    return $this->dateFoto;
  }

  /**
   * Get the value of idPub
   */ 
  public function getIdPub()
  {
    return $this->idPub;
  }

  /**
   * Get the value of idUsu
   */ 
  public function getIdUsu()
  {
    return $this->idUsu;
  }

  /**
   * Set the value of description
   *
   * @return  self
   */ 
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Set the value of place
   *
   * @return  self
   */ 
  public function setPlace($place)
  {
    $this->place = $place;

    return $this;
  }


  /**
   * Set the value of nameFoto
   *
   * @return  self
   */ 
  public function setNameFoto($nameFoto)
  {
    $this->nameFoto = $nameFoto;

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
   * Busca y obtiene todas las fotos de cada publicación.
   * también Nick e imágen del usuario que la ha publicado.
   * @param int $id id de publicación.
   * @return Foto[]|null
   */
  public static function findAll($id){

    $db = new Database();

    // Para obtener la fecha en español.
    $db->query("SET lc_time_names = 'es_VE'");
    
    $prepared = $db->prepare("SELECT f.idPub , f.shows , f.description , f.place , f.nameFoto , 
                              CONCAT( DAY(f.dateFoto) , ' de ' , MONTHNAME(f.dateFoto) ,' del ' ,
                              YEAR(f.dateFoto) ) AS 'dateFoto' , u.idUsu , u.nick , u.imgUser FROM foto f
                              JOIN usuario u ON f.idUsu = u.idUsu                      
                              WHERE idPub = :id");

    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    $db->execute();
    return $db->getAll('Foto');

  }


  /**
   * Guarda la foto en la DB.
   * Almacena en la tabla foto
   * la id de su publicación y del usuario
   * que la ha realizado.
   * @return bool
   */
  public function save(){

    $db = new Database();
    $prepared = $db->prepare("INSERT INTO foto (description , place , nameFoto , 
                              idUsu , idPub) VALUES (:description , :place , :img ,
                              :idUsu , :idPub)");

    $prepared->bindValue(":img" , $this->getNameFoto() , PDO::PARAM_STR );
    $prepared->bindValue(":description" , $this->getDescription() , PDO::PARAM_STR );
    $prepared->bindValue(":place" , $this->getPlace() , PDO::PARAM_STR );
    $prepared->bindValue(":idUsu" , $this->getIdUsu() , PDO::PARAM_INT );
    $prepared->bindValue(":idPub" , $this->getIdPub() , PDO::PARAM_INT );    
    return $db->execute();

  }


  /**
   * Edita la foto de una publicación.
   * place y description de la imágen.
   * @return bool
   */
  public function update(){

    $db = new Database();
    $prepared = $db->prepare("UPDATE foto SET place = :place , description = :des
                              WHERE idPub = :id");
                              
    $prepared->bindValue(":place" , $this->getPlace() , PDO::PARAM_STR);
    $prepared->bindValue(":des" , $this->getDescription() , PDO::PARAM_STR);
    $prepared->bindValue(":id" , $this->getIdPub() , PDO::PARAM_INT);
    return $db->execute();

  }



  /**
   * Inserta un show a la foto.
   * @param int $idFoto id de la publicación.
   */
  public static function addShow($idPub){

    $db = new Database();
    $prepared = $db->prepare("UPDATE foto SET shows = shows +1  WHERE idPub = :idPub");
    $prepared->bindValue(":idPub" , $idPub , PDO::PARAM_INT );
    return $db->execute();

  }

}