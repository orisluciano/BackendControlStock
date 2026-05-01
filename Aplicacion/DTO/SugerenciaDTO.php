<?php
require_once "./Aplicacion/DTO/DTOBase.php";

class SugerenciaDTO extends DTOBase
{
    public string $descripcion;
    public bool $leido;
    public int $usuarioId;
}
?>