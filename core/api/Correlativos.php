<?php
// Declaracion de direccion a la conexion, validator y el modelo a usar
require_once('../helpers/conexion.php');
require_once('../helpers/validator.php');
require_once('../models/kt_correlativos.php');

// Filtro para seleccionar la accion a realizar
if(isset($_GET['action']))
{
    //Comienza a iniciar la sesión
    session_start();
    $correlativo = new Correlativos;
    //Declaraciòn de la variable para el manejo de get y set
    $result = array('status'=> 0, 'message' =>null,'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['USER_ID'])) {
        //Uso del switch para la acción a realizar
    switch($_GET['action']){
        case 'search':
            $_POST = $correlativo->validateForm($_POST);
            if ($_POST['txt_buscar'] != '') {
                if ($result['dataset'] = $correlativo->buscarCorrelativo(strip_tags(htmlspecialchars($_POST['txt_buscar'])))) {
                    $result['status'] = 1;
                    $rows = count($result['dataset']);
                    if ($rows > 1) {
                        $result['message'] = 'Se encontraron '.$rows.' coincidencias';
                    } else {
                        $result['message'] = 'Solo existe una coincidencia';
                    }
                } else {
                    $result['exception'] = 'No hay coincidencias de el dato buscado';
                }
            } else {
                $result['exception'] = 'Ingrese un valor para buscar un dato';
            }
            break;
        case 'read':
            if ($result['dataset'] = $correlativo->readCorrelativo()) {
                $result['status'] = 1;
            } else {
                $result['exception'] = 'No hay correlativos registrados';
            }
            break; 
        case 'get':
            if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                if ($correlativo->setId(strip_tags(htmlspecialchars($_POST['rowid'])))) {
                    if ($result['dataset'] = $correlativo->getCorrelativo()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Correlativo inexistente';
                    }
                } else {
                    $result['exception'] = 'Id incorrecto';
                }
            }else{
                $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
            }
            break;   
        case 'create':
            $_POST = $correlativo->validateForm($_POST);
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if( $correlativo->setDescripcion(strip_tags(htmlspecialchars($_POST['cb_proceso']))) ) {
                        if( $correlativo->setId(strip_tags(htmlspecialchars($_POST['txt_correlativo']))) ) {
                            if( $correlativo->setUltimo(strip_tags(htmlspecialchars($_POST['txt_ultimo_numero']))) ) {
                                if( $correlativo->createCorrelativo() ){
                                    $result['status'] = 1;
                                    $result['message'] = 'Correlativo creado correctamente';
                                } else {
                                    $result['exception'] = Conexion::getException();
                                }
                            } else {
                                $result['exception'] = 'Numero incorrecto';
                            }                       
                        } else {
                            $result['exception'] = 'Correlativo incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Proceso incorrecto';
                    }
                }else{
                    $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
                }
            break; 
        case 'update':
            $_POST = $correlativo->validateForm($_POST);
            if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                if( $correlativo->setId(strip_tags(htmlspecialchars($_POST['txt_correlativo']))) ) {
                    if( $sata = $correlativo->getCorrelativo() ) {
                         if( $correlativo->setDescripcion(strip_tags(htmlspecialchars($_POST['cb_proceso']))) ) {
                             if( $correlativo->setUltimo(strip_tags(htmlspecialchars($_POST['txt_ultimo_numero']))) ) {
                                 if( $correlativo->createCorrelativo() ){
                                     $result['status'] = 1;
                                     $result['message'] = 'Correlativo creado correctamente';
                                 } else {
                                     $result['exception'] = Conexion::getException();
                                 }
                             } else {
                                 $result['exception'] = 'Numero incorrecto';
                             }                       
                         } else {
                             $result['exception'] = 'Proceso incorrecto';
                         }
                    } else {
                     $result['exception'] = 'Proceso no encontrado';
                    }
                 } else {
                     $result['exception'] = 'Correlativo incorrecto';
                 }
            }else{
                $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
            }    
            break;   
        case 'delete':
            if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                if ($correlativo->setId(strip_tags(htmlspecialchars($_POST['rowid'])))) 
                {
                        if ($correlativo->deleteCorrelativo()) {
                            $result['status'] = 1;
                            $result['message'] = 'correlativo eliminada correctamente';
                        } else {
                            $result['exception'] = Conexion::getException();
                        }
                } else {
                    $result['exception'] = 'usuario incorrecta';
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