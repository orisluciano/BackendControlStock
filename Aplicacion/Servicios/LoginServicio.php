<?php
require_once "./Dominio/Entidades/Usuario.php";
require_once "./Aplicacion/Servicios/Token/TokenServicio.php";
require_once "./Aplicacion/Servicios/Respuestas/RespuestaServicioDatos.php";

class LoginServicio
{
    protected $repo;
    protected RespuestaServicioDatos $respuesta;
    public function __construct(IRepoUsuario $repo) {
        $this->repo = $repo;
        $this->respuesta = new RespuestaServicioDatos();
    }
    
    public function AutenticarUsuario(String $user, String $pass, String $appName)
    {
        if ($this->existeUsuario($user)) {
            $repoContraseña = $this->repo->VerificarContraseña($user,$pass);
            if ($this->verificarContraseña($repoContraseña)) {
                $usuario = $repoContraseña->resultado;
                if ($this->verificarAppName($usuario->_tipoUsuarioId, $appName)) {
                    $headers = array('alg'=>'HS256','typ'=>'JWT');
                    $payload = array('sub'=>'1234567890',
                        'user'=>$usuario->_usuario,
                        "userId" => $usuario->_id,
                        "tipoUsuarioId" => $usuario->_tipoUsuarioId,
                        "mail" => $usuario->_mail,
                        'admin'=>true,
                        'exp'=>(time() + 60 * 60 * 24 * 30));
                    $tokenServicio = new TokenServicio();
                    $jwt = $tokenServicio->generate_jwt($headers, $payload);
                    $this->respuesta->resultado = array('token' => $jwt, 'autorizado' => true);
                } else {
                    $this->respuesta->resultado = array('token' => "", 'autorizado' => false);
                }
            } else {
                $this->respuesta->resultado = array('token' => "", 'autorizado' => false);
            }
            
        }else {
            $this->respuesta->resultado = array('token' => "", 'autorizado' => false);
        }
        return $this->respuesta;
    }

    protected function verificarErrores($listaErrores) {
        $hayErrores = null;
        if (count($listaErrores)  > 0) {
            $this->respuesta->errores = $listaErrores;
            $hayErrores = true;
        } else{
            $hayErrores = false;
        }
        return $hayErrores;
    }

    protected function existeUsuario($user) : bool {
        $bandera = false;
        $repoExiste = $this->repo->ExisteUsuario($user);
        if ($this->verificarErrores($repoExiste->errores)) {
            $this->respuesta->errores[] = "Error en login al verificar existencia de usuario";
        } else {
            if ($repoExiste->resultado) {
                $bandera = true;
            }else {
                $this->respuesta->errores[] = "El usuario no existe";
            }
        }
        return $bandera;
    }

    protected function verificarContraseña($resRepo) : bool {
        $bandera = false;
        //$resRepo = $this->repo->VerificarContraseña($user,$pass);
        if ($this->verificarErrores($resRepo->errores)) {
            $this->respuesta->errores[] = "Error en login al verificar contraseña";
        } else {
            if ($resRepo->resultado !== null) {
                $bandera = true;
            }else {
                $this->respuesta->errores[] = "La contraseña es incorrecta";
            }
        }
        return $bandera;
    }

    protected function verificarAppName($tipoId, String $appName) : bool {
        $bandera = false;
        if ($appName === "TuLaburito" || $appName === "TuLaburitoAdmin") {
            if ($appName === "TuLaburitoAdmin") {
                if ($tipoId  === 1) {
                    $bandera = true;
                }else {
                    $bandera = false;
                    $this->respuesta->errores[] = "Usuario no autorizado";
                }
            }
            if ($appName === "TuLaburito") {
                $bandera = true;
            }
        }else {
            $bandera = false;
            $this->respuesta->errores[] = "Aplicacion no permitida";
        }
        return $bandera;
    }
}
?>