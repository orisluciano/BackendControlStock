<?php
require_once "IProductoServicio.php";
require_once "./Utiles/RespuestaServicioDatos.php";
require_once "ProductoDTO.php";

class ProductoServicio implements IProductoServicio
{
    protected IRepoProducto $_repo;
    protected RespuestaServicioDatos $_respuesta;

    public function __construct(IRepoProducto $repo) {
        $this->_repo = $repo;
        $this->_respuesta = new RespuestaServicioDatos();
    }

    public function _nuevo(ProductoDTO $producto) : RespuestaServicioDatos{
        $nuevo = new Producto();
        $nuevo->_nombre = $producto->nombre;
        $nuevo->_descripcion = $producto->descripcion;
        $nuevo->_codigo = $producto->codigo;
        $nuevo->_tipoCodigo = $producto->tipoCodigo;
        $nuevo->_tipoProdId = $producto->tipoProdId;
        $resRepo = $this->_repo->_crear($nuevo);
        $this->_respuesta->errores = $resRepo->errores;
        $this->_respuesta->mensajes = $resRepo->mensajes;
        return $this->_respuesta;
    }
    public function _modificar(ProductoDTO $producto) : RespuestaServicioDatos{
        if ($producto->id === null) {
            $this->_respuesta->errores[] = "El id no puede estar nulo";
        }
        if ($producto->nombre === null) {
            $this->_respuesta->errores[] = "El nombre no puede estar nulo";
        }
        if ($producto->descripcion === null) {
            $this->_respuesta->errores[] = "El nombre no puede estar nulo";
        }
        if (!$this->_checkErrores($this->_respuesta->errores)) {
            $mod = new Producto();
            $mod->_id =$producto->id;
            $mod->_nombre = $producto->nombre;
            $mod->_descripcion = $producto->descripcion;
            $mod->_codigo = $producto->codigo;
            $mod->_tipoCodigo = $producto->tipoCodigo;
            $mod->_tipoProdId = $producto->tipoProdId;
            $resRepo = $this->_repo->_modificar($mod);
            $this->_respuesta->errores = $resRepo->errores;
            $this->_respuesta->mensajes = $resRepo->mensajes;
        }
        return $this->_respuesta;
    }
    public function _eliminar($id) : RespuestaServicioDatos{
        if ($id === null) {
            $this->_respuesta->errores[] = "El id no puede estar nulo";
        }
        if (!$this->_checkErrores($this->_respuesta->errores)) {
            $resRepo = $this->_repo->_eliminar($id);
            $this->_respuesta->errores = $resRepo->errores;
            $this->_respuesta->mensajes = $resRepo->mensajes;
        }
        return $this->_respuesta;
    }
    public function _getById(int $id) : RespuestaServicioDatos{
        return new RespuestaServicioDatos();
    }
    public function _getProductos(int $desde, int $cantidad) : RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getTodo($desde, $cantidad);
        if ($this->_checkErrores($resRepo->errores)) {
            $respuesta->errores = $resRepo->errores;
            $respuesta->errores[] = "Error en el servicio";
        } else {
            $listaT = $resRepo->resultado;
            $listaMapeada = [];
            foreach ($listaT as $key) {
                $listaMapeada[] = $this->_MapearEntidadDto($key);
            }
            $respuesta->resultado = $listaMapeada;
        }
        return $respuesta;
    }
    public function _getCantidad() : RespuestaServicioDatos{
        $respuesta = new RespuestaServicioDatos();
        $resRepo = $this->_repo->_getCantidad();
        $respuesta->resultado = $resRepo->resultado;
        $respuesta->errores = $resRepo->errores;
        return $respuesta;
    }

    private function _MapearDtoEntidad(ProductoDTO $dto) : Producto {
        $t = new Producto();
        $t->_id = $dto->id;
        $t->_fechaCreacion = $dto->fechaCreacion;
        $t->_fechaModif = $dto->fechaModif;
        $t->_nombre = $dto->nombre;
        $t->_codigo = $dto->codigo;
        $t->_tipoCodigo = $dto->tipoCodigo;
        $t->_descripcion = $dto->descripcion;
        $t->_tipoProdId = $dto->tipoProdId;
        return $t;
    }

    private function _MapearEntidadDto(Producto $entidad) : ProductoDTO {
        $dto = new ProductoDTO();
        $dto->id = $entidad->_id;
        $dto->fechaCreacion = $entidad->_fechaCreacion;
        $dto->fechaModif = $entidad->_fechaModif;
        $dto->nombre = $entidad->_nombre;
        $dto->codigo = $entidad->_codigo;
        $dto->tipoCodigo = $entidad->_tipoCodigo;
        $dto->descripcion = $entidad->_descripcion;
        $dto->tipoProdId = $entidad->_tipoProdId;
        return $dto;
    }

    private function _checkErrores($listaErrores){
        $hayErrores = null;
        if (count($listaErrores)  > 0) {
            $this->_respuesta->errores = $listaErrores;
            $hayErrores = true;
        } else{
            $hayErrores = false;
        }
        return ($hayErrores);
    }
}

?>