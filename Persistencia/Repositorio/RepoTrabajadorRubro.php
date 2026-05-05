<?php
require_once "./Dominio/Repositorio/IRepoTrabajadorRubro.php";
require_once "./Dominio/Entidades/TrabajadorRubro.php";

class RepoTrabajadorRubro implements IRepoTrabajadorRubro
{
    protected ConexionMySQL $_conn;
    protected $_db;
    protected RespuestaRepositorio $_resRepo;

    public function __construct() {
        $this->_conn = new ConexionMySQL();
        $this->_resRepo = new RespuestaRepositorio();
    }

    public function _crear(TrabajadorRubro $entidad) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear rubro";
        } else {
            $Consulta = "INSERT INTO trabajadorrubro
            VALUES (null, false, curtime(), curtime(), " . $entidad->_trabajadorId .", " . $entidad->_rubroId . ")";
            try {
                $sql = $res->conexion->prepare($Consulta);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $this->_resRepo->mensajes[] = "Rubro creado con exito";
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
            
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }
    public function _modificar(TrabajadorRubro $entidad) : RespuestaRepositorio{}

    public function _eliminar(int $id) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear trabajador";
        } else {
            $Consulta = "UPDATE trabajadorrubro
            SET borrado = true,
            fechaModif = curtime()
            WHERE id = " . $id;
            try {
                $sql = $res->conexion->prepare($Consulta);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $this->_resRepo->mensajes[] = "Rubro eliminado con exito";
            } catch (\Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
            
        }
        $this->_conn->disconnect();
        return ($this->_resRepo);
    }

    public function _getById(int $id) : RespuestaRepositorio{}
    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio{}
    public function _getCantidad() : RespuestaRepositorio{}

    public function _getRubrosByTrabajadorId(int $id) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de rubros";
        } else {
            $Consulta = "SELECT trabajadorrubro.id, rubros.id as rubroId, rubros.descripcion
            FROM trabajadorrubro INNER JOIN trabajadores INNER JOIN rubros
            WHERE trabajadorrubro.trabajadorId = trabajadores.id
            AND trabajadorrubro.rubroId = rubros.id
            AND trabajadorrubro.borrado = false
            AND trabajadorrubro.trabajadorId = " . $id;
            $sql = $res->conexion->prepare($Consulta);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $respuestaBase = $sql->fetchAll();
            $this->_resRepo->resultado = $respuestaBase;
        }
        return ($this->_resRepo);
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