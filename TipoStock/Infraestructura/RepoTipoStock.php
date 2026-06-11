<?php
require_once "./TipoStock/Dominio/IRepoTipoStock.php";
require_once "./TipoStock/Dominio/TipoStock.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";
require_once "./Utiles/Infraestructura/RepoBase.php";

class RepoTipoStock extends RepoBase implements IRepoTipoStock
{
    public function _nuevo(TipoStock $tipoStock) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear tipo de stock";
        } else {
            try {
                $consulta = "INSERT INTO tipostock
                VALUES (null, curtime(), curtime(), 0, :descripcion)";
                $servicio = $res->conexion->prepare($consulta);
                $servicio->bindValue(":descripcion", $tipoStock->_descripcion);
                $servicio->execute();
                $this->_resRepo->mensajes[] = "Creacion exitosa";
            } catch (Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->_resRepo;
    }
    public function _modificar(TipoStock $tipoStock) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al modificar tipo de stock";
        } else {
            try {
                $consulta = "UPDATE tipostock
                SET descripcion = :descripcion
                WHERE id = :id";
                $servicio = $res->conexion->prepare($consulta);
                $servicio->bindValue(":id", $tipoStock->_id);
                $servicio->bindValue(":descripcion", $tipoStock->_descripcion);
                $servicio->execute();
                $this->_resRepo->mensajes[] = "Modificacion exitosa";
            } catch (Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->_resRepo;
    }
    public function _eliminar(int $id) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al modificar tipo de stock";
        } else {
            try {
                $consulta = "UPDATE tipostock
                SET borrado = true
                WHERE id = :id";
                $servicio = $res->conexion->prepare($consulta);
                $servicio->bindValue(":id", $id);
                $servicio->execute();
                $this->_resRepo->mensajes[] = "Eliminacion exitosa";
            } catch (Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->_resRepo;
    }

    public function _getById(int $id) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de tipos de stock";
        } else {
            $Consulta = "SELECT * FROM tipostock WHERE id = " . $id;
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
            $Consulta = "SELECT * FROM tipostock";
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

    private function _MapearEntidad($respuestaBase) : TipoStock
    {
        $t = new TipoStock();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaMod'];
        $t->_descripcion = $respuestaBase['descripcion'];
        return $t;
    }
}
?>