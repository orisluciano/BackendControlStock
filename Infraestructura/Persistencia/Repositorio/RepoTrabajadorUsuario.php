<?php
require_once "./Dominio/Repositorio/IRepoTrabajadorUsuario.php";

class RepoTrabajadorUsuario implements IRepoTrabajadorUsuario
{
    protected ConexionMySQL $_conn;
    protected $_db;
    protected RespuestaRepositorio $_resRepo;

    public function __construct() {
        $this->_conn = new ConexionMySQL();
        $this->_resRepo = new RespuestaRepositorio();
    }

    public function _getTrabajadorUsuarioById(int $id) : RespuestaRepositorio{
        return new RespuestaRepositorio;
    }

    public function _getTrabajadoresUsuarios(int $desde, int $cantidad) : RespuestaRepositorio {
        return new RespuestaRepositorio;
    }

    public function _getCantidad() : RespuestaRepositorio {
        return new RespuestaRepositorio;
    }

    public function _getTrabajadorByUsuarioId(int $id) : RespuestaRepositorio {
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de rubros";
        } else {
            $Consulta = "SELECT *
            FROM c2740163_labyadb.trabajadorusuario
            WHERE usuarioId =" . $id . "
            AND borrado = false";
            try {
                $sql = $res->conexion->prepare($Consulta);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $this->_resRepo->resultado = $respuestaBase;
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
            
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }

    public function _nuevoTrabajadorUsuario(TrabajadorUsuario $trabajadorUsuario) : RespuestaRepositorio {
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear trabajador";
        } else {
            $Consulta = "INSERT INTO trabajadorusuario
            VALUES (null, false, curtime(), curtime()," . $trabajadorUsuario->_usuarioId . ", " . $trabajadorUsuario->_trabajadorId . ")";
            try {
                $sql = $res->conexion->prepare($Consulta);
                $sql->execute();
                $id = $res->conexion->lastInsertId();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $this->_resRepo->resultado = $id;
                $this->_resRepo->mensajes[] = "TrabajadorUsuario creado con exito";
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
            
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }

    public function _modificarTrabajadorUsuario(TrabajadorUsuario $trabajadorUsuario) : RespuestaRepositorio {
        return new RespuestaRepositorio;
    }

    public function _eliminarTrabajadorUsuario(int $id) : RespuestaRepositorio {
        return new RespuestaRepositorio;
    }

    private function _MapearEntidad($respuestaBase) : TrabajadorUsuario
    {
        $t = new TrabajadorUsuario();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaModif'];
        $t->_trabajadorId = $respuestaBase['trabajadorId'];
        $t->_usuarioId = $respuestaBase['usuarioId'];
        return $t;
    }

    private function _checkErrores($listaErrores) : bool{
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