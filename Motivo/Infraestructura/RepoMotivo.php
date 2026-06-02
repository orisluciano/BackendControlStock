<?php
require_once "./Motivo/Dominio/IRepoMotivo.php";
require_once "./Motivo/Dominio/Motivo.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";
require_once "./Utiles/Infraestructura/RepoBase.php";

class RepoMotivo extends RepoBase implements IRepoMotivo
{
    public function _crear(Motivo $motivo) : RespuestaRepositorio{
        return $this->_resRepo;
    }
    public function _modificar(Motivo $motivo) : RespuestaRepositorio{
        return $this->_resRepo;
    }
    public function _eliminar(int $id) : RespuestaRepositorio{
        return $this->_resRepo;
    }
    public function _getById(int $id) : RespuestaRepositorio{
        return $this->_resRepo;
    }
    public function _getTodo() : RespuestaRepositorio{
        return $this->_resRepo;
    }

    private function _MapearEntidad($respuestaBase) : Motivo
    {
        $t = new Motivo();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaMod'];
        $t->_productoId = $respuestaBase['productoId'];
        $t->_minimo = $respuestaBase['minimo'];
        $t->_maximo = $respuestaBase['maximo'];
        $t->_actual = $respuestaBase['actual'];
        $t->_tipoStockId = $respuestaBase['tipoStockId'];
        return $t;
    }
}
?>