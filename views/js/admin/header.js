// cuando la pagina cargue por completo ejecuta el codigo que quita el loading
window.onload = function () {
  let cargando = document
    .querySelector(".centrado-cargando")
    .classList.add("overflow");
  body = document.querySelector("body");
  body.classList.remove("overflow");

  html = document.querySelector("html").classList.remove("overflow");
};

// Obtener el icono menu
const iconoMenu = document.querySelector(".icono-menu1");
const menuIzquierdo = document.querySelector(".menu-izquierdo");
const menuDerecho = document.querySelector(".derecho");
// Cerrar icono pa cerrar izquierdo
const close = document.querySelector(".close");
close.addEventListener("click", () => {
  menuIzquierdo.classList.remove("responsive");
  menuDerecho.classList.remove("responsive");
});

// Agregar evento click
iconoMenu.addEventListener("click", () => {
  // Obtener el menu izquierdo y derecho

  menuIzquierdo.classList.toggle("activo");
  menuDerecho.classList.toggle("activo");

  if (menuIzquierdo.classList.contains("activo")) {
    localStorage.setItem("menu-mode", "true");
  } else {
    localStorage.setItem("menu-mode", "false");
  }

  const liMenuNoCursor = document.querySelectorAll(".li-menu");
  // Quitar la clase activo a los submenus
  liMenuNoCursor.forEach((li) => {
    li.classList.remove("activo");
  });
});

// Obtenet el modo actual
if (localStorage.getItem("menu-mode") === "true") {
  menuIzquierdo.classList.add("activo");
  menuDerecho.classList.add("activo");
} else {
  menuIzquierdo.classList.remove("activo");
  menuDerecho.classList.remove("activo");
}

// Desplegar sub menu
const flechas = document.querySelectorAll(".flecha-link");
flechas.forEach((flecha) => {
  flecha.addEventListener("click", (e) => {
    let submenu = e.target.parentElement.parentElement;
    submenu.classList.toggle("activo");
  });
});

// Obtener el icono menu 2
const iconoMenu2 = document.querySelector(".icono-menu2");
// Agregar evento click
iconoMenu2.addEventListener("click", () => {
  const menuIzquierdo = document.querySelector(".menu-izquierdo");
  const menuDerecho = document.querySelector(".derecho");

  menuIzquierdo.classList.add("responsive");
  menuDerecho.classList.add("responsive");
});

function Establecerhora() {
  const reloj = document.querySelector(".hora");

  let date = new Date();
  let hora = date.getHours();
  let minutos = date.getMinutes();
  let segundos = date.getSeconds();
  let ampm = hora >= 12 ? "PM" : "AM";

  hora = hora % 12;
  hora = hora ? hora : 12;

  hora = hora < 10 ? "0" + hora : hora;
  minutos = minutos < 10 ? "0" + minutos : minutos;
  segundos = segundos < 10 ? "0" + segundos : segundos;

  let tiempo = hora + ":" + minutos + ":" + segundos + " " + ampm;
  reloj.innerHTML = tiempo;
}

setInterval(Establecerhora, 1000);

const opciones = document.querySelectorAll(".opciones");
opciones.forEach((opcion) => {
  opcion.addEventListener("click", (e) => {
    opcion = e.target;

    if (opcion.classList.contains("activo")) {
      e.preventDefault();
      opcion.classList.add("cursor");
    }
  });
});

const iconoCampana = document.querySelector(".campana-icono-noti");
const contenedorMensajes = document.querySelector(".contenedor-mensajes");
const logout = document.querySelector(".logout")



iconoCampana.addEventListener("click", () => {
  contenedorMensajes.classList.add("activo")
});

logout.addEventListener("click", () => {
  contenedorMensajes.classList.remove("activo")
});


// Animacion de los input
const inputs = document.querySelectorAll("input");

const animacionInput = (event) => {
  const input = event.target;

  if (input.value !== "") {
    input.classList.add("activo");
  } else {
    input.classList.remove("activo");
  }
};

inputs.forEach((input) => {
  input.addEventListener("focus", animacionInput);
  input.addEventListener("blur", animacionInput);

  
});

document.addEventListener("DOMContentLoaded", () => {
  inputs.forEach((input) => {
    animacionInput({ target: input });
  });
});









// LLamando los valores del chat
const searchBar = document.querySelector(".search input"),
  searchIcon = document.querySelector(".search button"),
  usersList = document.querySelector(".users-list");



searchIcon.onclick = () => {
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if (searchBar.classList.contains("active")) {
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
};

searchBar.onkeyup = () => {
  let searchTerm = searchBar.value;
  if (searchTerm != "") {
    searchBar.classList.add("active");
  } else {
    searchBar.classList.remove("active");
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "http://localhost/prestamos/ajax/mensajeAjax.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        usersList.innerHTML = data;
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
};

setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "http://localhost/prestamos/ajax/mensajeAjax.php?get=get", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        if (!searchBar.classList.contains("active")) {
          usersList.innerHTML = data;
        }
      }
    }
  };
  xhr.send();
}, 3000);




