<div class="titulo-descripcion">
    <h1>AGREGAR CLIENTE</h1>
    <p></p>
</div>

<div class="contenedorPadre">
    <div class="opciones">
        <a class="opcion activo cursor" href="<?php echo SERVERURL ?>adminClienteCrear/"><span class="material-symbols-sharp">add</span>AGREGAR
            CLIENTE</a>
        <a class="opcion " href="<?php echo SERVERURL ?>adminClienteList/"><span class="material-symbols-sharp"> list_alt</span>LISTA DE
            CLIENTES</a>
        <a class="opcion" href="<?php echo SERVERURL ?>adminClienteSearch/"><span class="material-symbols-sharp"> search</span>BUSCAR CLIENTE
            CLIENTE</a>

    </div>

    <div class="formularioContenedor">
        <div class="titulo-icon">
            <span class="material-symbols-sharp">person</span>
            <p> Información básica</p>
        </div>
        <form action="<?php echo SERVERURL ?>ajax/clienteAjax.php" method="post" class="FormularioAjax" data-form="save" autocomplete="off" >
            <input type="hidden" name="cliente" value="register">
            <div class="grupo-input">
                <!-- DNI -->
                <div class="input-label">
                    <input type="text" name="cliente_dni">
                    <label for="dni">DNI</label>
                    <span></span>
                </div>
                <!-- Nombre -->
                <div class="input-label" >
                    <input type="text" name="cliente_nombres">
                    <label for="dni">Nombre</label>
                    <span></span>

                </div>
            </div>





            <div class="grupo-input grupo-input3">
                <!-- Apellido -->
                <div class="input-label" >
                    <input type="text" name="cliente_apellidos" >
                    <label for="dni">Apellido</label>
                    <span></span>
                </div>
                <!-- Teléfono -->
                <div class="input-label">
                    <input type="text"  name="cliente_telefono" >
                    <label for="dni">Teléfono</label>
                    <span></span>

                </div>
                <!-- Dirección -->
                <div class="input-label" >
                    <input type="text" name="cliente_direccion" >
                    <label for="dni">Dirección</label>
                    <span></span>

                </div>


            </div>

            <div class="grupo-input grupo-input-botones">
                <!-- Guardar -->
                <div class="input-btn">
                    <button class="limpiar" type="reset"><span class="material-symbols-sharp">map</span>Limpiar</button>
                    <button class="guardar" type="submit"><span
                            class="material-symbols-sharp">save</span>Guardar</button>
                </div>
            </div>

        </form>
    </div>

</div>

<?php

// }else{
//     echo "no tienes permiso";
// }
?>