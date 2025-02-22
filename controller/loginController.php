<?php

if ($peticionAjax) {
    require_once("../model/loginModel.php");
} else {
    require_once("./model/loginModel.php");
}

class loginController extends loginModelUser
{

    //?-----------------------Controlador login---------------------//
    public function loginControllerUser()
    {
        //*------------ Recibiendo los valores ----------------//
        $usuario = self::limpiarCadena($_POST["usuario_login"]);
        $password = self::limpiarCadena($_POST["password_login"]);


        //*------------ Comprobando los campos vacíos ----------------//
        if ($usuario == "" || $password == "") {
            echo '
            <script>
                agregarToast({
                    tipo: "error",
                    titulo: "Error de inicio de sesión",
                    descripcion: "Por favor, ingresa tanto el usuario como la contraseña.",
                    autoCierre: true
                });
            </script>
        ';

            exit();
        }


        //*------------ Comprobando la integridad de los datos ----------------//
        if (self::verificarDatos("[a-zA-Z0-9]{4,35}", $usuario)) {
            echo '
             <script>
                agregarToast({
                    tipo: "error",
                    titulo: "Error en el nombre de usuario",
                    descripcion: "El nombre de usuario no coincide con el formato solicitado",
                    autoCierre: true
                });
         </script>
            ';

            exit();
        }


        if (self::verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $password)) {
            echo '
            <script>
                agregarToast({
                    tipo: "error",
                    titulo: "Error en la contraseña",
                    descripcion: "La contraseña no cumple con el formato solicitado",
                    autoCierre: true
                });
            </script>
             ';
            exit();
        }

        $password = self::encryption($password); //* Encriptar contraseña

        //*------------ Array de datos----------------//
        $datos_login = [
            "usuario_login" => $usuario,
            "password_login" => $password
        ];

        //*--------- Verificar datos en la base de datos ----------------
        $datos_cuenta = loginModelUser::loginModel($datos_login);
        if ($datos_cuenta->rowCount() == 1) {

            $datosBd = $datos_cuenta->fetch();
            session_start(['name' => 'SPM']);
            //*----------Almecenando variables de sesión------------
            $_SESSION["id_spm"] = $datosBd["usuario_id"];
            $_SESSION["nombre_spm"] = $datosBd["usuario_nombre"];
            $_SESSION["apellido_spm"] = $datosBd["usuario_apellido"];
            $_SESSION["usuario_spm"] = $datosBd["usuario_usuario"];
            $_SESSION["privilegio_spm"] = $datosBd["usuario_privilegio"];
            $_SESSION["estado_spm"] = $datosBd["usuario_estado"];
            $_SESSION["dni_spm"] = $datosBd["usuario_dni"];
            $_SESSION["foto_spm"] = $datosBd["usuario_foto"];
            $_SESSION["token_spm"] = md5(uniqid(mt_rand(), true));





            //*--------- Redirigir a la vista del dashboard_______//
            if (headers_sent()) {
                echo '
                        <script>
                        window.location.href = "' . SERVERURL . 'dashboard";
                        </script>
                    ';
            } else {
                return  header("Location: " . SERVERURL . "dashboard");
            }
        } else {
            echo '
            <script>
                agregarToast({
                    tipo: "error",
                    titulo: "Error de inicio de sesión",
                    descripcion: "Usuario o contraseña incorrectos. Por favor, verifica tus datos e intenta nuevamente.",
                    autoCierre: true
                });
            </script>

            ';
        }
    }


    //?-----------------------Controlador forzar cerrar sesión ---------------------//
    public function forzarCierreSesionControlador()
    {

        session_unset();
        session_destroy();

        //*--------- Redirigir a la vista del login//
        if (headers_sent()) {
            echo '
                    <script>
                    window.location.href = "' . SERVERURL . 'login";
                    </script>
                ';
        } else {
            header("Location: " . SERVERURL . "login");
        }
    }


    //?-----------------------Controlador  cerrar sesión ---------------------//
    public function CerrarSesionControlador()
    {
        session_start(['name' => 'SPM']);

        $token = self::decryption($_POST["token"]);
        $usuario = self::decryption($_POST["usuario"]);


        if ($token == $_SESSION["token_spm"] && $usuario == $_SESSION["usuario_spm"]) {

            session_unset();
            session_destroy();

            $alerta = [
                "tipo" => "redireccionar",
                "url" => SERVERURL . "login"
            ];

        } else {
            $alerta = [
                "tipo" => "error",
                "icono" => "error",
                "titulo" => "Error al cerrar sesión",
                "descripcion" => "No se pudo cerrar la sesión correctamente. Por favor, intenta nuevamente."
            ];
        }



        return json_encode($alerta);
    }
}
