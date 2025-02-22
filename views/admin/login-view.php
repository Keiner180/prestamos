<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <link rel="stylesheet" href="<?php echo SERVERURL ?>views/css/admin/login.css" />
    <title>Login</title>
</head>

<body>
<div class="conetendor-siin-wifi">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" id="no-internet-connection">
            <g>
                <path fill="#ccd3eb" d="M8 24.88a2.78 2.78 0 0 1-2-.83l-.2-.25a2.85 2.85 0 0 1-.8-2.12 2.69 2.69 0 0 1 1-2 39.92 39.92 0 0 1 52-.15 2.71 2.71 0 0 1 1 1.91 2.8 2.8 0 0 1-.7 2.08l-.23.26a2.77 2.77 0 0 1-2.1 1 3 3 0 0 1-1.89-.7 33.93 33.93 0 0 0-44 .11 2.88 2.88 0 0 1-2.08.69Z"></path>
                <path fill="#ccd3eb" d="M47.42 33.41a2.66 2.66 0 0 1-1.69-.59 22 22 0 0 0-27.46 0 2.66 2.66 0 0 1-1.69.59 2.84 2.84 0 0 1-2-.84l-.25-.25a2.85 2.85 0 0 1-.82-2.15 2.89 2.89 0 0 1 1.07-2.07 28 28 0 0 1 34.86 0 2.89 2.89 0 0 1 1.07 2.07 2.85 2.85 0 0 1-.82 2.15l-.25.25a2.84 2.84 0 0 1-2.02.84Z"></path>
                <path fill="#ccd3eb" d="M38.87 42a3.06 3.06 0 0 1-1.6-.46 10.18 10.18 0 0 0-10.54 0 3.06 3.06 0 0 1-1.6.46 2.76 2.76 0 0 1-2-.8l-.25-.25a2.84 2.84 0 0 1 .48-4.39 16 16 0 0 1 17.22 0 2.84 2.84 0 0 1 .48 4.39l-.25.25a2.76 2.76 0 0 1-2 .8Z"></path>
                <circle cx="32" cy="50" r="4" fill="#0074ff"></circle>
                <path fill="#033c59" d="M58.56 18.79a41.19 41.19 0 0 0-13.39-7.6l2.2-3.8a1 1 0 0 0-1.74-1l-2.42 4.19a40.81 40.81 0 0 0-22.49 0 1 1 0 0 0-.72 1.23 1 1 0 0 0 1.24.69 38.92 38.92 0 0 1 20.9-.14L40.1 16a34.88 34.88 0 0 0-30.84 7.41 1.84 1.84 0 0 1-2.5-.06l-.25-.26A1.85 1.85 0 0 1 6 21.72a1.75 1.75 0 0 1 .6-1.27 40.17 40.17 0 0 1 4.91-3.6 1 1 0 1 0-1.06-1.7 41.35 41.35 0 0 0-5.15 3.79 3.72 3.72 0 0 0-1.3 2.7 3.89 3.89 0 0 0 1.12 2.87l.26.25A3.79 3.79 0 0 0 8 25.88a3.91 3.91 0 0 0 2.53-.95 32.9 32.9 0 0 1 28.5-7.16L37 21.42a29 29 0 0 0-5-.42 28.67 28.67 0 0 0-18 6.32 3.82 3.82 0 0 0-.38 5.68l.24.25a3.8 3.8 0 0 0 5 .32A20.75 20.75 0 0 1 32 29h.56l-2.35 4.09a16.81 16.81 0 0 0-7.35 2.56 3.84 3.84 0 0 0-.66 5.95l.25.24a3.7 3.7 0 0 0 2.1 1l-7.92 13.7a1 1 0 0 0 .87 1.5 1 1 0 0 0 .87-.5l8.78-15.2.11-.06a9.13 9.13 0 0 1 9.48 0 3.88 3.88 0 0 0 4.81-.49l.25-.24a3.85 3.85 0 0 0 1.1-3.12 3.89 3.89 0 0 0-1.75-2.83 17 17 0 0 0-8.58-2.6l2.2-3.82A20.69 20.69 0 0 1 45.1 33.6a3.72 3.72 0 0 0 2.32.81 3.85 3.85 0 0 0 2.72-1.13l.24-.25a3.82 3.82 0 0 0-.33-5.71 28.59 28.59 0 0 0-11-5.46l2.06-3.57a33.06 33.06 0 0 1 12.24 6.53 3.83 3.83 0 0 0 5.38-.35l.23-.27a3.86 3.86 0 0 0 .95-2.81 3.78 3.78 0 0 0-1.35-2.6Zm-34.7 21.66-.24-.25a1.79 1.79 0 0 1-.53-1.49 1.84 1.84 0 0 1 .84-1.35 14.83 14.83 0 0 1 5-2l-3.19 5.52a1.84 1.84 0 0 1-1.88-.43ZM32 35a15 15 0 0 1 8.07 2.36 1.84 1.84 0 0 1 .84 1.35 1.79 1.79 0 0 1-.53 1.49l-.24.25a1.9 1.9 0 0 1-2.35.2 11.18 11.18 0 0 0-9-1.16L31.41 35Zm0-8a23 23 0 0 0-14.35 5 1.79 1.79 0 0 1-2.37-.18l-.28-.2a1.83 1.83 0 0 1-.53-1.4 1.86 1.86 0 0 1 .69-1.34A26.7 26.7 0 0 1 32 23a27.54 27.54 0 0 1 3.87.29l-2.18 3.78C33.13 27 32.57 27 32 27Zm16.81 1.88a1.86 1.86 0 0 1 .69 1.34 1.83 1.83 0 0 1-.53 1.4l-.25.24a1.8 1.8 0 0 1-2.37.18 23 23 0 0 0-10.5-4.71L38 23.68a26.69 26.69 0 0 1 10.81 5.2Zm8.61-6-.23.26a1.84 1.84 0 0 1-2.59.15 35.21 35.21 0 0 0-12.5-6.79l2-3.54a38.92 38.92 0 0 1 13.11 7.35 1.74 1.74 0 0 1 .61 1.22 1.79 1.79 0 0 1-.4 1.35Z"></path>
                <path fill="#033c59" d="M15 14.79a1.11 1.11 0 0 0 .43-.09c.64-.3 1.29-.59 1.95-.86a1 1 0 1 0-.76-1.84c-.69.28-1.37.58-2.05.9a1 1 0 0 0 .43 1.9zM32 45a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3z"></path>
            </g>
        </svg>
        <span class="sinconexion"></span>
        <a href="">Reintentar</a>

</div>

    <!-- Alertas personalizadas -->
    <div class="contenedor-toast " id="contenedor-toast"></div>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="" class="sign-in-form" method="post">
                    <h2 class="title">Iniciar sesión</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Usuario" name="usuario_login" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Contraseña" name="password_login" />
                    </div>
                    <input type="submit" value="Iniciar" class="btn solid" />

                </form>


            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3> Bienvenido al sistema de préstamos</h3>
                    <p>
                        Aquí podrás registrar y gestionar los préstamos de tus clientes de forma sencilla y eficiente.
                    </p>
                </div>

                <img src="<?php echo SERVERURL ?>views/assets/img/admin/bg.svg" class="image" alt="" />
            </div>
        </div>
    </div>

    <script src="<?php echo SERVERURL ?>views/js/admin/alerta.js"></script>
    <script src="<?php echo SERVERURL ?>views/js/admin/comprobarConexion.js"></script>


</body>

</html>

<?php

if (isset($_POST["usuario_login"]) && isset($_POST["password_login"])) {
    require_once("./controller/loginController.php");

    $ins_login = new loginController();
    echo $ins_login->loginControllerUser();
}


?>

