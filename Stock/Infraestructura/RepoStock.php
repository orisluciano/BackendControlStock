<?php
require_once "./Stock/Dominio/IRepoStock.php";
require_once "./Stock/Dominio/Stock.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";
require_once "./Utiles/Infraestructura/RepoBase.php";

class RepoStock extends RepoBase implements IRepoStock
{
    public function _crear(Stock $entidad) : RespuestaRepositorio{
        return new RespuestaRepositorio;
    }
    public function _modificar(Stock $entidad) : RespuestaRepositorio{
        return new RespuestaRepositorio;
    }
    public function _eliminar(int $id) : RespuestaRepositorio{
        return new RespuestaRepositorio;
    }
    public function _getById(int $id) : RespuestaRepositorio{
        return new RespuestaRepositorio;
    }
    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio{
        return new RespuestaRepositorio;
    }
    public function _getStockByProductoId(int $productoId, string $desde, string $hasta) : RespuestaRepositorio{
        return new RespuestaRepositorio;
    }
    public function _getCantidad() : RespuestaRepositorio  {
        return new RespuestaRepositorio;
    }
}
?>