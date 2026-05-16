<?php
require_once "./Utiles/DTOBase.php";

class StockDTO extends DTOBase
{
    public int $productoId;
    public float $actual;
    public float $minimo;
    public float $maximo;
    public int $tipoStockId;
}

?>