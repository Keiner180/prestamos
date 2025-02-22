<?php
//?--------------Archivos de la aplicación ---------------
require_once("./config/app.php");
require_once("./controller/viewsController.php");

$plantilla = new viewsController();
$plantilla->obtenerPlantillaControlador();




?>







