<?php
require_once "./Infraestructura/Api/LoginController.php";
require_once "./Infraestructura/Api/UsuarioController.php";
require_once "./Infraestructura/Api/TrabajadorController.php";
require_once "./Infraestructura/Api/TrabajadorRubroController.php";
require_once "./Infraestructura/Api/TrabajadorContactoController.php";
require_once "./Infraestructura/Api/TrabajadorOpinionController.php";
require_once "./Infraestructura/Api/SugerenciaController.php";
require_once "./Infraestructura/Api/RubroController.php";
require_once "./Infraestructura/Api/TipoContactoController.php";
require_once "./Infraestructura/Api/FavoritoController.php";
require_once "./Infraestructura/Api/Utiles/InyeccionServicios.php";

class Enrutador
{
    protected string $url;
    protected string $metodo;
    protected $datos;
    protected $rutas;
    protected $token;
    protected InyeccionServicios $inyeccion;

    public function __construct(string $dir, string $metodo, $datos, $token) {
        $this->inyeccion = new InyeccionServicios();
        $this->url = $dir;
        $this->metodo = $metodo;
        $this->datos = $datos;
        $this->token = $token;
        $this->rutas = ['login' => "login",
        'usuario' => "usuario",
        'trabajador' =>"trabajador",
        "rubro" => "rubro",
        "tipocontacto" => "tipocontacto",
        "trabajadorrubro" => "trabajadorrubro",
        "trabajadorcontacto" => "trabajadorcontacto",
        "trabajadoropinion" => "trabajadoropinion",
        "sugerencia" => "sugerencia",
        "favoritos" => "favoritos"];
    }

    public function dirigir()
    {
        $rutaResuelta = $this->resolverRuta();
        switch ($rutaResuelta['ruta']) {
            case $this->rutas['login']:
                $loginController = new LoginController($this->metodo, $this->datos, $this->inyeccion->getLoginServicio());
                $loginController->ejecutar();
                break;
            case $this->rutas['usuario']:
                $userController = new UsuarioController($this->metodo, $this->datos, $rutaResuelta['parametros'], $this->token, $this->inyeccion->getUsuarioServicio());
                $userController->ejecutar();
                break;
            case $this->rutas['trabajador']:
                $trabajadorController = new TrabajadorController($this->inyeccion->_getTrabajadorServicio(),  $this->inyeccion->_getTrabajadorUsuarioServicio(), $this->inyeccion->_getTokenServicio(), $this->metodo, $this->datos, $rutaResuelta['parametros'], $this->token);
                $trabajadorController->_ejecutar();
                break;
            case $this->rutas['rubro']:
                $rubroController = new RubroController($this->inyeccion->_getRubroServicio(), $this->inyeccion->_getTokenServicio(), $this->metodo, $this->datos, $rutaResuelta['parametros'], $this->token);
                $rubroController->_ejecutar();
                break;
            case $this->rutas['trabajadorrubro']:
                $trController = new TrabajadorRubroController($this->inyeccion->_getTrabajadorRubroServicio(), $this->inyeccion->_getTokenServicio(), $this->metodo, $this->datos, $rutaResuelta['parametros'], $this->token);
                $trController->_ejecutar();
                break;
            case $this->rutas['trabajadorcontacto']:
                $tcController = new TrabajadorContactoController($this->inyeccion->_getTrabajadorContactoServicio(), $this->inyeccion->_getTokenServicio(), $this->metodo, $this->datos, $rutaResuelta['parametros'], $this->token);
                $tcController->_ejecutar();
                break;
            case $this->rutas['trabajadoropinion']:
                $toController = new TrabajadorOpinionController($this->inyeccion->_getTrabajadorOpinionServicio(), $this->inyeccion->_getTokenServicio(), $this->metodo, $this->datos, $rutaResuelta['parametros'], $this->token);
                $toController->_ejecutar();
                break;
            case $this->rutas['tipocontacto']:
                $tConController = new TipoContactoController($this->inyeccion->_getTipoContactoServicio(), $this->inyeccion->_getTokenServicio(), $this->metodo, $this->datos, $rutaResuelta['parametros'], $this->token);
                $tConController->_ejecutar();
                break;
            case $this->rutas['sugerencia']:
                $sugController = new SugerenciaController($this->inyeccion->_getSugerenciaServicio(), $this->inyeccion->_getTokenServicio(), $this->metodo, $this->datos, $rutaResuelta['parametros'], $this->token);
                $sugController->_ejecutar();
                break;
            case $this->rutas['favoritos']:
                $favController = new FavoritoController($this->inyeccion->_getFavoritoServicio(), $this->inyeccion->_getTokenServicio(), $this->metodo, $this->datos, $rutaResuelta['parametros'], $this->token);
                $favController->_ejecutar();
                break;
            default:
                $respuesta = new RespuestaPeticion();
                $respuesta->errores[] = "Ese elemento no existe";
                echo(json_encode($respuesta));
        }
    }

    protected function resolverRuta(){
        $datos = ['ruta' => null, 'parametros' => null];
        $uri = explode("api/", $this->url);
        if (str_contains($uri[1], "/")) {
            $ruta = explode("/", $uri[1]);
            $datos['ruta'] = $ruta[0];
            //$datos['parametros'] = $ruta[1];
            $datos['parametros'] = array();
            foreach ($ruta as $key => $value) {
                if ($key > 0) {
                    $datos['parametros'][] = $value;
                }
            }
        }else {
            $datos['ruta'] = $uri[1];
            $datos['parametros'] = null;
        }
        return $datos;
    }
}
?>