            <div class="titulo-descripcion"> 
                <h1>Dashboard</h1>
                <p></p>
            </div>
            <div class="cajas-datos">
                <?php
                require_once("./controller/clienteController.php");
                $insCliente = new ClienteController();
                $totalCliente = $insCliente->datosClienteControlador("Conteo", 0);
                $totalCliente = $totalCliente->rowCount();
                ?>

                <a class="caja" href="<?php echo SERVERURL ?>adminClienteList/">
                    <p>CLIENTE</p>
                    <span class="material-symbols-sharp icono-dah">person</span>

                    <div>
                        <?php
                        $registro = ($totalCliente == 1) ? "Registrado" : "Registrados";
                        if ($totalCliente == 0) {
                            $registro = "No hay clientes ";
                            echo $registro .  '</div>';
                        } else {
                            echo $totalCliente . " " . $registro . '</div>';
                        }
                        ?>

                </a>

                <?php
                require_once("./controller/itemController.php");
                $insItem = new ItemController();
                $totalItem = $insItem->datosItemControlador("Conteo", 0);
                $totalItem = $totalItem->rowCount();
                ?>
                <a class="caja" href="<?php echo SERVERURL ?>adminItemList/">
                    <p>ITEM</p>
                    <span class="material-symbols-sharp icono-dah">archive</span>


                    <div>
                        <?php
                        $registro = ($totalItem == 1) ? "Registrado" : "Registrados";
                        if ($totalItem == 0) {
                            $registro = "No hay items ";
                            echo $registro .  '</div>';
                        } else {
                            echo $totalItem . " " . $registro . '</div>';
                        }
                        ?>
                </a>

                <?php
                require_once("./controller/prestamoController.php");
                $insReservacion = new prestamosControlador();
                $totalReservacion = $insReservacion->datosPrestamoControlador("ConteoCamposDiferentes", $insReservacion->encryption("Reservacion"));
                $totalReservacion = $totalReservacion->rowCount();
                ?>

                <a class="caja" href="<?php echo SERVERURL ?>adminReservaciones/">
                    <p>Reservaciones</p>
                    <span class="material-symbols-sharp icono-dah">calendar_month</span>



                    <div>
                        <?php
                        $registro = ($totalReservacion == 1) ? "Registrado" : "Registrados";
                        if ($totalReservacion == 0) {
                            $registro = "No hay reservaciones ";
                            echo $registro .  '</div>';
                        } else {
                            echo $totalReservacion . " " . $registro . '</div>';
                        }
                        ?>

                </a>


                <?php
                require_once("./controller/prestamoController.php");
                $insPrestamo = new prestamosControlador();
                $totalPrestamo = $insPrestamo->datosPrestamoControlador("ConteoCamposDiferentes", $insPrestamo->encryption("Prestamo"));
                $totalPrestamo = $totalPrestamo->rowCount();
                ?>

                <a class="caja" href="<?php echo SERVERURL ?>adminPrestamos/">
                    <p>Préstamos</p>
                    <span class="material-symbols-sharp icono-dah">book_online</span>


                    <div>
                        <?php
                        $registro = ($totalPrestamo == 1) ? "Registrado" : "Registrados";
                        if ($totalPrestamo == 0) {
                            $registro = "No hay préstamos ";
                            echo $registro .  '</div>';
                        } else {
                            echo $totalPrestamo . " " . $registro . '</div>';
                        }
                        ?>

                </a>


                <?php
                require_once("./controller/prestamoController.php");
                $insFinalizado = new prestamosControlador();
                $totalFinalizado = $insFinalizado->datosPrestamoControlador("ConteoCamposDiferentes", $insFinalizado->encryption("Finalizado"));
                $totalFinalizado = $totalFinalizado->rowCount();
                ?>

                <a class="caja" href="<?php echo SERVERURL ?>adminFinalizado/">
                    <p>Finalizados</p>
                    <span class="material-symbols-sharp icono-dah">fact_check</span>



                    <div>
                        <?php
                        $registro = ($totalFinalizado == 1) ? "Registrado" : "Registrados";
                        if ($totalFinalizado == 0) {
                            $registro = "No existen finalizados ";
                            echo $registro .  '</div>';
                        } else {
                            echo $totalFinalizado . " " . $registro . '</div>';
                        }
                        ?>

                </a>


                <?php
                require_once("./controller/userController.php");
                $insUsuario = new userController();
                $totalUsuarios = $insUsuario->datosUsuarioControlador("ConteoSinIncluir", $insUsuario->encryption(1));
                $totalUsuarios = $totalUsuarios->rowCount();
                ?>

                <a class="caja" href="<?php echo SERVERURL ?>adminUserList/">
                    <p>USUARIOS</p>
                    <span class="material-symbols-sharp icono-dah">group</span>
                    <div>
                        <?php
                        $registro = ($totalUsuarios == 1) ? "Registrado" : "Registrados";
                        if ($totalUsuarios == 0) {
                            $registro = "No hay usuarios ";
                            echo $registro .  '</div>';
                        } else {
                            echo $totalUsuarios . " " . $registro . '</div>';
                        }
                        ?>

                </a>

                <a class="caja" href="<?php echo SERVERURL ?>adminEmpresa/">
                    <p>EMPRESA</p>
                    <span class="material-symbols-sharp icono-dah">apartment</span>
                    <div>1 Registrada</div>
                </a>
            </div>
            </div>