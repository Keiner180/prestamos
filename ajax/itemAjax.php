<?php
$peticionAjax = true;
require_once("../config/app.php");
session_start(['name' => 'SPM']);


if (isset($_POST["item"])) {


    // ?---------------------INSTANCE TO CONTROLLER--------------------------//
    require_once("../controller/itemController.php");
    $insItem = new ItemController();


    // ?---------------------ADD A NEW ITEM--------------------------//
    if ($_POST["item"] == "registrar" ) {
        echo $insItem->agregarItemControlador();
    }


    // ?---------------------DELETE A ITEM--------------------------//
    if ($_POST["item"] == "eliminar" ) {
        echo $insItem->eliminarItemControlador();
    }


    // ?---------------------UPDATE A ITEM--------------------------//
    if ($_POST["item"] == "actualizar" ) {
        echo $insItem->actualizarItemControlador();
    }

    
} else {

    session_start(['name' => 'SPM']);
    session_unset();
    session_destroy();
    header("Location:" . SERVERURL . "login/");
    
}
