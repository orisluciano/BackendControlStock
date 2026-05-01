<?php
require_once "./Infraestructura/Api/Utiles/HttpMethods.php";
require_once "./Infraestructura/Api/Utiles/RespuestaPeticion.php";
require_once "./Infraestructura/Api/Utiles/Errores.php";
require_once "./Aplicacion/Servicios/LoginServicio.php";

class LoginController
{
    protected $metodos;
    protected $datos;
    protected $metodo;
    protected LoginServicio $loginService;

    public function __construct($metodo, $datos, LoginServicio $loginService) {
        $this->metodos = new HttpMethods();
        $this->loginService = $loginService;
        $this->metodo = $metodo;
        $this->datos = $datos;
    }

    public function ejecutar(){
        $respuesta = new RespuestaPeticion();
        switch($this->metodo){
            case $this->metodos->GET:
                $respuesta->respuesta = array('token' => null);
                $respuesta->errores[] = ("Metodo equivocado");
                break;
            
            case $this->metodos->POST:
                /*$tokenRes = $this->loginService->AutenticarUsuario($this->datos->usuario, $this->datos->contraseña);
                $token = $tokenRes->resultado;
                if ($token['autorizado']) {
                    $respuesta->respuesta = array('token' => $token['token']);
                } else {
                    $respuesta->respuesta = array('token' => null);
                    //$respuesta->errores[] = ($token['token']);
                    foreach ($tokenRes->errores as $e) {
                        $respuesta->errores[] = $e;
                    }
                }*/
                $respuesta = $this->post();
                break;
        }
        echo(json_encode($respuesta));
    }

    private function post() : RespuestaPeticion {
        $respuesta = new RespuestaPeticion();
        $respuesta->errores = [];
        if (!property_exists($this->datos, "usuario")) {
            $respuesta->errores[] = "Falta usuario";
        }
        $respuesta->errores = [];
        if (!property_exists($this->datos, "contraseña")) {
            $respuesta->errores[] = "Falta contraseña";
        }
        $respuesta->errores = [];
        if (!property_exists($this->datos, "appName")) {
            $respuesta->errores[] = "Falta appName";
        }
        if (count($respuesta->errores) === 0 || $respuesta->errores === null) {
            $tokenRes = $this->loginService->AutenticarUsuario($this->datos->usuario, $this->datos->contraseña, $this->datos->appName);
            $token = $tokenRes->resultado;
            if ($token['autorizado']) {
                $respuesta->respuesta = array('token' => $token['token']);
            } else {
                $respuesta->respuesta = array('token' => null);
                foreach ($tokenRes->errores as $e) {
                    $respuesta->errores[] = $e;
                }
            }
        }
        return $respuesta;
    }
}
?>