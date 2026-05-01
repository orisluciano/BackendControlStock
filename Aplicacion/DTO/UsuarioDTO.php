<?php
require_once "./Aplicacion/DTO/DTOBase.php";
class UsuarioDTO extends DTOBase
{
    public string $usuario;
    public string $pass;
    public string $mail;
    public int $tipoUsuarioId;
    public bool $bloqueado;    
}
?>