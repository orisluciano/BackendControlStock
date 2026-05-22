<?php
require_once "ITipoStockServicio.php";
require_once "./Utiles/RespuestaServicioDatos.php";
require_once "TipoStockDTO.php";

class TipoStockServicio  implements ITipoStockServicio
{
    protected IRepoTipoStock $_repo;
    protected RespuestaServicioDatos $_respuesta;

    public function __construct(IRepoTipoStock $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
    }

    public function _nuevo(TipoStockDTO $stock) : RespuestaServicioDatos{
        return $this->_respuesta;
    }
    public function _modificar(TipoStockDTO $stock) : RespuestaServicioDatos{
        return $this->_respuesta;
    }
    public function _eliminar(int $id) : RespuestaServicioDatos{
        return $this->_respuesta;
    }
    public function _getById(int $id) : RespuestaServicioDatos{
        return $this->_respuesta;
    }
    public function _getTodo() : RespuestaServicioDatos{
        return $this->_respuesta;
    }   
}
?>