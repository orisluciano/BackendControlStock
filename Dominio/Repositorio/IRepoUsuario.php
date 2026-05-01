<?php
interface IRepoUsuario
{
    public function crear(Usuario $entidad);
    public function modificar(Usuario $entidad);
    public function eliminar(int $id);
    public function getById(int $id);
    public function getTodo(int $desde, int $cantidad);
    public function getCantidad() : RespuestaRepositorio;
    public function ExisteUsuario(string $user);
    public function ExisteUsuarioById(string $user, int $id);
    public function VerificarContraseña(string $user, string $pass);
    public function VerificarContraseñaId(int $id, string $pass);
}
?>