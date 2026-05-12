<?php
require_once "./Utiles/DTOBase.php";

class PrecioDTO extends DTOBase
{
    public int $productoId;
    public float $costo;
    public float $venta;
}

?>