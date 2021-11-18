// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_USUARIOS = '../../core/api/Usersapp.php?action=';

// Método que se ejecuta cuando el documento está listo.
$( document ).ready(function() {
    // Se llama a la función que verifica la existencia de usuarios. Se encuentra en el archivo account.js
    checkUsuarios();
    grecaptcha.ready(function() {
        // Se declara e inicializa una variable para guardar la llave pública del reCAPTCHA.
        let publicKey = '6LdBzLQUAAAAAJvH-aCUUJgliLOjLcmrHN06RFXT';
        // Se obtiene un token para la página web mediante la llave pública.
        grecaptcha.execute( publicKey, { action: 'homepage' } )
        .then(function( token ) {
            // Se asigna el valor del token al campo oculto del formulario
            $( '#g-recaptcha-response' ).val( token );
        });
    });
});

// Evento para registrar el primer usuario del sitio privado.
$( '#Registrarse' ).submit(function( event ) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    $.ajax({
        type: 'post',
        url: API_USUARIOS + 'registrarse',
        data: $( '#Registrarse' ).serialize(),
        dataType: 'json'    
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje de error.
        if ( response.status ) {
            sweetAlert( 1, response.message, 'index.php' );
        } else {
            sweetAlert( 2, response.exception, null );
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
});