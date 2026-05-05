<?php
require_once "./Dominio/Repositorio/IRepoSugerencia.php";

class RepoSugerencia implements IRepoSugerencia
{
    protected ConexionMySQL $conn;
    protected $db;
    protected RespuestaRepositorio $resRepo;

    public function __construct() {
        $this->conn = new ConexionMySQL();
        $this->resRepo = new RespuestaRepositorio();
    }

    public function _crear(Sugerencia $entidad) : RespuestaRepositorio{
        $res = $this->conn->connect();
        if ($this->checkErrores($res->errores)) {
            $this->resRepo->errores[] = "Error al modificar usuario";
        } else {
            try {
                $consulta = "INSERT INTO sugerencias
                VALUES (null, false, :descripcion, false, :usuarioId, curtime(), curtime());";
                $servicio = $res->conexion->prepare($consulta);
                $servicio->bindValue(":descripcion", $entidad->_descripcion);
                $servicio->bindValue(":usuarioId", $entidad->_usuarioId);
                $servicio->execute();
                $this->resRepo->mensajes[] = "Creacion exitosa";
            } catch (Throwable $th) {
                $this->resRepo->errores[] = $th->getMessage();
            }
        }
        $this->conn->disconnect();
        return $this->resRepo;
    }

    public function _modificar(Sugerencia $entidad) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }

    public function _eliminar(int $id) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }

    public function _getById(int $id) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }

    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }

    public function _getCantidad() : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }

    private function checkErrores($listaErrores){
        $hayErrores = null;
        if (count($listaErrores)  > 0) {
            foreach ($listaErrores as $e) {
                $this->resRepo->errores[] = $e;
            };
            $hayErrores = true;
        } else{
            $hayErrores = false;
        }
        return ($hayErrores);
    }
}
?>