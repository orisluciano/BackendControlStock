<?php
require_once "./Utiles/DTOBase.php";

class ProductoDTO extends DTOBase
{
    public string $_nombre;
    public string $_descripcion;
    public string $_codSKU;
    public int $_tipoProdId;
}

?>