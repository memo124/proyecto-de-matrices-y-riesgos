/*Función que se ejecuta cuando el documento cargo completamente*/
$(document).ready(function() {
    eliminarSesionLogin()
});

/* Constantes que sirve para establecer la comunicación con la API a utilizar.*/
const RUTA_API = '../../core/api/Usersapp.php?action=';

function  eliminarSesionLogin(){
    var ruta = window.location.pathname;
    if( ruta != '/Matrices/ExpoTecnica/views/Sitio/index2.php' ){
        $.ajax({
            dataType: 'json',
            url: RUTA_API + 'EliminarVariableLogin'
        })
        .done(function( response ) {
            // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje de error.
            if ( response.status ) {
                console.log(response.message);
            } else {
                console.log( response.exception);
            }
        })
        .fail(function( jqXHR ) {
            // Se verifica si la API ha respondido para mostrar la respuesta, de lo contrario se presenta el estado de la petición.
            if ( jqXHR.status == 200 ) {
                console.log( jqXHR.responseText );
            } else {
                console.log( jqXHR.status + ' ' + jqXHR.statusText );
            }
        });
    }
}
