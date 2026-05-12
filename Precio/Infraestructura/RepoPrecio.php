<?php
require_once "./Precio/Dominio/IRepoPrecio.php";
require_once "./Precio/Dominio/Precio.php";
require_once "./Persistencia/Conexion/ConexionMySQL.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";

final class RepoPrecio implements IRepoPrecio
{
    protected ConexionMySQL $_conn;
    protected $_db;
    protected RespuestaRepositorio $_resRepo;

    public function __construct() {
        $this->_conn = new ConexionMySQL();
        $this->_resRepo = new RespuestaRepositorio();
    }

    public function _crear(Precio $precio) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
    public function _modificar(Precio $precio) : RespuestaRepositorio{
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
    public function _getByProductoId(int $productoId, string $desde, string $hasta) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de productos";
        } else {
            /*$Consulta = "SELECT * FROM productos
            WHERE borrado = false
            LIMIT " . $desde . ","  . $cantidad;*/
            $Consulta = "SELECT * FROM precios
            WHERE fechaMod >= '" . $desde . "' AND fechaMod <= '" . $hasta . "' AND productoId = " . $productoId;
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

    private function _MapearEntidad($respuestaBase) : Precio
    {
        $t = new Precio();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaMod'];
        $t->_productoId = $respuestaBase['productoId'];
        $t->_costo = $respuestaBase['costo'];
        $t->_venta = $respuestaBase['venta'];
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