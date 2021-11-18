<?php
require_once('../../core/helpers/template.php');
Page::headerTemplate('Correlativos',
'<link rel="stylesheet" href="../../resources/css/cssgeneral.css" type="text/css">');
?>
<div class="contenedor">
        <!--Se crea el contenedor de la caja que contiene los botones de agregar usuario, 
        generar reporte y el titulo de la página-->
        <div class="row">
            <div class="row center-align">
                <div class="col l10 offset-l1 m10 offset-m1 s12 caja_titulo">
                    <div>
                        <h3 class="tituloh3">Gestión de correlativo</h3>
                    </div> 
                    <div class="row">
                        <div class="col l12 m12 s12 caja_botones">
                            <div class="col l4 offset-l2 m6 s12 cb1">
                                <button class="boton" onclick="AbrirVentanaCrearcorrelativo()">Agregar correlativo</button>
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
                        <input type="text" id="txt_buscar" name="txt_buscar" placeholder="Buscar Correlativo">
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
                                <th class="cabeza_tabla">Correlativo</th>
                                <th class="cabeza_tabla">Proceso</th>
                                <th class="cabeza_tabla">Último número utilizado</th>
                                <th class="cabeza_tabla">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpotablacorrelativo">              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <!-- Ventana para crear un registro de correlativo-->
<div id="save-modal-1" class="modal">
    <div class="modal-content">
        <h4 id="modal-title-1" class="center-align"></h4>
        <form id="save-form-1" autocomplete="off">
            <div class="row">
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">chrome_reader_mode</i>
                    <input id="txt_correlativo" type="text" name="txt_correlativo" class="validate"/>
                    <label for="txt_correlativo">Correlativo</label>
                </div>
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">description</i>
                    <select  id="cb_proceso" name="cb_proceso">
                    </select>
                    <label>Procesos:</label>
                </div>
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">filter_9_plus</i>
                    <input id="txt_ultimo_numero" type="number" min=0 max=9 name="txt_ultimo_numero" class="validate"/>
                    <label for="txt_ultimo_numero">Último número utilizado</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="modal-action modal-close btn-medium waves-effect waves-light grey darken-4 btn" onclick="confirmacionagregarcorrelativo()">Guardar<i class="material-icons left">save</i></button>
                <a class="modal-close btn-medium waves-effect waves-light red btn">Cancelar<i class="material-icons left">close</i></a>
            </div>
        </form>
    </div>
</div>


 <!--Ventana para modificar un registro de correlativo-->
 <div id="save-modal-2" class="modal">
    <div class="modal-content">
        <h4 id="modal-title-2" class="center-align"></h4>
        <form id="save-form-2" autocomplete="off">
        <div class="row">
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">chrome_reader_mode</i>
                    <input id="txt_correlativo" type="text" name="txt_correlativo" class="validate"/>
                    <label for="txt_correlativo">Correlativo</label>
                </div>
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">description</i>
                    <select id="cb_proceso" name="cb_proceso">
                    </select>
                    <label>Procesos:</label>
                </div>
                <div class="input-field col s12 m6 l6 offset-l3">
                    <i class="material-icons prefix">filter_9_plus</i>
                    <input id="txt_ultimo_numero" type="number" min=0 max=9 name="txt_ultimo_numero" class="validate"/>
                    <label for="txt_ultimo_numero">Último número utilizado</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="modal-action modal-close btn-medium waves-effect waves-light grey darken-4 btn" onclick="confirmacionmodificarcorrelativo()">Guardar<i class="material-icons left">save</i></button>
                <a class="modal-close btn-medium waves-effect waves-light red btn">Cancelar<i class="material-icons left">close</i></a>
            </div>
        </form>
    </div>
</div>

</main>
<?php
Page::footerTemplate('<script src="../../core/controllers/Correlativos.js" type="text/javascript"></script>');
?>
   