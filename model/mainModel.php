<?php

if ($peticionAjax) {
    require_once("../config/server.php");
} else {
    require_once("./config/server.php");
}



//* Incluimos los archivos para enviar los correos
require(__DIR__ . "/../PHPMailer/PHPMailer/Exception.php");
require(__DIR__ . "/../PHPMailer/PHPMailer/PHPMailer.php");
require(__DIR__ . "/../PHPMailer/PHPMailer/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



class mainModel
{


    //?------------Conexión a la base de datos ----------//
    protected static function conectar()
    {
        $conexion = new PDO(SBGD, USER, PASS); //* Conexión metodo PDO
        $conexion->exec("SET CHARACTER SET utf8"); // *Recibe todos los caracteres 
        return $conexion;
    }


    //?---------------Función ejecutar consultas simple ----------//
    protected static function ejecutarConsultaSimple($consulta)
    {

        $sql = self::conectar()->prepare($consulta);
        $sql->execute();
        return $sql;
    }


    //?---------------Función para encritar palabras----------//
    public function encryption($string)
    {
        $output = FALSE;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);

        return $output;
    }


    //?---------------Función para desencritar palabras----------//
    protected static function decryption($string)
    {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }


    //?---------------Función para generar códigos aleatorios----------//
    protected static function generarCodigoAleatorio($letra, $longitud, $numero)
    {
        for ($i = 1; $i <= $longitud; $i++) {

            $aleatorio = rand(0, 9);
            $letra .= $aleatorio; //? Se pone letra seguido de un número EJM(p7)

        }

        return $letra . "-" . $numero;
    }


    //?---------------Función para limpiar cadenas (Evitar ataques de inyeccion)----------//
    protected static function limpiarCadena($cadena)
    {
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        $palabras = [
            "<script>",
            "</script>",
            "<script src",
            "<script type=",
            "SELECT * FROM",
            "SELECT",
            " SELECT",
            "DELETE FROM",
            "INSERT INTO",
            "DROP TABLE",
            "DROP DATABASE",
            "TRUNCATE TABLE",
            "SHOW TABLES",
            "SHOW DATABASES",
            "<?php",
            "?>",
            "--",
            "^",
            "<",
            ">",
            "==",
            "=",
            ";",
            "::",
            "UNION SELECT",
            "UNION ALL",
            "OR 1=1",
            "1=1",
            "AND 1=1",
            "ORDER BY",
            "GROUP BY",
            "HAVING",
            "EXEC(",
            "EXECUTE(",
            "xp_",
            "sp_",
            "sysobjects",
            "syscolumns",
            "xp_cmdshell",
            "information_schema",
            "CREATE USER",
            "ALTER USER",
            "GRANT ALL PRIVILEGES",
            "mysql_",
            "pg_",
            "pgsql_",
            "schema.",
            "table_name",
            "column_name",
            "sleep(",
            "benchmark(",
            "/*",
            "*/",
            "CONCAT(",
            "CONCAT_WS(",
            "LOAD_FILE(",
            "INTO OUTFILE",
            "MID(",
            "SUBSTRING(",
            "BENCHMARK(",
            "CHAR(",
            "ASCII(",
            "UNICODE(",
            "ORD(",
            "HEX(",
            "XOR",
            "VERSION()"
        ];

        foreach ($palabras as $palabra) {
            $cadena = str_ireplace($palabra, "", $cadena);
        }

        return $cadena;
    }


    //?---------------Función para verificar datos (Evitar ataques de inyeccion)----------//
    protected static function verificarDatos($filtro, $palabra)
    {

        if (preg_match("/^" . $filtro . "$/", $palabra)) {
            return false;
        } else {
            return true;
        }
    }


    //?---------------Función para verificar fechas ----------//
    public static function verificarFecha($fecha)
    {
        $valores = explode("-", $fecha);

        if (count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])) {
            return false;
        } else {
            return true;
        }
    }


    //?---------------Función para insertar valores a la BD ----------//
    protected  function insertarDatos($tabla, $datos)
    {

        $query = "INSERT INTO $tabla ( ";
        $ci = 0;
        //Insertando los nombres de los campos
        foreach ($datos as $valor) {

            if ($ci >= 1) {
                $query .= ",";
            }

            $query .= $valor["campo_nombre"];
            $ci++;
        }

        $query .= " ) VALUES ( ";
        $ci = 0;
        //Insertando el nombre de los valores
        foreach ($datos as $valor) {

            if ($ci >= 1) {
                $query .= ",";
            }

            $query .= $valor["campo_marcador"];
            $ci++;
        }
        $query .= " );";

        // Insertando los datos a la base de datos
        $sql = self::conectar()->prepare($query);

        foreach ($datos as $valor) {
            $sql->bindParam($valor["campo_marcador"], $valor["campo_valor"]);
        }

        $sql->execute();
        return $sql;
    }


    //?---------------Función para actualizar datoa en la BD ----------//
    protected static function actualizarDatos($tabla, $datos, $condicion)
    {
        $query = "UPDATE $tabla SET ";
        $c = 0;
        foreach ($datos as $clave) {
            if ($c >= 1) {
                $query .= ",";
            }
            $query .= $clave["campo_nombre"] . "=" . $clave["campo_marcador"];

            $c++;
        }

        $query .= " WHERE " . $condicion["condicion_campo"] . "=" . $condicion["condicion_marcador"];
        $sql = self::conectar()->prepare($query);

        foreach ($datos as $clave) {

            $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
        }

        $sql->bindParam($condicion["condicion_marcador"], $condicion["condicion_valor"]);

        $sql->execute();
        return $sql;
    }


    //?---------------Función para seleccionar datoa en la BD ----------//
    public static function seleccionarDatos($tipo, $tabla, $campo, $valor)
    {
        // Limpiar los datos recibidos
        $tipo = self::limpiarCadena($tipo);
        $tabla = self::limpiarCadena($tabla);
        $campo = self::limpiarCadena($campo);
        $valor = self::limpiarCadena($valor);


        if ($tipo == "Unico") {
            $sql = self::conectar()->prepare("SELECT * FROM $tabla WHERE $campo =:ID");
            $sql->bindParam(":ID", $valor);
        } elseif ($tipo == "Conteo") {
            $sql = self::conectar()->prepare("SELECT $campo FROM $tabla");
        } elseif ($tipo == "ConteoSinIncluir") {
            $sql = self::conectar()->prepare("SELECT $campo FROM $tabla WHERE $campo != :Valor");
            $sql->bindParam(":Valor", $valor);
        }

        $sql->execute();
        return $sql;
    }


    public static function seleccionarDatosCampos($tipo, $tabla, $campo, $valor, $condicion)
    {
        // Limpiar los datos recibidos
        $tipo = self::limpiarCadena($tipo);
        $tabla = self::limpiarCadena($tabla);
        $campo = self::limpiarCadena($campo);
        $valor = self::limpiarCadena($valor);
        $condicion = self::limpiarCadena($condicion);


        if ($tipo == "ConteoCamposDiferentes") {
            $sql = self::conectar()->prepare("SELECT $campo FROM $tabla WHERE $condicion =:Valor");
            $sql->bindParam(":Valor", $valor);
        } else if ($tipo == "Unico") {

            $sql = self::conectar()->prepare("SELECT * FROM $tabla WHERE $campo =:ID");
            $sql->bindParam(":ID", $valor);
            
        } else if ($tipo == "UnicoFactura") {
            $valor = self::decryption($valor);
            $sql = self::conectar()->prepare("SELECT * FROM $tabla WHERE $campo =:ID");
            $sql->bindParam(":ID", $valor);
        }

        $sql->execute();
        return $sql;
    }


    //?---------------Función para eliminar datoa en la BD ----------//
    protected static function eliminarDatos($tabla, $campo, $id)
    {
        $sql = self::conectar()->prepare("DELETE FROM $tabla WHERE $campo =:id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        return $sql;
    }


    //?---------------Función paginador de tablas----------//
    protected static function paginadorTablas($pagina, $numeroPaginas, $url, $botones)
    {
        $tabla = '<div class="botonera">';

        if ($pagina <= 1) {
            $tabla .= '<div class="botones">
              <span class="anterior prevenir">Anterior</span>
              <div class="btn1">';
        } else {
            $tabla .= '<div class="botones">
              <a href="' . $url . ($pagina - 1) . '/" class="anterior" >Anterior</a>
              <div class="btn1">
              <a class="boton" href="' . $url . '1/">1</a>
              <span class="material-symbols-sharp si">page_control</span>';
        }

        $ci = 0;
        for ($i = $pagina; $i <= $numeroPaginas; $i++) {
            if ($ci >= $botones) {
                break;
            }

            if ($pagina == $i) {
                $tabla .= '<a class="boton activo" href="' . $url . $i . '/">' . $i . '</a>';
            } else {
                $tabla .= '<a class="boton" href="' . $url . $i . '/">' . $i . '</a>';
            }
            $ci++;
        }



        if ($pagina == $numeroPaginas) {
            $tabla .= '
                  </div>
                  <span class="siguiente prevenir">Siguiente</span>
              ';
        } else {
            $tabla .= '
               <li>&hellip;</li>
              <a class="boton" href="' . $url . $numeroPaginas . '/">' . $numeroPaginas . '</a>
              </div>
              <a class="siguiente " href="' . $url . ($pagina + 1) . '/">Siguiente</a>
          ';
        }

        $tabla .= '</div>';
        return $tabla;
    }


    //?---------------Función para enviar correos----------//
    protected static function enviarCorreo($mensaje)
    {
        $correo = $mensaje["correo"];
        $asunto = $mensaje["asunto"];
        $cuerpo = $mensaje["mensaje"];



        $mail = new PHPMailer(true);

        try {

            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'sistemaprestamos2025@gmail.com';
            $mail->Password   = 'sokk sqdg ktsi prjy'; //sistemaprestamos(password del correo)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->SMTPDebug  = SMTP::DEBUG_OFF;
            $mail->CharSet = 'UTF-8';


            // Cabeceras del correo
            $mail->setFrom('sistemaprestamos2025@gmail.com', 'Préstamos');
            $mail->addAddress($correo);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $cuerpo;

            // Enviar correo
            $mail->send();
        } catch (Exception $e) {
            echo "El correo no pudo ser enviado. Error: {$mail->ErrorInfo}";
        }
    }
}
