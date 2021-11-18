<?php
require_once('../../core/helpers/template.php');
Page::headerTemplate('Objetivos Calidad',
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
                        <h3 class="tituloh3_2">Gestión de objetivos de calidad</h3>
                    </div> 
                    <div class="row">
                        <div class="col l12 m12 s12 caja_botones">
                            <div class="col l4 offset-l2 m6 s12 cb1">
                                <button class="boton2" onclick="AbrirVentanaCrearOC()">Agregar objetivo de calidad</button>
                            </div>
                            <div class="col l4 m6 s12 cb2">
                                <a href="../../core/reports/kt_objetivoscalidad.php" target="_blank"><button class="boton" onclick="">Generar reporte</button></a>
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
                        <input type="text" id="search" name="search" placeholder="Buscar objetivo de calidad">
                    </div>
                </form>
            </div>
        </div>

        <!--contenedor de la tabla que contiene los datos de la tabla KT_USUARIOSCROSS-->
        <div class="row">
            <div class="col l10 offset-l1 m10 offset-m1 s12">
                <div id="caja_tabla">
                    <table class="Tabla_Datos4"  id="tablaOC">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Objetivo de calidad</th>
                                <th>Descripción</th>
                                <th>Palabra clave</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpotablaOC">              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Ventana para crear un registro de Objetivo calidad-->
    <div id="save-modal-1" class="modal">
        <div class="modal-content">
            <h4 id="modal-title-1" class="center-align"></h4>
            <form id="save-form-1" name="save-form-1" autocomplete="off">
            <input id="txtRowid" type="text" name="txtRowid" class="hide"/>
                <div class="row">
                    <div class="input-field col s12 m6 l12">
                        <i class="material-icons prefix">input</i>
                        <input id="txtObjetivoCalidad" type="text" name="txtObjetivoCalidad" class="validate"/>
                        <label for="txtObjetivoCalidad">Objetivo de calidad</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">description</i>
                        <input id="txtDescripcion" type="text" name="txtDescripcion" class="validate"/>
                        <label for="txtDescripcion">Descripcion</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">comment</i>
                        <input id="txtPalabraClave" type="text" name="txtPalabraClave" class="validate"/>
                        <label for="txtPalabraClave">Palabra clave</label>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn-medium waves-effect waves-light grey darken-4 btn">Guardar<i class="material-icons left">save</i></button>
                <a  href="#" class="modal-close btn-medium waves-effect waves-light red btn">Cancelar<i class="material-icons left">close</i></a>
                </div>
            </form>
        </div>
    </div>

    <!--Caja que contiene los gráficos del sitio privado-->
    <div>
        <div class="row">
            <div class="col l10 offset-l1 m10 offset-m1 s12">
                <div class="card-panel z-depth-5 center-align" id="CajaGraficos">
                    <div class="row">
                        <div class="col s12 m8 offset-m2 l6 offset-l3">
                            <h3>Gráficos</h3>
                        </div>
                    </div>
                    <div id="contenedor_graficos">
                        <h4 id="grafico-title" class="center-align"></h4>
                        <div class="Graficos col l12 m12 s12">
                            <canvas id="grafico1"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</main>
<?php
Page::footerTemplate('<script src="../../core/controllers/Objetivo_calidad.js" type="text/javascript"></script>');
?>
   