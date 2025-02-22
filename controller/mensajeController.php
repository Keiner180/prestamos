<?php

if ($peticionAjax) {
    require_once("../model/mensajeModel.php");
} else {
    require_once("./model/mensajeModel.php");
}


class mensajeController extends mensajeModel
{

    //?-----------------------Controlador  mostrar mostrar usuarios (chat)---------------------//
    public function mostrarUsuarioControlador()
    {

        $sql = self::mostrarUsuarioModelo();

        $output = "";
        if ($sql->rowCount() == 0) {

            $output .= "<p>No hay usuarios disponibles para chatear</p>";
        } elseif ($sql->rowCount() >= 1) {

            $output = self::obtenerUsuariosModelo($sql);

        }


        return $output;
    }


    //?-----------------------Controlador  para buscar usuarios (chat)---------------------//
    public function buscarUsuarioControlador()
    {
        $valor = mainModel::limpiarCadena($_POST['searchTerm']);
        $sql = self::buscarUsuarioModelo($valor);

        $output = "";
        if ($sql->rowCount() == 0) {

            $output .= "<p>No se encontró ningún usuario relacionado con su término de búsqueda</p>";
        } elseif ($sql->rowCount() > 0) {

            $output = self::obtenerUsuariosModelo($sql);
        }

        return $output;
    }


    //?-----------------------Controlador  insertar mensajes (chat)---------------------//
    public function insertarMensajeControlador()
    {
        $valor = mainModel::limpiarCadena($_POST['incoming_id']);
        $mensaje =  mainModel::limpiarCadena($_POST['message']);

        $sql = self::insertarMensajeModelo($valor, $mensaje);

        return $sql;
    }

    //?-----------------------Controlador para obtener mensajes (chat)---------------------/
    public function obtenerMensajeControlador()
    {

        $valor = mainModel::limpiarCadena($_POST['incoming_id2']);

        $sql = self::mostrarMensajesModelo($valor);
        return $sql;
    }
}
