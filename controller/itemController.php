<?php


if ($peticionAjax) {
    require_once("../model/mainModel.php");
} else {
    require_once("./model/mainModel.php");
}

class ItemController extends mainModel
{

    //?-----------------------Controlador para agregar un item-------------------------------//
    public function agregarItemControlador()
    {
        //* Recibiendo los datos del formulario//
        $codigo = self::limpiarCadena($_POST['item_codigo']);
        $nombre = self::limpiarCadena($_POST['item_nombre']);
        $stock = self::limpiarCadena($_POST['item_stock']);
        $estado = self::limpiarCadena($_POST['estado']);
        $detalle = self::limpiarCadena($_POST['item_detalle']);


        //* == comprobar campos vacíos ==*/
        if ($codigo == "" || $nombre == "" || $stock == "" || $estado == "") {
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
        if (self::verificarDatos("[a-zA-Z0-9-]{3,45}", $codigo)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el código",
                "descripcion" => "El còdigo no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $nombre)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el nombre",
                "descripcion" => "El nombre no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }


        if (self::verificarDatos("[0-9]{1,9}", $stock)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el stock",
                "descripcion" => "El stock no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }


        if ($detalle != "") {
            if (self::verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $detalle)) {
                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Error en el detalle",
                    "descripcion" => "El detalle no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
                ];
                return json_encode($alerta);
                exit();
            }
        }


        if ($estado != "Habilitado" && $estado != "Deshabilitado") {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el estado",
                "descripcion" => "El estado no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        //* Comprobando codigo para no repetir información el la base de datos//
        $checkCodigo = self::ejecutarConsultaSimple("SELECT item_codigo FROM item WHERE item_codigo = '$codigo'");
        if ($checkCodigo->rowCount() > 0) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el código",
                "descripcion" => "El código ya existe en el sistema. Por favor, verifica e intenta nuevamente."
            ];

            return json_encode($alerta);
            exit();
        }



        //* Comprobando el nombre para no repetir información el la base de datos//
        $checkCodigo = self::ejecutarConsultaSimple("SELECT item_nombre FROM item WHERE item_nombre = '$nombre'");
        if ($checkCodigo->rowCount() > 0) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el nombre",
                "descripcion" => "El nombre ya existe en el sistema. Por favor, verifica e intenta nuevamente."
            ];

            return json_encode($alerta);
            exit();
        }


        //* Arrys que contiene los valores que se van a insertar a la base de datos//
        $item_datos_reg = 
        [
            [
                "campo_nombre" => "item_codigo",
                "campo_marcador" => ":Codigo",
                "campo_valor" => $codigo

            ],

            [
                "campo_nombre" => "	item_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombre

            ],

            [
                "campo_nombre" => "item_stock",
                "campo_marcador" => ":Stock",
                "campo_valor" => $stock

            ],


            [
                "campo_nombre" => "	item_estado",
                "campo_marcador" => ":Estado",
                "campo_valor" => $estado

            ],

            [
                "campo_nombre" => "item_detalle",
                "campo_marcador" => ":Detalle",
                "campo_valor" => $detalle

            ]

        ];

        $agregar_item = self::insertarDatos("item", $item_datos_reg);

        if ($agregar_item->rowCount() > 0) {

            $alerta = [
                "tipo" => "limpiar",
                "icono" => "exito",
                "titulo" => "Item registrado",
                "descripcion" => "El item  ha sido registrado exitosamente en el sistema."
            ];
        } else {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "No se pudo registrar el item",
                "descripcion" => "Hubo un problema al intentar registrar el item. Por favor, intenta nuevamente más tarde."
            ];
        }

        return json_encode($alerta);
    }

    //?---------------------Controlador paginador de tabla---------------------------//
    public function paginadorItemControlador($pagina, $registros, $url, $busqueda)
    {

        //*--------------Limpiando los valores de ataques de inyeción-------------//
        $pagina = self::limpiarCadena($pagina);
        $registros = self::limpiarCadena($registros);
        $busqueda = self::limpiarCadena($busqueda);
        $url = self::limpiarCadena($url);

        $url = SERVERURL . $url . "/";
        $tabla = "";

        // Determinar en que pagina esta el usuario
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0; //Desde donde se va a extrater los datos 

        if (isset($busqueda) && $busqueda != "") {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM item WHERE (item_codigo LIKE '%$busqueda%' OR item_nombre LIKE '%$busqueda%' OR item_stock LIKE '%$busqueda%') ORDER BY item_nombre ASC  LIMIT $inicio, $registros";
        } else {
            $consulta =  "SELECT SQL_CALC_FOUND_ROWS * FROM item ORDER BY item_nombre ASC LIMIT $inicio, $registros";
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
                    <th>CÓDIGO</th>
                    <th>NOMBRE</th>
                    <th>STOCK</th>
                    <th>DETALLE</th>
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
                        <td>' . $row["item_codigo"] . '</td>
                        <td>' . $row["item_nombre"] . '</td>
                        <td>' . $row["item_stock"] . '</td>
                        <td>
                            <span class="material-symbols-sharp icon-info">info</span>
                            <div class="infoUser">
                                <div class="nombreCle">' . $row["item_nombre"] . '</strong></div>
                                <div class="DireccionCle">' . $row["item_detalle"] . '</div>
                            </div>
                         </td>
                        <td><a href="' . SERVERURL . 'adminItemUpdate/' . self::encryption($row["item_id"]) . '"><span class="material-symbols-sharp icon-upd">update</span></a></td>
                        <td>
                            <form class="FormularioAjax" action=" ' . SERVERURL . 'ajax/itemAjax.php" method="POST" data-form="delete"  >
    
                            
                            <input type="hidden" name="item" value="eliminar">
                            <input type="hidden" name="item_id" value="' . self::encryption($row['item_id']) . '">
    
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
                <p>Mostrando item del <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un total de <strong>' . $total . '</strong></p>
            </div>
            ';

            $tabla .= self::PaginadorTablas($pagina, $numero_paginas, $url, 6);
        }

        return $tabla;
    }


    //?-----------------------Controlador eliminar usuarios ---------------------//
    public function eliminarItemControlador()
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


        //*---------------- Recuperar ID del cliente----------------//
        $id = self::decryption($_POST["item_id"]);
        $id = self::limpiarCadena($id);


        //*---------------- Comprobando el cliente en la BD----------------//
        $check_item = self::seleccionarDatos("Unico", "item", "item_id", $id);
        if ($check_item->rowCount() <= 0) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Item no encontrado",
                "descripcion" => "El item que intentas eliminar no existe en el sistema."
            ];
            return json_encode($alerta);
            exit();
        }

        //*---------------- Comprobando detales de prestamos----------------//
        $check_prestamos = self::ejecutarConsultaSimple("SELECT item_id FROM detalle WHERE item_id = '$id' LIMIT 1");
        if ($check_prestamos->rowCount() > 0) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Acción no permitida",
                "descripcion" => "No se puede eliminar el item porque tiene préstamos asociados"
            ];
            return json_encode($alerta);
            exit();
        }


        //*---------------- Eliminando usuario----------------//
        $eliminarItem = self::eliminarDatos("item", "item_id", $id);

        if ($eliminarItem->rowCount() == 1) {


            $alerta = [
                "tipo" => "recargar",
                "icono" => "exito",
                "titulo" => "Item eliminado",
                "descripcion" => "El item se ha eliminado con éxito del sistema."
            ];
        } else {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error al eliminar",
                "descripcion" => "No se pudo eliminar el item del sistema. Por favor, intenta nuevamente más tarde."
            ];
        }

        return json_encode($alerta);
        exit();
    }


    //?-----------------------Controlador obtener datos del usuario ---------------------//
    public function datosItemControlador($tipo, $id)
    {

        $tipo = self::limpiarCadena($tipo);

        $id = self::decryption($id);
        $id = self::limpiarCadena($id);

        return self::seleccionarDatos($tipo, "item", "item_id", $id);
    }


    //?-----------------------Controlador actualizar item ---------------------//
    public function actualizarItemControlador()
    {


        //*---------------- Verificando permisos del usuario-----------------//
        if ($_SESSION["privilegio_spm"] < 1 || $_SESSION["privilegio_spm"] > 2) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Acción no permitida",
                "descripcion" => "No tienes el nivel de privilegio para actualizar la empresa."
            ];

            return json_encode($alerta);
            exit();
        }


        //*----------------- Recibiendo el id-------------------//
        $id = self::decryption($_POST["item_id"]);
        $id = self::limpiarCadena($id);

        //*----------------- Comprobando el usuario en la BD-------------------//
        $checkItem = self::ejecutarConsultaSimple("SELECT * FROM item WHERE item_id = '$id'");
        if ($checkItem->rowCount() <= 0) {

            $alerta = [
                "tipo" => "error",
                "icono" => "warning",
                "titulo" => "Item no encontrado",
                "descripcion" => "El Item que intentas buscar no existe en el sistema."
            ];

            return json_encode($alerta);
            exit();
        } else {
            $datosItem = $checkItem->fetch();
        }

        //* Recibiendo los datos del formulario//
        $codigo = self::limpiarCadena($_POST['item_codigo']);
        $nombre = self::limpiarCadena($_POST['item_nombre']);
        $stock = self::limpiarCadena($_POST['item_stock']);
        $estado = self::limpiarCadena($_POST['estado']);
        $detalle = self::limpiarCadena($_POST['item_detalle']);


        //* == comprobar campos vacíos ==*/
        if ($codigo == "" || $nombre == "" || $stock == "" || $estado == "") {
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
        if (self::verificarDatos("[a-zA-Z0-9-]{3,45}", $codigo)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el código",
                "descripcion" => "El código no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $nombre)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el nombre",
                "descripcion" => "El nombre no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }


        if (self::verificarDatos("[0-9]{1,9}", $stock)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el stock",
                "descripcion" => "El stock no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if ($detalle != "") {
            if (self::verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $detalle)) {
                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Error en el detalle",
                    "descripcion" => "El detalle no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
                ];
                return json_encode($alerta);
                exit();
            }
        }


        if ($estado != "Habilitado" && $estado != "Deshabilitado") {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el estado",
                "descripcion" => "El estado no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        //* Comprobando codigo para no repetir información el la base de datos//
        if ($datosItem["item_codigo"] != $codigo) {
            $checkCodigo = self::ejecutarConsultaSimple("SELECT item_codigo FROM item WHERE item_codigo = '$codigo'");
            if ($checkCodigo->rowCount() > 0) {
                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Error en el código",
                    "descripcion" => "El código ya existe en el sistema. Por favor, verifica e intenta nuevamente."
                ];

                return json_encode($alerta);
                exit();
            }
        }



        //* Comprobando el nombre para no repetir información el la base de datos//
        if ($datosItem["item_nombre"] != $nombre) {
            $checkCodigo = self::ejecutarConsultaSimple("SELECT item_nombre FROM item WHERE item_nombre = '$nombre'");
            if ($checkCodigo->rowCount() > 0) {
                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Error en el nombre",
                    "descripcion" => "El nombre ya existe en el sistema. Por favor, verifica e intenta nuevamente."
                ];

                return json_encode($alerta);
                exit();
            }
        }



        //* Arrys que contiene los valores que se van a insertar a la base de datos//
        $item_datos_up = [
            [
                "campo_nombre" => "item_codigo",
                "campo_marcador" => ":Codigo",
                "campo_valor" => $codigo

            ],

            [
                "campo_nombre" => "	item_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombre

            ],

            [
                "campo_nombre" => "item_stock",
                "campo_marcador" => ":Stock",
                "campo_valor" => $stock

            ],


            [
                "campo_nombre" => "	item_estado",
                "campo_marcador" => ":Estado",
                "campo_valor" => $estado

            ],

            [
                "campo_nombre" => "item_detalle",
                "campo_marcador" => ":Detalle",
                "campo_valor" => $detalle

            ]

        ];

        $condicion = [
            "condicion_campo" => "item_id",
            "condicion_marcador" => ":Id",
            "condicion_valor" => $id
        ];

        if (self::actualizarDatos("item", $item_datos_up, $condicion)) {

            $alerta = [
                "tipo" => "recargar",
                "icono" => "success",
                "titulo" => "Item actualizado",
                "descripcion" => "El Item ha sido actualizado exitosamente y los cambios se guardaron correctamente."

            ];
        } else {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en la actualización",
                "descripcion" => "No se pudo actualizar el item. Verificar la información"
            ];
        }

        return json_encode($alerta);
    }

    
}
