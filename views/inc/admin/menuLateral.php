<!-- Animacion carga (html, css) -->
<div class="centrado-cargando">
    <span class="loader"></span>
</div>
<!-- Alertas personalizadas -->
<div class="contenedor-toast " id="contenedor-toast"></div>
<!-- Animacion Ajax -->
<div class="centrado-cargando-loader ">
    <div class="preloader">
        <div class="box">
            <div class="box__inner">
                <div class="box__back-flap"></div>
                <div class="box__right-flap"></div>
                <div class="box__front-flap"></div>
                <div class="box__left-flap"></div>
                <div class="box__front"></div>
            </div>
        </div>
        <div class="box">
            <div class="box__inner">
                <div class="box__back-flap"></div>
                <div class="box__right-flap"></div>
                <div class="box__front-flap"></div>
                <div class="box__left-flap"></div>
                <div class="box__front"></div>
            </div>
        </div>
        <div class="line">
            <div class="line__inner"></div>
        </div>
        <div class="line">
            <div class="line__inner"></div>
        </div>
        <div class="line">
            <div class="line__inner"></div>
        </div>
        <div class="line">
            <div class="line__inner"></div>
        </div>
        <div class="line">
            <div class="line__inner"></div>
        </div>
        <div class="line">
            <div class="line__inner"></div>
        </div>
        <div class="line">
            <div class="line__inner"></div>
        </div>
    </div>

    <div class="loaderp"></div>

</div>
<!-- Contenedor del mensaje de alerta -->
<div class="alertaAceptar "></div>


<!-- Contenedor del mensaje de alerta cerrar sesion -->
<div class="alertaAceptar cerrarAlerta">
    <div class="alertaAceptarContenedor">
        <div class="iconoAlerta">
            <span class="material-symbols-sharp">logout</span>
        </div>
        <div class="alertaTexto">
            <h5>¿Cerrar sesión?</h5>
            <p>¿Estás seguro de que deseas cerrar sesión?</p>
        </div>
        <div class="alertaAceptarBotones">
            <button class="siEnv">Sí, cerrar</button>
            <button class="noEnv">Cancelar</button>
        </div>
    </div>

</div>
<!-- Menu -->
<div class="menu-izquierdo">
    <span class="material-symbols-sharp close">close</span>
    <div class="logo">
        <span class="material-symbols-sharp">request_quote</span>
        <p>PRESTAMOS</p>
    </div>
    <ul class="ul-menu">
        <a href="<?php echo SERVERURL ?>dashboard/" class="li-menu">
            <span class="material-symbols-sharp iconos-link"> dashboard</span>
            <li>Dashboard</li>
        </a>


        <span class="li-menu li-menu-no-cursor">
            <div class="links-todo">
                <span class="material-symbols-sharp iconos-link">groups</span>
                <li>Clientes</li>
                <span class="material-symbols-sharp flecha-link iconos-link"> keyboard_arrow_down </span>
            </div>

            <ul class="submenu">
                <a href="<?php echo SERVERURL ?>adminClienteCrear/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link"> add</span>
                    <li>Agregar Cliente</li>
                </a>

                <a href="<?php echo SERVERURL ?>adminClienteList/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link"> list_alt</span>
                    <li>Lista de Clientes</li>
                </a>

                <a href="<?php echo SERVERURL ?>adminClienteSearch/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link"> search</span>
                    <li>Buscar Cliente</li>
                </a>
            </ul>
        </span>

        <span class="li-menu li-menu-no-cursor ">
            <div class="links-todo">
                <span class="material-symbols-sharp iconos-link">align_items_stretch</span>

                <li>Items</li>
                <span class="material-symbols-sharp flecha-link iconos-link"> keyboard_arrow_down </span>
            </div>

            <ul class="submenu">
                <a href="<?php echo SERVERURL ?>adminItemCrear/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link"> add</span>
                    <li>Agregar Item</li>
                </a>

                <a href="<?php echo SERVERURL ?>adminItemList/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link"> list_alt</span>
                    <li>Lista de items</li>
                </a>

                <a href="<?php echo SERVERURL ?>adminItemSearch/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link"> search</span>
                    <li>Buscar item</li>
                </a>
            </ul>
        </span>

        <span class="li-menu li-menu-no-cursor ">
            <div class="links-todo">
                <span class="material-symbols-sharp iconos-link">paid</span>
                <li>Préstamos</li>
                <span class="material-symbols-sharp flecha-link iconos-link"> keyboard_arrow_down </span>
            </div>

            <ul class="submenu">
                <a href="<?php echo SERVERURL ?>adminNuevoPrestamo/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link"> add</span>
                    <li>Nuevo préstamo</li>
                </a>

                <a href="<?php echo SERVERURL ?>adminReservaciones/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link">calendar_month</span>
                    <li>Reservaciones</li>
                </a>

                <a href="<?php echo SERVERURL ?>adminPrestamos/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link"> paid</span>
                    <li>Préstamos</li>
                </a>

                <a href="<?php echo SERVERURL ?>adminFinalizado/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link"> fact_check</span>
                    <li>Finalizados</li>
                </a>

                <a href="<?php echo SERVERURL ?>adminSearchDate/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link"> manage_search</span>
                    <li>Buscar por fecha</li>
                </a>

            </ul>
        </span>
        <span class="li-menu li-menu-no-cursor">
            <div class="links-todo">
                <span class="material-symbols-sharp iconos-link">group</span>
                <li>Usuarios</li>
                <span class="material-symbols-sharp flecha-link iconos-link"> keyboard_arrow_down </span>
            </div>

            <ul class="submenu">
                <a href="<?php echo SERVERURL ?>adminUserCrear/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link"> add</span>
                    <li>Agregar Usuario</li>
                </a>

                <a href="<?php echo SERVERURL ?>adminUserList/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link"> list_alt</span>
                    <li>Lista de Usuarios</li>
                </a>

                <a href="<?php echo SERVERURL ?>adminUserSearch/" class="li-menu">
                    <span class="material-symbols-sharp iconos-link"> search</span>
                    <li>Buscar Usuario</li>
                </a>
            </ul>
        </span>

        <a href="<?php echo SERVERURL ?>adminEmpresa/" class="li-menu">
            <span class="material-symbols-sharp iconos-link"> apartment</span>
            <li>Empresa</li>
        </a>
    </ul>

    <div class="perfil">
        <?php
        if (is_file("./views/assets/img/admin/" . $_SESSION["foto_spm"])) {
            // Si la foto existe, mostrarla
            echo '<img src="' . SERVERURL . 'app/views/assets/img/user/fotoUser/' . $_SESSION["foto_spm"] . '" alt="Foto de usuario">';
        } else {
            // Si no existe, mostrar la foto por defecto
            echo '     <img src="' . SERVERURL . './views/assets/img/admin/defecto.png" alt="Foto por defecto">';
        }

        ?>
        <div class="info">
            <p><?php echo $_SESSION["nombre_spm"] ?></p>
            <?php
            $privilegio = "";
            if ($_SESSION["privilegio_spm"] == 1) {
                $privilegio = "Control total";
            } elseif ($_SESSION["privilegio_spm"] == 2) {
                $privilegio = "Edición y registrar";
            } elseif ($_SESSION["privilegio_spm"] == 3) {
                $privilegio = "Registrar";
            }
            ?>
            <span><?php echo $privilegio ?></span>
        </div>
    </div>
</div>