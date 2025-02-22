<?php
$peticionAjax = true;
require_once("../config/app.php");
session_start(['name' => 'SPM']);


if (isset($_POST["cliente"])) {

    // ?---------------------INSTANCE TO CONTROLLER--------------------------//
    require_once("../controller/clienteController.php");
    $insCliente= new ClienteController();


    // ?---------------------ADD A NEW CLIENT--------------------------//
    if ($_POST["cliente"] == "register") {
        echo $insCliente->agregarClienteControlador();
    }


    // ?---------------------DELTE A CLIENT--------------------------//
    if ($_POST["cliente"] == "eliminar") {
        echo $insCliente->eliminarClienteControlador();
    }


     // ?---------------------DELTE A CLIENT--------------------------//
     if ($_POST["cliente"] == "actualizar") {
        echo $insCliente->actualizarClienteControlador();
    }

    
} else {

    session_start(['name' => 'SPM']);
    session_unset();
    session_destroy();
    header("Location:" . SERVERURL . "login/");
}
