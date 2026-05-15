<?php
require_once "./Utiles/Dominio/EntidadBase.php";

class Stock extends EntidadBase
{
    public int $productoId;
    public float $actual;
    public float $minimo;
    public float $maximo;
    public int $tipoStock;
}

?>