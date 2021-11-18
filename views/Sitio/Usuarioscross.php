<?php
require_once('../../core/helpers/template.php');
Page::headerTemplate('Usuario cross', 
'<link rel="stylesheet" href="../../resources/css/cssgeneral.css" type="text/css">');
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
                                <button class="boton" onclick="AbrirVentanaCrearUC()">Agregar usuario</button>
                            </div>
                            <div class="col l4 m6 s12 cb2">
                            <a href="../../core/reports/kt_userscross.php" target="_blank"><button class="boton" onclick="">Generar reporte</button></a>
                            </div>
                        </div>
                    </div>
                </div>              
            </div>
        </div>
        <!--Se crea el contenedor de la caja para buscar un cargo de usuario-->
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
                    <table class="Tabla_Datos"  id="tablaUC">
                        <thead>
                            <tr>
                                <th class="cabeza_tabla">N°</th>
                                <th class="cabeza_tabla">Usuario</th>
                                <th class="cabeza_tabla">Proceso</th>
                                <th class="cabeza_tabla">Rol</th>
                                <th class="cabeza_tabla">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpotablaUC">              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <!--Ventana modal que sirve para crear o modificar un registro de un cargo de usuario-->
 <div id="save-modal-1" class="modal">
    <div class="modal-content">
        <h4 id="modal-title-1" class="center-align"></h4>
        <form id="Cargo" autocomplete="off">
            <input class="hide" type="text" id="id_cargo" name="id_cargo"/>
            <div class="row">
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">person_pin</i>
                    <select id="cb_usuario" name="cb_usuario">
                        <option value="" disabled selected>Seleccione un usuario</option>
                        <option value="1">Viejo lin</option>
                        <option value="2">Viejo lin 2</option>
                        <option value="3">Viejo lin 3</option>
                    </select>
                    <label>Usuario:</label>
                </div>
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">description</i>
                    <select id="cb_proceso" name="cb_proceso">
                    </select>
                    <label>Proceso:</label>
                </div>
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">perm_contact_calendar</i>
                    <input id="txt_rol" type="number" min="1" max="9" name="txt_rol" class="validate"/>
                    <label for="txt_rol">Rol</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="modal-action modal-close btn-medium waves-effect waves-light grey darken-4 btn">Guardar<i class="material-icons left">save</i></button>
                <a class="modal-close btn-medium waves-effect waves-light red btn">Cancelar<i class="material-icons left">close</i></a>
            </div>
        </form>
    </div>
</div>

</main>
<?php
Page::footerTemplate('<script src="../../core/controllers/Usuarioscross.js" type="text/javascript"></script>');
?>
   