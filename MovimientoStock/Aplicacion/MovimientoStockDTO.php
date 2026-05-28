<?php
require_once "./Utiles/DTOBase.php";

class MovimientoStockDTO extends DTOBase
{
    public int $stockId;
    public float $cantidad;
    public int $tipoMovimientoId;
    public int $causaId;
}
?>