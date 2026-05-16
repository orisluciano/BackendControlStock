<?php
require_once "./Utiles/Dominio/EntidadBase.php";

class Stock extends EntidadBase
{
    public int $_productoId;
    public float $_actual;
    public float $_minimo;
    public float $_maximo;
    public int $_tipoStockId;
}

?>