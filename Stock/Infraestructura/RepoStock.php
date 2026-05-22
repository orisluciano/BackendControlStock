<?php
require_once "./Stock/Dominio/IRepoStock.php";
require_once "./Stock/Dominio/Stock.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";
require_once "./Utiles/Infraestructura/RepoBase.php";

class RepoStock extends RepoBase implements IRepoStock
{
    public function _crear(Stock $entidad) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear stock";
        } else {
            try {
                $consulta = "INSERT INTO stock VALUES (null, curtime(), curtime(), false, 0, :minimo, :maximo, :productoId, :tipoStockId)";
                $servicio = $res->conexion->prepare($consulta);
                $servicio->bindValue(":minimo", $entidad->_minimo);
                $servicio->bindValue(":maximo", $entidad->_maximo);
                $servicio->bindValue(":productoId", $entidad->_productoId);
                $servicio->bindValue(":tipoStockId", $entidad->_tipoStockId);
                $servicio->execute();
                $this->_resRepo->mensajes[] = "Creacion exitosa";
            } catch (Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->_resRepo;
    }
    public function _modificar(Stock $entidad) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear stock";
        } else {
            try {
                $consulta = "UPDATE stock SET 
                fechaMod = curtime(), actual = :actual, minimo = :minimo, maximo = :maximo, tipoStockId = :tipoStockId
                WHERE id = :id";
                $servicio = $res->conexion->prepare($consulta);
                $servicio->bindValue(":actual", $entidad->_actual);
                $servicio->bindValue(":minimo", $entidad->_minimo);
                $servicio->bindValue(":maximo", $entidad->_maximo);
                $servicio->bindValue(":tipoStockId", $entidad->_tipoStockId);
                $servicio->bindValue(":id", $entidad->_id);
                $servicio->execute();
                $this->_resRepo->mensajes[] = "Modiicacion exitosa";
            } catch (Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->_resRepo;
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
        $t->_tipoStockId = $respuestaBase['tipoStockId'];
        return $t;
    }
}
?>