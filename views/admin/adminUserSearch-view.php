<div class="titulo-descripcion"> <!--Tengo que poner la condicon de registarda y registradas -->
    <h1>BUSCAR USUARIO</h1>
    <p></p>
</div>

<div class="contenedorPadre">
    <div class="opciones">
        <a class="opcion " href="<?php echo SERVERURL ?>adminUserCrear/"><span class="material-symbols-sharp">add</span>AGREGAR
            USUARIO</a>
        <a class="opcion " href="<?php echo SERVERURL ?>adminUserList/"><span class="material-symbols-sharp"> list_alt</span>LISTA DE
            USUARIOS</a>
        <a class="opcion activo cursor" href="<?php echo SERVERURL ?>adminUserSearch/"><span class="material-symbols-sharp"> search</span>BUSCAR USUARIO</a>

    </div>

    <?php if (!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])) { ?>
        <form action="<?php echo SERVERURL ?>ajax/buscadorAjax.php" class="fondoInput FormularioAjax" method="post" autocomplete="off" data-form="search">
            <input type="text" name="txt_buscador" id="" placeholder="Buscar usuario">
            <button type="submit">
                <span class="material-symbols-sharp">search</span>
            </button>
            <input type="hidden" name="modulo_buscador" value="prestamos">
            <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
        </form>
    <?php } else { ?>

        <div class="resultadoBus">
            <p>Resultado de la búsqueda <strong>"<?php echo $_SESSION[$url[0]] ?>"</strong></p>
            <form class="FormularioAjax " action="<?php echo SERVERURL ?>ajax/buscadorAjax.php" method="post" autocomplete="off" data-form="search" >
                <input type="hidden" name="modulo_buscador" value="eliminar">
                <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                <button><span class="material-symbols-sharp">delete</span>ELIMINAR BÚSQUEDA</button>

            </form>

        </div>
        <div class="formularioContenedor">
            <div class="titulo-icon">
            </div>
            <?php
            require_once("./controller/userController.php");
            $insUsuario = new userController();

            echo $insUsuario->paginadorUsuarioControlador($url[1], 8, $_SESSION["privilegio_spm"], $url[0], $_SESSION["id_spm"], $_SESSION[$url[0]]);
            ?>

        <?php } ?>


        </div>

</div>