<?php if ($_SESSION["privilegio_spm"] == 1 || $_SESSION["privilegio_spm"] == 2) { ?>

    <div class="titulo-descripcion">
        <h1>Actualizar Préstamo</h1>

        <p></p>
    </div>

    <div class="contenedorPadre">
        <?php

        require_once("./controller/prestamoController.php");

        $insPrestamo = new prestamosControlador();

        $datosPrestamo = $insPrestamo->datosPrestamoControlador("Unico", $url[1]);

        $prestamoEncontrado = $datosPrestamo->rowCount();

        if ($prestamoEncontrado == 1) {
            $campos = $datosPrestamo->fetch();

            if ($campos["prestamo_estado"] == "Finalizado" && $campos["prestamo_pagado"] == $campos["prestamo_total"]) { ?>

                <div class="contenedor-error-ines">

                    <div class="error-ines">
                        <span class="material-symbols-sharp">warning</span>
                        <h4>¡Ocurrió un error inesperado!</h4>
                        <p>Lo sentimos, no podemos actualizar el prestamo debido a que ya se encuentra cancelado y fanalizado.</p>

                    </div>
                </div>
            <?php } else { ?>





                <div class="opciones">
                    <a class="opcion " href="<?php echo SERVERURL ?>adminNuevoPrestamo/"><span class="material-symbols-sharp">add</span>NUEVO
                        PRÉSTAO</a>
                    <a class="opcion " href="<?php echo SERVERURL ?>adminReservaciones/"><span class="material-symbols-sharp">calendar_month</span>RESERVACIONES</a>
                    <a class="opcion" href="<?php echo SERVERURL ?>adminPrestamos/"><span class="material-symbols-sharp">paid</span>PRÉSTAMOS</a>
                    <a class="opcion" href="<?php echo SERVERURL ?>adminFinalizado/"><span class="material-symbols-sharp"> receipt_long</span>FINALIZADOS</a>
                    <a class="opcion" href="<?php echo SERVERURL ?>adminSearchDate/"><span class="material-symbols-sharp"> search_check</span>BUSCAR
                        USUARIO</a>

                </div>

                <div class="formularioContenedor">
                    <?php if ($campos["prestamo_pagado"] != $campos["prestamo_total"]) { ?>

                        <div class="titulo-icon centro">
                            <p>Este préstamo presenta un pago pendiente por la cantidad de <strong> <?php echo MONEDA . number_format(($campos["prestamo_total"] - $campos["prestamo_pagado"]), "2", ",", ",") ?></strong>, puede agregar un pago a este préstamo haciendo clic en el siguiente botón.</p>

                            <div class="grupo-links-adi">
                                <p class="addItem"><span class="material-symbols-sharp">payments</span>AGREGAR PAGO</p>


                            </div>
                        </div>
                    <?php } ?>

                    <div class="addClienteContenedor">
                        <div class="contenedorCliente">
                            <div class="tituloClienteAdd">
                                <p class="addItem">Agregar pago</p>
                                <span class="material-symbols-sharp cerrarC">close</span>
                            </div>
                            <div class="formularioContenedor">

                                <table class="table">
                                    <thead>
                                        <tr class="">
                                            <th>FECHA</th>
                                            <th>MONTO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $datosPago = $insPrestamo->seleccionarDatos("Unico", "pago", "prestamo_codigo", ($campos["prestamo_codigo"]));

                                        if ($datosPago->rowCount() > 0) {
                                            $datosPago = $datosPago->fetchAll();

                                            foreach ($datosPago as $row) {

                                                echo '
                                        <tr>
                                            <td>' . date("d-m-Y", strtotime($row["pago_fecha"])) . '</td>
                                            <td>' . MONEDA . $row["pago_total"] . '</td>
                                        </tr>
                                            ';
                                            }
                                        } else {
                                        ?>
                                            <tr>
                                                <td colspan="2">No hay pagos registrados</td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>

                                <form action="<?php echo SERVERURL ?>ajax/prestamoAjax.php" method="post" class="FormularioAjax item" data-form="save" autocomplete="off">
                                    <input type="hidden" name="pago_codigo_reg" value="<?php echo $insPrestamo->encryption($campos["prestamo_codigo"]) ?>">

                                    <div class="grupo-input grupo-input1 mb">
                                        <div class="input-label">
                                            <input type="text" pattern="[0-9.]{1,10}" class="form-control" name="pago_monto_reg" id="pago_monto_reg" maxlength="10" required="">
                                            <label for="dni">Monto en <?php echo MONEDA ?> </label>
                                            <span></span>
                                        </div>
                                    </div>



                                    <div class="busquedaCerrar ">
                                        <div class="buscarText">
                                            <button type="submit">Agregar</button>
                                        </div>
                                        <div class="buscarText dos">
                                            <p class="cerrarTxt">Cancelar</p>
                                        </div>
                                    </div>

                                </form>


                            </div>
                        </div>
                    </div>



                    <?php
                    require_once("./controller/clienteController.php");

                    $insCliente = new ClienteController();

                    $datosCliente = $insCliente->datosClienteControlador("Unico", $insCliente->encryption($campos["cliente_id"]));
                    $datosCliente = $datosCliente->fetch();


                    ?>
                    <div class="infoAdicionalClient">
                        <div class="nombreClient">
                            <p class="pCiente"><strong>Cliente</strong>: <?php echo $datosCliente["cliente_nombre"] . " " . $datosCliente["cliente_apellido"] ?></p>

                        </div>
                    </div>


                    <div class="contenedorTabla">
                        <table class="table tablem ">
                            <thead>
                                <tr>
                                    <th>ITEM</th>
                                    <th>CANTIDAD</th>
                                    <th>TIEMPO</th>
                                    <th>COSTO</th>
                                    <th>TOTAL</th>
                                </tr>


                            </thead>

                            <tbody>
                                <?php
                                $datos_detale = $insPrestamo->seleccionarDatos("Unico", "detalle", "prestamo_codigo", $campos["prestamo_codigo"]);
                                $datos_detale = $datos_detale->fetchAll();
                                foreach ($datos_detale as $row) {
                                    $subTotal = $row["detalle_cantidad"] * $row["detalle_costo_tiempo"] * $row["detalle_tiempo"];
                                    $subTotal = number_format($subTotal, 2, ".", ",");
                                ?>
                                    <tr class="">
                                        <td><?php echo $row["detalle_descripcion"] ?></td>
                                        <td><?php echo $row["detalle_cantidad"] ?></td>
                                        <td><?php echo $row["detalle_tiempo"] . " " . $row["detalle_formato"] ?></td>
                                        <td><?php echo MONEDA . " " .  $row["detalle_costo_tiempo"] . " x 1 "  . $row["detalle_formato"]  ?></td>
                                        <td><?php echo MONEDA . $subTotal ?></td>




                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>

                    </div>

                    <form action="<?php echo SERVERURL ?>ajax/prestamoAjax.php" method="post" class="FormularioAjax " data-form="save" autocomplete="off">

                        <input type="hidden" name="pago_codigo_up" value="<?php echo $insPrestamo->encryption($campos["prestamo_codigo"]) ?>">

                        <div class="titulo-icon tres">
                            <span class="material-symbols-sharp">schedule</span>
                            <p>Fecha y hora de préstamo</p>
                        </div>

                        <div class="grupo-input">
                            <!-- Fecha -->
                            <div class="input-label">
                                <input type="date" name="fecha_prestamo" value="<?php echo $campos["prestamo_fecha_inicio"] ?>" readonly="">
                                <label for="fecha_prestamo" class="labelSelect">Fecha de préstamo</label>
                                <span></span>
                            </div>
                            <!-- Hora -->
                            <div class="input-label">
                                <input type="text" name="hora_prestamo" value="<?php echo $campos["prestamo_hora_inicio"]; ?>" readonly="">
                                <label for="hora_prestamo" class="labelSelect">Hora de préstamo</label>
                                <span></span>
                            </div>
                        </div>

                        <div class="titulo-icon tres">
                            <span class="material-symbols-sharp">history</span>
                            <p>Fecha y hora de entrega</p>
                        </div>

                        <div class="grupo-input">
                            <!-- Fecha -->
                            <div class="input-label">
                                <input type="date" name="fecha_entrega" value="<?php echo $campos["prestamo_fecha_final"] ?>" readonly="">
                                <label for="fecha_entrega" class="labelSelect">Fecha de entrega</label>
                                <span></span>
                            </div>
                            <!-- Hora -->
                            <div class="input-label">
                                <input type="text" name="hora_entrega" value="<?php echo $campos["prestamo_hora_final"] ?>" readonly="">
                                <label for="hora_entrega" class="labelSelect">Hora de entrega</label>
                                <span></span>
                            </div>
                        </div>

                        <div class="titulo-icon tres">
                            <span class="material-symbols-sharp">deployed_code</span>
                            <p>Otros datos</p>
                        </div>

                        <div class="grupo-input grupo-input3">
                            <!-- Estado -->
                            <div class="input-label">
                                <select name="estado">
                                    <option value="" hidden>Selecciona una opción</option>
                                    <option <?php echo ($campos["prestamo_estado"] === "Reservacion") ? "selected" : "" ?> value="Reservacion">Reservación</option>
                                    <option <?php echo ($campos["prestamo_estado"] === "Prestamo") ? "selected" : "" ?> value="Prestamo">Préstamo</option>
                                    <option <?php echo ($campos["prestamo_estado"] === "Finalizado") ? "selected" : "" ?> value="Finalizado">Finalizado</option>
                                </select>
                                <label class="labelSelect">ESTADO</label>
                                <span></span>
                            </div>

                            <!-- Total a pagar -->
                            <div class="input-label">
                                <input type="text" name="total_pagar" value="<?php echo number_format($campos['prestamo_total'], 2, ".", "")  ?>" readonly="">
                                <label for="total_pagar" class="labelSelect">Total a pagar en <?php echo MONEDA ?></label>
                                <span></span>
                            </div>

                            <!-- Total depositado -->
                            <div class="input-label">
                                <input type="text" name="total_depositado" value="<?php echo $campos["prestamo_pagado"] ?>" readonly>
                                <label for="total_depositado" class="">Total depositado en <?php echo MONEDA ?></label>
                                <span></span>
                            </div>
                        </div>

                        <div class="grupo-input grupo-input1">
                            <!-- Observación -->
                            <div class="input-label">
                                <input type="text" name="observacion_prestamo" value="<?php echo $campos["prestamo_observacion"] ?>">
                                <label for="observacion_prestamo" class="">Observación</label>
                                <span></span>
                            </div>
                        </div>

                        <div class="grupo-input grupo-input-botones">
                            <!-- Guardar -->
                            <div class="input-btn">
                                <button class="guardar" type="submit"><span class="material-symbols-sharp">save</span>Actualizar</button>
                            </div>
                        </div>

                    </form>

                </div>

    </div>




    <script>
        const addItem = document.querySelector(".addItem");
        const addClienteContenedor2 = document.querySelector(".addClienteContenedor");
        const cerrarC1 = document.querySelector(".addClienteContenedor .cerrarC");
        const cerrarTxt2 = document.querySelector(".addClienteContenedor .cerrarTxt");
        const contenedorCliente2 = document.querySelector(".addClienteContenedor .contenedorCliente")








        addItem.addEventListener("click", () => {
            addClienteContenedor2.classList.add("activo");
            contenedorCliente2.classList.remove("activo")

        });

        cerrarC1.addEventListener("click", () => {
            addClienteContenedor2.classList.remove("activo");
            contenedorCliente2.classList.remove("activo")
        });

        cerrarTxt2.addEventListener("click", () => {
            addClienteContenedor2.classList.remove("activo");
            contenedorCliente2.classList.remove("activo")
        });



        addClienteContenedor2.addEventListener("click", (e) => {
            if (e.target.classList.contains("addClienteContenedor")) {
                addClienteContenedor2.classList.remove("activo");
            }
        });
    </script>


<?php require_once("./views/inc/admin/reservation.php");
            }
        } else {
            require_once("./views/inc/admin/errorDatos.php");
        } ?>

<?php
}else{
require_once("./views/inc/admin/sinPermiso.php");
}
?>