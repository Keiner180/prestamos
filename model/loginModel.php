<?php
require_once("mainModel.php");

class loginModelUser extends mainModel
{

    //?--------------- Modelo iniciar sesión-------------------//
    protected static function loginModel($datos)
    {

        $sql = self::conectar()->prepare("SELECT * FROM usuario WHERE usuario_usuario = :Usuario AND usuario_clave = :Clave AND usuario_estado = 'Activa'");
        $sql->bindParam(":Usuario", $datos["usuario_login"]);
        $sql->bindParam(":Clave", $datos["password_login"]);
        $sql->execute();
        return $sql;

    }
}
