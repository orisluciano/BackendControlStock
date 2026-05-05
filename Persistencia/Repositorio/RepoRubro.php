<?php
require_once "./Dominio/Repositorio/IRepoRubro.php";

class RepoRubro implements IRepoRubro
{
    protected ConexionMySQL $_conn;
    protected $_db;
    protected RespuestaRepositorio $_resRepo;

    public function __construct() {
        $this->_conn = new ConexionMySQL();
        $this->_resRepo = new RespuestaRepositorio();
    }

    public function _crear(Rubro $entidad){}
    public function _modificar(Rubro $entidad){}
    public function _eliminar(int $id){}
    public function _getById(int $id){}

    public function _getTodo(int $desde, int $cantidad){
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de rubros";
        } else {
            $Consulta = "SELECT * FROM rubros
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

    public function _getCantidad(){
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar la cantidad de rubros";
        } else {
            $Consulta = "SELECT count(*) as cantidad
            FROM rubros
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

    private function _MapearEntidad($respuestaBase) : Rubro
    {
        $t = new Rubro();
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