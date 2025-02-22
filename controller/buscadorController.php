<?php
if ($peticionAjax) {
    require_once("../model/mainModel.php");
} else {
    require_once("./model/mainModel.php");
}

class BuscadorController extends mainModel
{
    //?------------- Controlador de los modulos de busqueda-----------//
    public function moduloBusquedaControlador($modulo)
    {
        $lista_modulo = ["adminUserSearch", "adminClienteSearch", "adminItemSearch"];

        if (in_array($modulo, $lista_modulo)) {

            return false;
        } else {

            return true;
        }
    }


    //?-------------Controlador inicar busqueda--------------//
    public function iniciarBuscadorControlador()
    {
        //*------------ Almecenar los datos del formulario----------//
        $url = self::limpiarCadena($_POST["modulo_url"]);
        $texto = self::limpiarCadena($_POST["txt_buscador"]);

        if ($this->moduloBusquedaControlador($url)) {

            $alerta = [
                "tipo" => "error",
                "titulo" => "Ocurrió un error inesperado",
                "descripcion" => "No podemos procesar la petición en este momento",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($texto == "") {
            $alerta = [
                "tipo" => "error",
                "titulo" => "Ocurrió un error inesperado",
                "descripcion" => "Introduce un termino de busqueda",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}", $texto)) {
            $alerta = [
                "tipo" => "error",
                "titulo" => "Ocurrió un error inesperado",
                "descripcion" => "El termino de busqueda no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        $_SESSION[$url] = $texto;

        $alerta = [
            "tipo" => "redireccionar",
            "url" => SERVERURL . $url . "/"
        ];
        return json_encode($alerta);
    }


    //?---------------- Eliminar busqueda controlador--------------//
    public function eliminarBuscadorControlador()
    {
        $url = self::limpiarCadena($_POST["modulo_url"]);


        if ($this->moduloBusquedaControlador($url)) {

            $alerta = [
                "tipo" => "error",
                "titulo" => "Ocurrió un error",
                "descripcion" => "No podemos procesar la petición en este momento",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        unset($_SESSION[$url]);

        $alerta = [
            "tipo" => "redireccionar",
            "url" => SERVERURL . $url . "/"
        ];
        return json_encode($alerta);
    }


    //?---------------Busqueda de prestamos-----------------//
    public function busquedaPrestamosControlador()
    {

        //*------------ Comprobando si viene busqueda por fechas----------//
        $fechaInicio = self::limpiarCadena($_POST["fecha_inicio_prestamo"]);
        $fechaFinal = self::limpiarCadena($_POST["fecha_final_prestamo"]);

        $fechaInicio = DateTime::createFromFormat('Y-m-d', $fechaInicio)->format('d-m-Y');
        $fechaFinal = DateTime::createFromFormat('Y-m-d', $fechaFinal)->format('d-m-Y');

        $url = self::limpiarCadena($_POST["modulo_url"]);

        if ($fechaInicio == "" || $fechaFinal == "") {
            $alerta = [
                "tipo" => "error",
                "titulo" => "Ocurrió ",
                "descripcion" => "Porr favor introduzca una fecha de inicio y una fecha final",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }


        //*------------ Creando las variables de sesión----------//
        $_SESSION["fecha_inicio_prestamo"] = $fechaInicio;
        $_SESSION["fecha_final_prestamo"] = $fechaFinal;

        //*------------ Eliminar las variables de sesión----------//


        $alerta = [
            "tipo" => "redireccionar",
            "url" => SERVERURL . $url . "/"
        ];
        return json_encode($alerta);
    }


    //?---------------Eliminar busqueda de prestamos-----------------//
    public function eliminarPrestamosControlador()
    {

        $url = self::limpiarCadena($_POST["modulo_url"]);

        //*------------ Eliminar las variables de sesión----------//
        unset($_SESSION["fecha_inicio_prestamo"]);
        unset($_SESSION["fecha_final_prestamo"]);




        $alerta = [
            "tipo" => "redireccionar",
            "url" => SERVERURL . $url . "/"
        ];
        return json_encode($alerta);
    }
}
