<?php
//require_once "../Servicios/Usuarios/UsuarioDto.php";
//require_once "../Servicios/Usuarios/UsuarioServicio.php";

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    /*$usuario = new UsuarioDto();
$usuario->Id = 1; 
$usuario->Usuario = "loris";
$usuario->Contraseña = "1234";

echo $usuario->Usuario;

$users = new UsuarioServicio();
//$users->Nuevo($usuario);

print_r($users->Login($usuario));
//print_r($users->getUsuarios());*/
echo($_GET['Login'] . $_GET['Usuario'] . $_GET['Clave']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Login']) && $_POST['Login']==true) {
        if ( isset($_POST['Usuario']) && isset($_POST['Clave'])  ) {
            /*$usuario = $_POST['Usuario'];
            $clave = $_POST['Clave'];
            $Usuario = new UsuarioDto();
            $Usuario->Usuario = $usuario;
            $Usuario->Contraseña = $clave;
            $Usuarios = new UsuarioServicio();
            //$listaUsuarios = $Usuarios->getUsuarios();
            //$listaUsuarios = $Usuarios->Login($usuario, $clave);
            $listaUsuarios = [];
            if ($Usuarios->Login($Usuario)) {
                $listaUsuarios = $Usuarios->BuscarUsuario($Usuario);
                
            }
            //print_r($listaUsuarios);
            if (count($listaUsuarios)>=1) {
                $json = [];
                $resultados = [];
                for ($i=0; $i < count($listaUsuarios); $i++) { 
                    $array = array("Usuario" => $listaUsuarios[$i]->Id );
                    $resultados[] = $array;
                }
                echo( json_encode( array("Count" => count($resultados),"Result" => $resultados) ) );
            } else {
                echo( json_encode( array("Count" => 0,"Result" => "Sin resultados") ) );
            }*/
               
        }else {
            echo( json_encode(array("Result" => array("No ingreso todos los parametros"))) );
        }
    }else {
        echo"error: falta algo";
    }
    
}
?>