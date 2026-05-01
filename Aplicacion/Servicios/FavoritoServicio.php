<?php
require_once "./Aplicacion/Interfaces/IFavoritoServicio.php";
require_once "./Aplicacion/Servicios/Respuestas/RespuestaServicioDatos.php";
require_once "./Aplicacion/DTO/FavoritoDTO.php";
require_once "./Dominio/Entidades/Favorito.php";

class FavoritoServicio implements IFavoritoServicio{
    protected IRepoFavorito $_repo;
    protected RespuestaServicioDatos $_respuesta;

    public function __construct(IRepoFavorito $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
    }

    public function _nuevo(FavoritoDTO $favorito) : RespuestaServicioDatos{
        $nuevo = new Favorito();
        $nuevo->_etiqueta = $favorito->etiqueta;
        $nuevo->_descripcion = $favorito->descripcion;
        $nuevo->_usuarioId = $favorito->usuarioId;
        $nuevo->_trabajadorId = $favorito->trabajadorId;
        $resRepo = $this->_repo->_crear($nuevo);
        $this->_respuesta->errores = $resRepo->errores;
        $this->_respuesta->mensajes = $resRepo->mensajes;
        return $this->_respuesta;
    }

    public function _modificar(FavoritoDTO $favorito) : RespuestaServicioDatos{return $this->_respuesta;}
    public function _eliminar($id) : RespuestaServicioDatos{return $this->_respuesta;}
    public function _getById(int $id) : RespuestaServicioDatos{return $this->_respuesta;}

    public function _getFavoritos(int $desde, int $cantidad) : RespuestaServicioDatos{
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

    public function _getCantidad() : RespuestaServicioDatos{
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

    public function _getByUsuario(int $id): RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getByUsuario($id);
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

    private function _MapearDtoEntidad(FavoritoDTO $dto) : Favorito {
        $t = new Favorito();
        $t->_id = $dto->id;
        $t->_fechaCreacion = $dto->fechaCreacion;
        $t->_fechaModif = $dto->fechaModif;
        $t->_etiqueta = $dto->etiqueta;
        $t->_descripcion = $dto->descripcion;
        $t->_usuarioId = $dto->usuarioId;
        $t->_trabajadorId = $dto->trabajadorId;
        return $t;
    }

    private function _MapearEntidadDto(Favorito $entidad) : FavoritoDTO {
        $dto = new FavoritoDTO();
        $dto->id = $entidad->_id;
        $dto->fechaCreacion = $entidad->_fechaCreacion;
        $dto->fechaModif = $entidad->_fechaModif;
        $dto->etiqueta = $entidad->_etiqueta;
        $dto->descripcion = $entidad->_descripcion;
        $dto->usuarioId = $entidad->_usuarioId;
        $dto->trabajadorId = $entidad->_trabajadorId;
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