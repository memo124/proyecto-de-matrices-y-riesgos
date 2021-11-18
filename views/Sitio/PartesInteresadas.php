<?php
require_once('../../core/helpers/template.php');
Page::headerTemplate('Partes Interesadas',
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
                        <h3 class="tituloh3_2">Gestión de partes interesadas</h3>
                    </div> 
                    <div class="row">
                        <div class="col l12 m12 s12 caja_botones">
                            <div class="col l4 offset-l2 m6 s12 cb1">
                                <button class="boton2" onclick="AbrirVentanaCrearPI()">Agregar parte interesada</button>
                            </div>
                            <div class="col l4 m6 s12 cb2">
                            <a href="../../core/reports/kt_partesinteresadas.php" target="_blank"><button class="boton" onclick="">Generar reporte</button></a>
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
                        <input type="text" id="search" name="search" placeholder="Buscar parte interesada">
                    </div>
                </form>
            </div>
        </div>

        <!--contenedor de la tabla que contiene los datos de la tabla KT_USUARIOSCROSS-->
        <div class="row">
            <div class="col l10 offset-l1 m10 offset-m1 s12">
                <div id="caja_tabla">
                    <table class="Tabla_Datos3"  id="tablaPI">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Parte interesada id</th>
                                <th>Proceso</th>
                                <th>Descripción</th>
                                <th>Requisito identificado</th>
                                <th>Last user</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpotablaPI">              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


        <!-- Ventana para crear un registro de parte interesada-->
<div id="save-modal-2" class="modal">
    <div class="modal-content">
        <h4 id="modal-title-1" class="center-align"></h4>
        <form id="partesinteresadas" name="partesinteresadas" method="POST" autocomplete="off">
            <input id="id_parte" type="text" class="hide" name="id_parte">
            <div class="row">
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">input</i>
                    <input id="txt_parte_interesada" type="text" name="txt_parte_interesada" class="validate">
                    <label for="txt_parte_interesada">Parte interesada ID</label>
                </div>
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">description</i>
                    <select id="cb_proceso" name="cb_proceso">
                    </select>
                    <label>Proceso:</label>
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">group</i>
                    <input type="text" id="textarea_descripcion" name="textarea_descripcion" class="validate">
                    <label for="textarea_descripcion">Descripción</label>
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">note_add</i>
                    <input type="text" id="textarea_requisito" name="textarea_requisito" class="validate">
                    <label for="textarea_requisito">Requisito identificado</label>
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="txt_lastuser" type="text" name="txt_lastuser" class="validate">
                    <label for="txt_lastuser">Last user</label>
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
Page::footerTemplate(
'<script src="../../core/controllers/PartesInteresadas.js" type="text/javascript"></script>');
?>
   