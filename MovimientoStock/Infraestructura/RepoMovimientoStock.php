<?php
require_once "./MovimientoStock/Dominio/IRepoMovimientoStock.php";
require_once "./MovimientoStock/Dominio/MovimientoStock.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";
require_once "./Utiles/Infraestructura/RepoBase.php";

class RepoMovimientoStock extends RepoBase implements IRepoMovimientoStock
{
    public function _nuevo(MovimientoStock $movStock) : RespuestaRepositorio{
        return $this->_resRepo;
    }
    public function _modificar(MovimientoStock $movStock) : RespuestaRepositorio{
        return $this->_resRepo;
    }
    public function _eliminar(int $id) : RespuestaRepositorio{
        return $this->_resRepo;
    }

    public function _getById(int $id) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de tipos de stock";
        } else {
            $Consulta = "SELECT * FROM movimientostock WHERE id = " . $id;
            $sql = $res->conexion->prepare($Consulta);
            try {
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $listaMapeada = [];
                foreach ($respuestaBase as $key){
                    $listaMapeada[] = $this->_MapearEntidad($key);
                }
                $this->_resRepo->resultado = $listaMapeada;
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->_resRepo;
    }

    public function _getTodo() : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de tipos de stock";
        } else {
            $Consulta = "SELECT * FROM movimientoStock";
            $sql = $res->conexion->prepare($Consulta);
            try {
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $listaMapeada = [];
                foreach ($respuestaBase as $key){
                    $listaMapeada[] = $this->_MapearEntidad($key);
                }
                $this->_resRepo->resultado = $listaMapeada;
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->_resRepo;
    }

    public function _getMovsById(int $id) : RespuestaRepositorio {
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de tipos de stock";
        } else {
            $Consulta = "SELECT * FROM movimientostock WHERE stockId = " . $id . " order by id desc";
            $sql = $res->conexion->prepare($Consulta);
            try {
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $listaMapeada = [];
                foreach ($respuestaBase as $key){
                    $listaMapeada[] = $this->_MapearEntidad($key);
                }
                $this->_resRepo->resultado = $listaMapeada;
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->_resRepo;
    }

    private function _MapearEntidad($respuestaBase) : MovimientoStock
    {
        $t = new MovimientoStock();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaMod'];
        $t->_stockId = $respuestaBase['stockId'];
        $t->_cantidad = $respuestaBase['cantidad'];
        $t->_tipoMovimientoId = $respuestaBase['tipoMovId'];
        $t->_motivoMovId = $respuestaBase['motivoMovId'];
        return $t;
    }
}
?>