<?php
require_once "./Api/Enrutador.php";

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$json = file_get_contents('php://input');
$data = json_decode($json);
$enrutador = new Enrutador($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $data);
$enrutador->dirigir();
?>