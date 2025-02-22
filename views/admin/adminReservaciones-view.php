<div class="titulo-descripcion"> 
    <p></p>
</div>

<div class="contenedorPadre">
    <div class="opciones">
        <a class="opcion " href="<?php echo SERVERURL ?>adminNuevoPrestamo/"><span class="material-symbols-sharp">add</span>NUEVO
            PRÉSTAO</a>
        <a class="opcion activo cursor" href="<?php echo SERVERURL ?>adminReservaciones/"><span class="material-symbols-sharp">calendar_month</span>RESERVACIONES</a>
        <a class="opcion " href="<?php echo SERVERURL ?>adminPrestamos/"><span class="material-symbols-sharp">paid</span>PRÉSTAMOS</a>
        <a class="opcion" href="<?php echo SERVERURL ?>adminFinalizado/"><span class="material-symbols-sharp"> receipt_long</span>FINALIZADOS</a>
        <a class="opcion" href="<?php echo SERVERURL ?>adminSearchDate/"><span class="material-symbols-sharp"> search_check</span>BUSCAR
            USUARIO</a>

    </div>

    <div class="formularioContenedor">
        <div class="titulo-icon">
        </div>

        <?php
        require_once("./controller/prestamoController.php");
        $insPrestamo = new prestamosControlador();

        echo $insPrestamo->paginadorPrestamosControlador($url[1], 8, $url[0], "Reservacion",  "", "");
        ?>

    </div>

</div>