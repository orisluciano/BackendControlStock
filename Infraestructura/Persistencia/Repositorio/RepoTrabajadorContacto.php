<?php
require_once "./Dominio/Repositorio/IRepoTrabajadorContacto.php";

class RepoTrabajadorContacto implements IRepoTrabajadorContacto
{
    protected ConexionMySQL $_conn;
    protected $_db;
    protected RespuestaRepositorio $_resRepo;

    public function __construct() {
        $this->_conn = new ConexionMySQL();
        $this->_resRepo = new RespuestaRepositorio();
    }

    public function _getTrabajadorContactoById(int $id) : RespuestaRepositorio {
        return new RespuestaRepositorio();
    }

    public function _getTrabajadoresContactos(int $desde, int $cantidad) : RespuestaRepositorio {
        return new RespuestaRepositorio();
    }

    public function _getCantidad() : RespuestaRepositorio {
        return new RespuestaRepositorio();
    }

    public function _getContactosByTrabajadorId(int $id) : RespuestaRepositorio {
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de contactos";
        } else {
            $Consulta = "SELECT trabajadorcontacto.id, trabajadorcontacto.descripcion, tipoContacto.descripcion as tipoContacto
            FROM trabajadorcontacto INNER JOIN trabajadores INNER JOIN tipoContacto
            WHERE trabajadorcontacto.trabajadorId = trabajadores.id
            AND trabajadorcontacto.tipoContactoId = tipoContacto.id
            AND trabajadorcontacto.trabajadorId = " . $id .
            " AND trabajadorcontacto.borrado = false";
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
    public function _nuevoTrabajadorContacto(TrabajadorContacto $trabajadorContacto) : RespuestaRepositorio {
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear trabajador";
        } else {
            $Consulta = "INSERT INTO trabajadorcontacto
            VALUES(null, false, curtime(), curtime()," . $trabajadorContacto->_trabajadorId . ", '" . $trabajadorContacto->_descripcion ."'," . $trabajadorContacto->_tipoContactoId . ")";
            try {
                $sql = $res->conexion->prepare($Consulta);
                $sql->execute();
                $id = $res->conexion->lastInsertId();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $this->_resRepo->resultado = $id;
                $this->_resRepo->mensajes[] = "Contacto creado con exito";
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
            
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }

    public function _modificarTrabajadorContacto(TrabajadorContacto $trabajadorContacto) : RespuestaRepositorio {
        return new RespuestaRepositorio();
    }

    public function _eliminarTrabajadorContacto(int $id) : RespuestaRepositorio {
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al eliminar contacto";
        } else {
            $Consulta = "UPDATE trabajadorcontacto
            SET borrado = true,
            fechaModif = curtime()
            WHERE id = " . $id;
            try {
                $sql = $res->conexion->prepare($Consulta);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $this->_resRepo->mensajes[] = "Contacto eliminado con exito";
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
            
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }
    
    private function _MapearEntidad($respuestaBase) : TrabajadorContacto
    {
        $t = new TrabajadorContacto();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaModif'];
        $t->_trabajadorId = $respuestaBase['trabajadorId'];
        $t->_tipoContactoId = $respuestaBase['tipoContactoId'];
        $t->_descripcion = $respuestaBase['descripcion'];
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