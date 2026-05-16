<?php
require_once "IPrecioServicio.php";
require_once "./Utiles/RespuestaServicioDatos.php";
require_once "PrecioDTO.php";

class PrecioServicio implements IPrecioServicio
{
    protected IRepoPrecio $_repo;
    protected RespuestaServicioDatos $_respuesta;

    public function __construct(IRepoPrecio $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
    }

    public function _nuevo(PrecioDTO $precio) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }
    public function _modificar(PrecioDTO $precio) : RespuestaServicioDatos{return new RespuestaServicioDatos();}
    public function _eliminar(int $id) : RespuestaServicioDatos{return new RespuestaServicioDatos();}
    public function _getById(int $id) : RespuestaServicioDatos{return new RespuestaServicioDatos();}
    public function _getPrecios(int $desde, int $cantidad) : RespuestaServicioDatos{return new RespuestaServicioDatos();}

    public function _getByIdFechas(int $id, string $desde, string $hasta) : RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        if (!is_numeric($id)) {
            $respuesta->errores[] = "Se proporciono un campo no numerico";
        }
        $resRepo = $this->_repo->_getByProductoId($id, $desde, $hasta);
        if ($this->_checkErrores($resRepo->errores)) {
            $respuesta->errores = $resRepo->errores;
            $respuesta->errores[] = "Error en el servicio";
        } else {
            $listaT = $resRepo->resultado;
            $listaMapeada = [];
            foreach ($listaT as $key) {
                $listaMapeada[] = $this->_MapearEntidadDto($key);
            }
            $respuesta->resultado = $listaMapeada;
        }
        return $respuesta;
    }
    
    public function _getCantidad() : RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getCantidad();
        $respuesta->resultado = $resRepo->resultado;
        $respuesta->errores = $resRepo->errores;
        return $respuesta;
    }

    public function _getUltimoById(int $id) : RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getUltimoById($id);
        if ($this->_checkErrores($resRepo->errores)) {
            $respuesta->errores = $resRepo->errores;
            $respuesta->errores[] = "Error en el servicio";
        } else {
            $listaT = $resRepo->resultado;
            if (count($listaT) > 0) {
                $listaMapeada = [];
                foreach ($listaT as $key) {
                    $listaMapeada[] = $this->_MapearEntidadDto($key);
                }
                $respuesta->resultado = $listaMapeada;
            } else {
                $respuesta->errores[] = "No hay resultados";
            }
        }
        return $respuesta;
    }

    private function _MapearDtoEntidad(PrecioDTO $dto) : Precio {
        $t = new Precio();
        $t->_id = $dto->id;
        $t->_fechaCreacion = $dto->fechaCreacion;
        $t->_fechaModif = $dto->fechaModif;
        $t->_costo = $dto->costo;
        $t->_venta = $dto->venta;
        $t->_productoId = $dto->productoId;
        return $t;
    }

    private function _MapearEntidadDto(Precio $entidad) : PrecioDTO {
        $dto = new PrecioDTO();
        $dto->id = $entidad->_id;
        $dto->fechaCreacion = $entidad->_fechaCreacion;
        $dto->fechaModif = $entidad->_fechaModif;
        $dto->costo = $entidad->_costo;
        $dto->venta = $entidad->_venta;
        $dto->productoId = $entidad->_productoId;
        return $dto;
    }

    private function _checkErrores($listaErrores){
        $hayErrores = null;
        if (count($listaErrores)  > 0) {
            $this->_respuesta->errores = $listaErrores;
            $hayErrores = true;
        } else{
            $hayErrores = false;
        }
        return ($hayErrores);
    }
}

?>