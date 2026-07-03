<?php
require_once "./Api/InyeccionServicios.php";
require_once "./Api/Rutas.php";
require_once "./Producto/Infraestrucura/ProductoController.php";
require_once "./Precio/Infraestructura/PrecioController.php";
require_once "./Stock/Infraestructura/StockController.php";
require_once "./TipoStock/Infraestructura/TipoStockController.php";
require_once "./MovimientoStock/Infraestructura/MovimientoStockController.php";
require_once "./Motivo/Infraestructura/MotivoController.php";
require_once "./TipoProducto/Infraestructura/TipoProductoController.php";
require_once "./Escaner/Infraestructura/EscanerController.php";

class Enrutador
{
    protected string $url;
    protected string $metodo;
    protected $datos;
    protected Rutas $rutas;
    protected InyeccionServicios $inyeccion;

    public function __construct(string $dir, string $metodo, $datos) {
        $this->inyeccion = new InyeccionServicios();
        $this->url = $dir;
        $this->metodo = $metodo;
        $this->datos = $datos;
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
                /*$loginController = new LoginController($this->metodo, $this->datos, $this->inyeccion->getLoginServicio());
                $loginController->ejecutar();*/
                echo("Proximamente login");
                break;
            case $this->rutas->producto:
                $prodController = new ProductoController($this->metodo, $this->datos, $rutaResuelta['parametros'], $this->inyeccion->_getProductoServicio());
                $prodController->_ejecutar();
                break;
            case $this->rutas->precio:
                $precioController = new PrecioController($this->metodo, $this->datos, $rutaResuelta['parametros'], $this->inyeccion->_getPrecioServicio());
                $precioController->_ejecutar();
                break;
            case $this->rutas->stock:
                $stockController = new StockController($this->metodo, $this->datos, $rutaResuelta['parametros'], $this->inyeccion->_getStockServicio(), $this->inyeccion->_getTipoStockServicio());
                $stockController->_ejecutar();
                break;
            case $this->rutas->tipoStock:
                $stockController = new TipoStockController($this->metodo, $this->datos, $rutaResuelta['parametros'], $this->inyeccion->_getTipoStockServicio());
                $stockController->_ejecutar();
                break;
            case $this->rutas->movimientoStock:
                $movStockController = new MovimientoStockController($this->metodo, $this->datos, $rutaResuelta['parametros'], $this->inyeccion->_getMovStockServicio());
                $movStockController->_ejecutar();
                break;
            case $this->rutas->motivoMovimiento:
                $motivoController = new MotivoController($this->metodo, $this->datos, $rutaResuelta['parametros'], $this->inyeccion->_getMotivoServicio());
                $motivoController->_ejecutar();
                break;
            case $this->rutas->tipoProducto:
                $tipoProdController = new TipoProductoController($this->metodo, $this->datos, $rutaResuelta['parametros'], $this->inyeccion->_getTipoProdServicio());
                $tipoProdController->_ejecutar();
                break;
            case $this->rutas->escaner:
                $escanerController = new EscanerController($this->metodo, $this->datos, $rutaResuelta['parametros'], $this->inyeccion->_getProductoServicio());
                $escanerController->_ejecutar();
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