<div class="derecho">
    <div class="header-derecho">
        <div class="icono-menu">
            <span class="material-symbols-sharp icono-menu1"> menu</span>
            <span class="material-symbols-sharp icono-menu2"> menu</span>
        </div>

        <div class="iconos-derecho">
            <div class="reloj">
                <span class="material-symbols-sharp campana-icono">schedule</span>
                <div class="hora"></div>
            </div>
            <div class="campana">
                <span class="material-symbols-sharp campana-icono campana-icono-noti">sms</span>
                

                <div class="contenedor-mensajes">
                    <div class="wrapper">
                        <section class="users">
                            <header>
                                <div class="content">
                                    <?php
                                    if (is_file("./views/assets/img/admin/" . $_SESSION["foto_spm"] )) {
                                        // Si la foto existe, mostrarla
                                        echo '<img src="' . SERVERURL . 'app/views/assets/img/user/fotoUser/' . $_SESSION["foto_spm"] . '" alt="Foto de usuario">';
                                    } else {
                                        // Si no existe, mostrar la foto por defecto
                                        echo '     <img src="' . SERVERURL . './views/assets/img/admin/defecto.png" alt="Foto por defecto">';
                                    }

                                    ?>
                                    <div class="details">
                                        <span><?php echo $_SESSION["nombre_spm"] . $_SESSION["apellido_spm"] ?></span>
                                        <p><?php echo  $_SESSION["estado_spm"] ?></p>
                                    </div>
                                </div>
                                <span href="" class="logout">Cerrar</span>
                            </header>
                            <div class="search">
                                <span class="text">Seleccione un usuario para iniciar el chat</span>
                                <input type="text" placeholder="Introduzca el nombre para buscar...">
                                <button><i class="fas fa-search"></i></button>
                            </div>
                            <div class="users-list">
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <a href="<?php echo SERVERURL . "adminUserUpdate/" . $lc->encryption($_SESSION["id_spm"]) ?>/"> <span class="material-symbols-sharp"> person</span></a>
            <span class="material-symbols-sharp btnCerrar"> logout</span>
        </div>



    </div>