<?php
class Page {
    public static function headerTemplate($title) {
        session_start();
        self::modals();
        print('
        <!doctype html>
        <html lang="es">
        <head>
            <!-- Conjunto de caracteres -->
            <meta charset="utf-8">
            <!-- Indica al navegador que la página web está optimizada para dispositivos móviles -->
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- Título del documento -->
            <title>'.$title.'</title>
            <!-- Importación de archivos tipo CSS -->
            <link rel="stylesheet" href="../../resources/css/materialize.min.css" type="text/css">
            <link rel="stylesheet" href="../../resources/css/material-icons.css" type="text/css">
            <link rel="stylesheet" href="../../resources/css/style.css" type="text/css">
            <link rel="stylesheet" href="../../resources/css/animate.css" type="text/css">
            <link rel="stylesheet" href="../../resources/css/sweetalert2.min.css" type="text/css">
            
            <!-- Llamada a un archivo tipo icono -->
            <link rel="shortcut icon" href="img/logo.png" type="image/png">
        </head>
        <body>
        <header>
            <ul id="slide-out" class="sidenav red">
                <li><div class="user-view">
                <div class="background grey lighten-4">
                    <img src="../../resources/img/Procaps_logo.png" class="responsive-img">
                </div>
                <a href="matrices.php"><img class="circle" src="../../resources/img/Perfil2.png"></a>
                <a href="matrices.php"><span class="black-text name">Nombre: <b>'.$_SESSION['USER_ID'].'</b></span></a>
                </div></li>
                <li><a class="subheader">Paginas Anexas</a></li>
                <li><a class="waves-effect" href="Matrices.php"><i class="material-icons">home</i>Pagina Principal</a></li>
                <li><a class="waves-effect" href="Procesos.php"><i class="material-icons">description</i>Procesos</a></li>
                <li><a class="waves-effect" href="Indicadores.php"><i class="material-icons">library_books</i>Indicadores</a></li>
                <li><a class="waves-effect" href="PartesInteresadas.php"><i class="material-icons">group</i>Partes interesadas</a></li>
                <li><a class="waves-effect" href="Usersapp.php"><i class="material-icons">person_pin</i>Usuarios</a></li>
                <li><a class="waves-effect" href="Usuarioscross.php"><i class="material-icons">perm_contact_calendar</i>Cargo de Usario</a></li>
                <li><a class="waves-effect" href="Objetivos_calidad.php"><i class="material-icons">check_box</i>Objetivos de calidad</a></li>
                <li><a class="waves-effect" href="Correlativos.php"><i class="material-icons">chrome_reader_mode</i>Correlativos</a></li>
                <li><a class="waves-effect modal-trigger" href="#CambiarContraseña"><i class="material-icons">chrome_reader_mode</i>Cambiar contraseña</a></li>
            </ul>
            <nav class="red lighten-5" height="70">
                <div class="nav-wrapper">
                    <div class="row">
                        <div class="col s4 l4">
                            <a href="#!"><i class="Large material-icons sidenav-trigger black-text text-accent-3"  data-target="slide-out">menu</i></a>
                        </div>
                        <div class="col s4 l4 offset-l1 center-aling">
                            <a href="matrices.php" class="brand-logo"><img src="../../resources/img/Procaps_logo.png" height="60"></a>
                        </div>
                        <div class="col s4 l2 offset-l1"> 
                            <a onclick="signOff()" href="#!"><i class="Large material-icons black-text right">subdirectory_arrow_right</i></a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        ');   
    }

    public function footerTemplate($Scrips) {
        print('
            <footer class="page-footer red">
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
            <script type="text/javascript" src="../../resources/js/chart.js"></script>
            <script src="../../core/controllers/cuenta.js" type="text/javascript"></script>
            <script src="../../core/controllers/desconectar.js" type="text/javascript"></script>
            <script src="../../core/controllers/borrarvariablesesion.js" type="text/javascript"></script>
            '.$Scrips.'
        </body>
        </html>
        ');
    }

    private function modals(){
        $nombre = $_SESSION['USER_ID'];
        print('
        <div id="CambiarContraseña" class="modal">
        <div class="modal-content">
            <h4 class="center-align">Cambiar contraseña</h4>
                <form id = "Editar_Contraseña" autocomplete="off" name = "Editar_Contraseña" method="POST" enctype="multipart/form-data">
                    <div class="row center-align">
                        <h6>Contraseña actual</h6>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">lock</i>
                            <input id="contrasena_actual1" type="password" name="contrasena_actual1" class="validate" required onkeypress="return ValidarEscritura5(event, 3, this)" minlength="6" maxlength="60" required oncopy="return false" oncut="return false" onpaste="return false" oncut="return false" onpaste="return false"/>
                            <label for="contrasena_actual1">Contraseña</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">lock</i>
                            <input id="contrasena_actual2" type="password" name="contrasena_actual2" class="validate" required onkeypress="return ValidarEscritura5(event, 3, this)" minlength="6" maxlength="60" required oncopy="return false" oncut="return false" onpaste="return false" oncut="return false" onpaste="return false"/>
                            <label for="contrasena_actual2">Confirmar contraseña</label>
                        </div>
                    </div>
                    <div class="row center-align">
                        <h6>Contraseña nueva</h6>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">lock</i>
                            <input id="contrasena_nueva1" type="password" name="contrasena_nueva1" class="validate" required onkeypress="return ValidarEscritura5(event, 3, this)" minlength="6" maxlength="60" required oncopy="return false" oncut="return false" onpaste="return false" oncut="return false" onpaste="return false"/>
                            <label for="contrasena_nueva1">Contraseña</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">lock</i>
                            <input id="contrasena_nueva2" type="password" name="contrasena_nueva2" class="validate" required onkeypress="return ValidarEscritura5(event, 3, this)" minlength="6" maxlength="60" required oncopy="return false" oncut="return false" onpaste="return false" oncut="return false" onpaste="return false"/>
                            <label for="contrasena_nueva2">Confirmar contraseña</label>
                        </div>
                    </div>
                    <div class="row center-align">
                        <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                        <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Componente Modal para mostrar el formulario de editar perfil -->
        <div id="Editar_perfil" class="modal">
            <div class="modal-content">
                <h4 class="center-align">Editar perfil</h4>
                <form id = "Editar_Perfil" name = "Editar_Perfil" autocomplete="off" onsubmit="return Validar_Editar_Perfil();" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">person</i>
                            <input id="txt_nombres_perfil" type="text" name="txt_nombres_perfil" class="validate" required onkeypress="return ValidarEscritura6(event, 2, this)" minlength="2" maxlength="50" required oncopy="return false" oncut="return false" onpaste="return false" oncut="return false" onpaste="return false"/>
                            <label for="txt_nombres_perfil">Nombres</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">person</i>
                            <input id="txt_apellidos_perfil" type="text" name="txt_apellidos_perfil" class="validate" required onkeypress="return ValidarEscritura6(event, 2, this)" minlength="2" maxlength="50" required oncopy="return false" oncut="return false" onpaste="return false" oncut="return false" onpaste="return false"/>
                            <label for="txt_apellidos_perfil">Apellidos</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">contact_mail</i>
                            <input id="txt_correo_usuario" type="email" name="txt_correo_usuario" class="validate" required onkeypress="return ValidarEscritura7(event, 3)" minlength="15" maxlength="100" required oncopy="return false" oncut="return false" onpaste="return false" oncut="return false" onpaste="return false"/>
                            <label for="txt_correo_usuario">Correo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">person_pin</i>
                            <input id="txt_usuario_perfil" type="text" name="txt_usuario_perfil" class="validate" required onkeypress="return ValidarEscritura8(event, 3, this)" minlength="8" maxlength="30" required oncopy="return false" oncut="return false" onpaste="return false" oncut="return false" onpaste="return false"/>
                            <label for="txt_usuario_perfil">Usuario</label>
                        </div>
                    </div>
                    <div class="row center-align">
                        <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                        <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
                    </div>
                </form>
            </div>
        </div> 

        ');
    }
}
?>