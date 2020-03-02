<?php
/**
 * @Author: David Pérez Pardo
 * Curso: 2019-2020 | 2º DAW - DWES
 * 
 * Modelo Usuario.
 * 
 */
require_once "libs/Database.php";

class Usuario{

  private $idUsu = null;
  private $nameUsu;
  private $nick;
  private $imgUser;
  private $bioUser;
  private $email;
  private $passUsu;
  private $rol;
  private $altaUsu;


  public function __construct(){}

  
  /**
   * Get the value of idUsu
   */ 
  public function getIdUsu()
  {
    return $this->idUsu;
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
   * Get the value of nombre
   */ 
  public function getNameUsu()
  {
    return $this->nameUsu;
  }

  /**
   * Set the value of nombre
   *
   * @return  self
   */ 
  public function setNameUsu($nombre)
  {
    $this->nameUsu = $nombre;

    return $this;
  }

  /**
   * Get the value of user
   */ 
  public function getNick()
  {
    return $this->nick;
  }

  /**
   * Set the value of user
   *
   * @return  self
   */ 
  public function setNick($nick)
  {
    $this->nick = $nick;

    return $this;
  }

  /**
   * Get the value of imgUser
   */ 
  public function getImgUser()
  {
    return $this->imgUser;
  }

  /**
   * Set the value of imgUser
   *
   * @return  self
   */ 
  public function setImgUser($imgUser)
  {
    $this->imgUser = $imgUser;

    return $this;
  }

  /**
   * Get the value of bioUser
   */ 
  public function getBioUser()
  {
    return $this->bioUser;
  }

  /**
   * Set the value of bioUser
   *
   * @return  self
   */ 
  public function setBioUser($bioUser)
  {
    $this->bioUser = $bioUser;

    return $this;
  }

  /**
   * Get the value of email
   */ 
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the value of email
   *
   * @return  self
   */ 
  public function setEmail($email)
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Get the value of pass
   */ 
  public function getPassUsu()
  {
    return $this->passUsu;
  }

  /**
   * Set the value of pass
   *
   * @return  self
   */ 
  public function setPassUsu($pass)
  {
    $this->passUsu = $pass;

    return $this;
  }

  /**
   * Get the value of rol
   */ 
  public function getRol()
  {
    return $this->rol;
  }

  /**
   * Set the value of rol
   *
   * @return  self
   */ 
  public function setRol($rol)
  {
    $this->rol = $rol;

    return $this;
  }

  /**
   * Get the value of altaUsu
   */ 
  public function getAltaUsu()
  {
    return $this->altaUsu;
  }

  /**
   * Set the value of altaUsu
   *
   * @return  self
   */ 
  public function setAltaUsu($date)
  {
    $this->altaUsu = $date;

    return $this;
  }




  /**
   * Busca y devuelve un usuario de la DB.
   * @param int $id id del usuario.
   * @return Usuario|false 
   */
  public static function find($id){

    $db = new Database();
    $prepared = $db->prepare("SELECT * FROM usuario WHERE idUsu = :id");
    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    $prepared->execute();

    return $db->getObject('Usuario');
  }


  /**
   * ADMINISTRADOR.
   * 
   * Busca y obtiene todos los usuarios
   * de la DB.
   * @return Usuario|false 
   */
  public static function findAll(){

    $db = new Database();
    $prepared = $db->prepare("SELECT * FROM usuario ORDER BY 1 DESC");
    $prepared->execute();

    return $db->getAll('Usuario');

  }

  /**
   * ADMINISTRADOR.
   * 
   * Elimina un usuario de la DB.
   * @param int $id del usuario.
   * @return boolean
   */
  public static function delete($id){

    $db = new Database();
    $prepared = $db->prepare("DELETE FROM usuario WHERE idUsu = :id");
    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    return $prepared->execute();

  }


  /**
   * @brief Registra un nuevo usuario en la DB.
   * @return boolean
   */
  public function save():bool {

    $db = new Database();
    $sql = "INSERT INTO usuario (nameUsu , nick , email , passUsu )
            VALUES (:name , :nick , :email , MD5(:pass) )";

    $prepared = $db->prepare($sql);

    $prepared->bindValue(":name" , $this->getNameUsu() , PDO::PARAM_STR);
    $prepared->bindValue(":nick" , $this->getNick() , PDO::PARAM_STR);
    $prepared->bindValue(":email" , $this->getEmail() , PDO::PARAM_STR);
    $prepared->bindValue(":pass" , $this->getPassUsu() , PDO::PARAM_STR);

    return $db->execute();

  }


  /**
   * Actualiza un usuario en la DB.
   * @return boolean
   */
  public function update():bool{

    $db = new Database();
    $sql = "UPDATE usuario SET nameUsu = :nombre , nick = :nick , imgUser = :img , 
                               bioUser = :bio , email = :email WHERE idUsu = :id";

    $prepared = $db->prepare($sql);
    $prepared->bindValue(":nombre" , $this->getNameUsu() , PDO::PARAM_STR);
    $prepared->bindValue(":nick" , $this->getNick() , PDO::PARAM_STR);
    $prepared->bindValue(":email" , $this->getEmail() , PDO::PARAM_STR);
    $prepared->bindValue(":bio" , $this->getBioUser() , PDO::PARAM_STR);
    $prepared->bindValue(":img" , $this->getImgUser() , PDO::PARAM_STR);
    //$prepared->bindValue(":pass" , $this->getPassUsu() , PDO::PARAM_STR);
    $prepared->bindValue(":id" , $this->getIdUsu() , PDO::PARAM_INT);

    return $db->execute();

  }

  /**
   * Comprueba si ya existe el nick y el email 
   * del usuario a registrar en la DB.
   * 
   * @param string $nick
   * @param string $email
   * @return int
   */
  public function checkExist($nick , $email):int{

    $db = new Database();
    $sql = "SELECT idUsu FROM usuario WHERE nick = :nick OR email = :email";
    $prepared = $db->prepare($sql);
    $prepared->bindValue(":nick" , $nick, PDO::PARAM_STR);
    $prepared->bindValue(":email" , $email , PDO::PARAM_STR);
    $db->execute();
    return $db->rowCount();

  }


  /**
   * @brief Comprueba si el usuario introducido en el login
   * existe o no en la DB.
   * Se comprueba el nick o email del usuario y la contraseña.
   * Si existe, devuelve el id, sino false.
   * 
   * @param string $user
   * @param string $pass
   * @return int id del registro encontrado.
   */
  public static function checkUser($user , $pass){

    $db = new Database();

    $prepared = $db->prepare("SELECT * FROM usuario WHERE ( nick = :user OR email = :user
                             ) AND passUsu = MD5(:pass) ");

    $prepared->bindValue(":user" , $user , PDO::PARAM_STR);
    $prepared->bindValue(":pass" , $pass , PDO::PARAM_STR);
    $db->execute();
    return $db->getColumn();

  }


  /**
   * Para cambiar la contraseña del usuario.
   * 
   * @param string $passOld pass actual del usuario.
   * @param string $passOld pass nueva  del usuario.
   * @param int $id id del usuario.
   * @return bool
   */
  public static function changePass($id , $passOld , $passNew){

    $db = new Database();
    $sql = "UPDATE usuario SET passUsu = MD5(:passNew)  WHERE idUsu = :id AND passUsu = MD5(:passOld)";

    $prepared = $db->prepare($sql);
    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    $prepared->bindValue(":passOld" , $passOld , PDO::PARAM_STR);
    $prepared->bindValue(":passNew" , $passNew , PDO::PARAM_STR);
    $db->execute();
    return $db->rowCount();

  }


  /**
   * Comprueba si el usuario tiene api key.
   * Si tiene, la devuelve.
   * @param int $id del usuario.
   * @return string|null
   */
  public static function getApi($id){

    $db = new Database();
    $prepared = $db->prepare("SELECT apiKey FROM usuario WHERE idUsu= :id");
    $prepared->bindValue(":id" , $id , PDO::PARAM_STR);
    $prepared->execute();
    return $db->getColumn();

  }


  /**
   * Inserta en la DB la API Key generada
   * al usuario.
   * @param int $id id del usuario.
   * @param string $key api key.
   */
  public static function saveKey($id , $key){

    $db = new Database();
    $sql = "UPDATE usuario SET apiKey = :key WHERE idUsu = :id";

    $prepared = $db->prepare($sql);
    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    $prepared->bindValue(":key" , $key , PDO::PARAM_STR);
    return $db->execute();

  }

  /**
   * 
   * PARA PETICIONES AJAX
   * 
   */


  /**
   * AJAX.
   * 
   * Comprueba si ya existe el nick en la base de datos.
   * @param string $nick
   * @param int $id del usuario
   * @return int 1 si existe en la db.
   */
  public static function checkNick($nick , $id):int{

    $db = new Database();
    $prepared = $db->prepare("SELECT idUsu FROM usuario WHERE nick = :nick AND idUsu != :id");
    $prepared->bindValue(":nick" , $nick , PDO::PARAM_STR);
    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    $prepared->execute();
    return $db->rowCount();

  }

  /**
   * AJAX.
   * 
   * Comprueba si ya existe el email en la base de datos.
   * @param int $id del usuario
   * @param string $email
   * @return int 1 si existe en la db.
   */
  public static function checkEmail($email , $id):int{

    $db = new Database();
    $prepared = $db->prepare("SELECT idUsu FROM usuario WHERE email = :email AND idUsu != :id");
    $prepared->bindValue(":email" , $email , PDO::PARAM_STR);
    $prepared->bindValue(":id" , $id , PDO::PARAM_INT);
    $prepared->execute();
    return $db->rowCount();

  }


  /**
   * AJAX.
   * 
   */
  public static function search($filtro , $search){

    $db = new Database();
    $prepared = $db->prepare("SELECT * FROM usuario WHERE {$filtro} LIKE '%' :search '%' ");
    $prepared->bindValue(":search" , $search);
    $prepared->execute();
    return $db->getAll('Usuario');

  }


}