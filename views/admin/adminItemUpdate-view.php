<?php if ($_SESSION["privilegio_spm"] == 1 || $_SESSION["privilegio_spm"] == 2) { ?>

<div class="titulo-descripcion">
    <h1>ACTUALIZAR ITEM</h1>
    <p></p>
</div>

<div class="contenedorPadre">
    <?php
    require_once("./controller/itemController.php");

    $insItem = new ItemController();

    $datosItem = $insItem->datosItemControlador("Unico", $url[1]);
    $itemEncontrado = $datosItem->rowCount();

    if ($itemEncontrado == 1) {
        $campos = $datosItem->fetch();
    ?>

        <div class="opciones">
            <a class="opcion" href="<?php echo SERVERURL ?>adminItemCrear"><span class="material-symbols-sharp">add</span>AGREGAR
                ITEM</a>
            <a class="opcion " href="<?php echo SERVERURL ?>adminItemList/"><span class="material-symbols-sharp"> list_alt</span>LISTA DE
                ITEMS</a>
            <a class="opcion" href="<?php echo SERVERURL ?>adminItemSearch/"><span class="material-symbols-sharp"> search</span>BUSCAR ITEM
            </a>

        </div>

        <div class="formularioContenedor">
            <div class="titulo-icon">
                <span class="material-symbols-sharp">update</span>

                <p> Información del item</p>
            </div>
            <form action="<?php echo SERVERURL ?>ajax/itemAjax.php" method="post" class="FormularioAjax" data-form="update" autocomplete="off">
                <input type="hidden" name="item" value="actualizar">
            <input type="hidden" name="item_id" value="<?php echo $url[1] ?>">



                <div class="grupo-input grupo-input3">
                    <!-- CODIGO -->
                    <div class="input-label">
                        <input type="text" name="item_codigo" value="<?php echo $campos["item_codigo"] ?>">
                        <label for="dni">CÓDIGO</label>
                        <span></span>
                    </div>
                    <!-- NOMBRE -->
                    <div class="input-label">
                        <input type="text" name="item_nombre" value="<?php echo $campos["item_nombre"] ?>">
                        <label for="dni">NOMBRE</label>
                        <span></span>

                    </div>
                    <!-- STOCK -->
                    <div class="input-label">
                        <input type="text" name="item_stock" value=" <?php echo $campos["item_stock"] ?> ">
                        <label for="dni">Stock</label>
                        <span></span>

                    </div>
                </div>

                <div class="grupo-input">
                    <!-- Estado -->
                    <div class="input-label">
                        <select class="" name="estado">
                            <option value="" hidden selected>Selecciona una opción</option>
                            <option <?php echo ($campos["item_estado"] == "Habilitado") ? "selected" : "" ?> value="Habilitado">Habilitado</option>
                            <option <?php echo ($campos["item_estado"] == "Deshabilitado") ? "selected" : "" ?> value="Deshabilitado">Deshabilitado</option>
                        </select>
                        <label class="labelSelect">ESTADO</label>
                        <span></span>
                    </div>
                    <!--Detalle -->
                    <div class="input-label">
                        <input type="text" name="item_detalle"  value=" <?php echo $campos["item_detalle"] ?> ">
                        <label for="dni">DETALLE</label>
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
    <?php } else {
        require_once("./views/inc/admin/errorDatos.php");
    } ?>

</div>

<?php
} 
require_once("./views/inc/admin/sinPermiso.php");
?>