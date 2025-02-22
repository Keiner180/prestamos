// Dectetar si hay conexion o no

function comprobarConexion() {
  if (navigator.onLine) {
    document.querySelector(".conetendor-siin-wifi").classList.remove("activo");
  } else {
    document.querySelector(".conetendor-siin-wifi").classList.add("activo");
  }
}

window.addEventListener("load", comprobarConexion);

// Escuchar cambios en la conexión
window.addEventListener("online", comprobarConexion);
window.addEventListener("offline", comprobarConexion);

comprobarConexion();
