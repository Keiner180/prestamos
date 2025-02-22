<?php 

require_once("./model/viewsModels.php");

class viewsController extends viewsModels{
    //*---------------Controlador obtener plantilla ----------- */

    public function obtenerPlantillaControlador(){
        return require_once("./views/admin/plantilla.php");
    }


     //*---------Controlador obtener vista (páginas web)----------- */

     public function obtenerVistaControlador(){

        if(isset($_GET['views'])){
            $ruta = explode("/",$_GET['views']);
            $respuesta = viewsModels::obtenerVistasModelo($ruta[0]);
        }else{
            $respuesta = "AdminDashboard-view.php";
        }

        return $respuesta;

    }

}