<?php
require_once('../../core/helpers/template.php');
Page::headerTemplate('Indicadores',
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
                        <h3 class="tituloh3">Gestión de indicadores</h3>
                    </div> 
                    <div class="row">
                        <div class="col l12 m12 s12 caja_botones">
                            <div class="col l4 offset-l2 m6 s12 cb1">
                                <button class="boton2" onclick="AbrirVentanaCrearIn()">Agregar indicador</button>
                            </div>
                            <div class="col l4 m6 s12 cb2">
                                <a href="../../core/reports/kt_indicadores.php" target="_blank"><button class="boton" onclick="">Generar reporte</button></a>
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
                        <input type="text" id="search" name="search" placeholder="Buscar indicador">
                    </div>
                </form>
            </div>
        </div>
        <!--contenedor de la tabla que contiene los datos de la tabla KT_USUARIOSCROSS-->
        <div class="row">
            <div class="col l10 offset-l1 m10 offset-m1 s12">
                <div id="caja_tabla" class="contenedor_tabla">
                    <table class="Tabla_Datos2"  id="tablaUC">
                        <thead>
                            <tr>
                                <th class="cabeza_tabla2">N°</th>
                                <th class="cabeza_tabla2">Indicador</th>
                                <th class="cabeza_tabla2">Nombre</th>
                                <th class="cabeza_tabla2">Proceso</th>
                                <th class="cabeza_tabla2">Objetivo de calidad</th>
                                <th class="cabeza_tabla2">Objetivo específico</th>
                                <th class="cabeza_tabla2">Fórmula de cálculo</th>
                                <th class="cabeza_tabla2">Valor actual</th>
                                <th class="cabeza_tabla2">Valor potencial</th>
                                <th class="cabeza_tabla2">Meta</th>
                                <th class="cabeza_tabla2">Frecuencia de medición</th>
                                <th class="cabeza_tabla2">Responsable de medición</th>
                                <th class="cabeza_tabla2">responsable de seguimiento</th>
                                <th class="cabeza_tabla2">Fuente de información</th>
                                <th class="cabeza_tabla2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpotablaIn">              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--Ventana para modificar un registro de usuario-->
    <div id="save-modal-2" class="modal">
        <div class="modal-content">
            <h4 id="modal-title-2" class="center-align"></h4>
            <form id="form_indicadores" name="form_indicadores" method="POST" autocomplete="off">
                <input class="hide" type="text" id="id_indicador" name="id_indicador"/>
                <div class="row">
                <div class="input-field col s12 m6 l6 offset-l3">
                        <i class="material-icons prefix">input</i>
                        <input id="txtIndicador" type="text" name="txtIndicador" class="validate"/>
                        <label for="txtIndicador">Indicador ID</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">local_offer</i>
                        <input id="txtnombre" type="text" name="txtnombre" class="validate"/>
                        <label for="txtnombre">Nombre</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">description</i>
                        <select id="cb_proceso" name="cb_proceso">
                            <option value="" disabled selected>Elija una opcion</option>
                        </select>
                        <label for="cb_proceso">Proceso</label>
                    </div>
                    <div class="input-field col s12 m6 l12">
                        <i class="material-icons prefix">bookmark</i>
                        <select id="cb_objetivo" name="cb_objetivo">
                        </select>
                        <label for="cb_objetivo">Objetivo calidad</label>
                    </div>
                    <div class="input-field col s12 m6 l12">
                        <i class="material-icons prefix">bookmark_border</i>
                        <input id="txtObjetivoEspecifico" type="text" name="txtObjetivoEspecifico" class="validate"/>
                        <label for="txtObjetivoEspecifico">Objetivo especifico</label>
                    </div>
                    <div class="input-field col s12 m6 l12">
                        <i class="material-icons prefix">queue</i>
                        <input id="txtFormulaCalculo" type="text" name="txtFormulaCalculo" class="validate"/>
                        <label for="txtFormulaCalculo">Formula de calculo</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <i class="material-icons prefix">wb_sunny</i>
                        <input id="txtValorActualidad" type="text" name="txtValorActualidad" class="validate"/>
                        <label for="txtValorActualidad">Valor actualidad</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <i class="material-icons prefix">wb_incandescent</i>
                        <input id="txtValorPotencialidad" type="text" name="txtValorPotencialidad" class="validate"/>
                        <label for="txtValorPotencialidad">Valor potencialidad</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <i class="material-icons prefix">wb_iridescent</i>
                        <input id="txtMeta" type="text" name="txtMeta" class="validate"/>
                        <label for="txtMeta">Meta</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">sort</i>
                        <input id="txtFrecuenciaMedicion" type="text" name="txtFrecuenciaMedicion" class="validate"/>
                        <label for="txtFrecuenciaMedicion">Frecuencia de medicion</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">account_box</i>
                        <input id="txtResponsableMedicion" type="text" name="txtResponsableMedicion" class="validate"/>
                        <label for="txtResponsableMedicion">Responsable de medicion</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">assignment_ind</i>
                        <input id="txtResponsableSeguimiento" type="text" name="txtResponsableSeguimiento" class="validate"/>
                        <label for="txtResponsableSeguimiento">Responsable de seguimiento</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">find_in_page   </i>
                        <input id="txtFuenteInformacion" type="text" name="txtFuenteInformacion" class="validate"/>
                        <label for="txtFuenteInformacion">Fuente de informacion</label>
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
'<script src="../../core/controllers/Indicadores.js" type="text/javascript"></script>');
?>
   