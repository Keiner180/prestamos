<?php
if ($lc->encryption($_SESSION["id_spm"]) == $url[1]) {


?>

    <div class="titulo-descripcion">
        <h1>Actualizar datos de mi cuenta</h1>
        <p></p>
    </div>


    <div class="contenedorPadre">
        <?php
        require_once("./controller/userController.php");
        $insUsuario = new userController();
        $datosUsuario = $insUsuario->datosUsuarioControlador("Unico", ($url[1]));
        $usuaioEncontado = $datosUsuario->rowCount();
        if ($usuaioEncontado == 1) {
            $campos = $datosUsuario->fetch();
        ?>
            <div class="opciones">
                <a class="opcion " href="<?php echo SERVERURL ?>adminUserCrear/"><span class="material-symbols-sharp">add</span>AGREGAR
                    USUARIO</a>
                <a class="opcion " href="<?php echo SERVERURL ?>adminUserList/"><span class="material-symbols-sharp"> list_alt</span>LISTA DE
                    USUARIOS</a>
                <a class="opcion " href="<?php echo SERVERURL ?>adminUserSearch/"><span class="material-symbols-sharp"> search</span>BUSCAR USUARIO</a>

            </div>
            <div class="formularioContenedor">

                <div class="titulo-icon">
                    <span class="material-symbols-sharp">person</span>
                    <p> Información personal</p>
                </div>
                <form class="FormularioAjax" action="<?php echo SERVERURL ?>ajax/userAjax.php" method="post" data-form="update" autocomplete="off">

                    <input type="hidden" name="user" value="actualizar">
                    <input type="hidden" name="usuario_id" value="<?php echo $url[1] ?>"><!-- ID del usuario -->


                    <div class="grupo-input grupo-input3">
                        <!-- DNI -->
                        <div class="input-label">
                            <input type="text" name="usuario_dni" value="<?php echo $campos["usuario_dni"] ?>">
                            <label for="dni">DNI</label>
                            <span></span>
                        </div>
                        <!-- Nombre -->
                        <div class="input-label">
                            <input type="text" value="<?php echo $campos["usuario_nombre"] ?>" name="usuario_nombres">
                            <label for="dni">Nombres</label>
                            <span></span>
                        </div>
                        <!-- Apellidos -->
                        <div class="input-label">
                            <input type="text" name="usuario_apellidos" value="<?php echo $campos["usuario_apellido"] ?>">
                            <label for="dni">Apellidos</label>
                            <span></span>
                        </div>
                    </div>

                    <div class="grupo-input">
                        <!-- TELEFONO -->
                        <div class="input-label">
                            <input type="text" name="usuario_telefono" value="<?php echo $campos["usuario_telefono"] ?>">
                            <label for="dni">TELÉFONO</label>
                            <span></span>
                        </div>
                        <!-- Dirección -->
                        <div class="input-label">
                            <input type="text" name="usuario_direccion" value="<?php echo $campos["usuario_direccion"] ?>">
                            <label for="dni">Dirección</label>
                            <span></span>
                        </div>
                    </div>

                    <div class="titulo-icon dos">
                        <span class="material-symbols-sharp">account_circle</span>
                        <p> Información de la cuenta</p>
                    </div>

                    <div class="grupo-input">
                        <!-- Usuario -->
                        <div class="input-label">
                            <input type="text" name="usuario_nombre_usuario" value="<?php echo $campos["usuario_usuario"] ?>">
                            <label for="dni">NOMBRE DE USUARIO</label>
                            <span></span>
                        </div>
                        <!-- EMAIL -->
                        <div class="input-label">
                            <input type="text" name="usuario_email" value="<?php echo $campos["usuario_email"] ?>">
                            <label for="dni">EMAIL</label>
                            <span></span>
                        </div>
                    </div>

                    <?php if ($_SESSION["privilegio_spm"] == 1 && $campos["usuario_id"] != 1) { ?>
                        <div class="grupo-input grupo-input1">
                            <!-- Estado de la cuenta -->
                            <div class="input-label">
                                <select name="usuario_estado">
                                    <option selected value="" hidden>Selecciona una opción</option>
                                    <option <?php echo ($campos["usuario_estado"] == "Activa") ? "selected"  : "" ?> value="Activa">Activa</option>
                                    <option <?php echo ($campos["usuario_estado"] == "Deshabilitada") ? "selected"  : "" ?> value="Deshabilitada">Deshabilitada</option>
                                </select>
                                <label class="labelSelect">ESTADO DE CUENTA</label>
                                <span></span>
                            </div>
                        </div>
                    <?php } ?>



                    <div class="titulo-icon dos">
                        <span class="material-symbols-sharp">lock</span>
                        <p>Nueva contraseña (Opcional)</p>
                    </div>


                    <div class="grupo-input">
                        <!-- Contraseña -->
                        <div class="input-label">
                            <input type="password" name="usuario_contrasena_nueva" value="">
                            <label for="dni">CONTRASEÑA</label>
                            <span></span>
                        </div>
                        <!-- Repetir contraseña -->
                        <div class="input-label">
                            <input type="password" name="usuario_contrasena_nueva_repetir">
                            <label for="dni">REPETIR CONTRASEÑA</label>
                            <span></span>
                        </div>
                    </div>

                    <?php if ($_SESSION["privilegio_spm"] == 1 && $campos["usuario_id"] != 1) { ?>

                        <div class="titulo-icon dos privilegio">
                            <div class="text-icon">
                                <span class="material-symbols-sharp">social_leaderboard</span>
                                <p> Nivel de privilegio</p>
                            </div>
                            <div class="pre">
                                <p><span class="ctrlTotal">Control total</span>Permisos para registrar, actualizar y eliminar</p>
                                <p><span class="ctrlEdicion">Edición</span>Permisos para registrar y actualizar</p>
                                <p><span class="ctrlRegistrar">Registrar</span>Solo permisos para registrar</p>
                            </div>
                        </div>




                        <div class="grupo-input grupo-input1">
                            <!-- Privilegio -->
                            <div class="input-label">
                                <select name="usuario_privilegio">
                                    <option selected value="" hidden>Selecciona una opción</option>
                                    <option <?php echo ($campos["usuario_privilegio"] == 1) ? "selected"  : "" ?> value="1">Control total</option>
                                    <option <?php echo ($campos["usuario_privilegio"] == 2) ? "selected"  : "" ?> value="2">Edición</option>
                                    <option <?php echo ($campos["usuario_privilegio"] == 3) ? "selected"  : "" ?> value="3">Registrar</option>
                                </select>
                                <label class="labelSelect">NIVEL DE PRIVILEGIO</label>
                                <span></span>
                            </div>
                        </div>
                    <?php } ?>



                    <div class="titulo-icon dos">
                        <p class="pCeentrado">Para poder guardar los cambios de este cuenta debe ingresar su nombre de usuario y contraseña</p>
                    </div>

                    <div class="grupo-input">
                        <!-- Usuario -->
                        <div class="input-label">
                            <input type="text" name="admin_usuario" value="">
                            <label for="dni">Usuario</label>
                            <span></span>
                        </div>
                        <!-- contraseña -->
                        <div class="input-label">
                            <input type="password" name="admin_password">
                            <label for="dni">Contraseña</label>
                            <span></span>
                        </div>
                    </div>

                    <?php if ($lc->encryption($_SESSION["id_spm"]) != $url[1]) { ?>
                        <input type="hidden" name="tipo_cuenta" value="Impropia">
                    <?php } else { ?>
                        <input type="hidden" name="tipo_cuenta" value="Propia">
                    <?php } ?>


                    <div class="grupo-input grupo-input-botones">
                        <!-- Guardar -->
                        <div class="input-btn">
                            <button class="limpiar" type="reset"><span class="material-symbols-sharp">map</span>Limpiar</button>
                            <button class="guardar" type="submit"><span class="material-symbols-sharp">save</span>Guardar</button>
                        </div>
                    </div>
                </form>


            </div>
        <?php } else {
            require_once("./views/inc/admin/errorDatos.php");
        }
        ?>

    </div>

<?php } elseif (($_SESSION["privilegio_spm"] == 1 || $_SESSION["privilegio_spm"] == 2)) { ?>

    <div class="titulo-descripcion">
        <h1>Actualizar datos</h1>
        <p></p>
    </div>

    <div class="contenedorPadre">
        <?php
        require_once("./controller/userController.php");
        $insUsuario = new userController();
        $datosUsuario = $insUsuario->datosUsuarioControlador("Unico", ($url[1]));
        $usuaioEncontado = $datosUsuario->rowCount();
        if ($usuaioEncontado == 1) {
            $campos = $datosUsuario->fetch();
        ?>
            <div class="opciones">
                <a class="opcion " href="<?php echo SERVERURL ?>adminUserCrear/"><span class="material-symbols-sharp">add</span>AGREGAR
                    USUARIO</a>
                <a class="opcion " href="<?php echo SERVERURL ?>adminUserList/"><span class="material-symbols-sharp"> list_alt</span>LISTA DE
                    USUARIOS</a>
                <a class="opcion " href="<?php echo SERVERURL ?>adminUserSearch/"><span class="material-symbols-sharp"> search</span>BUSCAR USUARIO</a>

            </div>
            <div class="formularioContenedor">

                <div class="titulo-icon">
                    <span class="material-symbols-sharp">person</span>
                    <p> Información personal</p>
                </div>
                <form class="FormularioAjax" action="<?php echo SERVERURL ?>ajax/userAjax.php" method="post" data-form="update" autocomplete="off">

                    <input type="hidden" name="user" value="actualizar">
                    <input type="hidden" name="usuario_id" value="<?php echo $url[1] ?>"><!-- ID del usuario -->


                    <div class="grupo-input grupo-input3">
                        <!-- DNI -->
                        <div class="input-label">
                            <input type="text" name="usuario_dni" value="<?php echo $campos["usuario_dni"] ?>">
                            <label for="dni">DNI</label>
                            <span></span>
                        </div>
                        <!-- Nombre -->
                        <div class="input-label">
                            <input type="text" value="<?php echo $campos["usuario_nombre"] ?>" name="usuario_nombres">
                            <label for="dni">Nombres</label>
                            <span></span>
                        </div>
                        <!-- Apellidos -->
                        <div class="input-label">
                            <input type="text" name="usuario_apellidos" value="<?php echo $campos["usuario_apellido"] ?>">
                            <label for="dni">Apellidos</label>
                            <span></span>
                        </div>
                    </div>

                    <div class="grupo-input">
                        <!-- TELEFONO -->
                        <div class="input-label">
                            <input type="text" name="usuario_telefono" value="<?php echo $campos["usuario_telefono"] ?>">
                            <label for="dni">TELÉFONO</label>
                            <span></span>
                        </div>
                        <!-- Dirección -->
                        <div class="input-label">
                            <input type="text" name="usuario_direccion" value="<?php echo $campos["usuario_direccion"] ?>">
                            <label for="dni">Dirección</label>
                            <span></span>
                        </div>
                    </div>

                    <div class="titulo-icon dos">
                        <span class="material-symbols-sharp">account_circle</span>
                        <p> Información de la cuenta</p>
                    </div>

                    <div class="grupo-input">
                        <!-- Usuario -->
                        <div class="input-label">
                            <input type="text" name="usuario_nombre_usuario" value="<?php echo $campos["usuario_usuario"] ?>">
                            <label for="dni">NOMBRE DE USUARIO</label>
                            <span></span>
                        </div>
                        <!-- EMAIL -->
                        <div class="input-label">
                            <input type="text" name="usuario_email" value="<?php echo $campos["usuario_email"] ?>">
                            <label for="dni">EMAIL</label>
                            <span></span>
                        </div>
                    </div>

                    <?php if ($_SESSION["privilegio_spm"] == 1 && $campos["usuario_id"] != 1) { ?>
                        <div class="grupo-input grupo-input1">
                            <!-- Estado de la cuenta -->
                            <div class="input-label">
                                <select name="usuario_estado">
                                    <option selected value="" hidden>Selecciona una opción</option>
                                    <option <?php echo ($campos["usuario_estado"] == "Activa") ? "selected"  : "" ?> value="Activa">Activa</option>
                                    <option <?php echo ($campos["usuario_estado"] == "Deshabilitada") ? "selected"  : "" ?> value="Deshabilitada">Deshabilitada</option>
                                </select>
                                <label class="labelSelect">ESTADO DE CUENTA</label>
                                <span></span>
                            </div>
                        </div>
                    <?php } ?>



                    <div class="titulo-icon dos">
                        <span class="material-symbols-sharp">lock</span>
                        <p>Nueva contraseña (Opcional)</p>
                    </div>


                    <div class="grupo-input">
                        <!-- Contraseña -->
                        <div class="input-label">
                            <input type="password" name="usuario_contrasena_nueva" value="">
                            <label for="dni">CONTRASEÑA</label>
                            <span></span>
                        </div>
                        <!-- Repetir contraseña -->
                        <div class="input-label">
                            <input type="password" name="usuario_contrasena_nueva_repetir">
                            <label for="dni">REPETIR CONTRASEÑA</label>
                            <span></span>
                        </div>
                    </div>

                    <?php if ($_SESSION["privilegio_spm"] == 1 && $campos["usuario_id"] != 1) { ?>

                        <div class="titulo-icon dos privilegio">
                            <div class="text-icon">
                                <span class="material-symbols-sharp">social_leaderboard</span>
                                <p> Nivel de privilegio</p>
                            </div>
                            <div class="pre">
                                <p><span class="ctrlTotal">Control total</span>Permisos para registrar, actualizar y eliminar</p>
                                <p><span class="ctrlEdicion">Edición</span>Permisos para registrar y actualizar</p>
                                <p><span class="ctrlRegistrar">Registrar</span>Solo permisos para registrar</p>
                            </div>
                        </div>




                        <div class="grupo-input grupo-input1">
                            <!-- Privilegio -->
                            <div class="input-label">
                                <select name="usuario_privilegio">
                                    <option selected value="" hidden>Selecciona una opción</option>
                                    <option <?php echo ($campos["usuario_privilegio"] == 1) ? "selected"  : "" ?> value="1">Control total</option>
                                    <option <?php echo ($campos["usuario_privilegio"] == 2) ? "selected"  : "" ?> value="2">Edición</option>
                                    <option <?php echo ($campos["usuario_privilegio"] == 3) ? "selected"  : "" ?> value="3">Registrar</option>
                                </select>
                                <label class="labelSelect">NIVEL DE PRIVILEGIO</label>
                                <span></span>
                            </div>
                        </div>
                    <?php } ?>



                    <div class="titulo-icon dos">
                        <p class="pCeentrado">Para poder guardar los cambios de este cuenta debe ingresar su nombre de usuario y contraseña</p>
                    </div>

                    <div class="grupo-input">
                        <!-- Usuario -->
                        <div class="input-label">
                            <input type="text" name="admin_usuario" value="">
                            <label for="dni">Usuario</label>
                            <span></span>
                        </div>
                        <!-- contraseña -->
                        <div class="input-label">
                            <input type="password" name="admin_password">
                            <label for="dni">Contraseña</label>
                            <span></span>
                        </div>
                    </div>

                    <?php if ($lc->encryption($_SESSION["id_spm"]) != $url[1]) { ?>
                        <input type="hidden" name="tipo_cuenta" value="Impropia">
                    <?php } else { ?>
                        <input type="hidden" name="tipo_cuenta" value="Propia">
                    <?php } ?>


                    <div class="grupo-input grupo-input-botones">
                        <!-- Guardar -->
                        <div class="input-btn">
                            <button class="limpiar" type="reset"><span class="material-symbols-sharp">map</span>Limpiar</button>
                            <button class="guardar" type="submit"><span class="material-symbols-sharp">save</span>Guardar</button>
                        </div>
                    </div>
                </form>


            </div>
        <?php } else {
            require_once("./views/inc/admin/errorDatos.php");
        }
        ?>

    </div>
<?php }else {
    require_once("./views/inc/admin/sinPermiso.php");
} ?>
