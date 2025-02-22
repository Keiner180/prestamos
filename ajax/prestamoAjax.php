<?php
$peticionAjax = true;
require_once("../config/app.php");
session_start(['name' => 'SPM']);


if (isset($_POST["buscar_cliente"]) || isset($_POST["id_agregar_cliente"]) || isset($_POST["id_eliminar_cliente"]) || isset($_POST["buscar_item"]) || isset($_POST["id_agregar_item"]) || isset($_POST["id_eliminar_item"]) || isset($_POST["agregar_prestamo"]) || isset($_POST["prestamo_codigo"]) || isset($_POST["pago_codigo_reg"]) || isset($_POST["pago_codigo_up"])) {


    // ?---------------------INSTANCE TO CONTROLLER--------------------------//
    require_once("../controller/prestamoController.php");
    $insPrestamo = new prestamosControlador();


    // ?---------------------Buscar un cliente--------------------------//
    if (isset($_POST["buscar_cliente"])) {
        echo $insPrestamo->buscarClientePrestamoControlador();
    }


    // ?---------------------Agregar cliente--------------------------//
    if (isset($_POST["id_agregar_cliente"])) {
        echo $insPrestamo->agregarClientePrestamoControlador();
    }


    // ?---------------------Agregar cliente--------------------------//
    if (isset($_POST["id_eliminar_cliente"])) {
        echo $insPrestamo->eliminarClienteControlador();
    }


    // ?--------------------- BUSCAR ITEMS--------------------------//
    if (isset($_POST["buscar_item"])) {
        echo $insPrestamo->buscarItemPrestamoControlador();
    }

    // ?--------------------- Agregar item--------------------------//
    if (isset($_POST["id_agregar_item"])) {
        echo $insPrestamo->agregarItemPrestamoControlador();
    }

    // ?--------------------- Eliminar item--------------------------//
    if (isset($_POST["id_eliminar_item"])) {
        echo $insPrestamo->eliminarItemControlador();
    }

    // ?--------------------- Agregar prestamo--------------------------//
    if (isset($_POST["agregar_prestamo"])) {
        echo $insPrestamo->agregarPrestamoControlador();
    }

    // ?--------------------- Eliminar préstamo--------------------------//
    if (isset($_POST["prestamo_codigo"])) {
        echo $insPrestamo->eliminarPrestamoControlador();
    }

    // ?--------------------- Agregar pago--------------------------//
    if (isset($_POST["pago_codigo_reg"])) {
        echo $insPrestamo->agregarPagoControlador();
    }

    // ?--------------------- Actualizar prestamo--------------------------//
    if (isset($_POST["pago_codigo_up"])) {
        echo $insPrestamo->actualizarPrestamoControlador();
    }
} else {

    session_start(['name' => 'SPM']);
    session_unset();
    session_destroy();
    header("Location:" . SERVERURL . "login/");
}
