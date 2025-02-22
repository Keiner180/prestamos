<?php

if ($peticionAjax) {
    require_once("../model/mainModel.php");
} else {
    require_once("./model/mainModel.php");
}

class ClienteController extends mainModel
{

    //?-------------Controlador agregar cliente------------------//
    public function agregarClienteControlador()
    {


        //*--------------Recibiendo los datos del formulario---------------// 
        $dni = self::limpiarCadena($_POST["cliente_dni"]);
        $nombre = self::limpiarCadena($_POST["cliente_nombres"]);
        $apellido = self::limpiarCadena($_POST["cliente_apellidos"]);
        $telefono = self::limpiarCadena($_POST["cliente_telefono"]);
        $direccion = self::limpiarCadena($_POST["cliente_direccion"]);



        //*--------------Validando los campos obligatorios--------------// 
        if (empty($dni) || empty($nombre) || empty($apellido) || empty($telefono) || empty($direccion)) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Campos incompletos",
                "descripcion" => "No has llenado todos los campos que son obligatorios. Por favor, verifica e intenta nuevamente."
            ];

            return json_encode($alerta);
            exit();
        }


        //   *== Verificando integridad de los datos     ==*/
        if (self::verificarDatos("[0-9-]{7,20}", $dni)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el DNI",
                "descripcion" => "El DNI no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
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

        if (self::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $apellido)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el apellido",
                "descripcion" => "El apellido no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("[0-9()+]{8,20}", $telefono)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el teléfono",
                "descripcion" => "El teléfono no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\-\s@_+]{4,190}", $direccion)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en la dirección",
                "descripcion" => "La dirección no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }


        //* Comprobando el DNI para no repetir la misma información
        $checkDni = self::ejecutarConsultaSimple("SELECT cliente_dni FROM cliente WHERE cliente_dni = '$dni'");
        if ($checkDni->rowCount() > 0) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "DNI ya registrado",
                "descripcion" => "El DNI ingresado ya existe en la base de datos. Por favor, verifica los datos e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }



        //* Arrys que contiene los valores que se van a insertar a la base de datos//
        $cliente_datos_reg = [
            [
                "campo_nombre" => "cliente_dni",
                "campo_marcador" => ":DNI",
                "campo_valor" => $dni

            ],

            [
                "campo_nombre" => "cliente_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombre

            ],

            [
                "campo_nombre" => "cliente_apellido",
                "campo_marcador" => ":Apellido",
                "campo_valor" => $apellido

            ],


            [
                "campo_nombre" => "	cliente_telefono",
                "campo_marcador" => ":Telefono",
                "campo_valor" => $telefono

            ],

            [
                "campo_nombre" => "cliente_direccion",
                "campo_marcador" => ":Direccion",
                "campo_valor" => $direccion

            ]

        ];

        $agregar_cliente = self::insertarDatos("cliente", $cliente_datos_reg);

        if ($agregar_cliente->rowCount() > 0) {

            $alerta = [
                "tipo" => "limpiar",
                "icono" => "exito",
                "titulo" => "Cliente registrado",
                "descripcion" => "El Cliente " . $nombre . " ha sido registrado exitosamente en el sistema."
            ];
        } else {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "No se pudo registrar el cliente",
                "descripcion" => "Hubo un problema al intentar registrar el cliente. Por favor, intenta nuevamente más tarde."
            ];
        }

        return json_encode($alerta);
    }


    //?-----------------------Controlador pagianador de tablas ---------------------//
    public function paginadorClienteControlador($pagina, $registros, $url, $busqueda)
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
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM cliente WHERE (cliente_dni LIKE '%$busqueda%' OR cliente_nombre LIKE '%$busqueda%' OR cliente_apellido LIKE '%$busqueda%' OR cliente_telefono LIKE '%$busqueda%') ORDER BY cliente_nombre ASC  LIMIT $inicio, $registros";
        } else {
            $consulta =  "SELECT SQL_CALC_FOUND_ROWS * FROM cliente ORDER BY cliente_nombre ASC LIMIT $inicio, $registros";
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
                    <th>DNI</th>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>TELÉFONO</th>
                    <th>DIRECCIÓN</th>
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
                        <td>' . $row["cliente_dni"] . '</td>
                        <td>' . $row["cliente_nombre"] . '</td>
                        <td>' . $row["cliente_apellido"] . '</td>
                        <td>' . $row["cliente_telefono"] . '</td>
                        <td>
                            <span class="material-symbols-sharp icon-info">info</span>
                            <div class="infoUser">
                                <div class="nombreCle">' . $row["cliente_nombre"] . '</strong></div>
                                <div class="DireccionCle">' . $row["cliente_direccion"] . '</div>
                            </div>
                         </td>
                        <td><a href="' . SERVERURL . 'adminclienteUpdate/' . self::encryption($row["cliente_id"]) . '"><span class="material-symbols-sharp icon-upd">update</span></a></td>
                        <td>
                            <form class="FormularioAjax" action=" ' . SERVERURL . 'ajax/clienteAjax.php" method="POST" data-form="delete"  >
    
                            
                            <input type="hidden" name="cliente" value="eliminar">
                            <input type="hidden" name="cliente_id" value="' . self::encryption($row['cliente_id']) . '">
    
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
                <p>Mostrando clientes del <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un total de <strong>' . $total . '</strong></p>
            </div>
            ';

            $tabla .= self::PaginadorTablas($pagina, $numero_paginas, $url, 6);
        }

        return $tabla;
    }


    //?-----------------------Controlador eliminar usuarios ---------------------//
    public function eliminarClienteControlador()
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
        $id = self::decryption($_POST["cliente_id"]);
        $id = self::limpiarCadena($id);


        //*---------------- Comprobando el cliente en la BD----------------//
        $check_cliente = self::seleccionarDatos("Unico", "cliente", "cliente_id", $id);
        if ($check_cliente->rowCount() <= 0) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Cliente no encontrado",
                "descripcion" => "El Cliente que intentas eliminar no existe en el sistema."
            ];
            return json_encode($alerta);
            exit();
        }

        //*---------------- Comprobando los prestamos del usuario----------------//
        $check_prestamos = self::ejecutarConsultaSimple("SELECT cliente_id FROM prestamo WHERE cliente_id = '$id' LIMIT 1");
        if ($check_prestamos->rowCount() > 0) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Acción no permitida",
                "descripcion" => "No se puede eliminar al usuario porque tiene préstamos asociados"
            ];
            return json_encode($alerta);
            exit();
        }


        //*---------------- Eliminando usuario----------------//
        $eliminarCliente = self::eliminarDatos("cliente", "cliente_id", $id);

        if ($eliminarCliente->rowCount() == 1) {


            $alerta = [
                "tipo" => "recargar",
                "icono" => "exito",
                "titulo" => "Cliente eliminado",
                "descripcion" => "El cliente se ha eliminado con éxito del sistema."
            ];
        } else {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error al eliminar",
                "descripcion" => "No se pudo eliminar el cliente del sistema. Por favor, intenta nuevamente más tarde."
            ];
        }

        return json_encode($alerta);
        exit();
    }


    //?-----------------------Controlador obtener datos del usuario ---------------------//
    public function datosClienteControlador($tipo, $id)
    {

        $tipo = self::limpiarCadena($tipo);

        $id = self::decryption($id);
        $id = self::limpiarCadena($id);

        return self::seleccionarDatos($tipo, "cliente", "cliente_id", $id);
    }

    //?-----------------------Controlador actualizar datos de cliente ---------------------//
    public function actualizarClienteControlador()
    {


        //*----------------- Recibiendo el id-------------------//
        $id = self::decryption($_POST["cliente_id"]);
        $id = self::limpiarCadena($id);

        //*----------------- Comprobando el usuario en la BD-------------------//
        $checkCliente = self::ejecutarConsultaSimple("SELECT * FROM cliente WHERE cliente_id = '$id'");
        if ($checkCliente->rowCount() <= 0) {

            $alerta = [
                "tipo" => "error",
                "icono" => "warning",
                "titulo" => "Usuario no encontrado",
                "descripcion" => "El usuario que intentas buscar no existe en el sistema."
            ];

            return json_encode($alerta);
            exit();
        } else {
            $datosCliente = $checkCliente->fetch();
        }

        //* Recibiendo las datos del formulario

        //*--------------Recibiendo los datos del formulario---------------// 
        $dni = self::limpiarCadena($_POST["cliente_dni"]);
        $nombre = self::limpiarCadena($_POST["cliente_nombres"]);
        $apellido = self::limpiarCadena($_POST["cliente_apellidos"]);
        $telefono = self::limpiarCadena($_POST["cliente_telefono"]);
        $direccion = self::limpiarCadena($_POST["cliente_direccion"]);



        //*--------------Validando los campos obligatorios--------------// 
        if (empty($dni) || empty($nombre) || empty($apellido) || empty($telefono) || empty($direccion)) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Campos incompletos",
                "descripcion" => "No has llenado todos los campos que son obligatorios. Por favor, verifica e intenta nuevamente."
            ];

            return json_encode($alerta);
            exit();
        }


        //   *== Verificando integridad de los datos     ==*/
        if (self::verificarDatos("[0-9-]{7,20}", $dni)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el DNI",
                "descripcion" => "El DNI no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
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

        if (self::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $apellido)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el apellido",
                "descripcion" => "El apellido no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("[0-9()+]{8,20}", $telefono)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el teléfono",
                "descripcion" => "El teléfono no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\-\s@_+]{4,190}", $direccion)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en la dirección",
                "descripcion" => "La dirección no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }


        //* Comprobando el DNI para no repetir la misma información
        if ($dni != $datosCliente["cliente_dni"]) {

            $checkDni = self::ejecutarConsultaSimple("SELECT cliente_dni FROM cliente WHERE cliente_dni = '$dni'");
            if ($checkDni->rowCount() > 0) {
                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "DNI ya registrado",
                    "descripcion" => "El DNI ingresado ya existe en la base de datos. Por favor, verifica los datos e intenta nuevamente."
                ];
                return json_encode($alerta);
                exit();
            }
        }






        //* Preparando datos para enviarlos al modelo
        $cliente_datos_up = [
            [
                "campo_nombre" => "cliente_dni",
                "campo_marcador" => ":DNI",
                "campo_valor" => $dni

            ],

            [
                "campo_nombre" => "cliente_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombre

            ],

            [
                "campo_nombre" => "cliente_apellido",
                "campo_marcador" => ":Apellido",
                "campo_valor" => $apellido

            ],


            [
                "campo_nombre" => "	cliente_telefono",
                "campo_marcador" => ":Telefono",
                "campo_valor" => $telefono

            ],

            [
                "campo_nombre" => "cliente_direccion",
                "campo_marcador" => ":Direccion",
                "campo_valor" => $direccion

            ]

        ];

        $condicion = [
            "condicion_campo" => "cliente_id",
            "condicion_marcador" => ":Id",
            "condicion_valor" => $id
        ];

        if (self::actualizarDatos("cliente", $cliente_datos_up, $condicion)) {

            $alerta = [
                "tipo" => "recargar",
                "icono" => "success",
                "titulo" => "Cliente actualizado",
                "descripcion" => "El cliente ha sido actualizado exitosamente y los cambios se guardaron correctamente."

            ];
        } else {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en la actualización",
                "descripcion" => "No se pudo actualizar el cliente. Verificar la información"
            ];
        }

        return json_encode($alerta);
    }
}
