<?php
require_once('../helpers/conexion.php');
require_once('../helpers/validator.php');
require_once('../models/kt_objetivos_calidad.php');


if(isset($_GET['action']))
{
    session_start();
    $ObjetivosCalidad = new ObjetivosCalidad;
    $result = array('status'=> 0, 'message' =>null,'exception' => null);
     // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
     if (isset($_SESSION['USER_ID'])) {
        switch($_GET['action']){
            case 'read':
                if ($result['dataset'] = $ObjetivosCalidad->readObjetivoCalidad()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay Tipos objetivos de calidad registrados';
                }
                break;
            case 'readwe':
                if ($result['dataset'] = $ObjetivosCalidad->readObjetivoCalidad2()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay Tipos objetivos de calidad registrados';
                }
                break;
                case 'search':
                    $_POST = $ObjetivosCalidad->validateForm($_POST);
                    if ($_POST['search'] != '') {
                        if ($result['dataset'] = $ObjetivosCalidad->searchObjetivoCalidad(strip_tags(htmlspecialchars($_POST['search'])))) {
                            $result['status'] = 1;
                            $rows = count($result['dataset']);
                            if ($rows > 1) {
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
            case 'create':
                $_POST = $ObjetivosCalidad->validateForm($_POST);
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if($ObjetivosCalidad->setObjetivoCalidad(strip_tags(htmlspecialchars($_POST['txtObjetivoCalidad'])))){
                        if($ObjetivosCalidad->setDescripcion(strip_tags(htmlspecialchars($_POST['txtDescripcion'])))){
                            if($ObjetivosCalidad->setPalabraClave(strip_tags(htmlspecialchars($_POST['txtPalabraClave'])))){
                                if($ObjetivosCalidad->insertObjetivoCalidad()){
                                    $result['status'] = 1;
                                    $result['message'] = 'Objetivo de calidad creado correctamente';
                                }
                                else{
                                    $result['exception'] = Conexion::getException();
                                }
                            }else{
                                    $result['exception'] = 'palabra clave incorrecta';
                            }                       
                        }else{
                            $result['exception'] = 'Descripción error';
                        }
                    }else{
                        $result['exception'] = 'Objetivo incorrecto';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
            break;    
            case 'update':
                $_POST = $ObjetivosCalidad->validateForm($_POST);
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if($ObjetivosCalidad->setRowid(strip_tags(htmlspecialchars($_POST['txtRowid'])))){
                        if($data = $ObjetivosCalidad->obtenerObjetivoCalidad()){
                            if($ObjetivosCalidad->setObjetivoCalidad(strip_tags(htmlspecialchars($_POST['txtObjetivoCalidad'])))){
                                if($ObjetivosCalidad->setDescripcion(strip_tags(htmlspecialchars($_POST['txtDescripcion'])))){
                                    if($ObjetivosCalidad->setPalabraClave(strip_tags(htmlspecialchars($_POST['txtPalabraClave'])))){
                                        if($ObjetivosCalidad->updateObjetivoCalidad()) {
                                            $result['status'] = 1;
                                            $result['message'] = 'Objetivo de calidad actualizado';
                                        }else{
                                            $result['exception'] = Conexion::getException();
                                        }
                                    }else{
                                        $result['exception'] = 'Nivel incorrecto';
                                    }
                                }else{
                                    $result['exception'] = 'Descripción incorrecta';
                                }
                            } else{
                                $result['exception'] = 'Objetivo inexistente';
                            }
                        }else {
                            $result['exception'] = 'Objetivo no encontrado';
                        }
                    }else {
                        $result['exception'] = 'Objetivo no encontrado';
                    } 
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
                break;     
    
            case 'get':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ($ObjetivosCalidad->setRowid(strip_tags(htmlspecialchars($_POST['rowid'])))) {
                        if ($result['dataset'] = $ObjetivosCalidad->obtenerObjetivoCalidad()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'Objetivo inexistente';
                        }
                    } else {
                        $result['exception'] = 'Objetivo incorrecto';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
                break;
                case 'delete':
                    if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                        if ($ObjetivosCalidad->setRowid(strip_tags(htmlspecialchars($_POST['rowid'])))) {
                            if ( $ObjetivosCalidad->deleteObjetivoCalidad()) {
                                $result['status'] = 1;
                                $result['message'] = 'Objetivo de calidad eliminado correctamente';
                            } else {
                                $result['exception'] = Conexion::getException();
                            }
                        }else{
                            $result['exception'] = 'Id incorrecto';
                        } 
                    }else{
                        $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                    }
                break;
        /*Acción a realizar cuando se quieran los correlativos de un proceso*/
        case 'graficoIndicadores':
            if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                if ( $ObjetivosCalidad->setObjetivoCalidad(strip_tags(htmlspecialchars($_POST['objetivocalidad_id']))) ) 
                {
                    if ( $result['dataset'] = $ObjetivosCalidad->graficoIndicadores(strip_tags(htmlspecialchars($_POST['objetivocalidad_id'])))) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay datos disponibles';
                    }
                } else {
                    $result['exception'] = 'Hijo de pvta tramposo';
                }
            }else{
                $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
            }
            break;
        }
     }
    header('content-type: application/json; charset=utf-8');
    print(json_encode($result));
}
?>