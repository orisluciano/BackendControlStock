<?php
final class RepoPrecio implements IRepoPrecio
{
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