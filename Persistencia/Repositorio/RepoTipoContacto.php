<?php
require_once("./Dominio/Repositorio/IRepoTipoContacto.php");

class RepoTipoContacto implements IRepoTipoContacto
{
    protected ConexionMySQL $_conn;
    protected $_db;
    protected RespuestaRepositorio $_resRepo;

    public function __construct() {
        $this->_conn = new ConexionMySQL();
        $this->_resRepo = new RespuestaRepositorio();
    }

    public function _crear(TipoContacto $entidad) : RespuestaRepositorio {
        return new RespuestaRepositorio();
    }

    public function _modificar(TipoContacto $entidad) : RespuestaRepositorio {
        return new RespuestaRepositorio();
    }

    public function _eliminar(int $id) : RespuestaRepositorio {
        return new RespuestaRepositorio();
    }

    public function _getById(int $id) : RespuestaRepositorio {
        return new RespuestaRepositorio();
    }

    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio {
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de tipos";
        } else {
            $Consulta = "SELECT * FROM tipocontacto
            WHERE borrado = false
            LIMIT " . $desde . ","  . $cantidad;
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

    public function _getCantidad() : RespuestaRepositorio {
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar la cantidad de Tipos";
        } else {
            $Consulta = "SELECT count(*) as cantidad
            FROM tipocontacto
            WHERE borrado = false";
            $sql = $res->conexion->prepare($Consulta);
            try {
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $this->_resRepo->resultado = $respuestaBase[0]["cantidad"];
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }

    private function _MapearEntidad($respuestaBase) : TipoContacto
    {
        $t = new TipoContacto();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaModif'];
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