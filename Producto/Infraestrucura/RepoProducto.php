<?php
require_once "./Producto/Dominio/IRepoProducto.php";
require_once "./Producto/Dominio/Producto.php";
require_once "./Persistencia/Conexion/ConexionMySQL.php";
require_once "./Utiles/Dominio/RespuestaRepositorio.php";

class RepoProducto implements IRepoProducto
{
    protected ConexionMySQL $_conn;
    protected $_db;
    protected RespuestaRepositorio $_resRepo;

    public function __construct() {
        $this->_conn = new ConexionMySQL();
        $this->_resRepo = new RespuestaRepositorio();
    }

    public function _crear(Producto $entidad) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al crear producto";
        } else {
            try {
                $consulta = "INSERT INTO productos
                VALUES (null, 0, :nombre, :descripcion, :codSKU, 0, :tipoUsuarioId, curtime(), curtime())";
                $consulta = "INSERT INTO productos
                VALUES (null, curtime(), curtime(), 0, :nombre, :descripcion, :codigo, :tipoCodigo, :tipoProductoId)";
                $servicio = $res->conexion->prepare($consulta);
                $servicio->bindValue(":nombre", $entidad->_nombre);
                $servicio->bindValue(":descripcion", $entidad->_descripcion);
                $servicio->bindValue(":codigo", $entidad->_codigo);
                $servicio->bindValue(":tipoCodigo", $entidad->_tipoCodigo);
                $servicio->bindVAlue(":tipoProductoId", $entidad->_tipoProdId);
                $servicio->execute();
                $this->_resRepo->mensajes[] = "Creacion exitosa";
            } catch (Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->_resRepo;
    }
    public function _modificar(Producto $entidad) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al modificar producto";
        } else{
            $consulta = "update productos
            set nombre = :nombre, descripcion = :descripcion, codigo = :codigo, tipoCodigo = :tipoCodigo, tipoProdId = :tipoProductoId, fechaMod = curtime()
            where id = :id";
            try {
                $sql = $res->conexion->prepare($consulta);
                $sql->bindValue(":nombre", $entidad->_nombre);
                $sql->bindValue(":descripcion", $entidad->_descripcion);
                $sql->bindValue(":id", $entidad->_id);
                $sql->bindValue(":codigo", $entidad->_codigo);
                $sql->bindValue(":tipoCodigo", $entidad->_tipoCodigo);
                $sql->bindValue(":tipoProductoId", $entidad->_tipoProdId);
                $sql->execute();
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
            $this->_resRepo->errores[] = "Error al modificar producto";
        } else{
            $consulta = "update productos
            set borrado = true, fechaMod = curtime()
            where id = :id";
            try {
                $sql = $res->conexion->prepare($consulta);
                $sql->bindValue(":id", $id);
                $sql->execute();
                $this->_resRepo->mensajes[] = "Eliminacion exitosa";
            } catch (Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->_resRepo;
    }
    public function _getById(int $id) : RespuestaRepositorio{
        return new RespuestaRepositorio();
    }
    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de productos";
        } else {
            $Consulta = "SELECT * FROM productos
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
    public function _getCantidad() : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar la cantidad de productos";
        } else {
            $Consulta = "SELECT count(*) as cantidad
            FROM productos
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

    private function _MapearEntidad($respuestaBase) : Producto
    {
        $t = new Producto();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaMod'];
        $t->_nombre = $respuestaBase['nombre'];
        $t->_descripcion = $respuestaBase['descripcion'];
        $t->_codigo = $respuestaBase['codigo'];
        $t->_tipoCodigo = $respuestaBase['tipoCodigo'];
        $t->_tipoProdId = $respuestaBase['tipoProdId'];
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