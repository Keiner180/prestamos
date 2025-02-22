<?php
require_once("mainModel.php");

class mensajeModel extends mainModel
{

    //?--------------- Modelo de mostrar los usuarios (chat)------------------//
    protected static function mostrarUsuarioModelo()
    {

        $id_saliente = $_SESSION['dni_spm'];
        $sql = self::conectar()->prepare("SELECT * FROM usuario WHERE NOT usuario_dni = {$id_saliente} ORDER BY usuario_id DESC");
        $sql->execute();
        return $sql;
    }


    //?--------------- Modelo para bsucar los usuarios (chat)------------------//
    protected static function buscarUsuarioModelo($valor)
    {
        $id_saliente = $_SESSION['dni_spm'];
        $sql = self::conectar()->prepare("SELECT * FROM usuario WHERE NOT usuario_dni = {$id_saliente} AND (usuario_nombre LIKE '%{$valor}%' OR usuario_apellido LIKE '%{$valor}%') ");
        $sql->execute();

        return $sql;
    }


    //?--------------- Modelo para insertar mensajes (chat)------------------//
    protected static function insertarMensajeModelo($valor, $message)
    {

        $outgoing_id = $_SESSION['dni_spm'];
        $incoming_id_enviar = self::decryption($valor);

        if (!empty($message)) {
            $sql = self::conectar()->prepare("INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) VALUES ({$incoming_id_enviar}, {$outgoing_id}, '{$message}')");
            $sql->execute();
            return $sql;
        }
    }

    //?--------------- Modelo para mostrar los mensajes (chat)------------------//
    protected static function mostrarMensajesModelo($valor)
    {

        $outgoing_id = $_SESSION['dni_spm'];
        $incoming_id = self::decryption($valor);

        $output = "";
        $sql = "SELECT * FROM messages LEFT JOIN usuario ON usuario.usuario_dni = messages.outgoing_msg_id WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})   OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
        $query = self::conectar()->prepare($sql);
        $query->execute();
        if ($query->rowCount() > 0) {

            while ($row = $query->fetch()) {
                if ($row['outgoing_msg_id'] === $outgoing_id) {

                    $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <p>' . $row['msg'] . '</p>
                                    </div>
                                    </div>';
                } else {

                    if (is_file("./views/assets/img/admin/" . $row["usuario_foto"])) {
                        // Si la foto existe, mostrarla
                        $output .= '<div class="chat incoming">
                                      <img src="' . SERVERURL . 'app/views/assets/img/user/fotoUser/' . $row["usuario_foto"] . '" alt="Foto de usuario">
                                      <div class="details">
                                            <p>' . $row['msg'] . '</p>
                                      </div>
                                    </div>';
                    } else {
                        // Si no existe, mostrar la foto por defecto
                        $output .= '<div class="chat incoming">
                                        <img src="' . SERVERURL . './views/assets/img/admin/defecto.png" alt="Foto por defecto">
                                        <div class="details">
                                                <p>' . $row['msg'] . '</p>
                                         </div>
                                  </div>';
                    }
                }
            }
        } else {
            $output .= '<div class="text">No hay mensajes disponibles. Una vez que envíes el mensaje, aparecerán aquí.</div>';
        }
        return $output;
    }

    //?--------------- Modelo para encontrar usuarios  (chat)------------------//
    protected static function obtenerUsuariosModelo($sql)
    {

        // $sql = self::mostrarUsuarioModelo();

        $outgoing_id = $_SESSION['dni_spm'];
        $output = "";


        // Recorrer los resultados de la consulta de los mensajes
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            // Preparar la consulta de los mensajes
            $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = :unique_id OR outgoing_msg_id = :unique_id) AND (outgoing_msg_id = :outgoing_id OR incoming_msg_id = :outgoing_id) ORDER BY msg_id DESC LIMIT 1";

            $query2 = self::conectar()->prepare($sql2);
            $query2->bindParam(':unique_id', $row['usuario_dni']);
            $query2->bindParam(':outgoing_id', $outgoing_id);
            $query2->execute();

            $row2 = $query2->fetch(PDO::FETCH_ASSOC);
            $result = ($query2->rowCount() > 0) ? $row2['msg'] : "No hay mensaje disponible";

            // Limitar el tamaño del mensaje 
            $msg = (strlen($result) > 28) ? substr($result, 0, 28) . '...' : $result;

            // Determinar si el mensaje proviene del usuario actual
            $you = (isset($row2['outgoing_msg_id']) && $outgoing_id == $row2['outgoing_msg_id']) ? "TÚ: " : "";

            $datos = self::seleccionarDatos("Unico", "usuario", "usuario_id", $row["usuario_id"]);
            $datos = $datos->fetch();

            $mainModel = new mainModel();


           


            $offline = $datos["usuario_estado"];

            $output .= '<a href="' . SERVERURL . 'chat/' . $mainModel->encryption($row['usuario_dni']) . '">
                <div class="content">';
                if (is_file("./views/assets/img/admin/" . $row["usuario_foto"])) {
                    // Si la foto existe, mostrarla
                    $output .= '<img src="' . SERVERURL . 'app/views/assets/img/user/fotoUser/' . $row["usuario_foto"] . '" alt="Foto de usuario">';
                } else {
                    // Si no existe, mostrar la foto por defecto
                    $output .= '     <img src="' . SERVERURL . './views/assets/img/admin/defecto.png" alt="Foto por defecto">';
                }
                  $output .= '   
                    <div class="details">
                        <span>' . $row['usuario_nombre'] . " " . $row['usuario_apellido'] . '</span>
                        <p>' . $you . $msg . '</p>
                    </div>
                </div>
                <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
            </a>';
        }

        return $output;

                                            
    }

    
}
