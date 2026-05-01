<?php
require_once "./Aplicacion/Interfaces/ISugerenciaServicio.php";
require_once "./Dominio/Entidades/Sugerencia.php";

class SugerenciaServicio implements ISugerenciaServicio
{
    protected IRepoSugerencia $_repo;
    protected RespuestaServicioDatos $_respuesta;

    public function __construct(IRepoSugerencia $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
    }

    public function _getSugerenciasById(int $id) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }

    public function _getSugerencias(int $desde, int $cantidad) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }

    public function _getCantidad() : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }

    public function _nuevo(SugerenciaDTO $sugerencia) : RespuestaServicioDatos{
        $nuevo = new Sugerencia();
        $nuevo->_descripcion = $sugerencia->descripcion;
        $nuevo->_usuarioId = $sugerencia->usuarioId;
        $resRepo = $this->_repo->_crear($nuevo);
        $this->_respuesta->errores = $resRepo->errores;
        $this->_respuesta->mensajes = $resRepo->mensajes;
        return $this->_respuesta;
    }

    public function _modificar(SugerenciaDTO $sugerencia) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }

    public function _eliminar(int $id) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }
}
?>