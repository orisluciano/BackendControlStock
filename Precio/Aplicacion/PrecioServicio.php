<?php
require_once "IPrecioServicio.php";
require_once "./Utiles/RespuestaServicioDatos.php";
require_once "ProductoDTO.php";

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
    public function _getByIdFechas(int $id, string $desde, string $hasta) : RespuestaServicioDatos{return new RespuestaServicioDatos();}
    
    public function _getCantidad() : RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getCantidad();
        $respuesta->resultado = $resRepo->resultado;
        $respuesta->errores = $resRepo->errores;
        return $respuesta;
    }

    private function _MapearDtoEntidad(ProductoDTO $dto) : Producto {
        $t = new Producto();
        $t->_id = $dto->id;
        $t->_fechaCreacion = $dto->fechaCreacion;
        $t->_fechaModif = $dto->fechaModif;
        $t->_nombre = $dto->nombre;
        $t->_codSKU = $dto->codSKU;
        $t->_descripcion = $dto->descripcion;
        $t->_tipoProdId = $dto->tipoProdId;
        return $t;
    }

    private function _MapearEntidadDto(Producto $entidad) : ProductoDTO {
        $dto = new ProductoDTO();
        $dto->id = $entidad->_id;
        $dto->fechaCreacion = $entidad->_fechaCreacion;
        $dto->fechaModif = $entidad->_fechaModif;
        $dto->nombre = $entidad->_nombre;
        $dto->codSKU = $entidad->_codSKU;
        $dto->descripcion = $entidad->_descripcion;
        $dto->tipoProdId = $entidad->_tipoProdId;
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