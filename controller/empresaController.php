<?php


if ($peticionAjax) {
    require_once("../model/mainModel.php");
} else {
    require_once("./model/mainModel.php");
}

class EmpresaController extends mainModel
{


    //?-------------Obtener los datos de la empresa controlador--------------------//
    public function datosEmpresaControlador()
    {

        return self::seleccionarDatos("Conteo", "Empresa", "*", "");
    }


    //?-------------Agregar empresa controlador--------------------//
    public function agregarEmpresaControlador()
    {


        //*--------------Recibiendo los datos del formulario---------------// 
        $nombre = self::limpiarCadena($_POST["nombre_empresa"]);
        $correo = self::limpiarCadena($_POST["correo_empresa"]);
        $telefono = self::limpiarCadena($_POST["telefono_empresa"]);
        $direccion = self::limpiarCadena($_POST["direccion_empresa"]);


        //*--------------Validando los campos obligatorios--------------// 
        if (empty($nombre) || empty($correo) || empty($telefono) || empty($direccion)) {

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


        //* Comprobando el EMAIL para no repetir la misma información
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Formato de correo no válido",
                "descripcion" => "El correo ingresado no cumple con el formato requerido. Por favor, verifica e intenta nuevamente."
            ];

            return json_encode($alerta);
            exit();
        }


        // Compobar registros de empresa registrada
        $checkEmpresa = self::ejecutarConsultaSimple(("SELECT empresa_id FROM empresa"));
        if ($checkEmpresa->rowCount() >= 1) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Ocurrio un error",
                "descripcion" => "Ya existe una empresa registrada, ya no puedes registrar otra"
            ];

            return json_encode($alerta);
            exit();
        }


        //* Arrys que contiene los valores que se van a insertar a la base de datos//
        $empresa_datos_reg = [
            [
                "campo_nombre" => "empresa_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombre

            ],

            [
                "campo_nombre" => "empresa_email",
                "campo_marcador" => ":Email",
                "campo_valor" => $correo

            ],

            [
                "campo_nombre" => "empresa_telefono",
                "campo_marcador" => ":Telefono",
                "campo_valor" => $telefono

            ],


            [
                "campo_nombre" => "	empresa_direccion",
                "campo_marcador" => ":Direccion",
                "campo_valor" => $direccion

            ]

        ];

        $agregar_empresa = self::insertarDatos("empresa", $empresa_datos_reg);

        if ($agregar_empresa->rowCount() > 0) {

            $alerta = [
                "tipo" => "recargar",
                "icono" => "exito",
                "titulo" => "Empresa registrada",
                "descripcion" => "La empresa ha sido registrado exitosamente en el sistema."
            ];
        } else {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "No se pudo registrar la empresa",
                "descripcion" => "Hubo un problema al intentar registrar La empresa. Por favor, intenta nuevamente más tarde."
            ];
        }

        return json_encode($alerta);
    }


    //?-------------Actualizar datos de la empresa controlador--------------------//
    public function actualizarEmpresaControlador()
    {
        //*--------------Recibiendo los datos del formulario---------------// 
        $id = self::limpiarCadena($_POST["empresa_id"]);
        $nombre = self::limpiarCadena($_POST["nombre_empresa"]);
        $correo = self::limpiarCadena($_POST["correo_empresa"]);
        $telefono = self::limpiarCadena($_POST["telefono_empresa"]);
        $direccion = self::limpiarCadena($_POST["direccion_empresa"]);


        //*--------------Validando los campos obligatorios--------------// 
        if (empty($nombre) || empty($correo) || empty($telefono) || empty($direccion)) {

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


        //* Comprobando el EMAIL para no repetir la misma información
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Formato de correo no válido",
                "descripcion" => "El correo ingresado no cumple con el formato requerido. Por favor, verifica e intenta nuevamente."
            ];

            return json_encode($alerta);
            exit();
        }

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


        //* Arrys que contiene los valores que se van a actualizar a la base de datos//
        $empresa_datos_up = [
            [
                "campo_nombre" => "empresa_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombre

            ],

            [
                "campo_nombre" => "empresa_email",
                "campo_marcador" => ":Email",
                "campo_valor" => $correo

            ],

            [
                "campo_nombre" => "empresa_telefono",
                "campo_marcador" => ":Telefono",
                "campo_valor" => $telefono

            ],


            [
                "campo_nombre" => "	empresa_direccion",
                "campo_marcador" => ":Direccion",
                "campo_valor" => $direccion

            ]

        ];

        $condicion = [
            "condicion_campo" => "empresa_id",
            "condicion_marcador" => ":Id",
            "condicion_valor" => $id
        ];

        if (self::actualizarDatos("empresa", $empresa_datos_up, $condicion)) {

            $alerta = [
                "tipo" => "recargar",
                "icono" => "success",
                "titulo" => "Empresa actualizado",
                "descripcion" => "La empresa ha sido actualizado exitosamente y los cambios se guardaron correctamente."

            ];
        } else {

            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error en la actualización",
                "descripcion" => "No se pudo actualizar la empresa. Verificar la información"
            ];
        }

        return json_encode($alerta);
    }
}
