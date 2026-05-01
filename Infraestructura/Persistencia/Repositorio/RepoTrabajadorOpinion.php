<?php
require_once "./Dominio/Repositorio/IRepoTrabajadorOpinion.php";

class RepoTrabajadorOpinion implements IRepoTrabajadorOpinion
{
    protected ConexionMySQL $_conn;
    protected $_db;
    protected RespuestaRepositorio $_resRepo;

    public function __construct() {
        $this->_conn = new ConexionMySQL();
        $this->_resRepo = new RespuestaRepositorio();
    }

    public function _getTrabajadorOpinionById(int $id) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
    public function _getTrabajadoresOpiniones(int $desde, int $cantidad) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
    public function _getCantidad() : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
    public function _getOpinionesByTrabajadorId(int $id, int $desde, int $cantidad) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de rubros";
        } else {
            /*$Consulta = "SELECT trabajadorcontacto.id, trabajadorcontacto.descripcion
            FROM trabajadorcontacto INNER JOIN trabajadores
            WHERE trabajadorcontacto.trabajadorId = trabajadores.id
            AND trabajadorcontacto.trabajadorId = " . $id;*/
            $Consulta = "SELECT *
            FROM trabajadoropinion
            WHERE borrado = false
            AND trabajadoropinion.trabajadorId = " . $id .
            " LIMIT " . $desde . ", "  . $cantidad;
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
        return new RespuestaRepositorio();
    }
    public function _nuevoTrabajadorOpinion(TrabajadorOpinion $tOpi) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear trabajador";
        } else {
            $Consulta = "INSERT INTO trabajadoropinion 
            VALUES (null, false,current_time(), current_time()," . $tOpi->_trabajadorId . ", '" .  $tOpi->_opinion . "', " . $tOpi->_calificacion . ", " . $tOpi->_usuarioId . ")";
            try {
                $sql = $res->conexion->prepare($Consulta);
                $sql->execute();
                $id = $res->conexion->lastInsertId();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $this->_resRepo->resultado = $id;
                $this->_resRepo->mensajes[] = "Opinion creada con exito";
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
            
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }
    public function _modificarTrabajadorOpinion(TrabajadorOpinion $trabajadorContacto) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
    public function _eliminarTrabajadorOpinion(int $id) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }

    private function _MapearEntidad($respuestaBase) : TrabajadorRubro
    {
        $t = new TrabajadorRubro();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaModif'];
        $t->_trabajadorId = $respuestaBase['trabajadorId'];
        $t->_rubroId = $respuestaBase['rubroId'];
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