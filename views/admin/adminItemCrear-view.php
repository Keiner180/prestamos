            <div class="titulo-descripcion"> <!--Tengo que poner la condicon de registarda y registradas -->
                <h1>AGREGAR CLIENTE</h1>
                <p></p>
            </div>

            <div class="contenedorPadre">
                <div class="opciones">
                    <a class="opcion activo cursor" href="<?php echo SERVERURL ?>adminItemCrear"><span class="material-symbols-sharp">add</span>AGREGAR
                        ITEM</a>
                    <a class="opcion " href="<?php echo SERVERURL ?>adminItemList/"><span class="material-symbols-sharp"> list_alt</span>LISTA DE
                        ITEMS</a>
                    <a class="opcion" href="<?php echo SERVERURL ?>adminItemSearch/"><span class="material-symbols-sharp"> search</span>BUSCAR ITEM
                    </a>

                </div>

                <div class="formularioContenedor">
                    <div class="titulo-icon">
                    <span class="material-symbols-sharp">inventory</span>

                        <p> Información del item</p>
                    </div>
                    <form action="<?php echo SERVERURL ?>ajax/itemAjax.php" method="post" class="FormularioAjax" data-form="save" autocomplete="off">

                    <input type="hidden" name="item" value="registrar"  >


                        <div class="grupo-input grupo-input3">
                            <!-- CODIGO -->
                            <div class="input-label">
                                <input type="text" name="item_codigo">
                                <label for="dni">CÓDIGO</label>
                                <span></span>
                            </div>
                            <!-- NOMBRE -->
                            <div class="input-label">
                                <input type="text" name="item_nombre">
                                <label for="dni">NOMBRE</label>
                                <span></span>

                            </div>
                            <!-- STOCK -->
                            <div class="input-label">
                                <input type="text" name="item_stock">
                                <label for="dni">Stock</label>
                                <span></span>

                            </div>
                        </div>

                        <div class="grupo-input">
                            <!-- Estado -->
                            <div class="input-label">
                                <select class="" name="estado">
                                    <option value="" hidden selected>Selecciona una opción</option>
                                    <option value="Habilitado">Habilitado</option>
                                    <option value="Deshabilitado">Deshabilitado</option>
                                </select>
                                <label class="labelSelect">ESTADO</label>
                                <span></span>
                            </div>
                            <!--Detalle -->
                            <div class="input-label">
                                <input type="text" name="item_detalle" >
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

            </div>