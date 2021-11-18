<?php
require_once('../helpers/conexion.php');
require_once('../helpers/validator.php');
require_once('../models/kt_usuarioscross.php');


if(isset($_GET['action']))
{
    session_start();
    $usuariocross = new Usuariocross;
    $result = array('status'=> 0, 'message' =>null,'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['USER_ID'])) {
        switch($_GET['action']){
            case 'read':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ($result['dataset'] = $usuariocross->readUser()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay usuarios registradas';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
                break;
            case 'create':
                $_POST = $usuariocross->validateForm($_POST);
                if($_SESSION['LEVEL'] == 'S'){
                    if( $usuariocross->setUser(strip_tags(htmlspecialchars( $_POST['usuario']))) ){
                        if( $id_proceso = $usuariocross->getProcesoUC(strip_tags(htmlspecialchars($_POST['proceso'])))){
                            $id_proceso = $usuariocross->getProceso();
                            if( $usuariocross->setProceso(strip_tags(htmlspecialchars($id_proceso)))){
                                if( $usuariocross->setRol(strip_tags(htmlspecialchars($_POST['rol']))) ){
                                    if( $usuariocross->insertUser() ){
                                        $result['status'] = 1;
                                        $result['message'] = 'Usuario creado correctamente';
                                    }
                                    else{
                                        $result['exception'] = Conexion::getException();
                                    }
                                }else{
                                    $result['exception'] = 'Rol incorrecto';
                                }
                            }else{
                                $result['exception'] = 'proceso incorrecto';
                            }                       
                        }else{
                            $result['exception'] = 'No se capturo el proceso seleccionado';
                        }
                    }else{
                        $result['exception'] = 'usuario incorrecto';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
                break;   
            case 'delete':
                if($_SESSION['LEVEL'] == 'S'){
                    if ($usuariocross->setId(strip_tags(htmlspecialchars($_POST['id_cargo'])))) 
                    {
                            if ($usuariocross->deleteUser()) {
                                $result['status'] = 1;
                                $result['message'] = 'Cargo de Usuario eliminado correctamente';
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
                if($_SESSION['LEVEL'] == 'S'){
                    if ($usuariocross->setId(strip_tags(htmlspecialchars($_POST['id_cargo'])))) {
                        if ($result['dataset'] = $usuariocross->getUsercross()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'Cargo de usuario inexistente';
                        }
                    } else {
                        $result['exception'] = 'Cargo de usuario incorrecto';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
                break;  
            case 'update':
                $_POST = $usuariocross->validateForm($_POST);
                if($_SESSION['LEVEL'] == 'S'){
                    if($usuariocross->setId(strip_tags(htmlspecialchars($_POST['id_cargo']))))
                    {
                        if($data = $usuariocross->getUsercross())
                        {
                            if( $usuariocross->setUser(strip_tags(htmlspecialchars($_POST['usuario']))) ){
                                if( $id_proceso = $usuariocross->getProcesoUC(strip_tags(htmlspecialchars($_POST['proceso']))) ){
                                    $id_proceso = $usuariocross->getProceso();
                                    if( $usuariocross->setProceso(strip_tags(htmlspecialchars($id_proceso)))){
                                        if( $usuariocross->setRol(strip_tags(htmlspecialchars($_POST['rol'])))){
                                            if( $usuariocross->updateUser() ){
                                                $result['status'] = 1;
                                                $result['message'] = 'Cargo de usuario actualizado correctamente';
                                            }
                                            else{
                                                $result['exception'] = Conexion::getException();
                                            }
                                        }else{
                                            $result['exception'] = 'Rol incorrecto';
                                        }
                                    }else{
                                        $result['exception'] = 'proceso incorrecto';
                                    }                       
                                }else{
                                    $result['exception'] = 'No se capturo el proceso seleccionado';
                                }
                            }else{
                                $result['exception'] = 'usuario incorrecto';
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
                $_POST = $usuariocross->validateForm($_POST);
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ( $_POST['search'] != '' ) {
                        if ( $result['dataset'] = $usuariocross->searchUserCross(strip_tags(htmlspecialchars($_POST['search']))) ) {
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
            //acciones que se realizan para generar los graficos, que comprueba si existen datos los cuales solicita la grafica
            case 'cantidadUsuariosRol':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ($result['dataset'] = $usuariocross->cantidadUsuariosRol()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay datos disponibles';
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