<?php
require_once "./Dominio/Repositorio/IRepoFavorito.php";

class RepoFavorito implements IRepoFavorito
{
    protected ConexionMySQL $_conn;
    protected $_db;
    protected RespuestaRepositorio $_resRepo;

    public function __construct() {
        $this->_conn = new ConexionMySQL();
        $this->_resRepo = new RespuestaRepositorio();
    }

    public function _crear(Favorito $entidad) : RespuestaRepositorio {
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al modificar usuario";
        } else {
            try {
                $consulta = "INSERT INTO favoritos
                VALUES (null, false,  curtime(), curtime(), :etiqueta, :descripcion, :usuarioId, :trabajadorId);";
                $servicio = $res->conexion->prepare($consulta);
                $servicio->bindValue(":etiqueta", $entidad->_etiqueta);
                $servicio->bindValue(":descripcion", $entidad->_descripcion);
                $servicio->bindValue(":usuarioId", $entidad->_usuarioId);
                $servicio->bindValue(":trabajadorId", $entidad->_trabajadorId);
                $servicio->execute();
                $this->_resRepo->mensajes[] = "Creacion exitosa";
            } catch (Throwable $th) {
                $this->_resRepo->errores[] = $th->getMessage();
            }
        }
        $this->_conn->disconnect();
        return $this->_resRepo;
    }

    public function _modificar(Favorito $entidad) : RespuestaRepositorio {return $this->_resRepo;}
    public function _eliminar(int $id) : RespuestaRepositorio {return $this->_resRepo;}
    public function _getById(int $id) : RespuestaRepositorio {return $this->_resRepo;}

    public function _getTodo(int $desde, int $cantidad) : RespuestaRepositorio {
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de rubros";
        } else {
            $Consulta = "SELECT * FROM favoritos
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
            $this->_resRepo->errores[] = "Error al solicitar la cantidad de favoritos";
        } else {
            $Consulta = "SELECT count(*) as cantidad
            FROM favoritos
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

    public function _getByUsuario(int $id) : RespuestaRepositorio{
        $res = $this->_conn->connect();
        if ($this->_checkErrores($res->errores)) {
            $this->_resRepo->errores[] = "Error al solicitar lista de favoritos";
        } else {
            $Consulta = "SELECT * FROM favoritos
            WHERE borrado = false AND usuarioId = " . $id;
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

    private function _MapearEntidad($respuestaBase) : Favorito
    {
        $t = new Favorito();
        $t->_id = $respuestaBase['id'];
        $t->_borrado = $respuestaBase['borrado'];
        $t->_fechaCreacion = $respuestaBase['fechaCreacion'];
        $t->_fechaModif = $respuestaBase['fechaModif'];
        $t->_etiqueta = $respuestaBase['etiqueta'];
        $t->_descripcion = $respuestaBase['descripcion'];
        $t->_usuarioId = $respuestaBase['usuarioId'];
        $t->_trabajadorId = $respuestaBase['trabajadorId'];
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