<?php
class Errores
{
    public $errores;

    public function __construct() {
        $this->errores = [];
    }

    public function GetErrores()
    {
        return $this->errores;
    }

    public function AddError($error)
    {
        $this->errores[] = $error;
    }
}
?>