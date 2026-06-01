<?php
require_once "./Utiles/Dominio/EntidadBase.php";

class MovimientoStock extends EntidadBase
{
    public int $_stockId;
    public float $_cantidad;
    public string $_tipo;
    public int $_motivoMovId;
}

?>