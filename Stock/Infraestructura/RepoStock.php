<?php
require_once "./Stock/Dominio/IRepoStock.php";
require_once "./Stock/Dominio/Stock.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";
require_once "./Utiles/Infraestructura/RepoBase.php";

class RepoStock extends RepoBase implements IRepoStock
{
    public function _crear(Stock $entidad) : RespuestaRepositorio{
        return new RespuestaRepositorio;
    }
    public function _modificar(Stock $entidad) : RespuestaRepositorio{
        return new RespuestaRepositorio;
    }
    public function _eliminar(int $id) : RespuestaRepositorio{
        return new RespuestaRepositorio;
    }
    public function _getById(int $id) : RespuestaRepositorio{
        return new RespuestaRepositorio;
    }
    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio{
        return new RespuestaRepositorio;
    }
    public function _getStockByProductoId(int $productoId) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de productos";
        } else {
            $Consulta = "SELECT * FROM stock
            WHERE productoId = " . $productoId;
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
        return ($this->_resRepo);
    }
    public function _getCantidad() : RespuestaRepositorio  {
        return new RespuestaRepositorio;
    }

    private function _MapearEntidad($respuestaBase) : Stock
    {
        $t = new Stock();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaMod'];
        $t->_productoId = $respuestaBase['productoId'];
        $t->_minimo = $respuestaBase['minimo'];
        $t->_maximo = $respuestaBase['maximo'];
        $t->_actual = $respuestaBase['actual'];
        $t->_tipoStock = $respuestaBase['tipoStockId'];
        return $t;
    }
}
?>