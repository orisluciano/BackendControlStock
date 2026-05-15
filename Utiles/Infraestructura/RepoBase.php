<?php
require_once "./Persistencia/Conexion/ConexionMySQL.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";

class RepoBase
{
    protected ConexionMySQL $_conn;
    protected RespuestaRepositorio $_resRepo;

    public function __construct() {
        $this->_conn = new ConexionMySQL();
        $this->_resRepo = new RespuestaRepositorio();
    }   
}
?>