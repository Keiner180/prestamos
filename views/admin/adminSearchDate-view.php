            <div class="titulo-descripcion"> <!--Tengo que poner la condicon de registarda y registradas -->
                <h1>RESERVACIONES</h1>
                <p></p>
            </div>

            <div class="contenedorPadre">
                <div class="opciones">
                    <a class="opcion " href="<?php echo SERVERURL ?>adminNuevoPrestamo/"><span class="material-symbols-sharp">add</span>NUEVO
                        PRÉSTAO</a>
                    <a class="opcion " href="<?php echo SERVERURL ?>adminReservaciones/"><span class="material-symbols-sharp">calendar_month</span>RESERVACIONES</a>
                    <a class="opcion" href="<?php echo SERVERURL ?>adminPrestamos/"><span class="material-symbols-sharp">paid</span>PRÉSTAMOS</a>
                    <a class="opcion" href="<?php echo SERVERURL ?>adminFinalizado/"><span class="material-symbols-sharp"> receipt_long</span>FINALIZADOS</a>
                    <a class="opcion activo cursor" href="<?php echo SERVERURL ?>adminSearchDate/"><span class="material-symbols-sharp"> search_check</span>BUSCAR USUARIO</a>

                </div>

                <div class="formularioContenedor">
                    <div class="titulo-icon">
                    </div>
                    <?php if (!isset($_SESSION["fecha_inicio_prestamo"]) && empty($_SESSION["fecha_inicio_prestamo"]) && !isset($_SESSION["fecha_final_prestamo"]) && empty($_SESSION["fecha_final_prestamo"])) { ?>

                        <form action="<?php echo SERVERURL ?>ajax/buscadorAjax.php" class=" FormularioAjax" method="post" autocomplete="off" data-form="search">


                            <input type="hidden" name="modulo_buscador" value="prestamo">
                            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                            <input type="hidden" name="prestamo" value="">
                            <div class="grupo-input grupo-input3 ">
                                <!-- Fecha incial-->
                                <div class="input-label">
                                    <input type="date" name="fecha_inicio_prestamo">
                                    <label for="dni" class="labelSelect">Fecha inicial (día/mes/año)</label>
                                    <span></span>
                                </div>
                                <!-- Fecha final-->
                                <div class="input-label">
                                    <input type="date" name="fecha_final_prestamo">
                                    <label for="dni" class="labelSelect">Fecha final (día/mes/año)</label>
                                    <span></span>

                                </div>

                            </div>


                            <div class="botonBuscar">
                                <button type="submit" class="botonBuscar"> <span class="material-symbols-sharp">search</span> Buscar</button>

                            </div>

                        </form>


                    <?php } else { ?>

                        <div class="resultadoBus dos tres">
                            <p>Fecha de busqueda: <strong><?php echo $_SESSION["fecha_inicio_prestamo"] ?> a <?php echo $_SESSION["fecha_final_prestamo"] ?></strong></p>
                            <form action="<?php echo SERVERURL ?>ajax/buscadorAjax.php" class=" FormularioAjax" method="post" autocomplete="off" data-form="search">
                            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                            <input type="hidden" name="modulo_buscador" value="eliminarPrestamo">


                                <button><span class="material-symbols-sharp">delete</span>ELIMINAR BÚSQUEDA</button>
                            </form>

                        </div>

                        <?php
                        require_once("./controller/prestamoController.php");
                        $insPrestamo = new prestamosControlador();
                        $fechaInicio = DateTime::createFromFormat('d-m-Y',  $_SESSION["fecha_inicio_prestamo"] )->format('Y-m-d');
                        $fechaFinal = DateTime::createFromFormat('d-m-Y', $_SESSION["fecha_final_prestamo"])->format('Y-m-d');

                        echo $insPrestamo->paginadorPrestamosControlador($url[1], 8, $url[0], "Busqueda",   $fechaInicio, $fechaFinal);
                        ?>

                    <?php } ?>


                </div>

            </div>