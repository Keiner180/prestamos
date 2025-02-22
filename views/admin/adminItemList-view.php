            <div class="titulo-descripcion"> <!--Tengo que poner la condicon de registarda y registradas -->
                <h1> LISTA DE ITEMS</h1>
                <p></p>
            </div>

            <div class="contenedorPadre">
                <div class="opciones">
                    <a class="opcion" href="<?php echo SERVERURL?>adminItemCrear/"><span class="material-symbols-sharp">add</span>AGREGAR
                        ITEM</a>
                    <a class="opcion activo cursor" href="<?php echo SERVERURL?>adminItemList/"><span class="material-symbols-sharp"> list_alt</span>LISTA DE
                        ITEMS</a>
                    <a class="opcion" href="<?php echo SERVERURL?>adminItemSearch/"><span class="material-symbols-sharp"> search</span>BUSCAR ITEM
                    </a>

                </div>

                <div class="formularioContenedor">
                    <div class="titulo-icon">
                    </div>

                    <?php 
                    
                    require_once("./controller/itemController.php");
                    $insItem = new ItemController();
            
                    echo $insItem->paginadorItemControlador($url[1], 8, $url[0], "");
                    ?>




                </div>

            </div>