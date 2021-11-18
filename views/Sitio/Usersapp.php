<?php
require_once('../../core/helpers/template.php');
Page::headerTemplate('Usuarios');
?>
<main class="white">
    <!--Se crea el contenedor del contenido de la página-->
    <div class="contenedor">
        <!--Se crea el contenedor de la caja que contiene los botones de agregar usuario, 
        generar reporte y el titulo de la página-->
        <div class="row">
            <div class="row center-align">
                <div class="col l10 offset-l1 m10 offset-m1 s12 caja_titulo">
                    <div>
                        <h3 class="tituloh3">Gestión de usuarios</h3>
                    </div> 
                    <div class="row">
                        <div class="col l12 m12 s12 caja_botones">
                            <div class="col l4 offset-l2 m6 s12 cb1">
                                <button class="boton" onclick="AbrirVentanaCrearUA()">Agregar usuario</button>
                            </div>
                            <div class="col l4 m6 s12 cb2">
                            <a href="../../core/reports/kt_userapp.php" target="_blank"><button class="boton" onclick="">Generar reporte</button></a>
                            </div>
                        </div>
                    </div>
                </div>              
            </div>
        </div>

        <!--Se crea el contenedor de la caja para buscar un usuario-->
        <div class="row oka">
            <div class="col l10 offset-l1 m10 offset-m1 s12 searchuser">
                <form id="searchuser" autocomplete="off">
                    <div class="input-field col l2 m2 s2 c1">
                        <input type="submit" class="enviar_buscar" value="Buscar">
                    </div>
                    <div class="input-field col l8 offset-l2 m8 offset-m2 s8 offset-s2 c2">
                        <input type="text" id="search" name="search" placeholder="Buscar usuario">
                    </div>
                </form>
            </div>
        </div>

        <!--contenedor de la tabla que contiene los datos de la tabla KT_USUARIOSCROSS-->
        <div class="row">
            <div class="col l10 offset-l1 m10 offset-m1 s12">
                <div id="caja_tabla">
                    <table class="Tabla_Datos"  id="tablaUA">
                        <thead>
                            <tr>
                                <th class="cabeza_tabla">N°</th>
                                <th class="cabeza_tabla">Usuario</th>
                                <th class="cabeza_tabla">Nivel</th>
                                <th class="cabeza_tabla">Correo</th>
                                <th class="cabeza_tabla">Estado</th>
                                <th class="cabeza_tabla">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpotablaUA">              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <!-- Ventana para crear o modifica un registro de usuario-->
<div id="save-modal-1" class="modal">
    <div class="modal-content">
        <h4 id="modal-title-1" class="center-align"></h4>
        <form id="save-form-1" method="post" autocomplete="off">
            <input id="rowid" type="text" name="rowid" class="hide"/>
            <div class="row">
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="txt_usuario" type="text" name="txt_usuario" class="validate"/>
                    <label for="txt_usuario">Usuario</label>
                </div>
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">lock</i>
                    <input id="txt_password" type="password" name="txt_password" class="validate"/>
                    <label for="txt_password">Contraseña</label>
                </div>
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">lock</i>
                    <input id="txt_password2" type="password" name="txt_password2" class="validate"/>
                    <label for="txt_password2">Confirmar contraseña</label>
                </div>
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">dns</i>
                    <input id="txt_nivel" type="text" name="txt_nivel" class="validate"/>
                    <label for="txt_nivel">Nivel</label>
                </div>
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">email</i>
                    <input id="txt_correo" type="email" name="txt_correo" class="validate"/>
                    <label for="txt_correo">Correo</label>
                </div>
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">favorite_border</i>
                    <input id="txt_estado" type="number" min='1' max="10" step="1" name="txt_estado" class="validate"/>
                    <label for="txt_estado">Estado</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-medium waves-effect waves-light grey darken-4 btn">Guardar<i class="material-icons left">save</i></button>
                <a  href="#" class="modal-close btn-medium waves-effect waves-light red btn">Cancelar<i class="material-icons left">close</i></a>
            </div>
        </form>
    </div>
</div>
</main>
<?php
Page::footerTemplate('<script src="../../core/controllers/Usersapp.js" type="text/javascript"></script>');
?>
   