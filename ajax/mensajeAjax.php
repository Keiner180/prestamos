<?php
session_start(['name' => 'SPM']);
$peticionAjax = true;
require_once("../config/app.php");

require_once("../controller/mensajeController.php");

// ?---------------------INSTANCE TO CONTROLLER--------------------------//
$insMensaje = new mensajeController();

if (isset($_GET["get"])) {
    echo $insMensaje->mostrarUsuarioControlador();
    exit();
} elseif (isset($_POST['searchTerm'])) {
    echo $insMensaje->buscarUsuarioControlador();
    exit();
} elseif (isset($_POST['incoming_id'])) {
    echo $insMensaje->insertarMensajeControlador();
    exit();
} elseif (isset($_POST['incoming_id2'])) {
    echo $insMensaje->obtenerMensajeControlador();
    exit();
} else {
    session_unset();
    session_destroy();
    header("Location:" . SERVERURL . "login/");
}
