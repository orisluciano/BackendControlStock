<?php
require_once "./Aplicacion/DTO/UsuarioDTO.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Servicios/Respuestas/RespuestaServicioDatos.php";
require_once "./Aplicacion/Interfaces/IUsuarioServicio.php";
class UsuarioServicio implements IUsuarioServicio
{
    protected IRepoUsuario $repo;
    protected RespuestaServicioDatos $respuesta;

    public function __construct(IRepoUsuario $repo) {
        $this->repo = $repo;
        $this->respuesta = new RespuestaServicioDatos();
    }

    public function GetUsuario(int $id) : RespuestaServicioDatos
    {
        $respuesta = new RespuestaServicioDatos();
        $usuario = $this->repo->getById($id);
        if ($usuario != null) {
            $respuesta->listaDatos = $this->MapearEntidadDto($usuario);
        } else {
            $respuesta->errores[] = "Usuario no encontrado";
        }
        return $respuesta;
    }

    public function GetCantidadUsuarios() : RespuestaServicioDatos
    {
        $resRepo = $this->repo->getCantidad();
        $this->respuesta->resultado = $resRepo->resultado;
        $this->respuesta->errores = $resRepo->errores;
        return $this->respuesta;
    }

    public function GetUsuarios(int $desde, int $cantidad) : RespuestaServicioDatos
    {
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->repo->getTodo($desde, $cantidad);
        if ($this->checkErrores($resRepo->errores)) {
            $respuesta->errores = $resRepo->errores;
            $respuesta->errores[] = "Error en el servicio";
        } else {
            $listaUsuarios = $resRepo->resultado;
            $listaMapeada = [];
            foreach ($listaUsuarios as $key) {
                $listaMapeada[] = $this->MapearEntidadDto($key);
            }
            $respuesta->resultado = $listaMapeada;
        }
        return $respuesta;
    }

    public function Crear(UsuarioDTO $usuarioDto) : RespuestaServicioDatos
    {
        /*if ($this->repo->existeUsuario($usuarioDto->usuario)) {
            return(array("resultado" => "Nombre de usuario ya existente", "errores" => array()));
        }else {
            $usuario = new Usuario();
            $usuario->usuario = $usuarioDto->usuario;
            $usuario->pass = $usuarioDto->pass;
            return $this->repo->crear($usuario);
        }*/
        $existe = $this->repo->ExisteUsuario($usuarioDto->usuario);
        if ($this->checkErrores($existe->errores)) {
            $this->respuesta->errores = $existe->errores;
        } else {
            if ($existe->resultado) {
                $this->respuesta->errores[] = "Nombre de usuario ya existente";
            } else {
                $usuario = new Usuario();
                $usuario->_usuario = $usuarioDto->usuario;
                $usuario->_pass = $usuarioDto->pass;
                //$usuario->_tipoUsuarioId = $usuarioDto->tipoUsuarioId;
                $usuario->_mail = $usuarioDto->mail;
                if ($usuarioDto->tipoUsuarioId === 0) {
                    $usuario->_tipoUsuarioId = 2;
                } else {
                    $usuario->_tipoUsuarioId = $usuarioDto->tipoUsuarioId;
                }
                
                $resRepo = $this->repo->crear($usuario);
                $this->respuesta->errores = $resRepo->errores;
                $this->respuesta->mensajes = $resRepo->mensajes;
            }
        }
        return $this->respuesta;
    }

    public function Modificar(UsuarioDTO $usuarioDto, string $pass) : RespuestaServicioDatos
    {
        $existe = $this->repo->ExisteUsuarioById($usuarioDto->usuario, $usuarioDto->id);
        if ($this->checkErrores($existe->errores)) {
            $this->respuesta->errores = $existe->errores;
        } else {
            if ($existe->resultado) {
                $this->respuesta->errores[] = "Nombre de usuario ya existente";
            } else {
                if ($this->verificarContraseña($usuarioDto->id, $pass)) {
                    $usuario = new Usuario();
                    $usuario->_id = $usuarioDto->id;
                    $usuario->_usuario = $usuarioDto->usuario;
                    $usuario->_pass = $usuarioDto->pass;
                    $usuario->_mail = $usuarioDto->mail;
                    $resM = $this->repo->modificar($usuario);
                    $this->respuesta->mensajes = $resM->mensajes;
                    $this->respuesta->errores = $resM->errores;
                } else {
                    $this->respuesta->errores[] = "Contraseña incorrecta";
                }
            }   
        }
        return $this->respuesta;
    }

    public function Eliminar(UsuarioDTO $usuarioDto, string $pass) : RespuestaServicioDatos
    {
        return $this->repo->eliminar($usuarioDto->id);
    }

    private function MapearDtoEntidad(UsuarioDto $dto) : Usuario {
        $usuario = new Usuario();
        $usuario->_id = $dto->id;
        $usuario->_usuario = $dto->usuario;
        $usuario->_bloqueado = $dto->bloqueado;
        $usuario->_tipoUsuarioId = $dto->tipoUsuarioId;
        $usuario->_mail = $dto->mail;
        return $usuario;
    }

    private function MapearEntidadDto(Usuario $entidad) : UsuarioDto {
        $usuario = new UsuarioDto();
        $usuario->id = $entidad->_id;
        $usuario->usuario = $entidad->_usuario;
        $usuario->bloqueado = $entidad->_bloqueado;
        $usuario->tipoUsuarioId = $entidad->_tipoUsuarioId;
        $usuario->mail = $entidad->_mail;
        return $usuario;
    }

    private function checkErrores($listaErrores){
        $hayErrores = null;
        if (count($listaErrores)  > 0) {
            $this->respuesta->errores = $listaErrores;
            $hayErrores = true;
        } else{
            $hayErrores = false;
        }
        return ($hayErrores);
    }

    protected function verificarContraseña($id, $pass) : bool {
        $resRepo= $this->repo->VerificarContraseñaId($id,$pass);
        $bandera = false;
        if ($this->checkErrores($resRepo->errores)) {
            $this->respuesta->errores[] = "Error  al verificar contraseña";
        } else {
            if ($resRepo->resultado !== null) {
                $bandera = true;
            }else {
                $this->respuesta->errores[] = "La contraseña es incorrecta";
            }
        }
        return $bandera;
    }
}
?>