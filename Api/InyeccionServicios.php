<?php
require_once "./Producto/Aplicacion/ProductoServicio.php";
require_once "./Producto/Infraestrucura/RepoProducto.php";
require_once "./Precio/Aplicacion/PrecioServicio.php";
require_once "./Precio/Infraestructura/RepoPrecio.php";
require_once "./Stock/Aplicacion/StockServicio.php";
require_once "./Stock/Infraestructura/RepoStock.php";
require_once "./TipoStock/Aplicacion/TipoStockServicio.php";
require_once "./TipoStock/Infraestructura/RepoTipoStock.php";
require_once "./MovimientoStock/Aplicacion/MovimientoStockServicio.php";
require_once "./MovimientoStock/Infraestructura/RepoMovimientoStock.php";
require_once "./Motivo/Aplicacion/MotivoServicio.php";
require_once "./Motivo/Infraestructura/RepoMotivo.php";

class InyeccionServicios
{
    protected ProductoServicio $_productoServicio;
    protected PrecioServicio $_precioServicio;
    protected StockServicio $_stockServicio;
    protected TipoStockServicio $_tipoStockServicio;
    protected MovimientoStockServicio $_movStockServicio;
    protected MotivoServicio $_motivoSertvicio;

    public function __construct() {
        $this->iniciarServicios();
    }

    private function iniciarServicios()
    {
        $this->_productoServicio = new ProductoServicio(new RepoProducto());
        $this->_precioServicio = new PrecioServicio(new RepoPrecio());
        $this->_stockServicio = new StockServicio(new RepoStock());
        $this->_tipoStockServicio = new TipoStockServicio(new RepoTipoStock());
        $this->_movStockServicio = new MovimientoStockServicio(new RepoMovimientoStock());
        $this->_motivoSertvicio = new MotivoServicio(new RepoMotivo());
    }

    public function _getProductoServicio() : ProductoServicio {
        return $this->_productoServicio;
    }

    public function _getPrecioServicio() : PrecioServicio {
        return $this->_precioServicio;
    }

    public function _getStockServicio() : StockServicio {
        return $this->_stockServicio;
    }

    public function _getTipoStockServicio() : TipoStockServicio {
        return $this->_tipoStockServicio;
    }

    public function _getMovStockServicio() : MovimientoStockServicio {
        return $this->_movStockServicio;
    }

    public function _getMotivoServicio() : MotivoServicio {
        return $this->_getMotivoServicio();
    }
}

?>