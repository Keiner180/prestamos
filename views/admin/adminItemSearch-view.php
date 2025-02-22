<div class="titulo-descripcion">
    <h1>BUSCAR ITEM</h1>
    <p></p>
</div>

<div class="contenedorPadre">
    <div class="opciones">
        <a class="opcion " href="<?php echo SERVERURL ?>adminItemCrear/"><span class="material-symbols-sharp">add</span>AGREGAR
            ITEM</a>
        <a class="opcion " href="<?php echo SERVERURL ?>adminItemList/"><span class="material-symbols-sharp"> list_alt</span>LISTA DE
            ITEMS</a>
        <a class="opcion activo cursor" href="<?php echo SERVERURL ?>adminItemSearch/"><span class="material-symbols-sharp"> search</span>BUSCAR ITEM
        </a>

    </div>

    <?php if (!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])) { ?>
        <form action="<?php echo SERVERURL ?>ajax/buscadorAjax.php" class="fondoInput FormularioAjax" method="post" data-form="search">

            <input type="hidden" name="modulo_buscador" value="buscar">
            <input type="hidden" name="modulo_url" value="<?php echo $url[0] ?>">



            <input type="text" name="txt_buscador" id="" placeholder="Buscar Cliente">
            <button type="submit">
                <span class="material-symbols-sharp">search</span>
            </button>

        </form>
    <?php } else { ?>

        <div class="resultadoBus">
            <p>Resultado de la búsqueda <strong>"<?php echo $_SESSION[$url[0]] ?>"</strong></p>
            <form class="FormularioAjax " action="<?php echo SERVERURL ?>ajax/buscadorAjax.php" method="post" autocomplete="off" data-form="search">
                <input type="hidden" name="modulo_buscador" value="eliminar">
                <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                <button><span class="material-symbols-sharp">delete</span>ELIMINAR BÚSQUEDA</button>

            </form>

        </div>
        <div class="formularioContenedor">
            <div class="titulo-icon">
            </div>
            <?php
             require_once("./controller/itemController.php");
             $insItem = new ItemController();
     
             echo $insItem->paginadorItemControlador($url[1], 8, $url[0],$_SESSION[$url[0]]);
             ?>
        </div>

    <?php } ?>





</div>