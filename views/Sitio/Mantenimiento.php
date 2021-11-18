<?php
require_once('../../core/helpers/template.php');
Page::headerTemplate('Mi cuenta', ' ');
?>
<main class="white">
    <body><!--Contenedor de menú-->
        <div class="row center-align">
            <div class="col l12">
                <ul class="tabs">
                    <li class="tab col s4"><a class="black-text" target="_self"  href="Matrices.php">Matrices asignadas</a></li>
                    <li class="tab col s4"><a class="active indigo-text text-darken-4" href="#Matrices_opB">Mantenimiento de una matriz</a></li>
                    <li class="tab col s4 disabled"><a class="light-green-text text-darken-4" href="#test3">Filtar e imprimir matrices</a></li>
                </ul>
                <div id="Matrices_opB" class="col s12">
                <br>
                    <ul class="tabs">
                        <li class="tab"><a class="active grey-text text-darken-4" href="#FB1">Objeto de analisis y evaluacion</a></li>
                        <li class="tab"><a class="light-blue-text text-accent-4" href="#FB2">Identificacion de la Matriz</a></li>
                        <li class="tab"><a class=" green-text text-darken-2" href="#FB3">Analisis de la Matriz</a></li>
                        <li class="tab"><a class="red-text text-darken-4" href="#FB4">Evaluacion de la Matriz</a></li>
                        <li class="tab"><a class="pink-text" href="#FB5">Accion a realizar para la Matriz</a></li>
                    </ul>
                    <div id="FB1" class="col s12">
                    <br><br>
                        <div class="col l12 red lighten-5">
                            <div class="input-field col l2">
                                    <select>
                                    <option value="" disabled selected>Elija una opcion</option>
                                    <option value="1">Riesgo</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Tipo Matriz:</label>
                            </div>
                            <div class="input-field col l2 offset-l1">
                                <input autocomplete="off" id="num_oport" type="text" class="validate">
                                <label for="num_oport">num. de oportunidad</label>
                            </div>
                            <div class="input-field col l2 offset-l1">
                                <input autocomplete="off" id="num_edit" type="text" class="validate">
                                <label for="num_edit">num. de edicion:</label>
                            </div>
                            <div class="input-field col l2 offset-l1">
                                <input autocomplete="off" id="estad" type="text" class="validate">
                                <label for="estad">Estado:</label>
                            </div>
                            <div class="input-field col l4 offset-l1">
                                    <select>
                                    <option value="" disabled selected>Elija una opcion</option>
                                    <option value="1">Riesgo</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Proceso:</label>
                            </div>
                            <div class="input-field col l4 offset-l2">
                                    <select>
                                    <option value="" disabled selected>Elija una opcion</option>
                                    <option value="1">Riesgo</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>indicador:</label>
                            </div>
                            <div class="input-field col l4 offset-l1">
                                    <select>
                                    <option value="" disabled selected>Elija una opcion</option>
                                    <option value="1">Riesgo</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Partes interesadas:</label>
                            </div>
                            <div class="input-field col l4 offset-l2">
                                    <select>
                                    <option value="" disabled selected>Elija una opcion</option>
                                    <option value="1">Riesgo</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Objetivos de calidad:</label>
                            </div>
                            <div class="input-field col l12">
                            <input autocomplete="off" id="Requisitos_id" type="text" class="validate">
                            <label for="Requisitos_id">Requisitos identificado:</label>
                            </div>
                            <div class="input-field col l12">
                            <input autocomplete="off" id="Proceso_element" type="text" class="validate">
                            <label for="Proceso_element">Proceso Elemento:</label>
                            </div>
                        </div>
                        <br>
                            <div class="input-field col l12">
                            <input autocomplete="off" id="Meta_des" type="text" class="validate">
                            <label for="Meta_des">Meta (descripcion):</label>
                            </div>
                            <div class="input-field col l12">
                            <input autocomplete="off" id="Frecuenc_med" type="text" class="validate">
                            <label for="Frecuenc_med">Frecuencia de Medicion:</label>
                            </div>
                            <div class="input-field col l12">
                            <input autocomplete="off" id="Entrada_" type="text" class="validate">
                            <label for="Entrada_">Entrada:</label>
                            </div>
                            <div class="input-field col l12">
                            <input autocomplete="off" id="Actividad_" type="text" class="validate">
                            <label for="Actividad_">Actividad:</label>
                            </div>
                            <div class="input-field col l12">
                            <input autocomplete="off" id="Salida_" type="text" class="validate">
                            <label for="Salida_">Salida:</label>
                            </div>

                    </div>
                    <div id="FB2" class="col s12">
                    <br>
                            <div class="input-field col l12">
                            <input autocomplete="off" id="Oportunid_" type="text" class="validate">
                            <label for="Oportunid_">Oportunidad:</label>
                            </div>
                            <div class="input-field col l12">
                            <input autocomplete="off" id="Riesgo_" type="text" class="validate">
                            <label for="Riesgo_">Riesgos:</label>
                            </div>
                            <div class="input-field col l12">
                            <input autocomplete="off" id="Causa_" type="text" class="validate">
                            <label for="Causa_">Causas:</label>
                            </div>
                            <div class="input-field col l12">
                            <input autocomplete="off" id="Beneficio_" type="text" class="validate">
                            <label for="Beneficio_">Beneficio:</label>
                            </div> 
                    </div>
                    <div id="FB3" class="col s12">
                    <br>
                            <div class="input-field col l2">
                                    <select>
                                    <option value="1">N/A</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Mercado e Imagen:</label>
                            </div>
                            <div class="input-field col l2">
                                    <select>
                                    <option value="1">N/A</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Afectacion de Recursos:</label>
                            </div>
                            <div class="input-field col l2">
                                    <select>
                                    <option value="1">N/A</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Cumplimiento de Requisistos:</label>
                            </div>
                            <div class="input-field col l2">
                                    <select>
                                    <option value="1">N/A</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Medio Ambiente:</label>
                            </div>
                            <div class="input-field col l2">
                                    <select>
                                    <option value="1">N/A</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Responsabilidad Social:</label>
                            </div>
                            <div class="input-field col l2">
                                    <select>
                                    <option value="1">N/A</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Seguridad:</label>
                            </div>
                            <br>
                            <div class="input-field col l12">
                            <input autocomplete="off" id="Consecuencia_" type="text" class="validate">
                            <label for="Consecuencia_">Consecuencia:</label>
                            </div> 
                    </div>
                    <div id="FB4" class="col s12">
                    <br>
                            <div class="input-field col l3">
                                    <select>
                                    <option value="1">N/A</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Fatibilidad de implementacion</label>
                            </div>
                            <div class="input-field col l3 offset-l1">
                                    <select>
                                    <option value="1">N/A</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Probalididad de Ocurrencia:</label>
                            </div>
                            <div class="input-field col l3 offset-l1">
                                    <select>
                                    <option value="1">N/A</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Impacto:</label>
                            </div>
                            <div class="input-field col l12">
                            <input autocomplete="off" id="Resultado_" type="text" class="validate">
                            <label for="Resultado_">Resultado:</label>
                            </div> 
                            <div class="input-field col l12">
                                    <select>
                                    <option value="1">N/A</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Nivel de Oportunidad:</label>
                            </div>
                            <div class="input-field col l12">
                                    <select>
                                    <option value="1">N/A</option>
                                    <option value="2">Oportunidad</option>
                                    </select>
                                    <label>Decision:</label>
                            </div>
                    </div>
                    <div id="FB5" class="col s12">
                    <br>
                        <div class="col s12">
                            <ul class="tabs red lighten-5">
                                <li class="tab col l6"><a class="active purple-text text-darken-3" href="#B5-1">Acciones ingresadas</a></li>
                                <li class="tab col l6"><a class="orange-text text-darken-4" href="#B5-2">Mantenimiento de una accion</a></li>
                            </ul>
                        </div>
                        <div id="B5-1" class="col s12 red lighten-5">
                        <br>
                        <div class="col l12 float-right">
                            <a class="waves-effect waves-light red accent-3 black-text btn"><i class="material-icons right">add</i>Agregar</a>
                            <a class="waves-effect waves-light cyan darken-1 black-text btn"><i class="material-icons right">border_color</i>Editar</a>
                        </div>
                            <table class="highlight">
                                <thead>
                                <tr>
                                    <th>Num. de la oportunidad/riesgo</th>
                                    <th>Num. de la accion</th>
                                    <th>Accion propuesta</th>
                                    <th>Responsable de la accion</th>
                                    <th>Cargo del responsable</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                </tr>
                                <tr>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                </tr>
                                <tr>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="B5-2" class="col s12 red lighten-5">
                            <div class="col s12">
                                <ul class="tabs red lighten-4">
                                    <li class="tab col s3"><a class="active teal-text text-darken-4" href="#B5-2a">Informacion de la Accion</a></li>
                                    <li class="tab col s3"><a class="lime-text text-darken-4" href="#B5-2b">Recursos Requeridos</a></li>
                                    <li class="tab col s3"><a class="deep-orange-text text-darken-4" href="#B5-2c">Evaluacion de la Eficacia</a></li>
                                    <li class="tab col s3"><a class="black-text" href="#B5-2d">Control de Cierre</a></li>
                                </ul>
                            </div>
                            <div id="B5-2a" class="col l12">
                                <div class="input-field col l2">
                                <input autocomplete="off" id="Numero_Acc" type="text" class="validate">
                                <label for="Numero_Acc">Numero de Accion:</label>
                                </div>
                                <div class="input-field col l12">
                                <input autocomplete="off" id="Accion_prop" type="text" class="validate">
                                <label for="Accion_prop">Accion propuesta:</label>
                                </div>
                                <div class="input-field col l12">
                                <input autocomplete="off" id="Responsable_acc" type="text" class="validate">
                                <label for="Responsable_acc">Responsable de la accion:</label>
                                </div>
                                <div class="input-field col l12">
                                <input autocomplete="off" id="Cargo_resp" type="text" class="validate">
                                <label for="Cargo_resp">Cargo del Responsable:</label>
                                </div>
                                <div class="input-field col l12">
                                <input autocomplete="off" id="Requiere_auto" type="text" class="validate">
                                <label for="Requiere_auto">Requiere Autorizacion de:</label>
                                </div>
                                <div class="input-field col l2">
                                <input autocomplete="off" id="Fecha_plan" type="text" class="datepicker format">
                                <label for="Fecha_plan">Fecha Planeada:</label>
                                </div>
                                <div class="input-field col l2 offset-l3">
                                <input autocomplete="off" id="Fecha_Ejec" type="text" class="datepicker">
                                <label for="Fecha_Ejec">Fecha Ejecutada:</label>
                                </div>
                                <div class="input-field col l2 offset-l3">
                                <input autocomplete="off" id="Fecha_Segu" type="text" class="datepicker">
                                <label for="Fecha_Segu">Fecha Seguimiento:</label>
                                </div>
                            </div>
                            <div id="B5-2b" class="col l12">B5-2b</div>
                            <div id="B5-2c" class="col l12">B5-2c</div>
                            <div id="B5-2d" class="col l12">B5-2d<d/div>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    <br>
    </body>
    <br>          
</main>
<?php
Page::footerTemplate(' ');
?>
   