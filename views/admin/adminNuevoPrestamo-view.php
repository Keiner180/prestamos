<div class="titulo-descripcion">
    <h1>NUEVO PRÉSTAMO</h1>

    <p></p>
</div>

<div class="contenedorPadre">
    <div class="opciones">
        <a class="opcion activo cursor" href="<?php echo SERVERURL ?>adminNuevoPrestamo/"><span class="material-symbols-sharp">add</span>NUEVO
            PRÉSTAO</a>
        <a class="opcion " href="<?php echo SERVERURL ?>adminReservaciones/"><span class="material-symbols-sharp">calendar_month</span>RESERVACIONES</a>
        <a class="opcion" href="<?php echo SERVERURL ?>adminPrestamos/"><span class="material-symbols-sharp">paid</span>PRÉSTAMOS</a>
        <a class="opcion" href="<?php echo SERVERURL ?>adminFinalizado/"><span class="material-symbols-sharp"> receipt_long</span>FINALIZADOS</a>
        <a class="opcion" href="<?php echo SERVERURL ?>adminSearchDate/"><span class="material-symbols-sharp"> search_check</span>BUSCAR
            USUARIO</a>

    </div>

    <div class="formularioContenedor">

        <div class="titulo-icon centro">
            <p>AGREGAR CLIENTE O ITEMS</p>
            <div class="grupo-links-adi">
                <?php if (empty($_SESSION["datos_cliente"])) { ?>
                    <p class="addCliente"><span class="material-symbols-sharp">person_add</span>AGREGAR CLIENTE</p>
                <?php  } else { ?>
                    <p class="addCliente"></p>
                <?php  } ?>

                <p class="addItem"><span class="material-symbols-sharp">package_2</span>AGREGAR ITEM</p>
            </div>
        </div>

        <div class="addClienteContenedor">
            <div class="contenedorCliente">
                <div class="tituloClienteAdd">
                    <p>Agregar cliente</p>
                    <span class="material-symbols-sharp cerrarC">close</span>
                </div>
                <div class="input-label">
                    <input type="text" id="inputCliente" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}">
                    <label for="dni">DNI, NOMBRE APELLIDO, TELÉFONO</label>
                    <span></span>
                </div>

                <div id="tabla_clientes">



                </div>



                <div class="busquedaCerrar">
                    <div class="buscarText">
                        <span class="material-symbols-sharp">search</span>
                        <p onclick="buscarCliente()">Buscar</p>
                    </div>
                    <div class="buscarText dos">
                        <p class="cerrarTxt">Cerrar</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="addClienteContenedor2">
            <div class="contenedorCliente">
                <div class="tituloClienteAdd">
                    <p>Agregar item</p>
                    <span class="material-symbols-sharp cerrarC">close</span>
                </div>
                <div class="input-label">
                    <input type="text" id="inputItem">
                    <label for="dni">CÓDIGO,NOMBRE</label>
                    <span></span>
                </div>
                <div id="tabla_item">

                </div>



                <div class="busquedaCerrar">
                    <div class="buscarText">
                        <span class="material-symbols-sharp">search</span>
                        <p onclick="buscarItem()">Buscar</p>
                    </div>
                    <div class="buscarText dos">
                        <p class="cerrarTxt">Cerrar</p>
                    </div>
                </div>

            </div>
        </div>


        <!-- Formulario item -->
        <div class="addClienteContenedor3  ">
            <div class="contenedorCliente">
                <div class="tituloClienteAdd">
                    <p cl>Selecciona el formato, cantidad de items, tiempo y costo del préstamo del item</p>
                    <span class="material-symbols-sharp cerrarC">close</span>
                </div>
                <!-- Formato de prestamo -->
                <div class="formularioContenedor">

                    <form action="<?php echo SERVERURL ?>ajax/prestamoAjax.php" method="post" class="FormularioAjax item" data-form="" autocomplete="off">
                        <input type="hidden" name="id_agregar_item" id="id_agregar_item">
                        <div class="grupo-input grupo-input1">
                            <!-- Privilegio -->
                            <div class="input-label">
                                <select class="form-control" name="detalle_formato" id="detalle_formato">
                                    <option value="Horas" selected="">Horas</option>
                                    <option value="Dias">Días</option>
                                    <option value="Evento">Evento</option>
                                    <option value="Mes">Mes</option>
                                </select>
                                <label class="labelSelect">Formato de préstamo</label>
                                <span></span>
                            </div>
                        </div>


                        <div class="grupo-input grupo-input1">
                            <div class="input-label">
                                <input type="num" pattern="[0-9]{1,7}" class="form-control" name="detalle_cantidad" id="detalle_cantidad" maxlength="7" required="">
                                <label for="dni">Cantidad items</label>
                                <span></span>
                            </div>
                        </div>


                        <div class="grupo-input grupo-input1">
                            <div class="input-label">
                                <input type="num" pattern="[0-9]{1,7}" class="form-control" name="detalle_tiempo" id="detalle_tiempo" maxlength="7" required="">
                                <label for="dni">Tiempo (según formato)</label>
                                <span></span>
                            </div>
                        </div>


                        <div class="grupo-input grupo-input1 mb">
                            <div class="input-label">
                                <input type="text" pattern="[0-9.]{1,15}" class="form-control" name="detalle_costo_tiempo" id="detalle_costo_tiempo" maxlength="15" required="">
                                <label for="dni">Costo por unidad de tiempo</label>
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


        <div class="infoAdicionalClient">
            <div class="nombreClient">
                <p class="pCiente">Cliente:</p>
                <?php if (empty($_SESSION["datos_cliente"])) { ?>

                    <span class="material-symbols-sharp iconError ">warning</span>
                    <span class="textRojo">Seleccione un cliente</span>

                <?php  } else { ?>
                    <div class="contenedorFormCleint">
                        <form action="<?php echo SERVERURL ?>ajax/prestamoAjax.php" method="post" class="FormularioAjax formCliente" data-form="loans" autocomplete="off">
                            <p class="nombreClienP"><?php echo $_SESSION["datos_cliente"]["Nombre"] . " " . $_SESSION["datos_cliente"]["Apellido"] . " (" . $_SESSION["datos_cliente"]["DNI"]  . ")" ?> </p>
                            <input type="hidden" name="id_eliminar_cliente" value="<?php echo $_SESSION["datos_cliente"]["ID"]; ?>">

                            <button class="buttonIcono" type="submit"> <span class="material-symbols-sharp iconPeronQuit">person_remove</span></button>

                        </form>
                    </div>
                <?php  } ?>

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
                        <th>SUBTOTAL</th>
                        <th>DETALLE</th>
                        <th>ELIMINAR</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if (isset($_SESSION["datos_item"]) &&  count($_SESSION["datos_item"]) >= 1) {

                        $_SESSION['prestamo_total'] = 0;
                        $_SESSION['prestamo_item'] = 0;

                        foreach ($_SESSION['datos_item'] as $items) {

                            $subTotal = $items["Cantidad"] * $items["Costo"] * $items["Tiempo"];
                            $subTotal = number_format($subTotal, 2, ".", "");
                    ?>


                            <tr>
                                <td><?php echo $items["Nombre"] ?></td>
                                <td><?php echo $items["Cantidad"] ?></td>
                                <td><?php echo $items["Tiempo"] . " " . $items["Formato"]   ?></td>
                                <td><?php echo MONEDA . " " .  $items["Costo"] . " x 1 "  . $items["Formato"]  ?></td>
                                <td><?php echo $subTotal ?></td>

                                <td>
                                    <span class="material-symbols-sharp icon-info">info</span>
                                    <div class="infoUser dos">
                                        <div class="nombreCle"><strong><?php echo $items["Nombre"] ?></strong></div>
                                        <div class="DireccionCle"><?php echo $items["Detalle"] ?></div>
                                    </div>
                                </td>

                                <td>
                                    <form action="<?php echo SERVERURL ?>ajax/prestamoAjax.php" method="post" class="FormularioAjax formCliente" data-form="loans" autocomplete="off">



                                        <input type="hidden" name="id_eliminar_item" value="<?php echo $items["ID"] ?>">

                                        <button type="submit" class="eliminarForm"><span class="material-symbols-sharp icon-del">delete</span></button>
                                    </form>


                                </td>
                            </tr>
                        <?php

                            $_SESSION['prestamo_total'] += $subTotal;
                            $_SESSION['prestamo_item'] += $items["Cantidad"];
                        }
                        ?>

                        <tr class="negritaTr">
                            <td>TOTAL</td>
                            <td><?php echo $_SESSION['prestamo_item'] . " Items" ?></td>
                            <td></td>
                            <td></td>
                            <td><?php echo MONEDA . " " . number_format($_SESSION['prestamo_total'], 2, ".", "")  ?></td>

                            <td></td>
                            <td></td>

                        </tr>

                    <?php
                    } else {
                        $_SESSION['prestamo_total'] = 0;
                        $_SESSION['prestamo_item'] = 0;


                    ?>
                        <tr class="negritaTr">
                            <td colspan="100">No hay items seleccionados</td>
                        </tr>
                    <?php }  ?>




                </tbody>
            </table>

        </div>

        <form action="<?php echo SERVERURL ?>ajax/prestamoAjax.php" method="post" class="FormularioAjax " data-form="save" autocomplete="off">

            <input type="hidden" name="agregar_prestamo">
            <div class="titulo-icon tres">
                <span class="material-symbols-sharp">schedule</span>
                <p>Fecha y hora de préstamo</p>
            </div>

            <div class="grupo-input">
                <!-- Fecha -->
                <div class="input-label">
                    <input type="date" name="fecha_prestamo" value="<?php echo date("Y-m-d"); ?>">
                    <label for="fecha_prestamo" class="labelSelect">Fecha de préstamo</label>
                    <span></span>
                </div>
                <!-- Hora -->
                <div class="input-label">
                    <input type="time" name="hora_prestamo" value="<?php echo date("H:i"); ?>">
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
                    <input type="date" name="fecha_entrega">
                    <label for="fecha_entrega" class="labelSelect">Fecha de entrega</label>
                    <span></span>
                </div>
                <!-- Hora -->
                <div class="input-label">
                    <input type="time" name="hora_entrega">
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
                        <option value="Reservacion">Reservación</option>
                        <option value="Prestamo">Préstamo</option>
                        <option value="Finalizado">Finalizado</option>
                    </select>
                    <label class="labelSelect">ESTADO</label>
                    <span></span>
                </div>

                <!-- Total a pagar -->
                <div class="input-label">
                    <input type="text" name="total_pagar" value="<?php echo number_format($_SESSION['prestamo_total'], 2, ".", "")  ?>" readonly="">
                    <label for="total_pagar" class="labelSelect">Total a pagar en <?php echo MONEDA ?></label>
                    <span></span>
                </div>

                <!-- Total depositado -->
                <div class="input-label">
                    <input type="text" name="total_depositado">
                    <label for="total_depositado" class="">Total depositado en <?php echo MONEDA ?></label>
                    <span></span>
                </div>
            </div>

            <div class="grupo-input grupo-input1">
                <!-- Observación -->
                <div class="input-label">
                    <input type="text" name="observacion_prestamo">
                    <label for="observacion_prestamo" class="">Observación</label>
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




<script>
    const addCliente = document.querySelector(".addCliente");
    const addClienteContenedor = document.querySelector(".addClienteContenedor");
    const cerrarC = document.querySelector(".addClienteContenedor .cerrarC");
    const cerrarTxt = document.querySelector(".cerrarTxt");
    const contenedorCliente = document.querySelector(".contenedorCliente")

    const addItem = document.querySelector(".addItem");
    const addClienteContenedor2 = document.querySelector(".addClienteContenedor2");
    const cerrarC1 = document.querySelector(".addClienteContenedor2 .cerrarC");
    const cerrarTxt2 = document.querySelector(".addClienteContenedor2 .cerrarTxt");
    const contenedorCliente2 = document.querySelector(".addClienteContenedor2 .contenedorCliente")

    const addClienteContenedor3 = document.querySelector(".addClienteContenedor3");
    const cerrarC2 = document.querySelector(".addClienteContenedor3 .cerrarC");
    const cerrarTxt3 = document.querySelector(".addClienteContenedor3 .cerrarTxt");
    const contenedorCliente3 = document.querySelector(".addClienteContenedor3 .contenedorCliente")

    addCliente.addEventListener("click", () => {
        addClienteContenedor.classList.add("activo");

    });

    cerrarC.addEventListener("click", () => {
        addClienteContenedor.classList.remove("activo");
        contenedorCliente.classList.remove("activo")
    });

    cerrarTxt.addEventListener("click", () => {
        addClienteContenedor.classList.remove("activo");
        contenedorCliente.classList.remove("activo")
    });


    addClienteContenedor.addEventListener("click", (e) => {
        if (e.target.classList.contains("addClienteContenedor")) {
            addClienteContenedor.classList.remove("activo");
        }
    });





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
        if (e.target.classList.contains("addClienteContenedor2")) {
            addClienteContenedor2.classList.remove("activo");
        }
    });
</script>


<?php require_once("./views/inc/admin/reservation.php") ?>