<?php


class viewsModels
{

    /*---------Modelo obtener vistas----------- */

    protected static function obtenerVistasModelo($vistas)
    {
        $listaBlanca = ["adminClienteCrear", "adminClienteList", "adminClienteSearch", "adminEmpresa", "adminFinalizado", "adminItemCrear", "adminItemList", "adminItemSearch", "adminNuevoPrestamo", "adminPrestamos", "adminReservaciones", "adminSearchDate", "adminUserCrear", "adminUserList", "adminUserSearch", "chat", "adminUserUpdate", "adminclienteUpdate", "adminItemUpdate", "adminReservationUpdate"];

        if (in_array($vistas, $listaBlanca)) {
            if (is_file("./views/admin/" . $vistas . "-view.php")) {
                $contenido = "./views/admin/" . $vistas . "-view.php";
            } else {
                $contenido = "404";
            }
        } elseif ($vistas === "index" || $vistas === "dashboard") {
            $contenido = "AdminDashboard-view.php";
        } elseif ($vistas === "login") {
            $contenido = "login";
        } else {
            $contenido = "404";
        }

        return $contenido;
    }
}
