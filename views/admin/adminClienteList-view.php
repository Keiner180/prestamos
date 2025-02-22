<div class="titulo-descripcion">
    <h1> LISTA DE CLIENTES</h1>
    <p></p>
</div>

<div class="contenedorPadre">
    <div class="opciones">
        <a class="opcion " href="<?php echo SERVERURL ?>adminClienteCrear/"><span class="material-symbols-sharp">add</span>AGREGAR CLIENTE</a>
        <a class="opcion activo cursor" href="<?php echo SERVERURL ?>adminClienteList/"><span class="material-symbols-sharp"> list_alt</span>LISTA
            DE CLIENTES</a>
        <a class="opcion" href="<?php echo SERVERURL ?>adminClienteSearch/"><span class="material-symbols-sharp"> search</span>BUSCAR CLIENTE
            CLIENTE</a>

    </div>

    <div class="formularioContenedor">
        <div class="titulo-icon">
        </div>

        <?php
        require_once("./controller/clienteController.php");
        $insCliente = new ClienteController();

        echo $insCliente->paginadorClienteControlador($url[1], 8, $url[0], "");
        ?>

    </div>

</div>

</div>