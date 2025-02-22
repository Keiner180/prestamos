<div class="titulo-descripcion"> <!--Tengo que poner la condicon de registarda y registradas -->
    <h1>BUSCAR CLIENTE</h1>
    <p></p>
</div>

<div class="contenedorPadre">
    <div class="opciones">
        <a class="opcion " href="<?php echo SERVERURL ?>adminClienteCrear/"><span class="material-symbols-sharp">add</span>AGREGAR CLIENTE</a>
        <a class="opcion" href="<?php echo SERVERURL ?>adminClienteList/"><span class="material-symbols-sharp"> list_alt</span>LISTA
            DE CLIENTES</a>
        <a class="opcion activo cursor" href="<?php echo SERVERURL ?>adminClienteSearch/"><span class="material-symbols-sharp"> search</span>BUSCAR
            CLIENTE</a>

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
            require_once("./controller/clienteController.php");
            $insCliente = new ClienteController();

            echo $insCliente->paginadorClienteControlador($url[1], 8, $url[0], $_SESSION[$url[0]]);
            ?>
        </div>

    <?php } ?>


</div>