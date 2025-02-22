<div class="titulo-descripcion"> <!--Tengo que poner la condicon de registarda y registradas -->
    <h1>AGREGAR CLIENTE</h1>
    <p></p>
</div>


<div class="contenedorPadre">
    <div class="opciones">
        <a class="opcion activo cursor" href="<?php echo SERVERURL ?>adminUserCrear/"><span class="material-symbols-sharp">add</span>AGREGAR
            USUARIO</a>
        <a class="opcion " href="<?php echo SERVERURL ?>adminUserList/"><span class="material-symbols-sharp"> list_alt</span>LISTA DE
            USUARIOS</a>
        <a class="opcion" href="<?php echo SERVERURL ?>adminUserSearch/"><span class="material-symbols-sharp"> search</span>BUSCAR USUARIO</a>

    </div>

    <div class="formularioContenedor">
        <div class="titulo-icon">
            <span class="material-symbols-sharp">person</span>
            <p> Información personal</p>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVERURL ?>ajax/userAjax.php" method="post" data-form="save" autocomplete="off">
            <input type="hidden" name="user" value="register">

            <div class="grupo-input grupo-input3">
                <!-- DNI -->
                <div class="input-label">
                    <input type="text" name="usuario_dni">
                    <label for="dni">DNI</label>
                    <span></span>
                </div>
                <!-- Nombre -->
                <div class="input-label">
                    <input type="text" name="usuario_nombres">
                    <label for="dni">Nombres</label>
                    <span></span>
                </div>
                <!-- Apellidos -->
                <div class="input-label">
                    <input type="text" name="usuario_apellidos">
                    <label for="dni">Apellidos</label>
                    <span></span>
                </div>
            </div>

            <div class="grupo-input">
                <!-- TELEFONO -->
                <div class="input-label">
                    <input type="text" name="usuario_telefono">
                    <label for="dni">TELÉFONO</label>
                    <span></span>
                </div>
                <!-- Dirección -->
                <div class="input-label">
                    <input type="text" name="usuario_direccion">
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
                    <input type="text" name="usuario_nombre_usuario">
                    <label for="dni">NOMBRE DE USUARIO</label>
                    <span></span>
                </div>
                <!-- EMAIL -->
                <div class="input-label">
                    <input type="text" name="usuario_email">
                    <label for="dni">EMAIL</label>
                    <span></span>
                </div>
            </div>

            <div class="grupo-input">
                <!-- Contraseña -->
                <div class="input-label">
                    <input type="password" name="usuario_contrasena">
                    <label for="dni">CONTRASEÑA</label>
                    <span></span>
                </div>
                <!-- Repetir contraseña -->
                <div class="input-label">
                    <input type="password" name="usuario_repetir_contrasena">
                    <label for="dni">REPETIR CONTRASEÑA</label>
                    <span></span>
                </div>
            </div>

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
                        <option value="" hidden>Selecciona una opción</option>
                        <option value="1">Control total</option>
                        <option value="2">Edición</option>
                        <option value="3">Registrar</option>
                    </select>
                    <label class="labelSelect">NIVEL DE PRIVILEGIO</label>
                    <span></span>
                </div>
            </div>

            <div class="grupo-input grupo-input-botones">
                <!-- Guardar -->
                <div class="input-btn">
                    <button class="limpiar" type="reset"><span class="material-symbols-sharp">map</span>Limpiar</button>
                    <button class="guardar" type="submit"><span class="material-symbols-sharp">save</span>Guardar</button>
                </div>
            </div>
        </form>

    </div>

</div>
