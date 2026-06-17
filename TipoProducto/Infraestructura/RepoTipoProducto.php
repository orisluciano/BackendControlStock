<?php
require_once "./TipoProducto/Dominio/IRepoTipoProducto.php";
require_once "./TipoProducto/Dominio/TipoProducto.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";
require_once "./Utiles/Infraestructura/RepoBase.php";

class RepoTipoProducto extends RepoBase implements IRepoTipoProducto
{
    public function _crear(TipoProducto $TipoProducto) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear tipo de producto";
        } else {
            try {
                $consulta = "INSERT INTO tipoproducto
                VALUES (null, curtime(), curtime(), 0, :descripcion)";
                $servicio = $res->conexion->prepare($consulta);
                $servicio->bindValue(":descripcion", $TipoProducto->_descripcion);
                $servicio->execute();
                $this->_resRepo->mensajes[] = "Creacion exitosa";
            } catch (Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->_resRepo;
    }
    public function _modificar(TipoProducto $TipoProducto) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al modificar tipo de producto";
        } else {
            try {
                $consulta = "UPDATE tipoproducto
                SET descripcion = :descripcion
                WHERE id = :id";
                $servicio = $res->conexion->prepare($consulta);
                $servicio->bindValue(":id", $TipoProducto->_id);
                $servicio->bindValue(":descripcion", $TipoProducto->_descripcion);
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
            $this->_resRepo->errores[] = "Error al eliminar tipo de producto";
        } else {
            try {
                $consulta = "UPDATE tipoproducto
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
            $Consulta = "SELECT * FROM tipoproducto WHERE borrado = false";
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

    private function _MapearEntidad($respuestaBase) : TipoProducto
    {
        $t = new TipoProducto();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaMod'];
        $t->_descripcion = $respuestaBase['descripcion'];
        return $t;
    }
}
?>