<?php
require_once "./Utiles/Dominio/EntidadBase.php";

class Precio extends EntidadBase
{
    public int $_productoId;
    public float $_costo;
    public float $_venta;
}

?>