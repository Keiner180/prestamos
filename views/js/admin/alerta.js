const contenedorToast = document.getElementById("contenedor-toast");

// Función para agregar la clase de cerrando al toast.
const agregarToast = ({ tipo, titulo, descripcion, autoCierre }) => {
  let = nuevoToasta = document.querySelectorAll(".toast");

  // Eliminadno los toast anteriores
  nuevoToasta.forEach((toast) => {
    toast.remove();
  });
  const nuevoToast = document.createElement("div");

  // Agregar clases correspondientes
  nuevoToast.classList.add("toast");
  nuevoToast.classList.add(tipo);
  if (autoCierre) nuevoToast.classList.add("autoCierre");

  // Agregar id del toast
  const numeroAlAzar = Math.floor(Math.random() * 100);
  const fecha = Date.now();
  const toastId = fecha + numeroAlAzar;
  nuevoToast.id = toastId;

  // Iconos
  const iconos = {
    exito: `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"
                    />
                </svg>`,
    error: `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
                                />
                            </svg>`,
    info: `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"
                                />
                            </svg>`,
    warning: `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
                                />
                            </svg>`,

    recargar: `<svg xmlns="http://www.w3.org/2000/svg" focusable="false" viewBox="0 0 12 12">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" d="M10 4c-.8-1.1-2-2.5-4.1-2.5-2.5 0-4.4 2-4.4 4.5s2 4.5 4.4 4.5c1.3 0 2.5-.6 3.3-1.5m1.3-7.5V4c0 .3-.2.5-.5.5H7.5"/>
                     </svg>`,
    limpiar: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" role="img">  
                <path d="M928 895H554.51l386.745-384a64 64 0 000-90.51l-240-240a64 64 0 00-90.51 0l-528 525.255a64 64 0 000 90.51l144 144A64 64 0 00272 959h656a32 32 0 000-64zM128 751l264-264 240 240-168 168H272z" fill="currentColor"/>  
                </svg>`,
  };

  // Plantilla del toast
  const toast = `
        <div class="contenido">
            <div class="icono">
                ${iconos[tipo]}
            </div>
            <div class="texto">
                <p class="titulo">${titulo}</p>
                <p class="descripcion">${descripcion}</p>
            </div>
        </div>
        <button class="btn-cerrar">
            <div class="icono">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                    />
                </svg>
            </div>
        </button>
    `;

  // Agregar la plantilla al nuevo toast
  nuevoToast.innerHTML = toast;

  // Agregamos el nuevo toast al contenedor
  contenedorToast.appendChild(nuevoToast);

  // Función para menajer el cierre del toast
  const handleAnimacionCierre = (e) => {
    if (e.animationName === "cierre") {
      nuevoToast.removeEventListener("animationend", handleAnimacionCierre);
      nuevoToast.remove();
    }
  };

  if (autoCierre) {
    setTimeout(() => cerrarToast(toastId), 5000);
  }

  // Agregamos event listener para detectar cuando termine la animación
  nuevoToast.addEventListener("animationend", handleAnimacionCierre);
};
// Event listener para detectar click en los toasts
contenedorToast.addEventListener("click", (e) => {
  const toastId = e.target.closest("div.toast").id;

  if (e.target.closest("button.btn-cerrar")) {
    cerrarToast(toastId);
  }
});

// Función para cerrar el toast
const cerrarToast = (id) => {
  document.getElementById(id)?.classList.add("cerrando");
};

// Función de carga de la animacion
function animacionCarga() {
  let cargando = document
    .querySelector(".centrado-cargando-loader")
    .classList.add("overflow");
  body = document.querySelector("body");
  body.classList.add("overflow");

  html = document.querySelector("html").classList.add("overflow");
}
// Quita la animación de carga
function animacionFina() {
  let cargando = document
    .querySelector(".centrado-cargando-loader")
    .classList.remove("overflow");
  body = document.querySelector("body");
  body.classList.remove("overflow");

  html = document.querySelector("html").classList.remove("overflow");
}

//Recibiendo los Formularios y contenedor de alerta preguntar
const formularioAajax = document.querySelectorAll(".FormularioAjax");
let alertaAceptar = document.querySelector(".alertaAceptar");

// Function enviar los datos via AJAX
function enviarDatosAjax(e) {
  e.preventDefault();

  alertaAceptar.classList.add("activo");

  let data = new FormData(this);

  let method = this.getAttribute("method");
  let action = this.getAttribute("action");
  let tipoData = this.getAttribute("data-form");

  let encabezados = new Headers();
  let config = {
    method: method,
    headers: encabezados,
    body: data,
    mode: "cors",
    cache: "no-cache",
  };

  let textoAlerta = "";
  if (tipoData === "save") {
    textoAlerta =
      "Los datos serán guardados en el sistema de manera permanente.";
  } else if (tipoData === "delete") {
    textoAlerta = "Los datos serán eliminados permanentemente del sistema.";
  } else if (tipoData === "update") {
    textoAlerta = "Los datos serán actualizados en el sistema.";
  } else if (tipoData === "search") {
    textoAlerta =
      "El término de búsqueda será eliminado. Deberás ingresar uno nuevo.";
  } else if (tipoData === "loans") {
    textoAlerta =
      "¿Confirma que desea remover los datos seleccionados para préstamos o reservaciones?";
  } else {
    textoAlerta =
      "¿Está seguro de que desea proceder? Esta acción no se puede deshacer.";
  }

  const plantillaAlerta = `
     <div class="alertaAceptarContenedor">
         <div class="iconoAlerta">
             <span class="material-symbols-sharp">question_mark</span>
        </div>
        <div class="alertaTexto">
        <h5>¿Estás seguro?</h5>
        <p>${textoAlerta}</p>
     </div>
     <div class="alertaAceptarBotones">
            <button class="siEnv" >Sí,aceptar</button>
            <button class="noEnv" >Cancelar</button>
        </div>
    </div>
    `;
  alertaAceptar.innerHTML = plantillaAlerta;

  const siEnv = document.querySelector(".siEnv");
  const noEnv = document.querySelector(".noEnv");

  // Usa un flag para evitar múltiples registros
  let siEnvListenerAdded = false;

  // Asegurarse de que el listener solo se agregue una vez
  const handleSiEnvClick = (e) => {
    alertaAceptar.classList.remove("activo");
    animacionCarga();

    fetch(action, config)
      .then((respuesta) => respuesta.json())
      .then((respuesta) => {
        return alertasAjax(respuesta);
      })

      .finally(() => {
        animacionFina();
      });

    // Evita agregar el listener más de una vez
    if (siEnvListenerAdded) {
      siEnv.removeEventListener("click", handleSiEnvClick);
    }
  };

  if (!siEnvListenerAdded) {
    siEnv.addEventListener("click", handleSiEnvClick);
    siEnvListenerAdded = true;
  }

  noEnv.addEventListener("click", () => {
    alertaAceptar.classList.remove("activo");
  });
}

formularioAajax.forEach((formularios) => {
  formularios.addEventListener("submit", enviarDatosAjax);
});

// Alertas a mostrar dependiendo de la respuesta
function alertasAjax(alerta) {
  if (alerta.tipo == "exito") {
    agregarToast({
      tipo: alerta.tipo,
      titulo: alerta.titulo,
      descripcion: alerta.descripcion,
      autoCierre: true,
    });
  } else if (alerta.tipo == "error") {
    agregarToast({
      tipo: alerta.tipo,
      titulo: alerta.titulo,
      descripcion: alerta.descripcion,
      autoCierre: true,
    });
  } else if (alerta.tipo == "error1") {
    agregarToast({
      tipo: 'error',
      titulo: alerta.titulo,
      descripcion: alerta.descripcion,
      autoCierre: false,
    });
  } else if (alerta.tipo == "warning") {
    agregarToast({
      tipo: alerta.tipo,
      titulo: alerta.titulo,
      descripcion: alerta.descripcion,
      autoCierre: true,
    });
  } else if (alerta.tipo === "recargar") {
    agregarToast({
      tipo: alerta.tipo,
      titulo: alerta.titulo,
      descripcion: alerta.descripcion,
      autoCierre: true,
    });

    setTimeout(() => {
      location.reload();
    }, 5000);
  } else if (alerta.tipo === "limpiar") {
    agregarToast({
      tipo: "exito",
      titulo: alerta.titulo,
      descripcion: alerta.descripcion,
      autoCierre: true,
    });

    setTimeout(() => {
      document.querySelector(".FormularioAjax").reset();

      let inputs = document.querySelectorAll("input");
      inputs.forEach((input) => {
        input.classList.remove("activo");
      });
    }, 5000);
  } else if (alerta.tipo === "redireccionar") {
    window.location.href = alerta.url;
  }
}

// let obj = {

//     "tipo": "exito",
//     "titulo": "Error al eliminar",
//     "descripcion": "El mensaje de cont\u00e1ctenosc no existe en el sistema"
//        }

// agregarToast(obj.tipo, "a", "fffffffffffffffffffffffff")
