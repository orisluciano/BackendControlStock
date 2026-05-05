<?php
require_once "IProductoServicio.php";
require_once "./Utiles/RespuestaServicioDatos.php";

class ProductoServicio implements IProductoServicio
{
    protected IRepoProducto $_repo;
    protected RespuestaServicioDatos $_respuesta;

    public function __construct(IRepoProducto $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
    }

    public function _nuevo(ProductoDTO $producto) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }
    public function _modificar(ProductoDTO $producto) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }
    public function _eliminar($id) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }
    public function _getById(int $id) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }
    public function _getProductos(int $desde, int $cantidad) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }
    public function _getCantidad() : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }
}

?>