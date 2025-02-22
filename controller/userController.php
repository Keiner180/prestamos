<?php

if ($peticionAjax) {
    require_once("../model/mainModel.php");
} else {
    require_once("./model/mainModel.php");
}

class userController extends mainModel
{


    //?-----------------------Controlador agregar usuario ---------------------//
    public function addControllerUser()
    {

        //* Recibiendo las datos del formulario
        $dni = self::limpiarCadena($_POST['usuario_dni']);
        $nombres = self::limpiarCadena($_POST['usuario_nombres']);
        $apellidos = self::limpiarCadena($_POST['usuario_apellidos']);
        $telefono = self::limpiarCadena($_POST['usuario_telefono']);
        $direccion = self::limpiarCadena($_POST['usuario_direccion']);
        $nombre_usuario = self::limpiarCadena($_POST['usuario_nombre_usuario']);
        $email = self::limpiarCadena($_POST['usuario_email']);
        $password1 = self::limpiarCadena($_POST['usuario_contrasena']);
        $password2 = self::limpiarCadena($_POST['usuario_repetir_contrasena']);
        $privilegio = self::limpiarCadena($_POST['usuario_privilegio']);

        //* == comprobar campos vacíos ==*/
        if ($dni == "" || $nombres == "" || $apellidos == "" || $nombre_usuario == "" || $password1 == "" || $password2 == "" || $email == "" || $privilegio == "") {
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

        if (self::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $nombres)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el nombre",
                "descripcion" => "El nombre no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $apellidos)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el apellido",
                "descripcion" => "El apellido no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if ($telefono != "") {
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
        }

        if ($direccion != "") {
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
        }

        if (self::verificarDatos("[a-zA-Z0-9]{4,35}", $nombre_usuario)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el nombre de usuario",
                "descripcion" => "El nombre de usuario no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $password1) || self::verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $password2)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en las contraseñas",
                "descripcion" => "Las contraseñas no coinciden con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }


        //* Comprobando el DNI para no repetir la misma información
        $checkDni = self::ejecutarConsultaSimple("SELECT usuario_dni FROM usuario WHERE usuario_dni = '$dni'");
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


        //* Comprobando el USUARIO para no repetir la misma información
        $checkUser = self::ejecutarConsultaSimple("SELECT usuario_usuario FROM usuario WHERE usuario_usuario = '$nombre_usuario'");
        if ($checkUser->rowCount() > 0) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Usuario ya registrado",
                "descripcion" => "El nombre de usuario ingresado ya existe en la base de datos. Por favor, elige un nombre de usuario diferente."
            ];

            return json_encode($alerta);
            exit();
        }


        //* Comprobando el EMAIL para no repetir la misma información
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $checkEmail = self::ejecutarConsultaSimple("SELECT usuario_email FROM usuario WHERE usuario_email = '$email'");
            if ($checkEmail->rowCount() > 0) {
                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Correo ya registrado",
                    "descripcion" => "El correo ingresado ya existe en la base de datos. Por favor, utiliza un correo diferente."
                ];

                return json_encode($alerta);
                exit();
            }
        } else {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Formato de correo no válido",
                "descripcion" => "El correo ingresado no cumple con el formato requerido. Por favor, verifica e intenta nuevamente."
            ];

            return json_encode($alerta);
            exit();
        }


        if (self::verificarDatos("[1-3-]{1}", $privilegio)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el privilegio",
                "descripcion" => "El PRIVILEGIO no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }


        //* Comprobando las contraseñas
        if ($password1 != $password2) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Contraseñas no coinciden",
                "descripcion" => "Las contraseñas ingresadas no coinciden. Por favor, verifica y vuelve a intentarlo."
            ];
            return json_encode($alerta);
            exit();
        } else {
            $clave = self::encryption($password1);
        }


        //* Comprobando los privilegios
        if ($privilegio < 1 || $privilegio > 3) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Privilegio no válido",
                "descripcion" => "El privilegio seleccionado no es válido. Por favor, selecciona un privilegio válido e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }



        //* Arrys que contiene los valores que se van a insertar a la base de datos//
        $usuario_datos_reg = [
            [
                "campo_nombre" => "	usuario_dni",
                "campo_marcador" => ":DNI",
                "campo_valor" => $dni

            ],

            [
                "campo_nombre" => "usuario_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombres

            ],

            [
                "campo_nombre" => "usuario_apellido",
                "campo_marcador" => ":Apellido",
                "campo_valor" => $apellidos

            ],


            [
                "campo_nombre" => "	usuario_telefono",
                "campo_marcador" => ":Telefono",
                "campo_valor" => $telefono

            ],

            [
                "campo_nombre" => "usuario_direccion",
                "campo_marcador" => ":Direccion",
                "campo_valor" => $direccion

            ],

            [
                "campo_nombre" => "	usuario_email",
                "campo_marcador" => ":Email",
                "campo_valor" => $email

            ],

            [
                "campo_nombre" => "usuario_usuario",
                "campo_marcador" => ":Usuario",
                "campo_valor" => $nombre_usuario

            ],

            [
                "campo_nombre" => "usuario_clave",
                "campo_marcador" => ":Clave",
                "campo_valor" => $clave

            ],

            [
                "campo_nombre" => "usuario_estado",
                "campo_marcador" => ":Estado",
                "campo_valor" => "Activa"

            ],

            [
                "campo_nombre" => "usuario_privilegio",
                "campo_marcador" => ":Privilegio",
                "campo_valor" => $privilegio

            ]
        ];

        $agregar_usuario = self::insertarDatos("usuario", $usuario_datos_reg);

        if ($agregar_usuario->rowCount() == 1) {

            //*---------- Cambiando la informacion de la vairble privilegio--------//
            if ($privilegio == 1) {
                $permiso = "Control total";
            } elseif ($privilegio == 2) {
                $permiso = "Registrar y actualizar";
            } elseif ($privilegio == 3) {
                $permiso = "Permisos para registrar";
            }


            $mensajeEmail = [
                "asunto" => "¡Bienvenido al sistema de préstamos!",
                "mensaje" => "
                    <html lang='es'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Bienvenido al Sistema de Administración de Préstamos</title>
                    </head>
                    <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #F7FAFC; color: #2d3748;'>
                        <div style='max-width: 100%; margin: 40px auto; background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);'>
                            <div style='text-align: center; background-color: #1a202c; color: #ffffff; padding: 20px; border-radius: 8px 8px 0 0;'>
                                <h1 style='margin: 0; font-size: 24px;'>¡Bienvenido al sistema de administración de préstamos!</h1>
                            </div>
                            <div style='padding: 20px; font-size: 16px; line-height: 1.6;'>
                                <p>Estimado/a <span style='color: #1a202c; font-weight: bold;'>" . ($nombres) . " " . ($apellidos) . "</span>,</p>
                                <p>Nos complace informarte que tu cuenta como administrador ha sido registrada con éxito en el sistema de administración de préstamos. Ahora podrás gestionar y administrar los usuarios y préstamos de manera eficiente.</p>
                                
                                <p>A continuación, te proporcionamos los detalles para acceder a tu cuenta:</p>
                                <p><strong>Nombre de Usuario:</strong> <span style='color: #1a202c; font-weight: bold;'>" . ($nombre_usuario) . "</span></p>
                                <p><strong>Contraseña Temporal:</strong> <span style='color: #1a202c; font-weight: bold;'>" . ($password1) . "</span></p>
                                <p><strong>Tipo de Privilegio:</strong> <span style='color: #38b2ac; font-weight: bold;'>" . ($permiso) . "</span></p>
                                
                                <p>Recuerda que debes mantener tu nombre de usuario y contraseña seguros</p>

                                <p>Para comenzar, simplemente inicia sesión con tus credenciales en el siguiente enlace:</p>
                                <a href='" . SERVERURL . "login' style='background-color: #38b2ac; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-size: 16px; display: inline-block; text-align: center;'>Ir al inicio de sesión</a>

                                <p>Te recomendamos cambiar tu contraseña tras iniciar sesión por primera vez para mayor seguridad.</p>
                                <p>Si tienes alguna pregunta o necesitas asistencia adicional, no dudes en contactar a nuestro equipo de soporte a través del siguiente correo: <a href='mailto:sistemaprestamos2025@gmail.com' style='color: #38b2ac; text-decoration: none;'>soporte@tusitio.com</a>.</p>
                            </div>
                            <div style='text-align: center; font-size: 14px; color: #718096; padding: 10px 0; background-color: #f1f1f1; border-radius: 0 0 8px 8px;'>
                                <p>Atentamente, <br><strong>El equipo de soporte del sistema de administración de préstamos</strong></p>
                                <p>Si no solicitaste este registro, por favor <a href='mailto:sistemaprestamos2025@gmail.com' style='color: #38b2ac; text-decoration: none;'>contáctanos</a> inmediatamente.</p>
                            </div>
                        </div>
                    </body>
                    </html>",
                "correo" => $email
            ];


            $alerta = [
                "tipo" => "limpiar",
                "icono" => "exito",
                "titulo" => "Usuario registrado",
                "descripcion" => "El usuario ha sido registrado exitosamente en el sistema."
            ];

            self::enviarCorreo($mensajeEmail);
        } else {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "No se pudo registrar el usuario",
                "descripcion" => "Hubo un problema al intentar registrar el usuario. Por favor, intenta nuevamente más tarde."
            ];
        }

        return json_encode($alerta);
        exit();
    }


    //?-----------------------Controlador pagianador de tablas ---------------------//
    public function paginadorUsuarioControlador($pagina, $registros, $privilegio, $url, $id, $busqueda)
    {

        // *Limpiar los parametros (evitar ataques de inyeccion)
        $pagina = self::limpiarCadena($pagina);
        $registros = self::limpiarCadena($registros);
        $privilegio = self::limpiarCadena($privilegio);
        $id = self::limpiarCadena($id);
        $busqueda = self::limpiarCadena($busqueda);
        $url = self::limpiarCadena($url);

        $url = SERVERURL . $url . "/";
        $tabla = "";

        // Determinar en que pagina esta el usuario
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0; //Desde donde se va a extrater los datos 

        if (isset($busqueda) && $busqueda != "") {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE ((usuario_id!='$id'AND usuario_id!='1') AND (usuario_dni LIKE '%$busqueda%' OR usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_telefono LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%')) ORDER BY usuario_nombre ASC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE usuario_id!='$id'AND usuario_id!='1' ORDER BY usuario_nombre ASC LIMIT $inicio, $registros";
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
                    <th>USUARIO</th>
                    <th>EMAIL</th>
                    <th>ACTUALIZAR</th>
                    <th>ELIMINAR</th>
                </tr>
              </thead>
            <tbody>
        ';


        if ($total >= 1 && $pagina <= $numero_paginas) {

            $contador = $inicio + 1;
            $pag_inicio = $inicio + 1;
            foreach ($datos as $row) {

                $tabla .= '  
                <tr>
                    <td>' . $contador . '</td>
                    <td>' . $row["usuario_dni"] . '</td>
                    <td>' . $row["usuario_nombre"] . '</td>
                    <td>' . $row["usuario_apellido"] . '</td>
                    <td>' . $row["usuario_telefono"] . '</td>
                    <td>' . $row["usuario_usuario"] . '</td>
                    <td>' . $row["usuario_email"] . '</td>
                    <td><a href="' . SERVERURL . 'adminUserUpdate/' . self::encryption($row["usuario_id"]) . '"><span class="material-symbols-sharp icon-upd">update</span></a></td>
                    <td>
                        <form class="FormularioAjax" action=" ' . SERVERURL . 'ajax/userAjax.php" method="POST" data-form="delete"  >

                        
                        <input type="hidden" name="user" value="eliminar">
                        <input type="hidden" name="usuario_id" value="' . self::encryption($row['usuario_id']) . '">

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
                <p>Mostrando usuarios del <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un total de <strong>' . $total . '</strong></p>
            </div>
            ';

            $tabla .= self::PaginadorTablas($pagina, $numero_paginas, $url, 6);
        }

        return $tabla;
    }


    //?-----------------------Controlador eliminar usuarios ---------------------//
    public function eliminarUsuarioControlador()
    {

        //*---------------- Verificando permisos del usuario-----------------//
        if ($_SESSION["privilegio_spm"] != 1) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Acción no permitida",
                "descripcion" => "No tienes el nivel de privilegio para eliminar usuarios."
            ];

            return json_encode($alerta);
            exit();
        }


        //*---------------- Recuperar ID del usuario----------------//
        $id = self::decryption($_POST["usuario_id"]);
        $id = self::limpiarCadena($id);


        //*---------------- Comprobando el usuario----------------//
        if ($id == 1) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Acción no permitida",
                "descripcion" => "No se puede eliminar al administrador principal del sistema."
            ];
            return json_encode($alerta);
            exit();
        }



        //*---------------- Comprobando el usuario en la BD----------------//
        $check_usuario = self::seleccionarDatos("Unico", "usuario", "usuario_id", $id);
        if ($check_usuario->rowCount() <= 0) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Usuario no encontrado",
                "descripcion" => "El usuario que intentas eliminar no existe en el sistema."
            ];
            return json_encode($alerta);
            exit();
        }

        //*---------------- Comprobando los prestamos del usuario----------------//
        $check_prestamos = self::ejecutarConsultaSimple("SELECT usuario_id FROM prestamo WHERE usuario_id = '$id' LIMIT 1");
        if ($check_prestamos->rowCount() > 0) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Acción no permitida",
                "descripcion" => "No se puede eliminar al usuario porque tiene préstamos asociados. Puedes deshabilitar la cuenta"
            ];
            return json_encode($alerta);
            exit();
        }

        $datos_usuario = $check_usuario->fetch();


        //*---------------- Eliminando usuario----------------//
        $eliminarUsuario = self::eliminarDatos("usuario", "usuario_id", $id);

        if ($eliminarUsuario->rowCount() == 1) {

            $mensajeEmail = [
                "asunto" => "Cuenta eliminada del sistema de préstamos",
                "mensaje" => "
                    <html lang='es'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Cuenta Eliminada del Sistema de Administración de Préstamos</title>
                    </head>
                    <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #F7FAFC; color: #2d3748;'>
                        <div style='max-width: 100%; margin: 40px auto; background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);'>
                            <div style='text-align: center; background-color: #e53e3e; color: #ffffff; padding: 20px; border-radius: 8px 8px 0 0;'>
                                <h1 style='margin: 0; font-size: 24px;'>Tu cuenta ha sido eliminada</h1>
                            </div>
                            <div style='padding: 20px; font-size: 16px; line-height: 1.6;'>
                                <p>Estimado/a <span style='color: #1a202c; font-weight: bold;'>" . $datos_usuario["usuario_nombre"] . " " . $datos_usuario["usuario_apellido"] . "</span>,</p>
                                <p>Lamentamos informarte que tu cuenta ha sido eliminada del sistema de administración de préstamos. A continuación, te proporcionamos los detalles de la cuenta que ha sido eliminada:</p>
            
                                <p><strong>Nombre Completo:</strong> <span style='color: #1a202c; font-weight: bold;'>" . $datos_usuario["usuario_nombre"] . " " . $datos_usuario["usuario_apellido"] . "</span></p>
                                <p><strong>DNI:</strong> <span style='color: #1a202c; font-weight: bold;'>" . $datos_usuario["usuario_dni"] . "</span></p>
                                <p><strong>Nombre de Usuario:</strong> <span style='color: #1a202c; font-weight: bold;'>" . $datos_usuario["usuario_usuario"] . "</span></p>
            
                                <p>Si crees que esto ha sido un error, por favor contacta a nuestro equipo de soporte para asistencia adicional.</p>
            
            
                                <p>Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos a través del siguiente correo: <a href='mailto:sistemaprestamos2025@gmail.com' style='color: #38b2ac; text-decoration: none;'>soporte@tusitio.com</a>.</p>
                            </div>
                            <div style='text-align: center; font-size: 14px; color: #718096; padding: 10px 0; background-color: #f1f1f1; border-radius: 0 0 8px 8px;'>
                                <p>Atentamente, <br><strong>El equipo de soporte del sistema de administración de préstamos</strong></p>
                                <p>Si no solicitaste esta eliminación, por favor <a href='mailto:sistemaprestamos2025@gmail.com' style='color: #38b2ac; text-decoration: none;'>contáctanos</a> inmediatamente.</p>
                            </div>
                        </div>
                    </body>
                    </html>",
                "correo" => $datos_usuario["usuario_email"]
            ];



            $alerta = [
                "tipo" => "recargar",
                "icono" => "exito",
                "titulo" => "Usuario eliminado",
                "descripcion" => "El usuario se ha eliminado con éxito del sistema."
            ];
            self::enviarCorreo($mensajeEmail);
        } else {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error al eliminar",
                "descripcion" => "No se pudo eliminar al usuario del sistema. Por favor, intenta nuevamente más tarde."
            ];
        }

        return json_encode($alerta);
        exit();
    }


    //?-----------------------Controlador obtener datos del usuario ---------------------//
    public function datosUsuarioControlador($tipo, $id)
    {

        $tipo = self::limpiarCadena($tipo);

        $id = self::decryption($id);
        $id = self::limpiarCadena($id);

        return self::seleccionarDatos($tipo, "usuario", "usuario_id", $id);
    }

    //?-----------------------Controlador actualizar datos del usuario ---------------------//
    public function actualizarUsuarioControlador()
    {

        //*----------------- Recibiendo el id-------------------//
        $id = self::decryption($_POST["usuario_id"]);
        $id = self::limpiarCadena($id);

        //*----------------- Comprobando el usuario en la BD-------------------//
        $checUser = self::ejecutarConsultaSimple("SELECT * FROM usuario WHERE usuario_id = '$id'");
        if ($checUser->rowCount() <= 0) {

            $alerta = [
                "tipo" => "error",
                "icono" => "warning",
                "titulo" => "Usuario no encontrado",
                "descripcion" => "El usuario que intentas buscar no existe en el sistema."
            ];

            return json_encode($alerta);
            exit();
        } else {
            $datosUsuario = $checUser->fetch();
        }

        //* Recibiendo las datos del formulario
        $dni = self::limpiarCadena($_POST['usuario_dni']);
        $nombres = self::limpiarCadena($_POST['usuario_nombres']);
        $apellidos = self::limpiarCadena($_POST['usuario_apellidos']);
        $telefono = self::limpiarCadena($_POST['usuario_telefono']);
        $direccion = self::limpiarCadena($_POST['usuario_direccion']);
        $nombre_usuario = self::limpiarCadena($_POST['usuario_nombre_usuario']);
        $email = self::limpiarCadena($_POST['usuario_email']);

        // *-----Si existe el valor estado-------//
        if (isset($_POST['usuario_estado'])) {
            $estado = self::limpiarCadena($_POST["usuario_estado"]);
        } else {
            $estado = $datosUsuario["usuario_estado"];
        }

        // *-----Si existe el valor privilegio-----//
        if (isset($_POST['usuario_privilegio'])) {
            $privilegio = self::limpiarCadena($_POST["usuario_privilegio"]);
        } else {
            $privilegio = $datosUsuario["usuario_privilegio"];
        }

        // *-----Recibiendo los datos de la cuenat a actializar-----//
        $admin_usuario = self::limpiarCadena($_POST["admin_usuario"]);
        $admin_password = self::limpiarCadena($_POST["admin_password"]);

        $tipo_cuenta = self::limpiarCadena($_POST["tipo_cuenta"]);


        //* == comprobar campos vacíos ==*/
        if ($dni == "" || $nombres == "" || $apellidos == "" || $nombre_usuario == "" ||  $email == "" ||  $admin_usuario == "" || $admin_password == "") {
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

        if (self::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $nombres)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el nombre",
                "descripcion" => "El nombre no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if (self::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $apellidos)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el apellido",
                "descripcion" => "El apellido no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }

        if ($telefono != "") {
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
        }

        if ($direccion != "") {
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
        }

        if (self::verificarDatos("[a-zA-Z0-9]{4,35}", $nombre_usuario)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el nombre de usuario",
                "descripcion" => "El nombre de usuario no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }


        if (self::verificarDatos("[a-zA-Z0-9]{4,35}", $admin_usuario)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en el nombre de usuario",
                "descripcion" => "Tu nombre de usuario no coincide con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }



        if (self::verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $admin_password)) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en la contraseña",
                "descripcion" => "TU contraseña no coinciden con el formato solicitado. Por favor, verifica e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }
        $admin_password = self::encryption($admin_password);


        //* Comprobando los privilegios
        if ($privilegio < 1 || $privilegio > 3) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Privilegio no válido",
                "descripcion" => "El privilegio seleccionado no es válido. Por favor, selecciona un privilegio válido e intenta nuevamente."
            ];
            return json_encode($alerta);
            exit();
        }


        if ($estado != "Activa" && $estado != "Deshabilitada") {
            $alerta = [
                "tipo" => "error",
                "icono" => "warning",
                "titulo" => "Estado de la cuenta no coincide",
                "descripcion" => "El estado de la cuenta no coincide con el formato solicitado. Por favor, verifica el estado e intenta nuevamente."
            ];

            return json_encode($alerta);
            exit();
        }


        if ($dni != $datosUsuario["usuario_dni"]) {
            //* Comprobando el DNI para no repetir la misma información
            $checkDni = self::ejecutarConsultaSimple("SELECT usuario_dni FROM usuario WHERE usuario_dni = '$dni'");
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


        // //* Comprobando el USUARIO para no repetir la misma información
        if ($nombre_usuario != $datosUsuario["usuario_usuario"]) {
            $checkUser = self::ejecutarConsultaSimple("SELECT usuario_usuario FROM usuario WHERE usuario_usuario = '$nombre_usuario'");
            if ($checkUser->rowCount() > 0) {
                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Usuario ya registrado",
                    "descripcion" => "El nombre de usuario ingresado ya existe en la base de datos. Por favor, elige un nombre de usuario diferente."
                ];

                return json_encode($alerta);
                exit();
            }
        }



        //* Comprobando el EMAIL para no repetir la misma información
        if ($email != $datosUsuario["usuario_email"]) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $checkEmail = self::ejecutarConsultaSimple("SELECT usuario_email FROM usuario WHERE usuario_email = '$email'");
                if ($checkEmail->rowCount() > 0) {
                    $alerta = [
                        "tipo" => "error",
                        "icono" => "error",
                        "titulo" => "Correo ya registrado",
                        "descripcion" => "El correo ingresado ya existe en la base de datos. Por favor, utiliza un correo diferente."
                    ];

                    return json_encode($alerta);
                    exit();
                }
            } else {
                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Formato de correo no válido",
                    "descripcion" => "El correo ingresado no cumple con el formato requerido. Por favor, verifica e intenta nuevamente."
                ];

                return json_encode($alerta);
                exit();
            }
        }


        //* Comprobando las claves
        if (($_POST["usuario_contrasena_nueva"]) != "" || ($_POST["usuario_contrasena_nueva_repetir"]) != "") {
            if ($_POST["usuario_contrasena_nueva"] != $_POST["usuario_contrasena_nueva_repetir"]) {

                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Contraseñas no coinciden",
                    "descripcion" => "Las nuevas contraseñas ingresadas no coinciden"
                ];

                return json_encode($alerta);
                exit();
            } else {

                if (self::verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $_POST["usuario_contrasena_nueva"]) || self::verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $_POST["usuario_contrasena_nueva_repetir"])) {

                    $alerta = [
                        "tipo" => "error",
                        "icono" => "error",
                        "titulo" => "Error en las contraseñas",
                        "descripcion" => "Las nuevas contraseñas no coinciden con el formato solicitado."
                    ];

                    return json_encode($alerta);
                    exit();
                }

                $clave = self::encryption($_POST["usuario_contrasena_nueva"]);
            }
        } else {
            $clave = $datosUsuario["usuario_clave"];
        }

        //* Comprobando credenciales para actualizar datos
        if ($tipo_cuenta == "Propia") {
            $checkCuenta = self::ejecutarConsultaSimple("SELECT usuario_id FROM usuario WHERE usuario_usuario = '$admin_usuario' AND usuario_clave = '$admin_password' AND usuario_id='$id'");
        } else {

            if ($_SESSION["privilegio_spm"] != 1) {
                $alerta = [
                    "tipo" => "error",
                    "icono" => "error",
                    "titulo" => "Permisos insuficientes",
                    "descripcion" => "No puedes actualizar los datos porque no tienes los permisos necesarios."
                ];

                return json_encode($alerta);
                exit();
            }

            $checkCuenta = self::ejecutarConsultaSimple("SELECT usuario_id FROM usuario WHERE usuario_usuario = '$admin_usuario' AND usuario_clave = '$admin_password'");
        }

        if ($checkCuenta->rowCount() <= 0) {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Credenciales inválidas",
                "descripcion" => "El nombre o la clave de administrador son inválidos."
            ];

            return json_encode($alerta);
            exit();
        }

        //* Preparando datos para enviarlos al modelo
        $usuario_datos_up = [
            [
                "campo_nombre" => "	usuario_dni",
                "campo_marcador" => ":Dni",
                "campo_valor" => $dni

            ],

            [
                "campo_nombre" => "usuario_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombres

            ],

            [
                "campo_nombre" => "usuario_apellido",
                "campo_marcador" => ":Apellido",
                "campo_valor" => $apellidos

            ],


            [
                "campo_nombre" => "	usuario_telefono",
                "campo_marcador" => ":Telefono",
                "campo_valor" => $telefono

            ],

            [
                "campo_nombre" => "usuario_direccion",
                "campo_marcador" => ":Direccion",
                "campo_valor" => $direccion

            ],

            [
                "campo_nombre" => "	usuario_email",
                "campo_marcador" => ":Email",
                "campo_valor" => $email

            ],

            [
                "campo_nombre" => "usuario_usuario",
                "campo_marcador" => ":Usuario",
                "campo_valor" => $nombre_usuario

            ],

            [
                "campo_nombre" => "usuario_clave",
                "campo_marcador" => ":Clave",
                "campo_valor" => $clave

            ],

            [
                "campo_nombre" => "usuario_estado",
                "campo_marcador" => ":Estado",
                "campo_valor" => $estado

            ],

            [
                "campo_nombre" => "usuario_privilegio",
                "campo_marcador" => ":Privilegio",
                "campo_valor" => $privilegio

            ]
        ];

        $condicion = [
            "condicion_campo" => "	usuario_id",
            "condicion_marcador" => ":Id",
            "condicion_valor" => $id
        ];

        if (self::actualizarDatos("usuario", $usuario_datos_up, $condicion)) {

            //* Preparando el correo para enviar al usuario actualizado
            if ($privilegio == 1) {
                $permiso = "Control total";
            } elseif ($privilegio == 2) {
                $permiso = "Registrar y actualizar";
            } elseif ($privilegio == 3) {
                $permiso = "Permisos para registrar";
            }
            $mensajeEmail = [
                "asunto" => "Actualización de Datos en el Sistema de Préstamos",
                "mensaje" => "
                    <html lang='es'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Actualización de Datos en el Sistema de Administración de Préstamos</title>
                    </head>
                    <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #F7FAFC; color: #2d3748;'>
                        <div style='max-width: 100%; margin: 40px auto; background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);'>
                            <div style='text-align: center; background-color: #1a202c; color: #ffffff; padding: 20px; border-radius: 8px 8px 0 0;'>
                                <h1 style='margin: 0; font-size: 24px;'>Actualización de Datos en el Sistema de Préstamos</h1>
                            </div>
                            <div style='padding: 20px; font-size: 16px; line-height: 1.6;'>
                                <p>Estimado/a <span style='color: #1a202c; font-weight: bold;'>" . ($nombres) . " " . ($apellidos) . "</span>,</p>
                                <p>Te informamos que tus datos personales y de cuenta han sido actualizados exitosamente. A continuación, te proporcionamos un resumen de la información actualizada:</p>
                                
                                <h3>Datos Personales:</h3>
                                <p><strong>DNI:</strong> <span style='color: #1a202c; font-weight: bold;'>" . ($dni) . "</span></p>
                                <p><strong>Nombre:</strong> <span style='color: #1a202c; font-weight: bold;'>" . ($nombres) . "</span></p>
                                <p><strong>Apellido:</strong> <span style='color: #1a202c; font-weight: bold;'>" . ($apellidos) . "</span></p>
                                <p><strong>Teléfono:</strong> <span style='color: #1a202c; font-weight: bold;'>" . ($telefono) . "</span></p>
                                <p><strong>Dirección:</strong> <span style='color: #1a202c; font-weight: bold;'>" . ($direccion) . "</span></p>
                                
                                <h3>Datos de la Cuenta:</h3>
                                <p><strong>Nombre de Usuario:</strong> <span style='color: #1a202c; font-weight: bold;'>" . ($nombre_usuario) . "</span></p>
                                <p><strong>Email:</strong> <span style='color: #1a202c; font-weight: bold;'>" . ($email) . "</span></p>
                                <p><strong>Estado de la Cuenta:</strong> <span style='color: #38b2ac; font-weight: bold;'>" . ($estado) . "</span></p>
                                <p><strong>Nivel de Privilegio:</strong> <span style='color: #38b2ac; font-weight: bold;'>" . ($permiso) . "</span></p>
            
                                <p>De ahora en adelante, toda la información relevante sobre tu cuenta será enviada al correo electrónico proporcionado: <span style='color: #1a202c; font-weight: bold;'>" . ($email) . "</span></p>
            
                                <p>Si tienes alguna pregunta o necesitas asistencia adicional, no dudes en contactar a nuestro equipo de soporte a través del siguiente correo: <a href='mailto:sistemaprestamos2025@gmail.com' style='color: #38b2ac; text-decoration: none;'>soporte@tusitio.com</a>.</p>
                            </div>
                            <div style='text-align: center; font-size: 14px; color: #718096; padding: 10px 0; background-color: #f1f1f1; border-radius: 0 0 8px 8px;'>
                                <p>Atentamente, <br><strong>El equipo de soporte del sistema de administración de préstamos</strong></p>
                                <p>Si no solicitaste esta actualización, por favor <a href='mailto:sistemaprestamos2025@gmail.com' style='color: #38b2ac; text-decoration: none;'>contáctanos</a> inmediatamente.</p>
                            </div>
                        </div>
                    </body>
                    </html>",
                "correo" => $email
            ];

            $alerta = [
                "tipo" => "recargar",
                "icono" => "success",
                "titulo" => "Usuario actualizado",
                "descripcion" => "El usuario ha sido actualizado exitosamente y los cambios se guardaron correctamente."

            ];

            self::enviarCorreo($mensajeEmail);
        } else {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en la actualización",
                "descripcion" => "No se pudo actualizar el usuario. Verificar la información"
            ];
        }

        return json_encode($alerta);
        exit();
    }


}
