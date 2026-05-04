<?php
require_once "./Infraestructura/Persistencia/Repositorio/RepoUsuario.php";
require_once "./Infraestructura/Persistencia/Repositorio/RepoTrabajador.php";
require_once "./Infraestructura/Persistencia/Repositorio/RepoRubro.php";
require_once "./Infraestructura/Persistencia/Repositorio/RepoTrabajadorRubro.php";
require_once "./Infraestructura/Persistencia/Repositorio/RepoTrabajadorContacto.php";
require_once "./Infraestructura/Persistencia/Repositorio/RepoTrabajadorOpinion.php";
require_once "./Infraestructura/Persistencia/Repositorio/RepoTrabajadorUsuario.php";
require_once "./Infraestructura/Persistencia/Repositorio/RepoTipoContacto.php";
require_once "./Infraestructura/Persistencia/Repositorio/RepoSugerencia.php";
require_once "./Infraestructura/Persistencia/Repositorio/RepoFavorito.php";
require_once "./Aplicacion/Servicios/TrabajadorServicio.php";
require_once "./Aplicacion/Servicios/RubroServicio.php";
require_once "./Aplicacion/Servicios/TrabajadorRubroServicio.php";
require_once "./Aplicacion/Servicios/TrabajadorContactoServicio.php";
require_once "./Aplicacion/Servicios/TrabajadorOpinionServicio.php";
require_once "./Aplicacion/Servicios/TrabajadorUsuarioServicio.php";
require_once "./Aplicacion/Servicios/TipoContactoServicio.php";
require_once "./Aplicacion/Servicios/SugerenciaServicio.php";
require_once "./Aplicacion/Servicios/FavoritoServicio.php";

require_once "./Producto/Aplicacion/ProductoServicio.php";

class InyeccionServicios
{
    /*protected UsuarioServicio $_userService;
    protected LoginServicio $_loginService;
    protected TrabajadorServicio $_trabajadorServicio;
    protected TokenServicio $_tokenServicio;
    protected RubroServicio $_rubroServicio;
    protected TrabajadorRubroServicio $_trabajadorRubroServicio;
    protected TrabajadorContactoServicio $_trabajadorContactoServicio;
    protected TrabajadorOpinionServicio $_trabajadorOpinionServicio;
    protected TrabajadorUsuarioServicio $_trabajadorUsuarioServicio;
    protected TipoContactoServicio $_tipoContactoServicio;
    protected SugerenciaServicio $_sugerenciaServicio;
    protected FavoritoServicio $_favoritoServicio;*/
    protected ProductoServicio $_productoServicio;

    public function __construct() {
        $this->iniciarServicios();
    }

    private function iniciarServicios()
    {
        /*$this->_loginService = new LoginServicio(new RepoUsuario());
        $this->_userService = new UsuarioServicio(new RepoUsuario());
        $this->_trabajadorServicio = new TrabajadorServicio(new RepoTrabajador(), new RepoTrabajadorUsuario);
        $this->_tokenServicio = new TokenServicio();
        $this->_rubroServicio = new RubroServicio(new RepoRubro());
        $this->_trabajadorRubroServicio = new TrabajadorRubroServicio(new RepoTrabajadorRubro());
        $this->_trabajadorContactoServicio = new TrabajadorContactoServicio(new RepoTrabajadorContacto());
        $this->_trabajadorOpinionServicio = new TrabajadorOpinionServicio(new RepoTrabajadorOpinion());
        $this->_trabajadorUsuarioServicio = new TrabajadorUsuarioServicio(new RepoTrabajadorUsuario());
        $this->_tipoContactoServicio = new TipoContactoServicio(new RepoTipoContacto());
        $this->_sugerenciaServicio = new SugerenciaServicio(new RepoSugerencia());
        $this->_favoritoServicio = new FavoritoServicio(new RepoFavorito());*/
        $this->_productoServicio = new ProductoServicio();
    }

    public function _getProductoServicio() : ProductoServicio {
        return $this->_productoServicio;
    }

    /*public function _getTokenServicio() : TokenServicio {
        return $this->_tokenServicio;
    }

    public function getLoginServicio() : LoginServicio{
        return $this->_loginService;
    }
    public function getUsuarioServicio() : UsuarioServicio{
        return $this->_userService;
    }

    public function _getTrabajadorServicio() : TrabajadorServicio {
        return $this->_trabajadorServicio;
    }

    public function _getRubroServicio() : RubroServicio {
        return $this->_rubroServicio;
    }

    public function _getTrabajadorRubroServicio() : TrabajadorRubroServicio {
        return $this->_trabajadorRubroServicio;
    }

    public function _getTrabajadorContactoServicio() : TrabajadorContactoServicio{
        return $this->_trabajadorContactoServicio;
    }

    public function _getTrabajadorOpinionServicio() : TrabajadorOpinionServicio {
        return $this->_trabajadorOpinionServicio;
    }

    public function _getTrabajadorUsuarioServicio() : TrabajadorUsuarioServicio {
        return $this->_trabajadorUsuarioServicio;
    }

    public function _getTipoContactoServicio() : TipoContactoServicio {
        return $this->_tipoContactoServicio;
    }

    public function _getSugerenciaServicio() : SugerenciaServicio {
        return $this->_sugerenciaServicio;
    }

    public function _getFavoritoServicio() : FavoritoServicio {
        return $this->_favoritoServicio;
    }*/
}

?>