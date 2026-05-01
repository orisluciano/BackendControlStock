<?php
require_once "./Infraestructura/Persistencia/Conexion/ConexionMySQL.php";
require_once "./Dominio/Repositorio/IRepoUsuario.php";
require_once "./Infraestructura/Persistencia/Repositorio/RespuestaRepo.php";

class RepoUsuario implements IRepoUsuario{
    protected ConexionMySQL $conn;
    protected $db;
    protected RespuestaRepositorio $resRepo;

    public function __construct() {
        $this->conn = new ConexionMySQL();
        $this->resRepo = new RespuestaRepositorio();
    }

    public function crear(Usuario $usuario){
        $res = $this->conn->connect();
        if ($this->checkErrores($res->errores)) {
            $this->resRepo->errores[] = "Error al modificar usuario";
        } else {
            try {
                /*$consulta = "INSERT INTO usuarios
                VALUES(null, 0, :usuario, :pass, 0, :tipoUsuarioId)";*/
                $consulta = "INSERT INTO usuarios
                VALUES (null, 0, :usuario, :pass, :mail, 0, :tipoUsuarioId, curtime(), curtime())";
                $servicio = $res->conexion->prepare($consulta);
                $servicio->bindValue(":usuario", $usuario->_usuario);
                $servicio->bindValue(":pass", $usuario->_pass);
                $servicio->bindValue(":tipoUsuarioId", $usuario->_tipoUsuarioId);
                $servicio->bindVAlue("mail", $usuario->_mail);
                $servicio->execute();
                $this->resRepo->mensajes[] = "Creacion exitosa";
            } catch (Throwable $th) {
                $this->resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->resRepo;
    }

    public function modificar(Usuario $usuario){
        $res = $this->conn->connect();
        if ($this->checkErrores($res->errores)) {
            $this->resRepo->errores[] = "Error al modificar usuario";
        } else{
            $consulta = "update usuarios
            set usuario = :usuario, password = :pass, mail = :mail
            where id = :id";
            try {
                $sql = $res->conexion->prepare($consulta);
                $sql->bindValue(":usuario", $usuario->_usuario);
                $sql->bindValue(":pass", $usuario->_pass);
                $sql->bindValue(":id", $usuario->_id);
                $sql->bindValue(":mail", $usuario->_mail);
                $sql->execute();
                $this->resRepo->mensajes[] = "Modificacion exitosa";
            } catch (Throwable $th) {
                $this->resRepo->errores[] = $th->getMessage();
            }
        }
        return $this->resRepo;
    }

    public function eliminar(int $id){
        try {
            $consulta = "update usuarios
            set borrado = true
            where id = :id";
            $servicio = $this->db->prepare($consulta);
            $servicio->bindValue(":id", $id);
            $servicio->execute();
            return(array("resultado" => "Eliminacion exitosa", "errores" => array()));
        } catch (Throwable $th) {
            return(array("resultado" => null, "errores" => "Algo fallo"));
        }
    }

    public function getById(int $id){
        $res = $this->conn->connect();
        if ($this->checkErrores($res->errores)) {
            $this->resRepo->errores[] = "Error al solicitar usuarios";
        } else {
            $Consulta = "SELECT * FROM usuarios
            WHERE borrado = false
            AND id = " . $id;
            $sql = $res->conexion->prepare($Consulta);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $respuestaBase = $sql->fetchAll();
            $listaMapeada = [];
            foreach ($respuestaBase as $key){
                $listaMapeada[] = $this->MapearEntidad($key);
            }
            $this->resRepo->resultado = $listaMapeada;
        }
        return $this->resRepo;
    }
    
    public function getTodo(int $desde, int $cantidad){
        $res = $this->conn->connect();
        if ($this->checkErrores($res->errores)) {
            $this->resRepo->errores[] = "Error al solicitar lista de usuarios";
        } else {
            $Consulta = "SELECT * FROM usuarios
            WHERE borrado = false
            AND tipoUsuarioId = 2
            LIMIT " . $desde . ","  . $cantidad;
            $sql = $res->conexion->prepare($Consulta);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $respuestaBase = $sql->fetchAll();
            $listaMapeada = [];
            foreach ($respuestaBase as $key){
                $listaMapeada[] = $this->MapearEntidad($key);
            }
            $this->resRepo->resultado = $listaMapeada;
        }
        return ($this->resRepo);
    }

    public function getByUsuario(int $desde, int $cantidad, $user){
        $Consulta = "SELECT * FROM usuarios
        WHERE borrado = false
        AND tipoUsuarioId = 2
        AND usuario LIKE '%" . $user ."%'
        LIMIT " . $desde . ","  . $cantidad;
        $sql = $this->db->prepare($Consulta);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $respuestaBase = $sql->fetchAll();
        $listaMapeada = [];
        foreach ($respuestaBase as $key){
            $listaMapeada[] = $this->MapearEntidad($key);
        }
        return ($listaMapeada);
    }

    public function getCantidad() : RespuestaRepositorio
    {
        $res = $this->conn->connect();
        if ($this->checkErrores($res->errores)) {
            $this->resRepo->errores[] = "Error al solicitar la cantidad de usuarios";
        } else {
            $Consulta = "SELECT count(*) as cantidad
            FROM usuarios
            WHERE borrado = false
            AND tipoUsuarioId = 2";
            $sql = $res->conexion->prepare($Consulta);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $respuestaBase = $sql->fetchAll();
            $this->resRepo->resultado = $respuestaBase[0]["cantidad"];
        }
        $this->conn->disconnect();
        return ($this->resRepo);
    }

    function ExisteUsuario(String $user) {
        $res = $this->conn->connect();
        if ($this->checkErrores($res->errores)) {
            $this->resRepo->errores[] = "Error al verificar existencia de usuario";
        } else {
            $Consulta = "SELECT * FROM usuarios
            WHERE usuario = :usuario
            AND borrado = 0";
            $sql = $res->conexion->prepare($Consulta);
            $sql->bindValue(":usuario", $user);
            try {
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $this->resRepo->resultado = (count($respuestaBase) > 0 ? true : false);
            } catch (\Throwable $th) {
                $this->resRepo->errores[] = $th;
            }
        }
        $this->conn->disconnect();
        return ($this->resRepo);
    }

    public function ExisteUsuarioById(String $user, int $id)
    {
        $res = $this->conn->connect();
        if ($this->checkErrores($res->errores)) {
            $this->resRepo->errores[] = "Error al verificar existencia de usuario";
        } else {
            $Consulta = "SELECT * FROM usuarios
            WHERE usuario = :usuario
            AND borrado = 0
            AND id != :id";
            $sql = $res->conexion->prepare($Consulta);
            $sql->bindValue(":usuario", $user);
            $sql->bindValue(":id", $id);
            try {
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $respuestaBase = $sql->fetchAll();
                $this->resRepo->resultado = (count($respuestaBase) > 0 ? true : false);
                //$this->resRepo->errores[] = [];
            } catch (\Throwable $th) {
                $this->resRepo->errores[] = $th;
            }
        }
        $this->conn->disconnect();
        return ($this->resRepo);
    }
    
    public function VerificarContraseña(String $user, String $pass)
    {
        $res = $this->conn->connect();
        if ($this->checkErrores($res->errores)) {
            $this->resRepo->errores[] = "Error al verificar contraseña de usuario";
        } else {
            $Consulta = "SELECT * FROM usuarios
            WHERE usuario = :usuario
            AND password = :pass
            AND borrado = 0";
            $sql = $res->conexion->prepare($Consulta);
            $sql->bindValue(":usuario", $user);
            $sql->bindValue(":pass", $pass);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $respuestaBase = $sql->fetchAll();
            $usuario = new Usuario();
            if (count($respuestaBase) > 0) {
                $usuario = $this->MapearEntidad($respuestaBase[0]);
            }else {
                $usuario = null;
            }
            $this->resRepo->resultado = $usuario;
        }
        $this->conn->disconnect();
        return $this->resRepo;
    }

    public function VerificarContraseñaId(int $id, string $pass){
        $res = $this->conn->connect();
        if ($this->checkErrores($res->errores)) {
            $this->resRepo->errores[] = "Error al verificar contraseña de usuario";
        } else {
            $Consulta = "SELECT * FROM usuarios
            WHERE id = :id
            AND password = :pass
            AND borrado = 0";
            $sql = $res->conexion->prepare($Consulta);
            $sql->bindValue(":id", $id);
            $sql->bindValue(":pass", $pass);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $respuestaBase = $sql->fetchAll();
            $usuario = new Usuario();
            if (count($respuestaBase) > 0) {
                $usuario = $this->MapearEntidad($respuestaBase[0]);
            }else {
                $usuario = null;
            }
            $this->resRepo->resultado = $usuario;
        }
        $this->conn->disconnect();
        return $this->resRepo;
    }

    private function MapearEntidad($respuestaBase) : Usuario
    {
        $usuario = new Usuario();
        $usuario->_id = $respuestaBase['id'];
        $usuario->_borrado = $respuestaBase['borrado'];
        $usuario->_usuario = $respuestaBase['usuario'];
        $usuario->_pass = $respuestaBase['password'];
        $usuario->_bloqueado = $respuestaBase['bloqueado'];
        $usuario->_tipoUsuarioId = $respuestaBase['tipoUsuarioId'];
        $usuario->_mail = $respuestaBase['mail'];
        return $usuario;
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