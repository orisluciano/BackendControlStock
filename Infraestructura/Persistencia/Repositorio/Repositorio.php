<?php
require_once "../Back/Dominio/Repositorio/IRepositorio.php";
require_once "../Back/Infraestructura/Persistencia/Conexion/ConexionMySQL.php";

class Repositorio implements IRepositorio
{
    protected ConexionMySQL $conn;
    protected $db;

    public function __construct() {
        $this->conn = new ConexionMySQL();
        $this->db = $this->conn->connect();
    }

    public function crear($entidad){}
    public function modificar($entidad){}
    public function eliminar(int $id){}
    public function getById(int $id){}
    public function getTodo(){}
}
?>