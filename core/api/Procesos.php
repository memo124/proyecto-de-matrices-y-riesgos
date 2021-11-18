<?php
require_once('../helpers/conexion.php');
require_once('../helpers/validator.php');
require_once('../models/kt_procesos.php');


if(isset($_GET['action']))
{
    session_start();
    $procesos = new Procesos;
    $result = array('status'=> 0, 'message' =>null,'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['USER_ID'])) {
        switch($_GET['action']){
            case 'read':
                if ($result['dataset'] = $procesos->readProceso()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay Procesos registrados';
                }
            break;
            case 'readwe':
                if ($result['dataset'] = $procesos->readProceso2()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay Procesos registrados';
                }
            break;
            /*Acción para crear un proceso, solo los
            SuperAdministradores y Administradores pueden hacerlo*/
            case 'create':
                $_POST = $procesos->validateForm($_POST);
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if($procesos->setProcesoId(strip_tags(htmlspecialchars($_POST['txtProcesosID'])))){
                        if($procesos->setDescripcion(strip_tags(htmlspecialchars($_POST['txtDescripcion'])))){
                            if($procesos->insertProceso()){
                                $result['status'] = 1;
                                $result['message'] = 'Proceso creado correctamente';
                            }
                            else{
                                $result['exception'] = Conexion::getException();
                            }
                        }else{
                                $result['exception'] = 'Descripcion incorrecto';
                        }
                    }else{
                        $result['exception'] = 'Proceso ID incorrecto';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
            break;

            /*Acción para obtener datos de un proceso, solo los
            SuperAdministradores y Administradores pueden hacerlo*/
            case 'get':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ($procesos->setId(strip_tags(htmlspecialchars($_POST['rowid'])))) {
                        if ($result['dataset'] = $procesos->getProceso()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'Proceso inexistente';
                        }
                    } else {
                        $result['exception'] = 'Proceso incorrecto';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
            break;  
            /*Acción para modificar un proceso, solo los
            SuperAdministradores y Administradores pueden hacerlo*/
            case 'update':
                $_POST = $procesos->validateForm($_POST);
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if($procesos->setId(strip_tags(htmlspecialchars($_POST['rowid'])))){
                        if($procesos->setProcesoId(strip_tags(htmlspecialchars($_POST['txtProcesosID'])))){
                            if($procesos->setDescripcion(strip_tags(htmlspecialchars($_POST['txtDescripcion'])))){
                                if($procesos->updateProceso()){
                                    $result['status'] = 1;
                                    $result['message'] = 'Proceso actualizado correctamente';
                                }
                                else{
                                    $result['exception'] = Conexion::getException();
                                }
                            }else{
                                    $result['exception'] = 'Descripcion incorrecto';
                            }
                        }else{
                            $result['exception'] = 'Proceso ID incorrecto';
                        }
                    }else{
                        $result['exception'] = 'Proceso no encontrado';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
            break;
            /*Acción para eliminar un proceso, solo los
            SuperAdministradores pueden hacerlo*/
            case 'delete':
                if($_SESSION['LEVEL'] == 'S'){
                    if ($procesos->setId(strip_tags(htmlspecialchars($_POST['rowid'])))) 
                    {
                            if ($procesos->deleteProceso()) {
                                $result['status'] = 1;
                                $result['message'] = 'Proceso eliminado correctamente';
                            } else {
                                $result['exception'] = Conexion::getException();
                            }
                    } else {
                        $result['exception'] = 'Proceso incorrecto';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
            break;
            case 'search':
                $_POST = $procesos->validateForm($_POST);
                if ($_POST['search'] != '') {
                    if ($result['dataset'] = $procesos->searchProceso(strip_tags(htmlspecialchars($_POST['search'])))) {
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
            /*Acción a realizar cuando se quiera el grafico de usuarios de un proceso,
            solo SuperAdministradores y Administradores pueden hacerlo*/
            case 'graficoUsuarios':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ( $procesos->setProcesoId(strip_tags(htmlspecialchars($_POST['proceso_id']))) ) 
                    {
                        if ( $result['dataset'] = $procesos->graficoUsuarios(strip_tags(htmlspecialchars($_POST['proceso_id'])))) {
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
            /*Acción a realizar cuando se quieran los correlativos de un proceso*/
            case 'graficoCorrelativos':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ( $procesos->setProcesoId(strip_tags(htmlspecialchars($_POST['proceso_id']))) ) 
                    {
                        if ( $result['dataset'] = $procesos->graficoCorrelativos(strip_tags(htmlspecialchars($_POST['proceso_id']))) ) {
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
            /*Acción a realizar cuando se quieran los correlativos de un proceso*/
            case 'graficoIndicadores':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ( $procesos->setProcesoId(strip_tags(htmlspecialchars($_POST['proceso_id'])))) 
                    {
                        if ( $result['dataset'] = $procesos->graficoIndicadores(strip_tags(htmlspecialchars($_POST['proceso_id']))) ) {
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
            /*Acción a realizar cuando se quieran los correlativos de un proceso*/
            case 'graficoPI':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ( $procesos->setProcesoId(strip_tags(htmlspecialchars($_POST['proceso_id']))) ) 
                    {
                        if ( $result['dataset'] = $procesos->graficoPI(strip_tags(htmlspecialchars($_POST['proceso_id']))) ) {
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