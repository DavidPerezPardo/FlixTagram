<?php
/**
 * @author David Pérez Pardo
 * @brief Clase para la conexión con la DB.
 * 
 */
require_once "DataDb.php";

class Database{

  private $pdo;
  private $result;


  public function __construct(){

    $this->pdo = new PDO("mysql:host=" . CONEXION['host'] . ";dbname=" . CONEXION['dbName']
                         . ";charset=utf8" , CONEXION['user'] , CONEXION['pass'])
                        or die("Error:No se pudo conectar con la base de datos");
  
  }
  

  /**
  * @brief Cierra la conexión con la base de datos antes de que
  * se destruya el objeto Database.
  */
  public function __destruct()
  {
    $this->pdo = null ;
  }


	/**
  * @brief Realiza una consulta en la base de datos
  * @param string Consulta sql.
	*/
	public function query($sql)
	{
		$this->result = $this->pdo->query($sql) ;
  }


  /**
   * @brief Sentencia preparada.
   * @param string $sql Consulta sql.
   * @return PDOStatement 
   */
  public function prepare(String $sql):PDOStatement{

    return $this->result = $this->pdo->prepare($sql);

  }


  /**
   * @brief Ejecuta la sentencia preparada.
   * @return boolean
   */
  public function execute():bool{

    return $this->result->execute();
  }


  /**
   * Devuelve la primera columna del registro.
   * @return mixed primera columna de la fila.
   */
  public function getColumn(){

    return $this->result->fetchColumn();
  }


  /**
  * @brief Devuelve un sólo registro en formato de objeto.
  * @param  Object $cls
  * @return Object $this
	*/
	public function getObject($cls = "StdClass")
	{
		return $this->result->fetchObject($cls) ;
  }


  /**
   * @brief Devuelve 'más' de un registro en formato de array de objetos.
   * @param  Object $cls
   * @return Object[] $this
   */
  public function getAll($cls = "StdClass"){

    return $this->result->fetchAll(PDO::FETCH_CLASS , $cls);

  }


  /**
   * @brief Cuenta  y devuelve el número de filas de la consulta.
   * @return int $this
   */
  public function rowCount(){

    return $this->result->rowCount();
  }


  /**
   * Devuelve el id de la última fila insertada.
   * @return int id
   */
  public function insertId(){

    return $this->pdo->lastInsertId();
  }

}