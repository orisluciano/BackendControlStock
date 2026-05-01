<?php
require_once "./Aplicacion/DTO/DTOBase.php";

class FavoritoDTO extends DTOBase
{
    public string $etiqueta;
    public string $descripcion;
    public int $usuarioId;
    public int $trabajadorId;       
}
?>