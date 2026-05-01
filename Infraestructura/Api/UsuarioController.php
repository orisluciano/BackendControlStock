<?php
require_once "./Infraestructura/Api/Utiles/HttpMethods.php";
require_once "./Infraestructura/Api/Utiles/Acciones.php";
require_once "./Infraestructura/Api/Utiles/RespuestaPeticion.php";
require_once "./Infraestructura/Api/Utiles/Mensajes.php";
require_once "./Infraestructura/Api/Utiles/Errores.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Servicios/Usuario/UsuarioServicio.php";
require_once "./Aplicacion/DTO/UsuarioDTO.php";

class UsuarioController
{
    protected $metodos;
    protected $acciones;
    protected $mensajes;
    protected $datos;
    protected $metodo;
    protected $parametros;
    protected $token;
    protected TokenServicio $tokenService;
    protected UsuarioServicio $usuarioService;

    public function __construct($metodo, $datos, $parametros, $token, UsuarioServicio $usuarioService) {
        $this->metodos = new HttpMethods();
        $this->acciones = new Acciones();
        $this->mensajes = new Mensajes();
        $this->tokenService = new TokenServicio();
        $this->usuarioService = $usuarioService;
        $this->metodo = $metodo;
        $this->datos = $datos;
        $this->parametros = $parametros;
        $this->token = $token;
    }

    public function ejecutar(){
        $respuesta = new RespuestaPeticion();
        /*if ($this->token !== "") {
            if ($this->tokenService->is_jwt_valid($this->token)) {
                switch($this->metodo){
                    case $this->metodos->GET:
                        if ($this->parametros != null) {
                            if (count($this->parametros) > 1) {
                                $respuesta = $this->getUsuarios();
                            }else {
                                if (is_numeric($this->parametros[0])) {
                                    $servRes = $this->usuarioService->getUsuario($this->parametros[0]);
                                    if (count($servRes->errores) > 0) {
                                        $respuesta->errores = $servRes->errores;
                                    }else {
                                        $respuesta->respuesta = $servRes->listaDatos;
                                    }
                                }else {
                                    $respuesta->errores[] = "No se proporciono el id del usuario requerido";
                                }
                            }
                        }else {
                            $respuesta->errores[] = "No se proporciono ningun parametro";
                        }
                        break;
        
                    case $this->metodos->POST:
                        $respuesta = $this->_post();
                        break;
                    case $this->metodos->PUT:
                        $respuesta = $this->_put();
                        break;
                    case $this->metodos->DELETE:
                        $respuesta = $this->_delete();
                        break;
                }
            }else {
                $respuesta->respuesta = null;
                $respuesta->errores[] = $this->mensajes->TokenNoValido;
            }
        }else{
            $respuesta->respuesta = null;
            $respuesta->errores[] = $this->mensajes->FaltaToken;
        }*/
        switch($this->metodo){
            case $this->metodos->GET:
                if ($this->parametros != null) {
                    if (count($this->parametros) > 1) {
                        $respuesta = $this->getUsuarios();
                    }else {
                        if (is_numeric($this->parametros[0])) {
                            $servRes = $this->usuarioService->getUsuario($this->parametros[0]);
                            if (count($servRes->errores) > 0) {
                                $respuesta->errores = $servRes->errores;
                            }else {
                                $respuesta->respuesta = $servRes->listaDatos;
                            }
                        }else {
                            $respuesta->errores[] = "No se proporciono el id del usuario requerido";
                        }
                    }
                }else {
                    $respuesta->errores[] = "No se proporciono ningun parametro";
                }
                break;

            case $this->metodos->POST:
                $respuesta = $this->_post();
                break;
            case $this->metodos->PUT:
                $respuesta = $this->_put();
                break;
            case $this->metodos->DELETE:
                $respuesta = $this->_delete();
                break;
        }
        echo(json_encode($respuesta));
    }

    private function _post() : RespuestaPeticion{
        $respuesta = new RespuestaPeticion();
        $respuesta->errores = [];
        //$respuesta = $this->checkToken($this->token);
        if ($this->datos === null) {
            $respuesta->errores[] = "Faltan datos";
        } else {
            if (!property_exists($this->datos, "usuario") || $this->datos->usuario === null) {
                $respuesta->errores[] = "Falta usuario";
            }
            if (!property_exists($this->datos, "pass") || $this->datos->pass === null) {
                $respuesta->errores[] = "Falta pass";
            }
            if (!property_exists($this->datos, "mail") || $this->datos->mail === null) {
                $respuesta->errores[] = "Falta mail";
            }
            /*if ($this->datos->usuario === null) {
                $respuesta->errores[] = "Usuario nulo";
            }*/
        }
        
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $user = new UsuarioDTO();
            $user->usuario = $this->datos->usuario;
            $user->pass = $this->datos->pass;
            if (!property_exists($this->datos, "tipoUsuarioId") || $this->datos->tipoUsuarioId === null) {
                $user->tipoUsuarioId = 0;
            } else {
                $user->tipoUsuarioId = $this->datos->tipoUsuarioId;
            }
            
            $user->mail = $this->datos->mail;
            $resServ = $this->usuarioService->Crear($user);
            $respuesta->respuesta = $resServ->resultado;
            $respuesta->errores = $resServ->errores;
            $respuesta->mensajes = $resServ->mensajes;
        }
        return $respuesta;
    }

    private function _put() : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        $respuesta->errores = [];
        $respuesta = $this->checkToken($this->token);
        if (!property_exists($this->datos, "id")) {
            $respuesta->errores[] = "Falta id";
        }
        if (!property_exists($this->datos, "usuario")) {
            $respuesta->errores[] = "Falta usuario";
        }
        if (!property_exists($this->datos, "pass")) {
            $respuesta->errores[] = "Falta pass";
        }
        if (!property_exists($this->datos, "passActual")) {
            $respuesta->errores[] = "Falta passActual";
        }
        if (!property_exists($this->datos, "mail")) {
            $respuesta->errores[] = "Falta mail";
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $user = new UsuarioDTO();
            $user->id = $this->datos->id;
            $user->usuario = $this->datos->usuario;
            $user->pass = $this->datos->pass;
            $user->mail = $this->datos->mail;
            $resServ = $this->usuarioService->Modificar($user, $this->datos->passActual);
            $respuesta->respuesta = $resServ->resultado;
            $respuesta->errores = $resServ->errores;
            $respuesta->mensajes = $resServ->mensajes;
        }
        return $respuesta;
    }

    private function _delete() : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        $user = new UsuarioDTO();
        $user->id = $this->datos->id;
        $resServ = $this->usuarioService->Eliminar($user);
        $respuesta->respuesta = $resServ["resultado"];
        $respuesta->errores = $resServ["errores"];
        return $respuesta;
    }

    private function getUsuarios(){
        $respuesta = new RespuestaPeticion();
        $resCant = $this->usuarioService->GetCantidadUsuarios();
        $respuesta->respuesta["cantidad"] = $resCant->resultado;
        $resServ = $this->usuarioService->getUsuarios($this->parametros[0], $this->parametros[1]);
        $respuesta->respuesta["resultados"] = $resServ->resultado;
        $respuesta->errores = $resServ->errores;
        return $respuesta;
    }

    private function checkToken(string $token) : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        if ($this->token !== "") {
            if ($this->tokenService->is_jwt_valid($this->token)) {
                $respuesta->mensajes[] = "Token valido";
            } else {
                $respuesta->respuesta = null;
                $respuesta->errores[] = $this->mensajes->TokenNoValido;
            }
        } else {
            $respuesta->respuesta = null;
            $respuesta->errores[] = $this->mensajes->FaltaToken;
        }
        return $respuesta;
    }
}
?>