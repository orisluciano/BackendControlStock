<?php
require_once 'RespuestaConexion.php';

class ConexionMySQL
{
    protected $db = [
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'db' => 'controlstockdb'
    ];
    protected RespuestaConexion $res;
    protected $mensaje = array();

    public function __construct() {
        $this->res = new RespuestaConexion();
    }
    //Abrir conexion a la base de datos
  function connect()
  {
      try {
          $conn = new PDO("mysql:host={$this->db['host']};dbname={$this->db['db']}", $this->db['username'], $this->db['password']);

          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->res->conexion = $conn;
          $this->mensaje[] = "Conexion exitosa...";
          return $this->res;
      } catch (PDOException $exception) {
          //exit($exception->getMessage());
          $this->res->errores[] = $exception->getMessage();
          return $this->res;
      }
  }

  function disconnect(){
    $this->res->conexion = null;
  }


 //Obtener parametros para updates
 function getParams($input)
 {
    $filterParams = [];
    foreach($input as $param => $value)
    {
            $filterParams[] = "$param=:$param";
    }
    return implode(", ", $filterParams);
	}

  //Asociar todos los parametros a un sql
	function bindAllValues($statement, $params)
  {
		foreach($params as $param => $value)
    {
				$statement->bindValue(':'.$param, $value);
		}
		return $statement;
   }


}
?>