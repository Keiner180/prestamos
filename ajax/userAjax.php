<?php
$peticionAjax = true;
require_once("../config/app.php");
session_start(['name' => 'SPM']);


if (isset($_POST["user"])) {


    // ?---------------------INSTANCE TO CONTROLLER--------------------------//
    require_once("../controller/userController.php");
    $insUsuario = new userController();


    // ?---------------------ADD A NEW USER--------------------------//
    if ($_POST["user"] == "register" ) {
        echo $insUsuario->addControllerUser();
    }


    // ?---------------------DELETE A USER--------------------------//
    if ($_POST["user"] == "eliminar" ) {
        echo $insUsuario->eliminarUsuarioControlador();
    }


    // ?---------------------UPDATE A USER--------------------------//
    if ($_POST["user"] == "actualizar" ) {
        echo $insUsuario->actualizarUsuarioControlador();
    }

    
} else {

    session_start(['name' => 'SPM']);
    session_unset();
    session_destroy();
    header("Location:" . SERVERURL . "login/");
    
}
