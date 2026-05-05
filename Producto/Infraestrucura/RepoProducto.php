<?php
require_once "./Producto/Dominio/IRepoProducto.php";
require_once "./Producto/Dominio/Producto.php";
require_once "./Persistencia/Conexion/ConexionMySQL.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";

class RepoProducto implements IRepoProducto
{
    protected ConexionMySQL $_conn;
    protected $_db;
    protected RespuestaRepositorio $_resRepo;

    public function __construct() {
        $this->_conn = new ConexionMySQL();
        $this->_resRepo = new RespuestaRepositorio();
    }

    public function _crear(Producto $entidad) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
    public function _modificar(Producto $entidad) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
    public function _eliminar(int $id) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
    public function _getById(int $id) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
    public function _getCantidad() : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
}

?>