<?php
require_once('../helpers/conexion.php');
require_once('../helpers/validator.php');
require_once('../models/kt_indicadores.php');


if(isset($_GET['action']))
{
    session_start();
    $indicadores = new Indicadores;
    $proceso = '';
    $objetivo_calidad = '';
    $result = array('status'=> 0, 'message' =>null,'exception' => null);
    if (isset($_SESSION['USER_ID'])) {
        switch($_GET['action']){
            case 'read':
                if ($result['dataset'] = $indicadores->readIndicadores()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay usuarios registradas';
                }
                break;
            case 'create':
                $_POST = $indicadores->validateForm($_POST);
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if( $indicadores->getProcesoIn(strip_tags(htmlspecialchars($_POST['proceso']))) ){
                        $proceso = $indicadores->getProceso();
                        if( $indicadores->setProceso(strip_tags(htmlspecialchars($proceso)))){
                            if( $indicadores->setIndicador(strip_tags(htmlspecialchars($_POST['txtindicador']))) ){
                                if( $indicadores->setNombre(strip_tags(htmlspecialchars($_POST['txtnombre']))) ){
                                    if( $indicadores->getObjetivoIn(strip_tags(htmlspecialchars($_POST['objetivocalidad'])))){
                                        $objetivo_calidad = $indicadores->getObjetivosCal();
                                        if( $indicadores->setObjetivosCal(strip_tags(htmlspecialchars($objetivo_calidad))) ){
                                            if( $indicadores->setObjetivos(strip_tags(htmlspecialchars($_POST['objetivoespecifico'])))) {
                                                if( $indicadores->setFormula(strip_tags(htmlspecialchars($_POST['formula'])))){
                                                    if( $indicadores->setValorActual(strip_tags(htmlspecialchars($_POST['valoractual']))) ){
                                                        if( $indicadores->setValorPotencia(strip_tags(htmlspecialchars($_POST['valorpotencia'])))){
                                                            if( $indicadores->setMeta(strip_tags(htmlspecialchars($_POST['meta'])))){
                                                                if( $indicadores->setFrecuencia(strip_tags(htmlspecialchars($_POST['frecuencia'])))){
                                                                    if( $indicadores->setResponsable(strip_tags(htmlspecialchars($_POST['responsable'])))){
                                                                        if( $indicadores->setResponsible(strip_tags(htmlspecialchars($_POST['responsible'])))){
                                                                            if( $indicadores->setFuente(strip_tags(htmlspecialchars($_POST['fuente'])))){
                                                                                if( $indicadores->insertIndicadores() ){
                                                                                    $result['status'] = 1;
                                                                                    $result['message'] = 'Indicador creado correctamente';
                                                                                }else{
                                                                                    $result['exception'] = Conexion::getException();
                                                                                }
                                                                            }else{
                                                                                $result['exception'] = 'Fuente incorrecta';
                                                                            }
                                                                        }else{
                                                                            $result['exception'] = 'Responsable de seguimiento incorrecta';
                                                                        }
                                                                    }else{
                                                                        $result['exception'] = 'Responsable de medición incorrecto';
                                                                    }
                                                                }else{
                                                                    $result['exception'] = 'Frecuencia de medición incorrecta';
                                                                }
                                                            }else{
                                                                $result['exception'] = 'Meta incorrectas';
                                                            }
                                                        }else{
                                                            $result['exception'] = 'Valor potencial incorrecto';
                                                        }
                                                    }else{
                                                        $result['exception'] = 'Valor actual incorrecto';
                                                    }
                                                }else{
                                                    $result['exception'] = 'Fórmula de cálculo incorrecta';
                                                }
                                            }else{
                                                $result['exception'] = 'Objetivo específico incorrecto';
                                            }
                                        }else{
                                            $result['exception'] = 'Objetivo de calidad incorrecto';
                                        }
                                    }else{
                                        $result['exception'] = 'No se capturo el valor del objetivo de calidad';
                                    }
                                }else{
                                    $result['exception'] = 'Nombre incorrecto';
                                }
                            }else{
                                $result['exception'] = 'Identificación de indicador incorrecto';
                            }
                        }else{
                            $result['exception'] = 'Proceso incorrecto';
                        }
                    }else{
                        $result['exception'] = 'No se capturo el valor del proceso';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
                break;   
            case 'delete':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ($indicadores->setId(strip_tags(htmlspecialchars($_POST['id_indicador'])))) 
                    {
                            if ($indicadores->deleteIndicador()) {
                                $result['status'] = 1;
                                $result['message'] = 'Indicador eliminado correctamente';
                            } else {
                                $result['exception'] = Conexion::getException();
                            }
                    } else {
                        $result['exception'] = 'Usuario incorrecto';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
                break;
            case 'get':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ($indicadores->setId(strip_tags(htmlspecialchars($_POST['id_indicador'])))) {
                        if ($result['dataset'] = $indicadores->getIndicadores()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'Indicador inexistente';
                        }
                    } else {
                        $result['exception'] = 'Indicador incorrecto';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
                break;  
            case 'update':
                $_POST = $indicadores->validateForm($_POST);
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if($indicadores->setId(strip_tags(htmlspecialchars($_POST['id_indicador']))))
                    {
                        if($data = $indicadores->getIndicadores())
                        {
                            if( $indicadores->getProcesoIn(strip_tags(htmlspecialchars($_POST['proceso'])))){
                                $proceso = $indicadores->getProceso();
                                if( $indicadores->setProceso(strip_tags(htmlspecialchars($proceso)))){
                                    if( $indicadores->setIndicador(strip_tags(htmlspecialchars($_POST['txtindicador'])))){
                                        if( $indicadores->setNombre(strip_tags(htmlspecialchars($_POST['txtnombre'])))){
                                            if( $indicadores->getObjetivoIn(strip_tags(htmlspecialchars($_POST['objetivocalidad'])))){
                                                $objetivo_calidad = $indicadores->getObjetivosCal();
                                                if( $indicadores->setObjetivosCal(strip_tags(htmlspecialchars($objetivo_calidad)))){
                                                    if( $indicadores->setObjetivos(strip_tags(htmlspecialchars($_POST['objetivoespecifico'])))) {
                                                        if( $indicadores->setFormula(strip_tags(htmlspecialchars($_POST['formula'])))){
                                                            if( $indicadores->setValorActual(strip_tags(htmlspecialchars($_POST['valoractual'])))){
                                                                if( $indicadores->setValorPotencia(strip_tags(htmlspecialchars($_POST['valorpotencia'])))){
                                                                    if( $indicadores->setMeta(strip_tags(htmlspecialchars($_POST['meta'])))){
                                                                        if( $indicadores->setFrecuencia(strip_tags(htmlspecialchars($_POST['frecuencia'])))){
                                                                            if( $indicadores->setResponsable(strip_tags(htmlspecialchars($_POST['responsable']))) ){
                                                                                if( $indicadores->setResponsible(strip_tags(htmlspecialchars($_POST['responsible']))  ) ){
                                                                                    if( $indicadores->setFuente( strip_tags(htmlspecialchars($_POST['fuente'])) ) ){
                                                                                        if( $indicadores->updateIndicadores() ){
                                                                                            $result['status'] = 1;
                                                                                            $result['message'] = 'Indicador actualizado correctamente';
                                                                                        }else{
                                                                                            $result['exception'] = Conexion::getException();
                                                                                        }
                                                                                    }else{
                                                                                        $result['exception'] = 'Fuente incorrecta';
                                                                                    }
                                                                                }else{
                                                                                    $result['exception'] = 'Responsable de seguimiento incorrecta';
                                                                                }
                                                                            }else{
                                                                                $result['exception'] = 'Responsable de medición incorrecto';
                                                                            }
                                                                        }else{
                                                                            $result['exception'] = 'Frecuencia de medición incorrecta';
                                                                        }
                                                                    }else{
                                                                        $result['exception'] = 'Meta incorrectas';
                                                                    }
                                                                }else{
                                                                    $result['exception'] = 'Valor potencial incorrecto';
                                                                }
                                                            }else{
                                                                $result['exception'] = 'Valor actual incorrecto';
                                                            }
                                                        }else{
                                                            $result['exception'] = 'Fórmula de cálculo incorrecta';
                                                        }
                                                    }else{
                                                        $result['exception'] = 'Objetivo específico incorrecto';
                                                    }
                                                }else{
                                                    $result['exception'] = 'Objetivo de calidad incorrecto';
                                                }
                                            }else{
                                                $result['exception'] = 'No se capturo el valor del objetivo de calidad';
                                            }
                                        }else{
                                            $result['exception'] = 'Nombre incorrecto';
                                        }
                                    }else{
                                        $result['exception'] = 'Identificación de indicador incorrecto';
                                    }
                                }else{
                                    $result['exception'] = 'Proceso incorrecto';
                                }
                            }else{
                                $result['exception'] = 'No se capturo el valor del proceso';
                            }
                        }
                        else
                        {
                            $result['exception'] = 'Cargo de usuario inexistente';
                        }
                    }
                    else
                    {
                        $result['exception'] = 'Cargo de usuario no encontrado';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
                break; 
               //Acción a realizar cuando se quieran buscar datos de la tabla KT_USUARIOSCROSS
               case'search':    
                $_POST = $indicadores->validateForm($_POST);
                if ( $_POST['search'] != '' ) {
                    if ( $result['dataset'] = $indicadores->searchIndicadores(strip_tags(htmlspecialchars($_POST['search'])))) {
                        $result['status'] = 1;
                        $rows = count($result['dataset']);
                        if ( $rows > 1 ) {
                            $result['message'] = 'Se encontraron '.$rows.' coincidencias';
                        } else {
                            $result['message'] = 'Solo existe una coincidencia';
                        }
                    } else {
                        $result['exception'] = 'No hay coincidencias';
                    }
                } else {
                    $result['exception'] = 'Ingrese un valor para buscar';
                }
            break;     
    
        }   
    }
    header('content-type: application/json; charset=utf-8');
    print(json_encode($result));
}
?>