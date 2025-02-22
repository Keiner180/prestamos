<div class="titulo-descripcion">
    <h1>Empresa</h1>
    <p></p>
</div>

<div class="contenedorPadre">


    <div class="formularioContenedor">

        <?php
        require_once("./controller/empresaController.php");
        $ins_empresa = new EmpresaController();

        $datos_empresa = $ins_empresa->datosEmpresaControlador();


        if ($datos_empresa->rowCount() == 0) {
        ?>
            <div class="titulo-icon">
                <span class="material-symbols-sharp">business</span>

                <p> Información de la empresa</p>
            </div>
            <form action="<?php echo SERVERURL ?>ajax/empresaAjax.php" method="post" class="FormularioAjax" data-form="save" autocomplete="off">
            <input type="hidden" name="empresa" value="agregar">


                <div class="grupo-input ">
                    <!-- Nombre -->
                    <div class="input-label">
                        <input type="text" name="nombre_empresa">
                        <label for="dni">Nombre de la empresa</label>
                        <span></span>
                    </div>
                    <!-- correo -->
                    <div class="input-label">
                        <input type="text" name="correo_empresa">
                        <label for="dni">Correo</label>
                        <span></span>

                    </div>
                </div>

                <div class="grupo-input">

                    <!--TELEFONO -->
                    <div class="input-label">
                        <input type="text" name="telefono_empresa">
                        <label for="dni">Teléfono</label>
                        <span></span>

                    </div>

                    <!--DIRECCION -->
                    <div class="input-label">
                        <input type="text" name="direccion_empresa">
                        <label for="dni">Dirección</label>
                        <span></span>

                    </div>
                </div>

                <div class="grupo-input grupo-input-botones">
                    <!-- Guardar -->
                    <div class="input-btn">
                        <button class="limpiar" type="reset"><span
                                class="material-symbols-sharp">map</span>Limpiar</button>
                        <button class="guardar" type="submit"><span
                                class="material-symbols-sharp">save</span>Guardar</button>
                    </div>
                </div>

            </form>

        <?php } elseif (($datos_empresa->rowCount() == 1) && ($_SESSION["privilegio_spm"] == 1)) { ?>

            <div class="titulo-icon">
                <span class="material-symbols-sharp">domain</span>

                <p>Actualizar Información de la empresa</p>
            </div>

            <?php
            $campos = $datos_empresa->fetch();
            ?>

            <form action="<?php echo SERVERURL ?>ajax/empresaAjax.php" method="post" class="FormularioAjax" data-form="update" autocomplete="off">
                <input type="hidden" name="empresa_id" value="<?php echo $campos["empresa_id"] ?>">
                <input type="hidden" name="empresa" value="actualizar">

                <div class="grupo-input ">
                    <!-- Nombre -->
                    <div class="input-label">
                        <input type="text" name="nombre_empresa" value="<?php echo $campos["empresa_nombre"] ?>">
                        <label for="dni">Nombre de la empresa</label>
                        <span></span>
                    </div>
                    <!-- correo -->
                    <div class="input-label">
                        <input type="text" name="correo_empresa" value="<?php echo $campos["empresa_email"] ?>">
                        <label for="dni">Correo</label>
                        <span></span>

                    </div>
                </div>

                <div class="grupo-input">

                    <!--TELEFONO -->
                    <div class="input-label">
                        <input type="text" name="telefono_empresa" value="<?php echo $campos["empresa_telefono"] ?>">
                        <label for="dni">Teléfono</label>
                        <span></span>

                    </div>

                    <!--DIRECCION -->
                    <div class="input-label">
                        <input type="text" name="direccion_empresa" value="<?php echo $campos["empresa_direccion"] ?>">
                        <label for="dni">Dirección</label>
                        <span></span>

                    </div>
                </div>

                <div class="grupo-input grupo-input-botones">
                    <!-- Guardar -->
                    <div class="input-btn">
                        <button class="limpiar" type="reset"><span
                                class="material-symbols-sharp">map</span>Limpiar</button>
                        <button class="guardar" type="submit"><span
                                class="material-symbols-sharp">save</span>Guardar</button>
                    </div>
                </div>

            </form>
        <?php
        } elseif(1<2) {
            require_once("./views/inc/admin/errorDatos.php");
        } ?>

    </div>

</div>

1