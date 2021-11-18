<?php
require_once('../helpers/conexion.php');
require_once('../helpers/validator.php');
require_once('../models/Matrices.php');

// Se evalua si existe una sesión, sino se finaliza con un mensaje de error
if( isset($_GET['action']) )
{
    //Acá se crea una variable de sesión o se reanuda la anterior para trabajar con dichas variables
    session_start();
    // Se instancia la clase UserApp;
    $matrices = new Matrices;
    //Se declara un vector para almacenar lo que retornara la API
    $result = array('status'=> 0, 'message' =>null,'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['USER_ID'])) {
        //Se evalua la acción a realizar, si se ha iniciado sesión
    switch( $_GET['action'] ){
        //acción a realizar cuando se quieran leer los datos en general de la tabla Matrices
        case 'read':
            if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                if ( $result['dataset'] = $matrices->readMatris() ) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay matrices registradas';
                }
            }else{
                $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
            }
            break;
        /*acción a realizar cuando se quieran leer los datos del id y el usuario 
        de la tabla KT_USERSAPP cuando se quiera llenar un select de otra página*/
        case 'readwe':
            if ( $result['dataset'] = $matrices->readUser2() ) {
                $result['status'] = 1;
            } else {
                $result['exception'] = 'No hay usuarios registradas';
            }
            break;
        //Acción a realizar cunado se quieran insertar datos en la tabla KT_USERSAPP
        case 'create':
            $_POST = $matrices->validateForm($_POST);
            if( $matrices->setUser(strip_tags(htmlspecialchars( $_POST['txt_usuario']))) ){
                if( $matrices->setPassword(strip_tags(htmlspecialchars($_POST['txt_password']))) ){
                    if( $matrices->setLevel(strip_tags(htmlspecialchars($_POST['txt_nivel']))) ){
                        if( $matrices->insertUser() ){
                            $result['status'] = 1;
                            $result['message'] = 'Usuario creado correctamente';
                        }
                        else{
                            $result['exception'] = Conexion::getException();
                        }
                    }else{
                            $result['exception'] = 'nivel incorrecto';
                    }                       
                }else{
                    $result['exception'] = 'contraseña contraseña menor a 6 caracteres';
                }
            }else{
                $result['exception'] = 'usuario incorrecto';
            }
            break;
        //Acción a realizar cuando se quieran eliminar datos de la tabla KT_USERSAPP 
        case 'delete':
            if ( $matrices->setId(strip_tags(htmlspecialchars($_POST['user_id'])) ) ) 
            {
                if ( $matrices->deleteUser() ) {
                    $result['status'] = 1;
                    $result['message'] = 'usuario eliminado correctamente';
                } else {
                    $result['exception'] = Conexion::getException();
                }
            } else {
                $result['exception'] = 'usuario incorrecta';
            }
            break;
        //Acción a realizar cuando se quiera obtener un dato especifico de la tabla KT_USERSAPP
        case 'get':
            if ( $matrices->setId(strip_tags(htmlspecialchars($_POST['rowid'])) ) ) {
                if ( $result['dataset'] = $matrices->getUserApp() ) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'usuario inexistente';
                }
            } else {
                $result['exception'] = 'usuario incorrecto';
            }
            break; 
        //Acción a realizar cuando se quieran actualizar datos de la tabla KT_USERSAPP 
        case 'update':
            $_POST = $matrices->validateForm($_POST);
            if( $matrices->setId(strip_tags(htmlspecialchars($_POST['rowid'])) ) )
            {
                if( $data = $matrices->getUserApp() )
                {
                    if( $matrices->setuser(strip_tags(htmlspecialchars($_POST['txt_usuario'])) ) )
                    {
                        if( $matrices->setLevel(strip_tags(htmlspecialchars($_POST['txt_nivel']))) )
                        {
                            if( $matrices->updateUser() )
                            {
                                $result['status'] = 1;
                                $result['message'] = 'Usuario actualizado';
                            }
                            else
                            {
                                $result['exception'] = Conexion::getException();
                            }
                        }
                        else
                        {
                            $result['exception'] = 'Nivel incorrecto';
                        }
                    }
                    else
                    {
                        $result['exception'] = 'Usuario incorrecto';
                    }
                }
                else
                {
                    $result['exception'] = 'Usuario inexistente';
                }
            }
            else
            {
                $result['exception'] = 'Usuario no encontrado';
            }
            break; 
            //Acción a realizar cuando se quieran buscar datos de la tabla KT_USERSAPP
            case'search':    
                $_POST = $matrices->validateForm($_POST);
                if ( $_POST['search'] != '' ) {
                    if ( $result['dataset'] = $matrices->searchUserApp(strip_tags(htmlspecialchars($_POST['search'])) ) ) {
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
            /*Acción a realizar cuando se quiera iniciar sesión*/
            case 'login':
                $_POST = $matrices->validateForm($_POST);
                    if ( $matrices->checkAlias(strip_tags(htmlspecialchars($_POST['txt_usuario']))) ) {
                        if ( $matrices->checkPassword(strip_tags(htmlspecialchars($_POST['txt_contraseña'])))) {
                            $_SESSION['ROWID'] = $matrices->getId();
                            $_SESSION['USER_ID'] = $matrices->getUserApp();
                            $result['status'] = 1;
                            $result['message'] = 'Autenticación correcta';
                        } else {
                            $result['exception'] = 'Contraseña incorrecta';
                        }
                    } else {
                        $result['exception'] = 'Usuario incorrecto';
                    }
                break;
        /*Acción a realizar cuando se quieran los usuarios de un proceso*/
        case 'graficoUsuarios':
            if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                if ( $result['dataset'] = $matrices->graficoUsuarios() ) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
            }else{
                $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
            }
            break;
        /*Acción a realizar cuando se quieran los correlativos de un proceso*/
        case 'graficoCorrelativos':
            if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                if ( $result['dataset'] = $matrices->graficoCorrelativos() ) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
            }else{
                $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
            }
            break;
        /*Acción a realizar cuando se quieran los correlativos de un proceso*/
        case 'graficoIndicadores':
            if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                if ( $result['dataset'] = $matrices->graficoIndicadores() ) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
            }else{
                $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
            }
            break;
        /*Acción a realizar cuando se quieran los correlativos de un proceso*/
        case 'graficoPI':
            if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                if ( $result['dataset'] = $matrices->graficoPI() ) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
            }else{
                $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
            }
            break;
            /*Acción a realizar cuando se quieran los indicadores de un proceso*/
            case 'graficoIndicadores2':
                if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
                    if ( $result['dataset'] = $matrices->graficoIndicadores2() ) {
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
    //Se aclara el tipo de contenido que se mostrara y sus caracteres
    header('content-type: application/json; charset=utf-8');
    // Se devuelve impreso el resultado en formato JSON
    print(json_encode($result));
}
?>