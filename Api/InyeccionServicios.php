<?php
require_once "./Producto/Aplicacion/ProductoServicio.php";
require_once "./Producto/Infraestrucura/RepoProducto.php";
require_once "./Precio/Aplicacion/PrecioServicio.php";
require_once "./Precio/Infraestructura/RepoPrecio.php";

class InyeccionServicios
{
    protected ProductoServicio $_productoServicio;
    protected PrecioServicio $_precioServicio;

    public function __construct() {
        $this->iniciarServicios();
    }

    private function iniciarServicios()
    {
        $this->_productoServicio = new ProductoServicio(new RepoProducto());
        $this->_precioServicio = new PrecioServicio(new RepoPrecio());
    }

    public function _getProductoServicio() : ProductoServicio {
        return $this->_productoServicio;
    }

    public function _getPrecioServicio() : PrecioServicio {
        return $this->_precioServicio;
    }
}

?>