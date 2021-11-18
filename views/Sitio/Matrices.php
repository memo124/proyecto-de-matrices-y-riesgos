<?php
require_once('../../core/helpers/template.php');
Page::headerTemplate('Matrices', '');
?>
<main class="white">
    <body><!--Contenedor de menú-->
        <div class="row center-align">
            <div class="col l12">
                <ul class="tabs">
                    <li class="tab col s4"><a class="active black-text"  href="#Matrices_opA">Matrices asignadas</a></li>
                    <li class="tab col s4"><a class="indigo-text text-darken-4"  target="_self" href="Mantenimiento.php">Mantenimiento de una matriz</a></li>
                    <li class="tab col s4 disabled"><a class="light-green-text text-darken-4" href="#test3">Filtar e imprimir matrices</a></li>
                </ul>
                <br>
                <div id="Matrices_opA" class="col s12">
                    <div class="input-field col l2">
                            <select>
                            <option value="" disabled selected>Elija una opcion</option>
                            <option value="1">Riesgo</option>
                            <option value="2">Oportunidad</option>
                            <option value="2">todos</option>
                            </select>
                            <label>Matriz:</label>
                    </div>
                    <div class="input-field col l2">
                            <select>
                            <option value="" disabled selected>Elija una opcion</option>
                            </select>
                            <label>Estado:</label>
                    </div> 
                    <div class="input-field col l2">
                            <select>
                            <option value="" disabled selected>Elija una opcion</option>
                            </select>
                            <label>Clasificacion:</label>
                    </div>
                     <div class="input-field col l2">
                            <select>
                            <option value="" disabled selected>Elija una opcion</option>
                            <option value="1">htmlspecialchars_decode</option>
                            </select>
                            <label>Proceso:</label>
                    </div> 
                    <div class="col l4">
                        <a class="waves-effect waves-light white black-text btn">Revision</a>
                        <a class="waves-effect waves-light white black-text btn">Autorizada</a>
                        <a class="waves-effect waves-light white black-text btn">Actualizar</a>
                    </div>
                    <div>
                    <div class="row">
                        <div class="col l10 offset-l1 m10 offset-m1 s12">
                            <div id="caja_tabla">
                                <table class="Tabla_Datos2"  id="tablaUA">
                                    <thead>
                                        <tr>
                                            <th class="cabeza_tabla">Acciones</th>
                                            <th class="cabeza_tabla">N°</th>
                                            <th class="cabeza_tabla">Descripcion</th>
                                            <th class="cabeza_tabla">Palabra Clave</th>
                                            <th class="cabeza_tabla">Proceso</th>
                                            <th class="cabeza_tabla">Indicador</th>
                                            <th class="cabeza_tabla">Requisito identificado</th>
                                            <th class="cabeza_tabla">Clasificacion matriz</th>
                                            <th class="cabeza_tabla">ro num</th>
                                            <th class="cabeza_tabla">N° edicion</th>
                                            <th class="cabeza_tabla">Status</th>
                                            <th class="cabeza_tabla">Entrada</th>
                                            <th class="cabeza_tabla">Salida</th>
                                            <th class="cabeza_tabla">Oportunidad</th>
                                            <th class="cabeza_tabla">Riesgo</th>
                                            <th class="cabeza_tabla">Etapa</th>
                                            <th class="cabeza_tabla">Mercado e Imagen</th>
                                            <th class="cabeza_tabla">Afectacion recursos</th>
                                            <th class="cabeza_tabla">Cumplimiento de requisitos</th>
                                            <th class="cabeza_tabla">Medio Ambiente</th>
                                            <th class="cabeza_tabla">Responsabilidad sociial</th>
                                            <th class="cabeza_tabla">Seguridad</th>
                                            <th class="cabeza_tabla">Consecuencias</th>
                                            <th class="cabeza_tabla">Controles existentes</th>
                                            <th class="cabeza_tabla">Eficacia controles</th>
                                            <th class="cabeza_tabla">Causas</th>
                                            <th class="cabeza_tabla">Factibilidad</th>
                                            <th class="cabeza_tabla">impactos</th>
                                            <th class="cabeza_tabla">Resultados</th>
                                            <th class="cabeza_tabla">Nivel OR</th>
                                            <th class="cabeza_tabla">Decisiones OR</th>
                                            <th class="cabeza_tabla">Probablidad Ocurrencia</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cuerpotablaM">              
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    <br>
    <br> 
    <!-- Se muestra un gráfico de acuerdo con los datos existentes -->
    <div class="row">
        <div class="col s12 m6">
            <canvas id="chart"></canvas><br>
        </div>
    </div>
    </body>
    <br>   

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
                        <div class="Graficos col l12 m12 s12">
                            <canvas id="grafico1"></canvas>
                        </div>
                        <div class="Graficos col l12 m12 s12">
                            <canvas id="grafico2"></canvas>
                        </div>
                        <div class="Graficos col l12 m12 s12">
                            <canvas id="grafico3"></canvas>
                        </div>
                        <div class="Graficos col l12 m12 s12">
                            <canvas id="grafico4"></canvas>
                        </div>
                        <div class="Graficos col l12 m12 s12">
                            <canvas id="grafico5"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<?php
Page::footerTemplate('<script src="../../core/controllers/Matrices.js" type="text/javascript"></script>');
?>
   