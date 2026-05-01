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
require_once "./Api/Rutas.php";

class Enrutador
{
    protected string $url;
    protected string $metodo;
    protected $datos;
    protected Rutas $rutas;
    protected $token;
    protected InyeccionServicios $inyeccion;

    public function __construct(string $dir, string $metodo, $datos, $token) {
        $this->inyeccion = new InyeccionServicios();
        $this->url = $dir;
        $this->metodo = $metodo;
        $this->datos = $datos;
        $this->token = $token;
        $this->rutas = new Rutas();
    }

    public function dirigir()
    {
        $rutaResuelta = $this->resolverRuta();
        switch ($rutaResuelta['ruta']) {
            case $this->rutas->dashboard:
                echo("Proximamente habra un dashboard");
                break;
            case $this->rutas->login:
                $loginController = new LoginController($this->metodo, $this->datos, $this->inyeccion->getLoginServicio());
                $loginController->ejecutar();
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
        if (count($uri) === 1) {
            $datos['ruta'] = "dashboard";
            $datos['parametros'] = null;
        } else {
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
        }
        return $datos;
    }
}
?>