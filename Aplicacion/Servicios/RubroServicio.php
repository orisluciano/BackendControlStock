<?php
require_once "./Aplicacion/Interfaces/IRubroServicio.php";
require_once "./Aplicacion/Servicios/Respuestas/RespuestaServicioDatos.php";
require_once "./Aplicacion/DTO/RubroDTO.php";
require_once "./Dominio/Entidades/Rubro.php";

class RubroServicio implements IRubroServicio{
    protected IRepoRubro $_repo;
    protected RespuestaServicioDatos $_respuesta;

    public function __construct(IRepoRubro $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
    }

    public function _getRubroById($id){}
    public function _getRubros($desde, $cantidad){
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getTodo($desde, $cantidad);
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
    public function _getCantidad(){
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getCantidad();
        if ($this->_checkErrores($resRepo->errores)) {
            $respuesta->errores = $resRepo->errores;
            $respuesta->errores[] = "Error al obtenes cantidad de rubros";
        } else {
            $respuesta->resultado = $resRepo->resultado;
        }
        
        return $respuesta;
    }
    public function _nuevoRubro(RubroDTO $rubro){}
    public function _modificarRubro(RubroDTO $rubro){}
    public function _eliminarRubro($id){}

    private function _MapearDtoEntidad(RubroDTO $dto) : Rubro {
        $t = new Rubro();
        $t->_id = $dto->id;
        $t->_fechaCreacion = $dto->fechaCreacion;
        $t->_fechaModif = $dto->fechaModif;
        $t->_descripcion = $dto->descripcion;
        return $t;
    }

    private function _MapearEntidadDto(Rubro $entidad) : RubroDTO {
        $dto = new RubroDTO();
        $dto->id = $entidad->_id;
        $dto->fechaCreacion = $entidad->_fechaCreacion;
        $dto->fechaModif = $entidad->_fechaModif;
        $dto->descripcion = $entidad->_descripcion;
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