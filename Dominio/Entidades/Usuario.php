<?php
require_once "./Dominio/Entidades/EntidadBase.php";

class Usuario extends EntidadBase
{
 public string $_usuario;
 public string $_pass;
 public string $_mail;
 public int $_tipoUsuarioId;
 public bool $_bloqueado;   
}
?>