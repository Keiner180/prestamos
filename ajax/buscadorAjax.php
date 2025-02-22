<?php
$peticionAjax = true;
require_once("../config/app.php");
session_start(['name' => 'SPM']);


if (isset($_POST["modulo_buscador"])) {


    // ?---------------------INSTANCE TO CONTROLLER--------------------------//
    require_once("../controller/buscadorController.php");
    $insBuscador = new BuscadorController();

    if ($_POST['modulo_buscador'] == "buscar") {

        echo $insBuscador->iniciarBuscadorControlador();
    }

    if ($_POST['modulo_buscador'] == "eliminar") {

        echo $insBuscador->eliminarBuscadorControlador();
    }

    if ($_POST['modulo_buscador'] == "prestamo") {

        echo $insBuscador->busquedaPrestamosControlador();
       
    }

    if ($_POST['modulo_buscador'] == "eliminarPrestamo") {

        echo $insBuscador->eliminarPrestamosControlador();
    }
       


} else {

    session_start(['name' => 'SPM']);
    session_unset();
    session_destroy();
    header("Location:" . SERVERURL . "login/");
}
