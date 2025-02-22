<div class="titulo-descripcion"> <!--Tengo que poner la condicon de registarda y registradas -->
    <h1> LISTA DE USUARIOS</h1>
    <p></p>
</div>

<div class="contenedorPadre">
    <div class="opciones">
        <a class="opcion " href="<?php echo SERVERURL ?>adminUserCrear/"><span class="material-symbols-sharp">add</span>AGREGAR
            USUARIO</a>
        <a class="opcion activo cursor" href="<?php echo SERVERURL ?>adminUserList/"><span class="material-symbols-sharp"> list_alt</span>LISTA DE
            USUARIOS</a>
        <a class="opcion" href="<?php echo SERVERURL ?>adminUserSearch/"><span class="material-symbols-sharp"> search</span>BUSCAR USUARIO</a>

    </div>

    <div class="formularioContenedor">
        <div class="titulo-icon">
        </div>
        <?php
        require_once("./controller/userController.php");
        $insUsuario = new userController();

        echo $insUsuario->paginadorUsuarioControlador($url[1], 8, $_SESSION["privilegio_spm"], $url[0], $_SESSION["id_spm"], "");
        ?>
  





    </div>

</div>