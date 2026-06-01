<?php
require_once "./Utiles/DTOBase.php";

class MovimientoStockDTO extends DTOBase
{
    public int $stockId;
    public float $cantidad;
    public string $tipo;
    public int $motivoMovId;
}
?>