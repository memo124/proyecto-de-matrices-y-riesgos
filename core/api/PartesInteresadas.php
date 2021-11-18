<?php
require_once('../helpers/conexion.php');
require_once('../helpers/validator.php');
require_once('../models/kt_PartesInteresadas.php');


if(isset($_GET['action']))
{
    session_start();
    $partes_interesadas = new PartesIn;
    $id_proceso = '';
    $result = array('status'=> 0, 'message' =>null,'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['USER_ID'])) {
        switch($_GET['action']){
            case 'read':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ($result['dataset'] = $partes_interesadas->readPartesInteresadas()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay partes interesadas registradas';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
                break;
            case 'create':
                $_POST = $partes_interesadas->validateForm($_POST);
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if( $partes_interesadas->setPartesId(strip_tags(htmlspecialchars($_POST['partes'])))) {
                        if( $id_proceso = $partes_interesadas->getProcesoPI(strip_tags(htmlspecialchars($_POST['proceso'])))){
                            $id_proceso = $partes_interesadas->getProcesoId();
                            if( $partes_interesadas->setProcesoId(strip_tags(htmlspecialchars($id_proceso)))){
                                if( $partes_interesadas->setDescripcion(strip_tags(htmlspecialchars($_POST['descripcion']))) ){
                                    if( $partes_interesadas->setRequisitos(strip_tags(htmlspecialchars($_POST['requisitos'])))){
                                        if( $partes_interesadas->setLastUser(strip_tags(htmlspecialchars($_POST['user'])))){
                                            if( $partes_interesadas->insertPartesInteresadas() ){
                                                $result['status'] = 1;
                                                $result['message'] = 'Parte interesada creada correctamente';
                                            } else{
                                            $result['exception'] = Conexion::getException();
                                            }
                                        } else {
                                            $result['exception'] = 'Usuario incorrecto';
                                        } 
                                    } else {
                                        $result['exception'] = 'Requisito incorrecto';
                                    }
                                }else{
                                    $result['exception'] = 'Descripción incorrecta';
                                }
                            }else{
                                $result['exception'] = 'Proceso incorrecto';
                            }                       
                        }else{
                            $result['exception'] = 'No se capturo el proceso seleccionado';
                        }
                    } else {
                        $result['exception'] = 'Parte interesada incorrecta';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
                break;   
            case 'delete':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ($partes_interesadas->setId(strip_tags(htmlspecialchars($_POST['id_parte'])))) 
                    {
                            if ($partes_interesadas->deletePartesInteresadas()) {
                                $result['status'] = 1;
                                $result['message'] = 'Parte interesada eliminada correctamente';
                            } else {
                                $result['exception'] = Conexion::getException();
                            }
                    } else {
                        $result['exception'] = 'Parte interesada incorrecto';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
                break;
            case 'get':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ($partes_interesadas->setId(strip_tags(htmlspecialchars($_POST['id_parte'])))) {
                        if ($result['dataset'] = $partes_interesadas->getPartesInteresadas()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'Parte interesada inexistente';
                        }
                    } else {
                        $result['exception'] = 'Parte interesada incorrecta';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
                break;  
            case 'update':
                $_POST = $partes_interesadas->validateForm($_POST);
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if($partes_interesadas->setId(strip_tags(htmlspecialchars($_POST['id_parte']))))
                    {
                        if($data = $partes_interesadas->getPartesInteresadas())
                        {
                            if( $partes_interesadas->setPartesId(strip_tags(htmlspecialchars($_POST['partes'])))) {
                                if( $id_proceso = $partes_interesadas->getProcesoPI(strip_tags(htmlspecialchars($_POST['proceso'])))){
                                    $id_proceso = $partes_interesadas->getProcesoId();
                                    if( $partes_interesadas->setProcesoId(strip_tags(htmlspecialchars($id_proceso)))){
                                        if( $partes_interesadas->setDescripcion(strip_tags(htmlspecialchars($_POST['descripcion'])))){
                                            if( $partes_interesadas->setRequisitos(strip_tags(htmlspecialchars($_POST['requisitos'])))){
                                                if( $partes_interesadas->setLastUser(strip_tags(htmlspecialchars($_POST['user'])))){
                                                    if( $partes_interesadas->updatePartesInteresadas() ){
                                                        $result['status'] = 1;
                                                        $result['message'] = 'Parte interesada actualizada correctamente';
                                                    } else{
                                                    $result['exception'] = Conexion::getException();
                                                    }
                                                } else {
                                                    $result['exception'] = 'Usuario incorrecto';
                                                } 
                                            } else {
                                                $result['exception'] = 'Requisito incorrecto';
                                            }
                                        }else{
                                            $result['exception'] = 'Descripción incorrecta';
                                        }
                                    }else{
                                        $result['exception'] = 'Proceso incorrecto';
                                    }                       
                                }else{
                                    $result['exception'] = 'No se capturo el proceso seleccionado';
                                }
                            } else {
                                $result['exception'] = 'Parte interesada incorrecta';
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
                $_POST = $partes_interesadas->validateForm($_POST); 
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ( $_POST['search'] != '' ) {
                        if ( $result['dataset'] = $partes_interesadas->searchParteInteresada(strip_tags(htmlspecialchars($_POST['search'])))) {
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