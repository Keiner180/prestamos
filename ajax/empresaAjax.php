<?php
$peticionAjax = true;
require_once("../config/app.php");
session_start(['name' => 'SPM']);


if (isset($_POST["empresa"])) {

    // ?---------------------INSTANCE TO CONTROLLER--------------------------//
    require_once("../controller/empresaController.php");
    $insEmpresa = new EmpresaController();


    // ?---------------------ADD A NEW COMPANY--------------------------//
    if ($_POST["empresa"] == "agregar") {
        echo $insEmpresa->agregarEmpresaControlador();
    }

     // ?---------------------UPDATE A  COMPANY--------------------------//
     if ($_POST["empresa"] == "actualizar") {
        echo $insEmpresa->actualizarEmpresaControlador();
    }
} else {

    session_start(['name' => 'SPM']);
    session_unset();
    session_destroy();
    header("Location:" . SERVERURL . "login/");
}
