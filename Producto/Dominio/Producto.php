<?php
require_once "./Utiles/Dominio/EntidadBase.php";

class Producto extends EntidadBase
{
    public string $_nombre;
    public string $_descripcion;
    public string $_codigo;
    public string $_tipoCodigo;
    public int $_tipoProdId;
}

?>