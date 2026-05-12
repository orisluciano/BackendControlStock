<?php
require_once "./Precio/Dominio/IRepoPrecio.php";
require_once "./Precio/Dominio/Precio.php";
require_once "./Persistencia/Conexion/ConexionMySQL.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";

final class RepoPrecio implements IRepoPrecio
{
    protected ConexionMySQL $_conn;
    protected $_db;
    protected RespuestaRepositorio $_resRepo;

    public function __construct() {
        $this->_conn = new ConexionMySQL();
        $this->_resRepo = new RespuestaRepositorio();
    }
    
    public function _crear(Precio $precio) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
    public function _modificar(Precio $precio) : RespuestaRepositorio{
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
    public function _getByProductoId(int $productoId, string $desde, string $hasta) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
}

?>