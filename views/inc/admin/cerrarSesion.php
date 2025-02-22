<script>
    // cerrar sesion
    const btnCerrar = document.querySelector(".btnCerrar");
    const alerta = document.querySelector(".cerrarAlerta");

    const siEnv = document.querySelector(".siEnv");
    const noEnv = document.querySelector(".noEnv");

    btnCerrar.addEventListener("click", () => {
        alerta.classList.add("activo");

        siEnv.addEventListener("click", () => {
            let url = '<?php echo SERVERURL; ?>ajax/loginAjax.php';
            let token = '<?php echo $lc->encryption($_SESSION['token_spm']); ?>';
            let usuario = '<?php echo $lc->encryption($_SESSION['usuario_spm']); ?>';

            let datos = new FormData();
            datos.append("token", token);
            datos.append("usuario", usuario);

            fetch(url, {
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.json())
                .then(respuesta => {
                    return alertasAjax(respuesta);
                })
                .catch(error => console.error('Error:', error));
        });

        noEnv.addEventListener("click", () => {
            alerta.classList.remove("activo");
        });

        alerta.addEventListener("click", (e) => {
            if (e.target.classList.contains("cerrarAlerta")) {
                alerta.classList.remove("activo");
            }
        });
    });

</script>