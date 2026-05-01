<?php
interface IUsuarioServicio
{
    public function GetUsuario(int $id) : RespuestaServicioDatos;
    public function GetCantidadUsuarios() : RespuestaServicioDatos;
    public function GetUsuarios(int $desde, int $cantidad) : RespuestaServicioDatos;
    public function Crear(UsuarioDTO $usuarioDto) : RespuestaServicioDatos;
    public function Modificar(UsuarioDTO $usuarioDto, string $pass) : RespuestaServicioDatos;
    public function Eliminar(UsuarioDTO $usuarioDto, string $pass) : RespuestaServicioDatos;
}
?>