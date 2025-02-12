<?php 
session_start();
$cerrar_session = '1';
if($cerrar_session){
    $cerrar_session = ($cerrar_session != '' ? $cerrar_session : '');
    session_destroy();
}
?>
<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Sistema de Digitur</title>
    <meta name="description" content="" />

    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
    <link rel="stylesheet" href="assets/css/sweetalert2.min.css"/>

    <!-- Estilos personalizados para fondo -->
    <style>
      /* Se establece la imagen de fondo para el body */
      body {
        background-image: url('views/bg.svg');
        background-repeat: no-repeat;
        background-position: 10px center;
        background-size: cover;
      }
      /* Opcional: Si deseas que el contenedor de login tenga un fondo semitransparente para mejorar la legibilidad */
      .authentication-wrapper {
        
        border-radius: 10px;
        padding: 20px;
      }
    </style>
  </head>
  <body>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <div class="card">
            <div class="card-body">
              <div class="app-brand justify-content-center">
                <!-- Aquí puedes colocar el logo o nombre de tu marca -->
              </div>
              <h4 class="mb-2">Bienvenidos Modo Turno</h4>
              <p class="mb-4">Inicia tu Aventura</p>
              <form id="formAuthentication" class="mb-3" action="index.html" method="POST">
                <div class="mb-3">
                  <label for="usuariologin" class="form-label">Usuario</label>
                  <input
                    type="text"
                    class="form-control"
                    id="usuariologin"
                    name="usuariologin"
                    autofocus
                  />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="passwordlogin">Contraseña</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="passwordlogin"
                      class="form-control"
                      name="passwordlogin"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="button" onClick="Login()">Iniciar Session</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="controllers/loginController.js"></script>
  </body>
</html>
