<!doctype html>
    <html lang="es">
    <head>
        <!-- Conjunto de caracteres -->
        <meta charset="utf-8">
        <!-- Indica al navegador que la página web está optimizada para dispositivos móviles -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Título del documento -->
        <title>Plantilla general</title>
        <!-- Importación de archivos tipo CSS -->
        <link rel="stylesheet" href="../../resources/css/materialize.min.css" type="text/css">
        <link rel="stylesheet" href="../../resources/css/material-icons.css" type="text/css">
        <link rel="stylesheet" href="../../resources/css/style.css" type="text/css">
        <!-- Llamada a un archivo tipo icono -->
        <link rel="shortcut icon" href="img/logo.png" type="image/png">
    </head>
    <body id="contenedor_index">
    <header>
        <nav class="red" height="100">
            <div class="nav-wrapper">
                <div class="row contenedor_imagen_index">
                    <div class="center-align">
                        <div class="imagen_index">
                            <a href="index.php" class="brand-logo"><img src="../../resources/img/Procaps_logo.png" height="60"></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <p>
    <main class="main_index">
        <div>
            <div class="caja_login">
                <img src="../../resources/img/icono_usuario.png" class="icono_usuario" id="icono_usuario">
                <h3 class="h3_login">Iniciar sesión 2</h3> 
                <form autocomplete="off" id="Iniciar_Sesion2" name="Iniciar_Sesion2" method="POST" enctype="multipart/form-data">
                    <div class="caja_campo1">
                        <p>Usuario</p>
                        <input type="text" name="txt_usuario" id="txt_usuario" placeholder="Usuario">
                    </div>
                    <div class="caja_campo2">
                        <p>Correo</p>
                        <input type="email" name="txt_correo" id="txt_correo" placeholder="lamara@gmail.com">
                    </div>
                    <input type="submit" name="" value="Acceder">
                    <a href="RecuperarContraseña.php">Recuperar contraseña</a>
                </form>
            </div>
        </div>
    </main>  
    <footer class="page-footer grey darken-4">
        <div class="container">
            <div class="row">
                <div class="col l5 s12">
                    <h5 class="white-text">Matriz de identificacion riesgoz y oportunidades</h5>
                    <p class="grey-text text-lighten-4">Parrafo de copiright</p>
                </div>
            </div>
        </div>
        <div class="footer-copyright center-align">
            <div class="container">
                © 2020 Copyright Laboratorios Lopez.
            </div>
        </div>
    </footer>
        <script src="../../resources/js/jquery-3.4.1.min.js" type="text/javascript"></script>
        <script src="../../resources/js/materialize.min.js" type="text/javascript"></script>
        <script src="../../resources/js/initialization.js" type="text/javascript"></script>
        <script src="../../resources/js/sweetalert.min.js" type="text/javascript"></script>
        <script src="../../core/helpers/components.js" type="text/javascript"></script>
        <script src="../../core/controllers/index.js" type="text/javascript"></script>
        <script src="../../core/controllers/cuenta.js" type="text/javascript"></script>
        <script src="../../core/controllers/coso.js" type="text/javascript"></script>
        <script src="../../core/controllers/borrarvariablesesion.js" type="text/javascript"></script>
    </body>
</html>