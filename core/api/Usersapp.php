<?php
require_once('../helpers/conexion.php');
require_once('../helpers/validator.php');
require_once('../models/kt_usersapp.php');

// Se evalua si existe una sesión, sino se finaliza con un mensaje de error
if( isset($_GET['action']) )
{
    
    //Acá se crea una variable de sesión o se reanuda la anterior para trabajar con dichas variables
    session_start();
    // Se instancia la clase UserApp;
    $usersapp = new UserApp;
    //Se declara un vector para almacenar lo que retornara la API
    $result = array('status'=> 0, 'message' =>null,'exception' => null, 'code'=> 0 , 'cagad4'=> 0 , 'c4gon'=> null);
    $nombreusuariointento = '';
    $correousuario = '';
    $contrasena = '';
    $rango = '';
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['USER_ID']) ) {
    //Se evalua la acción a realizar, si se ha iniciado sesión
    switch( $_GET['action'] ){
        //acción a realizar cuando se quieran leer los datos en general de la tabla KT_USERSAPP
        case 'read':
            if ( $result['dataset'] = $usersapp->readUser() ) {
                $result['status'] = 1;
                $result['message'] = 'Existen usuarios';
            } else {
                $result['exception'] = 'No hay usuarios registrados';
            }
            break;
        /*acción a realizar cuando se quieran leer los datos del id y el usuario 
        de la tabla KT_USERSAPP cuando se quiera llenar un select de otra página*/
        case 'readwe':
            if ( $result['dataset'] = $usersapp->readUser2() ) {
                $result['status'] = 1;
            } else {
                $result['exception'] = 'No hay usuarios registradas';
            }
            break;
        //Acción a realizar cunado se quieran insertar datos en la tabla KT_USERSAPP
        case 'create':
            $_POST = $usersapp->validateForm($_POST);
            if($_SESSION['LEVEL'] == 'S' ){
                if( $usersapp->setUser(strip_tags(htmlspecialchars( $_POST['txt_usuario']))) ){
                    if( $usersapp->setPassword(strip_tags(htmlspecialchars($_POST['txt_password']))) ){
                        if($_POST['txt_password']==$_POST['txt_password2']){
                            if($_POST['txt_password']!=$_POST['txt_usuario']){
                                if( $usersapp->setLevel(strip_tags(htmlspecialchars($_POST['txt_nivel']))) ){
                                    if ( $usersapp->setCorreo(strip_tags(htmlspecialchars($_POST['txt_correo']))) ) {
                                        if($usersapp->setEstado(strip_tags(htmlspecialchars($_POST['txt_estado'])))){
                                            if( $usersapp->insertUser() ){
                                                $result['status'] = 1;
                                                $result['message'] = 'Usuario creado correctamente';
                                            }
                                            else{
                                                $result['exception'] = Conexion::getException();
                                            }
                                        }else{
                                            $result['exception'] = 'Estado incorrecto';
                                        }
                                    } else {
                                        $result['exception'] = 'Correo incorrecto';
                                    }
                                }else{
                                        $result['exception'] = 'nivel incorrecto';
                                }
                            }else{
                                $result['exception'] = 'Contraseña identica al nombre de usuario';
                            }
                        }else{
                            $result['exception'] = 'Las contraseñas iongresadas son diferentes';
                        }
                    }else{
                        $result['exception'] = 'contraseña incorrecta';
                    }
                }else{
                    $result['exception'] = 'usuario incorrecto';
                }
            } else if($_SESSION['LEVEL'] == 'A'){
                if( $usersapp->setUser(strip_tags(htmlspecialchars( $_POST['txt_usuario']))) ){
                    if( $usersapp->setPassword(strip_tags(htmlspecialchars($_POST['txt_password']))) ){
                        if($_POST['txt_password']==$_POST['txt_password2']){
                            if($_POST['txt_password']!=$_POST['txt_usuario']){
                                if($_POST['txt_nivel']!= 'S' && $_POST['txt_nivel']!= 'A' ){
                                    if( $usersapp->setLevel(strip_tags(htmlspecialchars($_POST['txt_nivel']))) ){
                                        if ( $usersapp->setCorreo(strip_tags(htmlspecialchars($_POST['txt_correo']))) ) {
                                            if($usersapp->setEstado(strip_tags(htmlspecialchars($_POST['txt_estado'])))){
                                                if( $usersapp->insertUser() ){
                                                    $result['status'] = 1;
                                                    $result['message'] = 'Usuario creado correctamente';
                                                }
                                                else{
                                                    $result['exception'] = Conexion::getException();
                                                }
                                            }else{
                                                $result['exception'] = 'Estado incorrecto';
                                            }
                                        } else {
                                            $result['exception'] = 'Correo incorrecto';
                                        }
                                    }else{
                                            $result['exception'] = 'nivel incorrecto';
                                    }
                                }else{
                                    $result['exception'] = 'No cuenta con permisos de crear SuperAdministradores y otros Administradores';
                                }
                            }else{
                                $result['exception'] = 'Contraseña identica al nombre de usuario';
                            }
                        }else{
                            $result['exception'] = 'Las contraseñas iongresadas son diferentes';
                        }
                    }else{
                        $result['exception'] = 'contraseña incorrecta';
                    }
                }else{
                    $result['exception'] = 'usuario incorrecto';
                }
            }else{
                $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
            }
            break;
        //Acción a realizar cuando se quieran eliminar datos de la tabla KT_USERSAPP 
        case 'delete':
            if($_SESSION['LEVEL'] == 'S'){
                if( $_SESSION['ROWID'] != strip_tags(htmlspecialchars($_POST['user_id']))){
                    if( $usersapp->verificarRango(strip_tags(htmlspecialchars($_POST['user_id'])))){
                        $rango = $usersapp->getLevel();
                        if( $rango != 'S' ) {
                            if ( $usersapp->setId(strip_tags(htmlspecialchars($_POST['user_id']))) ) {
                                if ( $usersapp->deleteUser() ) {
                                    $result['status'] = 1;
                                    $result['message'] = 'usuario eliminado correctamente';
                                } else {
                                    $result['exception'] = Conexion::getException();
                                }
                            } else {
                                $result['exception'] = 'usuario incorrecta';
                            }
                        }else{
                            $result['exception'] = 'No puedes eliminar a otro SuperAdministrador';
                        }
                    }else{
                        $result['exception'] = 'Ocurrió un error al verificar rango';
                    }  
                }else{
                    $result['exception'] = 'Suicidate en la vida real cerot3, pero aquí no porque me bajan puntos';
                }
                /*El nivel A es de administrador*/
            }else if($_SESSION['LEVEL'] == 'A'){
                if( $_SESSION['ROWID'] != strip_tags(htmlspecialchars($_POST['user_id']))){
                    if( $usersapp->verificarRango(strip_tags(htmlspecialchars($_POST['user_id'])))){
                        $rango = $usersapp->getLevel();
                        if( $rango != 'S' && $rango != 'A' ) {
                            if ( $usersapp->setId(strip_tags(htmlspecialchars($_POST['user_id']))) ) {
                                if ( $usersapp->deleteUser() ) {
                                    $result['status'] = 1;
                                    $result['message'] = 'usuario eliminado correctamente';
                                } else {
                                    $result['exception'] = Conexion::getException();
                                }
                            } else {
                                $result['exception'] = 'usuario incorrecta';
                            }
                        }else{
                            $result['exception'] = 'No puedes eliminar a un SuperAdministrador o a otro Administrador';
                        }
                    }else{
                        $result['exception'] = 'Ocurrió un error al verificar rango';
                    }  
                }else{
                    $result['exception'] = 'Suicidate en la vida real cerot3, pero aquí no porque me bajan puntos';
                }
            }else{
                $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
            }
            break;
        //Acción a realizar cuando se quiera obtener un dato especifico de la tabla KT_USERSAPP
        case 'get':
            if($_SESSION['LEVEL'] == 'S'){
                if($_SESSION['ROWID'] != $_POST['rowid'] ){
                    if ( $usersapp->setId(strip_tags(htmlspecialchars($_POST['rowid']))) ) {
                        if ( $result['dataset'] = $usersapp->getUserApp() ) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'usuario inexistente';
                        }
                    } else {
                        $result['exception'] = 'usuario incorrecto';
                    }
                }else{
                    $result['exception'] = 'No puedes modificar tus datos, solo puedes cambiar tu contraseña en la pestaña respectiva';
                }
            }else{
                $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
            }
            break; 
        //Acción a realizar cuando se quieran actualizar datos de la tabla KT_USERSAPP 
        case 'update':
            $_POST = $usersapp->validateForm($_POST);
            if($_SESSION['LEVEL'] == 'S'){
                if($_SESSION['ROWID'] != $_POST['rowid']){
                    if( $usersapp->setId(strip_tags(htmlspecialchars($_POST['rowid']))) )
                    {
                        if( $data = $usersapp->getUserApp() )
                        {
                            if( $usersapp->setuser(strip_tags(htmlspecialchars($_POST['txt_usuario']))) )
                            {
                                if( $usersapp->setLevel(strip_tags(htmlspecialchars($_POST['txt_nivel']))) )
                                {
                                    if ( $usersapp->setCorreo(strip_tags(htmlspecialchars($_POST['txt_correo'])))) {
                                        if($usersapp->setEstado(strip_tags(htmlspecialchars($_POST['txt_estado'])))){
                                            if( $usersapp->updateUser() ){
                                                $result['status'] = 1;
                                                $result['message'] = 'Usuario actualizado';
                                            }else{
                                                $result['exception'] = Conexion::getException();
                                            }
                                        }else{
        
                                        }
                                    } else {
                                        $result['exception'] = 'Correo incorrecto';
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
                }else{
                    $result['exception'] = 'No puedes modificar tus datos, solo puedes cambiar tu contraseña en la pestaña respectiva';
                }
            }else{
                $result['exception'] = 'No cuenta con este privilegio de usuario para realizar esta acción';
            }
            break; 
            //Acción a realizar cuando se quieran buscar datos de la tabla KT_USERSAPP
            case'search':    
                $_POST = $usersapp->validateForm($_POST);
                if ( $_POST['search'] != '' ) {
                    if ( $result['dataset'] = $usersapp->searchUserApp(strip_tags(htmlspecialchars($_POST['search']))) ) {
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
            case 'logout':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
                case 'EliminarVariableLogin':
                    if(isset($_SESSION['USUARIO'])){
                        unset($_SESSION['USUARIO']);
                        $result['status'] = 1;
                        $result['message'] = 'Sesión eliminada correctamente';
                    }else{
                        $result['exception'] = 'No existe, tranquilo cerot3';
                    }
                    break;
                case 'password':
                    $nombre_usuario = $_SESSION['ROWID'];
                    if ($usersapp->setId(strip_tags(htmlspecialchars($_SESSION['ROWID'])))) {
                        $_POST = $usersapp->validateForm($_POST);
                        if ($_POST['contrasena_actual1'] == $_POST['contrasena_actual2']) {
                            if ($usersapp->setPassword(strip_tags(htmlspecialchars($_POST['contrasena_actual1'])))) {
                                if ($usersapp->checkPassword(strip_tags(htmlspecialchars($_POST['contrasena_actual1'])))) {
                                    if ($_POST['contrasena_nueva1'] == $_POST['contrasena_nueva2']) {
                                        if( $_POST['contrasena_nueva1'] != $nombre_usuario ){
                                            if($_POST['contrasena_actual1'] != $nombre_usuario){
                                                if($_POST['contrasena_nueva1'] != $_POST['contrasena_actual1']){
                                                    if ($usersapp->setPassword(strip_tags(htmlspecialchars($_POST['contrasena_nueva1'])))) {
                                                        if ($usersapp->changePassword()) {
                                                            $result['status'] = 1;
                                                            $result['message'] = 'Contraseña cambiada correctamente';
                                                        } else {
                                                            $result['exception'] = Conexion::getException();
                                                        }
                                                    } else {
                                                        $result['exception'] = 'Contraseña nueva incorrecta';
                                                    }
                                                }else{
                                                    $result['exception'] = 'Contraseña identica a la anterior';
                                                }
                                            }else{
                                                $result['exception'] = 'Contraseña identica al nombre de usuario';
                                            }
                                        } else {
                                            $result['exception'] = 'La contraseña es igual al nombre de usuario';
                                        }
                                    } else {
                                        $result['exception'] = 'Claves nuevas diferentes';
                                    }
                                } else {
                                    $result['exception'] = 'Contraseña actual no registrada para este usuario';
                                }
                            } else {
                                $result['exception'] = 'Contraseña actual incorrecta';
                            }
                        } else {
                            $result['exception'] = 'Claves actuales diferentes';
                        }
                    } else {
                        $result['exception'] = 'Usuario incorrecto';
                    }
                    break;
            default:
                exit('Acción no disponible');
        }
    } else {
        switch($_GET['action']){
            case 'EliminarVariableLogin':
                if(isset($_SESSION['USUARIO'])){
                    unset($_SESSION['USUARIO']);
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                }else{
                    $result['exception'] = 'No existe, tranquilo cerot3';
                }
                break;
            //Acción a realizar cuando se quiera obtener un dato especifico de la tabla KT_USERSAPP
            case 'banearP3ndejo':
                if ( $usersapp->setUser(strip_tags(htmlspecialchars($_POST['usuario']))) ) {
                    if ( $usersapp->banearP3ndejo() ) {
                        $result['status'] = 1;
                        $result['message'] = 'Don p3ndejo, ya sabias que a la cuarta ibas a valer rafa, no chille cerot3';
                    } else {
                        $result['exception'] = 'Se salvó el c4brón';
                    }
                } else {
                    $result['exception'] = 'usuario incorrecto';
                }
                break; 
            /*Acción a realizar cuando se quiera iniciar sesión*/
            case 'login':
                $_POST = $usersapp->validateForm($_POST);
                    if ( $usersapp->checkAlias(strip_tags(htmlspecialchars($_POST['txt_usuario'])))) {
                        if ( $usersapp->checkPassword(strip_tags(htmlspecialchars($_POST['txt_contraseña'])))) {
                            $result['status'] = 1;
                            $result['message'] = 'Autenticación correcta';
                            $result['c4gon'] = $usersapp->getUser();
                            $_SESSION['USUARIO'] = $usersapp->getUser();
                        } else {
                            $result['exception'] = 'Contraseña incorrecta';
                            $result['cagad4'] = 1;
                            $result['c4gon'] = $usersapp->getUser();
                        }
                    } else {
                        $result['cagad4'] = 0;
                        $result['exception'] = 'Usuario incorrecto';
                    }
                break;
            /*Acción a realizar cuando se quiera iniciar sesión 2*/
            case 'loginwe':
                $_POST = $usersapp->validateForm($_POST);
                if(isset($_SESSION['USUARIO'])){
                    if( $_SESSION['USUARIO'] == strip_tags(htmlspecialchars($_POST['txt_usuario'])) ){
                        if ( $usersapp->checkAlias(strip_tags(htmlspecialchars($_POST['txt_usuario'])))) {
                            if ( $usersapp->checkEmail(strip_tags(htmlspecialchars($_POST['txt_correo'])))) {
                                $_SESSION['ROWID'] = $usersapp->getId();
                                $_SESSION['USER_ID'] = $usersapp->getUser();
                                $_SESSION['CORREO'] = $usersapp->getCorreo();
                                $_SESSION['LEVEL'] = $usersapp->getLevel();
                                $result['status'] = 1;
                                $result['message'] = 'Autenticación correcta';
                                unset($_SESSION['USUARIO']);
                            } else {
                                $result['exception'] = 'Correo incorrecto';
                                $result['cagad4'] = 1;
                                $result['c4gon'] = $usersapp->getUser();
                            }
                        } else {
                            $result['cagad4'] = 2;
                            $result['exception'] = 'Usuario incorrecto';
                            $result['c4gon'] = $_SESSION['USUARIO'];
                        }
                    }else{
                        $result['cagad4'] = 2;
                        $result['exception'] = 'El usuario ingresado es diferente al que se está intentando dar acceso';
                        $result['c4gon'] = $_SESSION['USUARIO'];
                    }
                }else{
                    $result['cagad4'] = 3;
                    $result['exception'] = 'Como si no veía venir lo que querias hacer, c3rotón';
                }
                break;
                case 'primerpaso':
                    $_POST = $usersapp->validateForm($_POST);
                        if ( $usersapp->setUser(strip_tags(htmlspecialchars($_POST['txt_usuario']))) ) {
                            if ( $usersapp->setCorreo(strip_tags(htmlspecialchars($_POST['txt_correo_usuario']))) ) {
                                if ( $result['dataset'] = $usersapp->verificarCuenta() ) {
                                    $nombreusuariointento = $usersapp->getUser();
                                    $correousuario = $usersapp->getCorreo();
                                    $contrasena = $usersapp->getPassword();
                                    $result['status'] = 1;
                                    $result['message'] = 'Datos correctos, verifique el correo ingresado para realizar el paso 2';
                                    $result['code'] = $usersapp->enviarCorreo( $correousuario , $nombreusuariointento );                                    
                                } else {
                                    $result['exception'] = 'No coinciden los datos';
                                }    
                            } else {
                                $result['exception'] = 'Correo incorrecto';
                            }                          
                        } else {
                            $result['exception'] = 'Usuario incorrecto';
                        }
                    break;
                    case 'segundopaso':
                        $_POST = $usersapp->validateForm($_POST);
                            if ( $usersapp->setCodigo(strip_tags(htmlspecialchars($_POST['txt_codigo']))) ) {
                                if ( $_POST['txt_codigo'] == $_POST['txt_codigo2'] ) {
                                    if ( $_POST['txt_codigo'] >= 100000 && $_POST['txt_codigo'] <= 999999 ) {
                                        if( $_POST['txt_codigo'] == $_POST['micodigo']) {
                                            $result['status'] = 1;
                                            $result['message'] = 'Datos correctos, puede cambiar su contraseña';
                                        } else {
                                            $result['exception'] = 'El código es distinto al enviado';
                                        }
                                    } else {
                                        $result['exception'] = 'El código no es válido';
                                    }
                                } else {
                                    $result['exception'] = 'Los valores ingresados son distintos';
                                }                          
                            } else {
                                $result['exception'] = 'Código incorrecto';
                            }
                        break;
                        case 'tercerpaso':
                            $_POST = $usersapp->validateForm($_POST);
                                if( $_POST['contra1'] == $_POST['contra2'] ){
                                    if(!(password_verify($_POST['contra1'], $_POST['contra']))){
                                        if( $_POST['contra1'] != $_POST['usuario'] ){
                                            if($usersapp->setPassword(strip_tags(htmlspecialchars($_POST['contra1'])))) {
                                                if($usersapp->setUser(strip_tags(htmlspecialchars($_POST['usuario'])))) {
                                                    if($usersapp->updatePasswordUser()){
                                                        $result['status'] = 1;
                                                        $result['message'] = 'Contraseña actualizada';
                                                    }else{
                                                        $result['exception'] = Conexion::getException();
                                                    }
                                                }else{
                                                    $result['exception'] = 'Usuario incorrecto';
                                                }
                                            }else{
                                                $result['exception'] = 'Contraseña incorrecta';
                                            }
                                        }else{
                                            $result['exception'] = 'Contraseña identica al nombre de usuario';
                                        }
                                    }else{
                                        $result['exception'] = 'Contraseña identica a la anterior';
                                    }
                                }else{
                                    $result['exception'] = 'Las contraseñas ingresadas son distintas';
                                }
                            break;
                case 'ridal':
                    if ( $result['dataset'] = $usersapp->readUser() ) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen usuarios';
                    } else {
                        $result['exception'] = 'No hay usuarios registrados';
                    }
                    break;
                    case 'registrarse':
                        $_POST = $usersapp->validateForm($_POST);
                        // Se sanea el valor del token para evitar datos maliciosos.
                 $token = filter_input(INPUT_POST, 'g-recaptcha-response', FILTER_SANITIZE_STRING);
                 if ($token) {
                     $secretKey = '6LdBzLQUAAAAAL6oP4xpgMao-SmEkmRCpoLBLri-';
                     $ip = $_SERVER['REMOTE_ADDR'];
 
                     $data = array(
                         'secret' => $secretKey,
                         'response' => $token,
                         'remoteip' => $ip
                     );
 
                     $options = array(
                         'http' => array(
                             'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                             'method'  => 'POST',
                             'content' => http_build_query($data)
                         ),
                         'ssl' => array(
                             'verify_peer' => false,
                             'verify_peer_name' => false
                         )
                     );
 
                     $url = 'https://www.google.com/recaptcha/api/siteverify';
                     $context  = stream_context_create($options);
                     $response = file_get_contents($url, false, $context);
                     $captcha = json_decode($response, true);
 
                     if ($captcha['success']) {
                        if($usersapp->setCorreo(strip_tags(htmlspecialchars($_POST['txt_correo_usuario'])))){
                            if($usersapp->setUser(strip_tags(htmlspecialchars($_POST['txt_usuario'])))){
                                if( $_POST['txt_contraseña_usuario'] == $_POST['txt_contraseña_usuario2'] ) {
                                  if($usersapp->setPassword(strip_tags(htmlspecialchars($_POST['txt_contraseña_usuario'])))){
                                      if ( $_POST['txt_contraseña_usuario'] != $_POST['txt_usuario'] ) {
                                          /*La S de setLevel es para un usuario de nivel SuperAdministrador*/
                                            if($usersapp->setLevel(strip_tags(htmlspecialchars('S')))) {
                                                if($usersapp->registrarUsuario()){
                                                    $result['status'] = 1;
                                                    $result['message'] = 'Usuario agregado correctamente';
                                                    }else {
                                                    $result['exception'] = Conexion::getException();
                                                    }   
                                            }else{
                        
                                            }
                                      } else {
                                        $result['exception'] = 'Contraseña identica al nombre de usuario';
                                      }
                                  }else {
                                    $result['exception'] = 'Contraseña incorrecta';
                                  }
                                } else {
                                  $result['exception'] = 'Las contraseñas no coinciden';
                                }
                            }else {
                              $result['exception'] = 'Usuario incorrecto';
                            }
                        }else {
                          $result['exception'] = 'Correo incorrecto';
                        }
            }else{
                $result['exception'] = '.l. hasta un bot de youtube es mejor que vos, hijo de un camión lleno de pvt4s'; 
            }
        }else{
            $result['exception'] = 'Ocurrió un problema al cargar el reCAPTCHA';
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