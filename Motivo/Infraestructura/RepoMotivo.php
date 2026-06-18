<?php
require_once "./Motivo/Dominio/IRepoMotivo.php";
require_once "./Motivo/Dominio/Motivo.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";
require_once "./Utiles/Infraestructura/RepoBase.php";

class RepoMotivo extends RepoBase implements IRepoMotivo
{
    public function _crear(Motivo $motivo) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear motivo";
        } else {
            try {
                $consulta = "INSERT INTO motivomovimiento
                VALUES (null, curtime(), curtime(), 0, :tipo, :descripcion)";
                $servicio = $res->conexion->prepare($consulta);
                $servicio->bindValue(":tipo", $motivo->_tipo);
                $servicio->bindValue(":descripcion", $motivo->_descripcion);
                $servicio->execute();
                $this->_resRepo->mensajes[] = "Creacion exitosa";
            } catch (Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->_resRepo;
    }

    public function _modificar(Motivo $motivo) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al modificar motivo";
        } else {
            try {
                $consulta = "UPDATE motivomovimiento
                SET descripcion = :descripcion, tipo = :tipo
                WHERE id = :id";
                $servicio = $res->conexion->prepare($consulta);
                $servicio->bindValue(":id", $motivo->_id);
                $servicio->bindValue(":tipo", $motivo->_tipo);
                $servicio->bindValue(":descripcion", $motivo->_descripcion);
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
            $this->_resRepo->errores[] = "Error al eliminar motivo";
        } else {
            try {
                $consulta = "UPDATE motivomovimiento
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
        return $this->_resRepo;
    }

    public function _getTodo() : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de tipos de stock";
        } else {
            $Consulta = "SELECT * FROM motivomovimiento WHERE borrado = false";
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

    private function _MapearEntidad($respuestaBase) : Motivo
    {
        $t = new Motivo();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaMod'];
        $t->_descripcion = $respuestaBase['descripcion'];
        $t->_tipo = $respuestaBase['tipo'];
        return $t;
    }
}
?>