<?php
require_once "./TipoStock/Dominio/IRepoTipoStock.php";
require_once "./TipoStock/Dominio/TipoStock.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";
require_once "./Utiles/Infraestructura/RepoBase.php";

class RepoTipoStock extends RepoBase implements IRepoTipoStock
{
    public function _nuevo(TipoStock $tipoStock) : RespuestaRepositorio{
        return $this->_resRepo;
    }
    public function _modificar(TipoStock $tipoStock) : RespuestaRepositorio{
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
}
?>