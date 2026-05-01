<?php
require_once "./Dominio/Repositorio/IRepoTrabajador.php";
require_once "./Dominio/Entidades/Trabajador.php";

class RepoTrabajador implements IRepoTrabajador
{
    protected ConexionMySQL $_conn;
    protected $_db;
    protected RespuestaRepositorio $_resRepo;

    public function __construct() {
        $this->_conn = new ConexionMySQL();
        $this->_resRepo = new RespuestaRepositorio();
    }

    public function _crear(Trabajador $entidad) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear trabajador";
        } else {
            $Consulta = "INSERT INTO trabajadores
            VALUES (null, false, '" . $entidad->_nombre . "', '" . $entidad->_apellido . "', '". $entidad->_descripcion . "', curtime(), curtime())";
            try {
                $sql = $res->conexion->prepare($Consulta);
                $sql->execute();
                $id = $res->conexion->lastInsertId();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $this->_resRepo->resultado = $id;
                $this->_resRepo->mensajes[] = "Trabajador creado con exito";
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
            
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }

    public function _modificar(Trabajador $entidad) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear trabajador";
        } else {
            $Consulta = "UPDATE trabajadores
            SET nombre = '" . $entidad->_nombre ."',
            apellido = '" . $entidad->_apellido . "',
            descripcion = '" . $entidad->_descripcion . "',
            fechaModif = curtime()
            WHERE id = " . $entidad->_id;
            try {
                $sql = $res->conexion->prepare($Consulta);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $this->_resRepo->mensajes[] = "Trabajador modificado con exito";
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
            
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }

    public function _eliminar(int $id) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear trabajador";
        } else {
            $Consulta = "UPDATE trabajadores
            SET borrado = true,
            fechaModif = curtime()
            WHERE id = " . $id;
            try {
                $sql = $res->conexion->prepare($Consulta);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $this->_resRepo->mensajes[] = "Trabajador eliminado con exito";
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
            
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }

    public function _getById(int $id) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de trabajadores";
        } else {
            $Consulta = "SELECT * FROM trabajadores
            WHERE borrado = false
            AND id = " . $id . "";
            $sql = $res->conexion->prepare($Consulta);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $respuestaBase = $sql->fetchAll();
            $listaMapeada = [];
            foreach ($respuestaBase as $key){
                $listaMapeada[] = $this->_MapearEntidad($key);
            }
            $this->_resRepo->resultado = $listaMapeada;
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }

    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de trabajadores";
        } else {
            $Consulta = "SELECT * FROM trabajadores
            WHERE borrado = false
            LIMIT " . $desde . ","  . $cantidad;
            $sql = $res->conexion->prepare($Consulta);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $respuestaBase = $sql->fetchAll();
            $listaMapeada = [];
            foreach ($respuestaBase as $key){
                $listaMapeada[] = $this->_MapearEntidad($key);
            }
            $this->_resRepo->resultado = $listaMapeada;
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }

    public function _getCantidad() : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar la cantidad de trabajadores";
        } else {
            $Consulta = "SELECT count(*) as cantidad
            FROM trabajadores
            WHERE borrado = false";
            $sql = $res->conexion->prepare($Consulta);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $respuestaBase = $sql->fetchAll();
            $this->_resRepo->resultado = $respuestaBase[0]["cantidad"];
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }

    public function _getByRubro(int $desde, int $cantidad, int $rubroId) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de trabajadores";
        } else {
            $Consulta = "SELECT trabajadores.id, trabajadores.borrado, trabajadores.nombre, trabajadores.apellido, trabajadores.descripcion, trabajadores.fechaCreacion, trabajadores.fechaModif
            FROM trabajadores, trabajadorrubro
            where trabajadorrubro.trabajadorId = trabajadores.id
            and trabajadorrubro.rubroId = " . $rubroId . "
            and trabajadorrubro.borrado = false
            LIMIT " . $desde . ","  . $cantidad;
            $sql = $res->conexion->prepare($Consulta);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $respuestaBase = $sql->fetchAll();
            $listaMapeada = [];
            foreach ($respuestaBase as $key){
                $listaMapeada[] = $this->_MapearEntidad($key);
            }
            $this->_resRepo->resultado = $listaMapeada;
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }

    public function _getCantidadByRubro(int $rubroId) : RespuestaRepositorio {
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar la cantidad de trabajadores";
        } else {
            $Consulta = "SELECT count(*) as cantidad FROM trabajadores, trabajadorrubro
            where trabajadorrubro.trabajadorId = trabajadores.id
            and trabajadorrubro.rubroId = " . $rubroId . "
            and trabajadorrubro.borrado = false";
            $sql = $res->conexion->prepare($Consulta);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $respuestaBase = $sql->fetchAll();
            $this->_resRepo->resultado = $respuestaBase[0]["cantidad"];
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }

    private function _MapearEntidad($respuestaBase) : Trabajador
    {
        $t = new Trabajador();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaModif'];
        $t->_nombre = $respuestaBase['nombre'];
        $t->_apellido = $respuestaBase['apellido'];
        $t->_descripcion = $respuestaBase['descripcion'];
        return $t;
    }

    private function _checkErrores($listaErrores){
        $hayErrores = null;
        if (count($listaErrores)  > 0) {
            foreach ($listaErrores as $e) {
                $this->_resRepo->errores[] = $e;
            };
            $hayErrores = true;
        } else{
            $hayErrores = false;
        }
        return ($hayErrores);
    }
}

?>