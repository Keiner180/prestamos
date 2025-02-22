<?php

if ($peticionAjax) {
    require_once("../model/mainModel.php");
} else {
    require_once("./model/mainModel.php");
}

class prestamosControlador extends mainModel
{

    //?---------------Buscar cliente para un prestamos--------------//
    public function buscarClientePrestamoControlador()
    {

        //*Recuperar el texto que estamos enviando//
        $cliente = self::limpiarCadena(($_POST["buscar_cliente"]));

        if ($cliente == "") {
            return ' 
            <div class="errorNo">
            <span class="material-symbols-sharp">warning</span>
            <p>Debes ingresar el DNI, Nombre, Apellido, Teléfono.</p>';
            exit();
        }


        //*Selecionando clientes en la BD//
        $datos_cliente = self::ejecutarConsultaSimple("SELECT * FROM cliente WHERE cliente_dni LIKE '%$cliente%' OR cliente_nombre LIKE '%$cliente%' OR cliente_apellido LIKE '%$cliente%' OR cliente_telefono LIKE '%$cliente%' ORDER BY cliente_nombre ASC ");
        if ($datos_cliente->rowCount() >= 1) {

            $datos_cliente = $datos_cliente->fetchAll();
            $tabla = '<table>';

            foreach ($datos_cliente as $row) {
                $tabla .= '
                <tr>
                     <td>' . $row["cliente_nombre"] . ' ' . $row["cliente_apellido"] . '-' . $row["cliente_dni"] . '</td>
                     <td onclick="agregarCliente(' . $row["cliente_id"] . ')" > <span class="material-symbols-sharp">person_add</span></td>
                 </tr>
                ';
            }

            $tabla .= '</table>';
            return $tabla;
        } else {
            return '
                <div class="errorNo">
                <span class="material-symbols-sharp">warning</span>
                <p>No hemos encontrado ningún cliente en el sistema que coincida con “' . $cliente . '”</p>
            ';
            exit();
        }
    }


    //?---------------Agregar cliente para un prestamos--------------//
    public function agregarClientePrestamoControlador()
    {
        //*Recuperar el id que se envio desde la funcion//
        $id = self::limpiarCadena(($_POST["id_agregar_cliente"]));

        //*Comprobar el cleinet en la BD
        $checkCliente = self::ejecutarConsultaSimple("SELECT * FROM cliente WHERE cliente_id = '$id'");
        if ($checkCliente->rowCount() <= 0) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Cliente no encontrado",
                "descripcion" => "El cliente ingresado no existe en el sistema. Por favor, verifica la información e intenta nuevamente."
            ];

            return json_encode($alerta);
            exit();
        } else {
            $datos_cliente = $checkCliente->fetch();
        }

        if (empty($_SESSION['datos_cliente'])) {

            $_SESSION['datos_cliente'] = [
                "ID" => $datos_cliente['cliente_id'],
                "DNI" => $datos_cliente['cliente_dni'],
                "Nombre" => $datos_cliente['cliente_nombre'],
                "Apellido" => $datos_cliente['cliente_apellido']
            ];

            $alerta = [
                "tipo" => "recargar",
                "icono" => "exito",
                "titulo" => "Cliente agregado",
                "descripcion" => "El clinete se agrego para realizar un préstamos"
            ];
            return json_encode($alerta);
        } else {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Ocurrio un error",
                "descripcion" => "No hemos podido agregar el cliente al préstamo"
            ];

            return json_encode($alerta);
        }
    }


    //?---------------Eliminar la variable de sesion de cliente--------------//
    public  function eliminarClienteControlador()
    {

        unset($_SESSION["datos_cliente"]);

        if (empty($_SESSION["datos_cliente"])) {

            $alerta = [
                "tipo" => "recargar",
                "icono" => "recargar",
                "titulo" => "Cliente removido",
                "descripcion" => "Los datos del cliente se han removido con éxito."
            ];
        } else {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Ocurrio un error inerperado",
                "descripcion" => "No hemos podido remover los datos del cliente."
            ];
        }


        return json_encode($alerta);
        exit();
    }


    //?---------------Buscar item para un prestamos--------------//
    public function buscarItemPrestamoControlador()
    {

        //*Recuperar el texto que estamos enviando//
        $item = self::limpiarCadena(($_POST["buscar_item"]));

        if ($item == "") {
            return ' 
              <div class="errorNo">
              <span class="material-symbols-sharp">warning</span>
              <p>Debes ingresar el Código, Nombre.</p>';
            exit();
        }


        //*Selecionando clientes en la BD//
        $datos_item = self::ejecutarConsultaSimple("SELECT * FROM item WHERE item_codigo LIKE '%$item%' OR item_nombre LIKE '%$item%' ORDER BY item_nombre ASC ");
        if ($datos_item->rowCount() >= 1) {

            $datos_item = $datos_item->fetchAll();
            $tabla = '<table>';

            foreach ($datos_item as $row) {
                $tabla .= '
                  <tr>
                       <td>' . $row["item_codigo"] . ' ' . $row["item_nombre"] . '</td>
                       <td onclick="agregarItem(' . $row["item_id"] . ')" ><span class="material-symbols-sharp">package_2</span></td>
                   </tr>
                  ';
            }

            $tabla .= '</table>';
            return $tabla;
        } else {
            return '
                  <div class="errorNo">
                  <span class="material-symbols-sharp">warning</span>
                  <p>No hemos encontrado ningún item en el sistema que coincida con “' . $item . '”</p>
              ';
            exit();
        }
    }


    //?---------------Agregar item para un prestamos--------------//
    public function agregarItemPrestamoControlador()
    {

        //*Recuperar el id del item//
        $id = self::limpiarCadena(($_POST["id_agregar_item"]));

        //*Comprobar el item en la BD
        $checkItem = self::ejecutarConsultaSimple("SELECT * FROM item WHERE item_id = '$id' AND item_estado='Habilitado'");
        if ($checkItem->rowCount() <= 0) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Item no encontrado",
                "descripcion" => "No hemos podido seleccionar el item."
            ];

            return json_encode($alerta);
            exit();
        } else {
            $datos_item = $checkItem->fetch();
        }

        //* == Recuperando detalles del prestamo ==*/
        $formato = self::limpiarCadena($_POST['detalle_formato']);
        $cantidad = self::limpiarCadena($_POST['detalle_cantidad']);
        $tiempo = self::limpiarCadena($_POST['detalle_tiempo']);
        $costo = self::limpiarCadena($_POST['detalle_costo_tiempo']);


        //* == comprobar campos vacíos ==*/
        if ($formato == "" || $cantidad == "" || $tiempo == "" || $costo == "") {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Campos incompletos",
                "descripcion" => "No has llenado todos los campos que son obligatorios. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        //*Verificando la integridad de los datos//
        if (self::verificarDatos("[0-9]{1,7}", $cantidad)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en la cantidad",
                "descripcion" => "La cantidad no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("[0-9]{1,7}", $tiempo)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el tiempo",
                "descripcion" => "El tiempo no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("[0-9.]{1,15}", $costo)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el costo",
                "descripcion" => "El costo no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }


        if ($formato != "Horas" && $formato != "Dias" && $formato != "Evento" && $formato != "Mes") {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Ocurrio un error",
                "descripcion" => "El formato de préstamo no es valido. Por favor, verifica e intenta nuevamente."
            ];

            return json_encode($alerta);
            exit();
        }

        if (empty($_SESSION["datos_item"][$id])) {

            $costo = number_format($costo, 2, ".", "");

            $_SESSION["datos_item"][$id] = [

                "ID" => $datos_item['item_id'],
                'Codigo' => $datos_item['item_codigo'],
                'Nombre' => $datos_item['item_nombre'],
                'Detalle' => $datos_item['item_detalle'],
                'Formato' => $formato,
                'Cantidad' => $cantidad,
                'Tiempo' => $tiempo,
                'Costo' => $costo
            ];

            $alerta = [
                "tipo" => "recargar",
                "icono" => "exito",
                "titulo" => "Item agrado",
                "descripcion" => "El item ha sido agregado para realizar un préstamo."
            ];

            return json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Ocurrio un error",
                "descripcion" => "El item que intenta agregar ya se encuentra seleccionado. Por favor, verifica e intenta nuevamente."
            ];

            return json_encode($alerta);
            exit();
        }
    }


    //?---------------Eliminar la variable de sesion del item --------------//
    public function eliminarItemControlador()
    {
        //*Recuperando el ID del item//
        $id = self::limpiarCadena($_POST["id_eliminar_item"]);

        //*Comprobar el item en la BD
        $checkItem = self::ejecutarConsultaSimple("SELECT * FROM item WHERE item_id = '$id' ");
        if ($checkItem->rowCount() <= 0) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Item no encontrado",
                "descripcion" => "No hemos podido seleccionar el item para eliminarlo."
            ];

            return json_encode($alerta);
            exit();
        } else {
            unset($_SESSION["datos_item"][$id]);

            if (empty($_SESSION["datos_item"][$id])) {

                $alerta = [
                    "tipo" => "recargar",
                    "icono" => "recargar",
                    "titulo" => "Item removido",
                    "descripcion" => "Los datos del item se han removido con éxito."
                ];
            } else {

                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Ocurrio un error inerperado",
                    "descripcion" => "No hemos podido remover los datos del item."
                ];
            }

            return json_encode($alerta);
        }
    }


    //?-----------------------Controlador obtener datos de pretamoss ---------------------//
    public function datosPrestamoControlador($tipo, $estado_prestamo)
    {

        $tipo = self::limpiarCadena($tipo);

        $estado_prestamo = self::decryption($estado_prestamo);
        $estado_prestamo = self::limpiarCadena($estado_prestamo);

        return self::seleccionarDatosCampos($tipo, "prestamo", "prestamo_id", $estado_prestamo, "prestamo_estado");
    }


    //?-----------------------Controlador para agregar prestamos ---------------------//
    public  function  agregarPrestamoControlador()
    {


        //*------------ Cmprando item------------------//
        if ($_SESSION["prestamo_item"] == 0) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Ningún ítem seleccionado",
                "descripcion" => "Por favor, selecciona al menos un ítem antes de continuar."
            ];

            return json_encode($alerta);
            exit();
        }

        //*------------ Cmprando cliente------------------//
        if (empty($_SESSION["datos_cliente"])) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Cliente no seleccionado",
                "descripcion" => "Por favor, selecciona un cliente antes de continuar."
            ];

            return json_encode($alerta);
            exit();
        }


        //*------------ Recibiendo los datos del formulario------------------//
        $fecha_prestamo = self::limpiarCadena($_POST['fecha_prestamo']);
        $hora_prestamo = self::limpiarCadena($_POST['hora_prestamo']);
        $fecha_entrega = self::limpiarCadena($_POST['fecha_entrega']);
        $hora_entrega = self::limpiarCadena($_POST['hora_entrega']);
        $estado = self::limpiarCadena($_POST['estado']);
        $total_depositado = self::limpiarCadena($_POST['total_depositado']);
        $observacion_prestamo = self::limpiarCadena($_POST['observacion_prestamo']);


        //*---------------Comprobar la integridad de los datos-----------------//


        //   *== Verificando integridad de los datos     ==*/
        if (self::verificarFecha($fecha_prestamo)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en la fecha",
                "descripcion" => "La fecha de préstamo no coincide con el formato solicitado."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])", $hora_prestamo)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en la hora de préstamo",
                "descripcion" => "La hora de préstamo no coincide con el formato solicitado."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarFecha($fecha_entrega)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en la fecha de entrega",
                "descripcion" => "La fecha de entrega no coincide con el formato solicitado."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])", $hora_entrega)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en la hora de entrega",
                "descripcion" => "La hora de entrega no coincide con el formato solicitado."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarFecha($fecha_entrega)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en la fecha de entrega",
                "descripcion" => "La fecha de entrega no coincide con el formato solicitado."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("[0-9.]{1,10}", $total_depositado)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el total depositado",
                "descripcion" => "El total depositado no coincide con el formato solicitado."
            ];
            return json_encode($alerta);
            exit();
        }

        if ($observacion_prestamo != "") {
            if (self::verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}", $observacion_prestamo)) {
                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Error en la observación",
                    "descripcion" => "La observación del préstamo no coincide con el formato solicitado."
                ];
                return json_encode($alerta);
                exit();
            }
        }

        if ($estado != "Reservacion" && $estado != "Prestamo" && $estado != "Finalizado") {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el estado",
                "descripcion" => "El estado no coincide con el formato solicitado."
            ];
            return json_encode($alerta);
            exit();
        }

        //*----------------Comprobando las fechas-----------------//
        if (strtotime($fecha_entrega) < strtotime($fecha_prestamo)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en las fechas",
                "descripcion" => "La fecha de entrega no puede ser menor a la fecha de préstamo."
            ];
            return json_encode($alerta);
            exit();
        }


        //*------------------Formateando las totales, fechas y hora-----------------//
        $total_prestamo = number_format($_SESSION['prestamo_total'], 2, '.', '');
        $total_pagado = number_format($total_depositado, 2, '.', '');

        $fecha_prestamo = date("Y-m-d", strtotime($fecha_prestamo));
        $fecha_entrega = date("Y-m-d", strtotime($fecha_entrega));

        $hora_prestamo = date("h:i a", strtotime($hora_prestamo));
        $hora_entrega = date("h:i a", strtotime($hora_entrega));


        //*------------------Generando codigo de prestamo----------------//
        $correlativo = self::ejecutarConsultaSimple("SELECT prestamo_id FROM prestamo");


        $correlativo = ($correlativo->rowCount()) + 1;

        $codigo = self::generarCodigoAleatorio("CP", "8", $correlativo);

        $datos_prestamos_reg =
            [

                [
                    "campo_nombre" => "prestamo_codigo",
                    "campo_marcador" => ":Codigo",
                    "campo_valor" => $codigo

                ],

                [
                    "campo_nombre" => "prestamo_fecha_inicio",
                    "campo_marcador" => ":Inicio",
                    "campo_valor" => $fecha_prestamo

                ],

                [
                    "campo_nombre" => "prestamo_hora_inicio",
                    "campo_marcador" => ":HoraInicio",
                    "campo_valor" => $hora_prestamo

                ],


                [
                    "campo_nombre" => "prestamo_fecha_final",
                    "campo_marcador" => ":Fecgafinal",
                    "campo_valor" => $fecha_entrega

                ],

                [
                    "campo_nombre" => "prestamo_hora_final",
                    "campo_marcador" => ":HoraFinal",
                    "campo_valor" => $hora_entrega

                ],

                [
                    "campo_nombre" => "prestamo_cantidad",
                    "campo_marcador" => ":Cantidad",
                    "campo_valor" => $_SESSION['prestamo_item']

                ],

                [
                    "campo_nombre" => "prestamo_total",
                    "campo_marcador" => ":Total",
                    "campo_valor" => $total_prestamo

                ],

                [
                    "campo_nombre" => "prestamo_pagado",
                    "campo_marcador" => ":Pagado",
                    "campo_valor" => $total_pagado

                ],

                [
                    "campo_nombre" => "prestamo_estado",
                    "campo_marcador" => ":Estado",
                    "campo_valor" => $estado

                ],

                [
                    "campo_nombre" => "prestamo_observacion",
                    "campo_marcador" => ":Observacion",
                    "campo_valor" => $observacion_prestamo

                ],

                [
                    "campo_nombre" => "usuario_id",
                    "campo_marcador" => ":UsuarioId",
                    "campo_valor" => $_SESSION["id_spm"]

                ],

                [
                    "campo_nombre" => "cliente_id",
                    "campo_marcador" => ":ClienteId",
                    "campo_valor" => $_SESSION['datos_cliente']['ID']

                ]

            ];



        //*------------------Agregar datos a la tabla prestamo ----------------//
        $agregar_prestamos = self::insertarDatos("prestamo", datos: $datos_prestamos_reg);

        if ($agregar_prestamos->rowCount()  != 1) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Ocurrio un error inesperado (Error: 001)",
                "descripcion" => "No hemos podido registrar el préstamo, por favor intente nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }


        //*------------------Agregar a la tabla pago----------------//
        if ($total_pagado > 0) {

            $datos_pago_reg = [

                [
                    "campo_nombre" => "pago_total",
                    "campo_marcador" => ":Pago_total",
                    "campo_valor" => $total_pagado

                ],

                [
                    "campo_nombre" => "pago_fecha",
                    "campo_marcador" => ":Pago_fecha",
                    "campo_valor" => $fecha_prestamo

                ],

                [
                    "campo_nombre" => "prestamo_codigo",
                    "campo_marcador" => ":Codigo",
                    "campo_valor" => $codigo

                ]

            ];

            $agregar_pago = self::insertarDatos("pago", $datos_pago_reg);


            if ($agregar_pago->rowCount()  != 1) {

                self::eliminarDatos("prestamo", "prestamo_codigo", $codigo);

                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Ocurrio un error inesperado (Error: 002)",
                    "descripcion" => "No hemos podido registrar el préstamo, por favor intente nuevamente."
                ];
                return json_encode($alerta);
                exit();
            }
        }


        //*------------------Agregar a la tabla detalle----------------//
        $errores_detalles = 0;

        foreach ($_SESSION["datos_item"] as $items) {
            $costo = number_format($items["Costo"], 2, '.', '');
            $descripcioon = $items["Codigo"] . " " . $items["Nombre"];

            $datos_detalle_reg = [

                [
                    "campo_nombre" => "detalle_cantidad",
                    "campo_marcador" => ":Cantidad",
                    "campo_valor" => $items['Cantidad']

                ],


                [
                    "campo_nombre" => "detalle_formato",
                    "campo_marcador" => ":Formato",
                    "campo_valor" => $items['Formato']

                ],


                [
                    "campo_nombre" => "detalle_tiempo",
                    "campo_marcador" => ":Tiempo",
                    "campo_valor" => $items['Tiempo']

                ],


                [
                    "campo_nombre" => "detalle_costo_tiempo",
                    "campo_marcador" => ":Costo",
                    "campo_valor" => $costo

                ],


                [
                    "campo_nombre" => "detalle_descripcion",
                    "campo_marcador" => ":Descripcion",
                    "campo_valor" => $descripcioon

                ],
                [
                    "campo_nombre" => "prestamo_codigo",
                    "campo_marcador" => ":Codigo",
                    "campo_valor" => $codigo

                ],
                [
                    "campo_nombre" => "	item_id ",
                    "campo_marcador" => ":Item_id",
                    "campo_valor" => $items['ID']

                ]
            ];


            $agregar_detalle = self::insertarDatos("detalle", $datos_detalle_reg);
            if ($agregar_detalle->rowCount() != 1) {

                $errores_detalles = 1;
                break;
            }
        }

        if ($errores_detalles == 0) {

            unset($_SESSION["datos_cliente"]);
            unset($_SESSION["datos_item"]);

            $alerta = [
                "tipo" => "recargar",
                "icono" => "exito",
                "titulo" => "Préstamo registrado",
                "descripcion" => "El préstamo ha sido registrado exitosamente en el sistema."
            ];
        } else {
            self::eliminarDatos("prestamo", "prestamo_codigo", $codigo);
            self::eliminarDatos("detalle", "prestamo_codigo", $codigo);
            self::eliminarDatos("pago", "prestamo_codigo", $codigo);


            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Ocurrio un error inesperado (Error: 003)",
                "descripcion" => "No hemos podido registrar el préstamo, por favor intente nuevamente."
            ];
        }

        return json_encode($alerta);
    }


    //?---------------------Controlador paginador de prestamos---------------------------//
    public function paginadorPrestamosControlador($pagina, $registros, $url, $tipo, $fecha_inicio, $fecha_final)
    {

        //*--------------Limpiando los valores de ataques de inyeción-------------//
        $pagina = self::limpiarCadena($pagina);
        $registros = self::limpiarCadena($registros);
        $tipo = self::limpiarCadena($tipo);
        $url = self::limpiarCadena($url);
        $fecha_inicio = self::limpiarCadena($fecha_inicio);
        $fecha_final = self::limpiarCadena($fecha_final);

        $url = SERVERURL . $url . "/";
        $tabla = "";

        // Determinar en que pagina esta el usuario
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0; //Desde donde se va a extrater los datos 

        if ($tipo == "Busqueda") {
            if (self::verificarFecha($fecha_inicio) || self::verificarFecha($fecha_final)) {

                return '
        <div class="contenedor-error-ines">

                <div class="error-ines">
                    <span class="material-symbols-sharp">warning</span>
                    <h4>¡Ocurrió un error inesperado!</h4>
                    <p>Lo sentimos, no podemos realizar la busqueda ya que ha ingresado una fecha incorrecta.</p>
                </div>
           </div>
                                ';
                exit();
            }
        }

        $campos = "prestamo.prestamo_id,prestamo.prestamo_codigo,prestamo.prestamo_fecha_inicio,prestamo.prestamo_fecha_final,prestamo.prestamo_total,prestamo.prestamo_pagado,prestamo.prestamo_estado,prestamo.usuario_id,prestamo.cliente_id,cliente.cliente_nombre,cliente.cliente_apellido";

        if ($tipo == "Busqueda" && $fecha_inicio != "" && $fecha_final != "") {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS  $campos FROM prestamo INNER JOIN cliente ON prestamo.cliente_id=cliente.cliente_id WHERE (prestamo.prestamo_fecha_inicio BETWEEN '$fecha_inicio' AND '$fecha_final') ORDER BY prestamo.prestamo_fecha_inicio DESC LIMIT $inicio, $registros";
        } else {
            $consulta =  "SELECT SQL_CALC_FOUND_ROWS $campos FROM prestamo INNER JOIN cliente ON prestamo.cliente_id=cliente.cliente_id WHERE prestamo.prestamo_estado = '$tipo' ORDER BY prestamo.prestamo_fecha_inicio DESC LIMIT $inicio, $registros";
        }

        $conexion = self::conectar();
        $datos = $conexion->prepare($consulta);
        $datos->execute();
        $datos = $datos->fetchAll();

        //* Obtener registros total de la base de datos
        $total = $conexion->prepare("SELECT FOUND_ROWS()");
        $total->execute();
        $total = (int) $total->fetchColumn();


        $numero_paginas = ceil($total / $registros);


        $tabla .= '
            <table class="table">
            <thead>
               <tr>
                 <th>#</th>
                 <th>CLEINTE</th>
                 <th>FECHA DE PRÉSTAMO</th>
                 <th>FECHA DE ENTREGA</th>
                 <th>TIPO</th>
                 <th>ESTADO</th>
                 <th>FACTURA</th>
                 <th>ACTUALIZAR</th>
                <th>ELIMINAR</th>
            </tr>
            </thead>
            <tbody> ';

        if ($pagina >= 1 && $pagina <= $numero_paginas) {

            $contador = $inicio + 1;
            $pag_inicio = $inicio + 1;
            foreach ($datos as $row) {

                $tabla .= '  
                    <tr>
                        <td>' . $contador . '</td>
                        <td>' . $row["cliente_nombre"] . ' ' . $row["cliente_apellido"] . '</td>
                        <td>' . date("d-m-Y", strtotime($row["prestamo_fecha_inicio"])) . '</td>
                        <td>' . date("d-m-Y", strtotime($row["prestamo_fecha_final"])) . '</td>';

                if ($row["prestamo_estado"] == "Reservacion") {
                    $tabla .= ' <td class="reservacion" >  <span>'  . $row["prestamo_estado"] . '</span></td>';
                } else if (($row["prestamo_estado"] == "Finalizado")) {
                    $tabla .= ' <td class="finalizado" >  <span>'  . $row["prestamo_estado"] . '</span></td>';
                } else if ($row["prestamo_estado"] == "Prestamo") {
                    $tabla .= ' <td class="prestamo" >  <span>'  . $row["prestamo_estado"] . '</span></td>';
                } else {
                    $tabla .= ' <td class="finalizado" >  <span>'  . $row["prestamo_estado"] . '</span></td>';
                }



                if ($row["prestamo_pagado"] < $row["prestamo_total"]) {

                    $tabla .= '<td class="pendiente"><span>Pendiente' . ' ' .  MONEDA . number_format(($row["prestamo_total"] - $row["prestamo_pagado"]), 2, '.', ',') . '</span></td>';
                } else {
                    $tabla .= '<td class="cancelado"><span>Cancelado</span></td>';
                }

                $tabla .= '<td> <a href="' . SERVERURL . 'bills/invoice.php?id=' . self::encryption($row["prestamo_id"]) . '" target="_blanck" ><span class="material-symbols-sharp icon-info"> receipt_long </span></a></td>';


                if ($row["prestamo_estado"] == "Finalizado" && $row["prestamo_pagado"] == $row["prestamo_total"]) {

                    $tabla .=  ' <td><span><span class="material-symbols-sharp icon-upd">update</span></span></td>';
                } else {
                    $tabla .=  ' <td><a href="' . SERVERURL . 'adminReservationUpdate/' . self::encryption($row["prestamo_id"]) . '"><span class="material-symbols-sharp icon-upd">update</span></a></td>';
                }


                $tabla .=  ' 
                        <td>
                            <form class="FormularioAjax" action=" ' . SERVERURL . 'ajax/prestamoAjax.php" method="POST" data-form="delete"  >
    
                            
                            <input type="hidden" name="prestamo_codigo" value="' . self::encryption($row["prestamo_codigo"]) . '">
                            <input type="hidden" name="prestamo_id" value="' . self::encryption($row['prestamo_id']) . '">
    
                            <button type="submit" class="eliminarForm"><span class="material-symbols-sharp icon-del">delete</span></button>
                        </form>
                            
                           
                        </td>
                    </tr>
                    ';
                $pag_final = $contador;
                $contador++;
            }
        } else {

            if ($total >= 1) {
                $tabla .= '
            <tr>
                <td class="recarTd" colspan="10"><a class="recargarBtn" href="' . $url . '1/">Haga click para recargar el listado</a></td>
            </tr>';
            } else {
                $tabla .= '
            <tr>
                <td colspan="100">No hay registros en el sistema</td>
            </tr>
                ';
            }
        }

        $tabla .= '
            </tbody>
            </thead>
        </table>
        ';

        if ($total >= 1 && $pagina <= $numero_paginas) {
            $tabla .= '
            <div class="mostrarInfo">
                <p>Mostrando préstamo del <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un total de <strong>' . $total . '</strong></p>
            </div>
            ';

            $tabla .= self::PaginadorTablas($pagina, $numero_paginas, $url, 6);
        }

        return $tabla;
    }


    //?---------------------Eliminar prestamos---------------------------//
    public function eliminarPrestamoControlador()
    {

        //*---------------- Verificando permisos del usuario-----------------//
        if ($_SESSION["privilegio_spm"] != 1) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Acción no permitida",
                "descripcion" => "No tienes el nivel de privilegio para eliminar clientes."
            ];

            return json_encode($alerta);
            exit();
        }


        //*Recuperando el código de préstamo//
        $codigo = self::decryption($_POST["prestamo_codigo"]);
        $codigo = self::limpiarCadena($codigo);


        //*Comprobando el préstamo en la BD //
        $chek_prestamo = self::ejecutarConsultaSimple("SELECT prestamo_codigo FROM prestamo WHERE prestamo_codigo = '$codigo'");

        if ($chek_prestamo->rowCount() <= 0) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Ocurrio un error",
                "descripcion" => "El préstamo que intentas eliminar no existe en el sistema."
            ];

            return json_encode($alerta);
            exit();
        }

        //*Comprobando y eliminar pagos//
        $chek_pagos = self::ejecutarConsultaSimple("SELECT prestamo_codigo FROM pago WHERE prestamo_codigo = '$codigo'");
        $chek_pagos = $chek_pagos->rowCount();


        if ($chek_pagos > 0) {

            $eliminar_pagos = mainModel::eliminarDatos("pago", "prestamo_codigo", $codigo);

            if ($eliminar_pagos->rowCount() != $chek_pagos) {

                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Ocurrio un error",
                    "descripcion" => "El préstamo que intentas eliminar no existe en el sistema."
                ];

                return json_encode($alerta);
                exit();
            }
        }


        //*Comprobando y eliminar detalles//
        $chek_detalle = self::ejecutarConsultaSimple("SELECT prestamo_codigo FROM detalle WHERE prestamo_codigo = '$codigo'");
        $chek_detalle = $chek_detalle->rowCount();

        if ($chek_detalle > 0) {

            $eliminar_detalle = mainModel::eliminarDatos("detalle", "prestamo_codigo", $codigo);

            if ($eliminar_detalle->rowCount() != $chek_detalle) {
                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Ocurrio un error",
                    "descripcion" => "El préstamo que intentas eliminar no existe en el sistema. detalle"
                ];

                return json_encode($alerta);
                exit();
            }
        }



        //*Comprobando y eliminar préstamo//

        $eliminar_prestamo = mainModel::eliminarDatos("prestamo", "prestamo_codigo", $codigo);
        if ($eliminar_prestamo->rowCount() == 1) {

            $alerta = [
                "tipo" => "recargar",
                "icono" => "exito",
                "titulo" => "Préstamo eliminado",
                "descripcion" => "El préstamo ha sido eliminado del sistema de forma exitosa."
            ];
        } else {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Ocurrio un error",
                "descripcion" => "El préstamo que intentas eliminar no existe en el sistema. 1"
            ];
        }
        return json_encode($alerta);
        exit();
    }


    //?---------------------Agregar pago controlador---------------------------//
    public function agregarPagoControlador()
    {

        //*------------------Recibiendo los datos----------------//
        $codigo = self::decryption($_POST["pago_codigo_reg"]);
        $codigo = self::limpiarCadena($codigo);

        $monto = self::limpiarCadena($_POST["pago_monto_reg"]);
        $monto = number_format($monto, "2", ".", "");


        //*------------------Verificar que el monto sea mayor a 0----------------//
        if ($monto <= 0) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Monto no válido",
                "descripcion" => "El pago debe ser mayor a 0. Verifica la información"
            ];
            return json_encode($alerta);
            exit();
        }


        //*Comprobando el préstamo en la BD //
        $datos_prestamo = self::ejecutarConsultaSimple("SELECT * FROM prestamo WHERE prestamo_codigo = '$codigo'");

        if ($datos_prestamo->rowCount() <= 0) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Ocurrio un error",
                "descripcion" => "El préstamo que intentas actualizar no existe en el sistema."
            ];

            return json_encode($alerta);
            exit();
        } else {
            $datos_prestamo = $datos_prestamo->fetch();
        }


        //*Comprobar que el monto no sea mayor mayor a lo que fata por pagar //
        $pendinete = number_format(($datos_prestamo["prestamo_total"] - $datos_prestamo["prestamo_pagado"]), "2", ".", "");


        if ($monto > $pendinete) {
            $alerta = [
                "tipo" => "error1",
                "icono" => "error",
                "titulo" => "Monto no válido",
                "descripcion" => "El monto ingresado no puede ser mayor a la cantidad pendiente por pagar de " . MONEDA . $pendinete . ".",
                "autoCierre" => "false"
            ];
            return json_encode($alerta);
            exit();
        }


        // *Calculando total a pagar y la fecha//
        $tota_pagado = number_format(($monto + $datos_prestamo["prestamo_pagado"]), "2", ".", "");
        $fecha = date("Y-m-d");

        $datos_pago_reg =
            [

                [
                    "campo_nombre" => "pago_total",
                    "campo_marcador" => ":Total",
                    "campo_valor" => $monto

                ],

                [
                    "campo_nombre" => "pago_fecha",
                    "campo_marcador" => ":Fecha",
                    "campo_valor" => $fecha

                ],

                [
                    "campo_nombre" => "prestamo_codigo",
                    "campo_marcador" => ":Codigo",
                    "campo_valor" => $codigo

                ]

            ];


        $agregar_pago = self::insertarDatos("pago", $datos_pago_reg);

        if ($agregar_pago->rowCount() == 1) {

            $datos_prestamo_up = [
                [
                    "campo_nombre" => "prestamo_pagado",
                    "campo_marcador" => ":Prestamo_pagado",
                    "campo_valor" => $tota_pagado

                ],
            ];

            $condicion = [
                "condicion_campo" => "prestamo_codigo ",
                "condicion_marcador" => ":Codigo",
                "condicion_valor" => $codigo
            ];

            if (self::actualizarDatos("prestamo", $datos_prestamo_up, $condicion)) {

                $alerta = [
                    "tipo" => "recargar",
                    "icono" => "exito",
                    "titulo" => "Pago realizado",
                    "descripcion" => "El pago de " . MONEDA . "$monto" . " se ha procesado correctamente y registrado en el sistema."
                ];
            } else {
                self::eliminarDatos("pago", "prestamo_codigo", $codigo);
                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "No se pudo registrar el pago",
                    "descripcion" => "Hubo un problema al intentar registrar el pago. Por favor, intenta nuevamente más tarde."
                ];
            }
        } else {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "No se pudo registrar el pago",
                "descripcion" => "Hubo un problema al intentar registrar el pago. Por favor, intenta nuevamente más tarde."
            ];
        }
        return json_encode($alerta);
    }


    //?---------------------Actualizar prestamo controlador---------------------------//
    public function actualizarPrestamoControlador()
    {

        //*------------------Recibiendo los datos----------------//
        $codigo = self::decryption($_POST["pago_codigo_up"]);
        $codigo = self::limpiarCadena($codigo);


        //*Comprobando el préstamo en la BD //
        $check_prestamo = self::ejecutarConsultaSimple("SELECT prestamo_codigo FROM prestamo WHERE prestamo_codigo = '$codigo'");

        if ($check_prestamo->rowCount() <= 0) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Ocurrio un error",
                "descripcion" => "El préstamo que intentas actualizar no existe en el sistema."
            ];

            return json_encode($alerta);
            exit();
        }

        //*------------------Recibiendo los datos----------------//
        $estado = self::limpiarCadena($_POST['estado']);
        $observacion_prestamo = self::limpiarCadena($_POST['observacion_prestamo']);



        //*------------------Verificando la integridad de los datos----------------//
        if ($estado != "Reservacion" && $estado != "Prestamo" && $estado != "Finalizado") {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el estado",
                "descripcion" => "El estado no coincide con el formato solicitado."
            ];
            return json_encode($alerta);
            exit();
        }

        if ($observacion_prestamo != "") {
            if (self::verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}", $observacion_prestamo)) {
                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Error en la observación",
                    "descripcion" => "La observación del préstamo no coincide con el formato solicitado."
                ];
                return json_encode($alerta);
                exit();
            }
        }


        $datos_prestamo_up = [
            [
                "campo_nombre" => "prestamo_estado",
                "campo_marcador" => ":Estado",
                "campo_valor" => $estado

            ],
            [
                "campo_nombre" => "prestamo_observacion",
                "campo_marcador" => ":Prestamo_observacion",
                "campo_valor" => $observacion_prestamo

            ]
        ];

        $condicion = [
            "condicion_campo" => "prestamo_codigo ",
            "condicion_marcador" => ":Codigo",
            "condicion_valor" => $codigo
        ];

        if (self::actualizarDatos("prestamo", $datos_prestamo_up, $condicion)) {

            $alerta = [
                "tipo" => "recargar",
                "icono" => "exito",
                "titulo" => "Préstamo modificado",
                "descripcion" => "El préstamo se ha procesado correctamente y actualizado en el sistema."
            ];
        } else {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Ocurrio un error inesperado",
                "descripcion" => "Hubo un problema al intentar actualizar el pr+estamo. Por favor, intenta nuevamente más tarde."
            ];
        }

        return json_encode($alerta);
    }
}
