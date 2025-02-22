<script>
    //?-----------Función buscar cliente---------------//
    function buscarCliente() {

        let input_cliente = document.getElementById("inputCliente").value;
        input_cliente = input_cliente.trim();

        if (input_cliente != "") {

            //*Verificando la integridad del texto ingresado//
            const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}$/;
            if (!regex.test(input_cliente)) {
                agregarToast({
                    tipo: "warning",
                    titulo: "Ocurrió un error",
                    descripcion: "Debes ingresar el DNI, Nombre, Apellido, Teléfono de forma correcta",
                    autoCierre: true
                });
                return

            }


            let datos = new FormData();
            datos.append("buscar_cliente", input_cliente);
            fetch("<?php echo SERVERURL ?>ajax/prestamoAjax.php", {
                    method: 'POST',
                    body: datos
                })
                .then((respuesta) => respuesta.text())
                .then((respuesta) => {

                    let tabla_clientes = document.getElementById("tabla_clientes");
                    tabla_clientes.innerHTML = respuesta

                })

        } else {
            agregarToast({
                tipo: "warning",
                titulo: "Ocurrio un errorr",
                descripcion: "Debes ingresar el DNI, Nombre, Apellido, Teléfono.",
                autoCierre: true
            });
        }
    }


    //?-----------Función buscar agregat un cliente---------------//
    function agregarCliente(id) {

        addClienteContenedor.classList.remove("activo");
        let alertaAceptar = document.querySelector(".alertaAceptar");
        alertaAceptar.classList.add("activo");

        const plantillaAlerta = `
     <div class="alertaAceptarContenedor">
         <div class="iconoAlerta">
             <span class="material-symbols-sharp">question_mark</span>
        </div>
        <div class="alertaTexto">
        <h5>¿Estás seguro?</h5>
        <p>Se va agregar este cliente para hacer una reserva</p>
     </div>
     <div class="alertaAceptarBotones">
            <button class="siEnv" >Sí,Agregar</button>
            <button class="noEnv" >No, Cancelar</button>
        </div>
    </div>
    `;
        alertaAceptar.innerHTML = plantillaAlerta;

        const siEnv = document.querySelector(".siEnv");
        const noEnv = document.querySelector(".noEnv");

        noEnv.addEventListener("click", () => {
            alertaAceptar.classList.remove("activo");
            addClienteContenedor.classList.add("activo");

        });

        siEnv.addEventListener("click", () => {
            alertaAceptar.classList.remove("activo");
            let datos = new FormData();
            datos.append("id_agregar_cliente", id);
            fetch("<?php echo SERVERURL ?>ajax/prestamoAjax.php", {
                    method: 'POST',
                    body: datos
                })
                .then((respuesta) => respuesta.json())
                .then((respuesta) => {

                    return alertasAjax(respuesta);

                })
        });
    }


    //?-----------Función buscar item---------------//
    function buscarItem() {


        let input_item = document.getElementById("inputItem").value;
        input_item = input_item.trim();

        if (input_item != "") {

            //*Verificando la integridad del texto ingresado//
            const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}$/;
            if (!regex.test(input_item)) {
                agregarToast({
                    tipo: "warning",
                    titulo: "Ocurrió un error",
                    descripcion: "Debes ingresar Código, Nombre de forma correcta",
                    autoCierre: true
                });
                return

            }


            let datos = new FormData();
            datos.append("buscar_item", input_item);
            fetch("<?php echo SERVERURL ?>ajax/prestamoAjax.php", {
                    method: 'POST',
                    body: datos
                })
                .then((respuesta) => respuesta.text())
                .then((respuesta) => {

                    let tabla_item = document.getElementById("tabla_item");
                    tabla_item.innerHTML = respuesta

                })

        } else {
            agregarToast({
                tipo: "warning",
                titulo: "Ocurrio un errorr",
                descripcion: "Debes ingresar el Código,Nombre",
                autoCierre: true
            });
        }
    }


    //?-----------Función para agregar item---------------//
    function agregarItem(id) {

        addClienteContenedor2.classList.remove("activo");
        addClienteContenedor3.classList.add("activo");


        document.querySelector("#id_agregar_item").setAttribute("value", id);

        cerrarTxt3.addEventListener("click", () => {
            alertaAceptar.classList.remove("activo");
            addClienteContenedor3.classList.remove("activo");
            addClienteContenedor2.classList.add("activo");

        });

        cerrarC2.addEventListener("click", () => {
            addClienteContenedor3.classList.remove("activo");
            contenedorCliente.classList.remove("activo")
        });

    }


    //?-----------Función para buscar item---------------//
</script>