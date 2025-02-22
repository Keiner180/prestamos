<?php
$peticionAjax = true;
require_once("../config/app.php");

if (isset($_POST["token"]) && isset($_POST["usuario"])) {

    require_once("../controller/loginController.php");
    $insLogin = new loginController();


    echo $insLogin->CerrarSesionControlador();
    
 
} else {

    session_start(['name' => 'SPM']);
    session_unset();
    session_destroy();
    header("Location:" . SERVERURL . "login/");
    
}
