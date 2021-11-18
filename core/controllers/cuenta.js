/* Constantes que sirve para establecer la comunicación con la API a utilizar.*/
const API = '../../core/api/Usersapp.php?action=';

function signOff()
{
    swal({
        title: 'Advertencia',
        text: '¿Quiere cerrar la sesión?',
        icon: 'warning',
        buttons: [ 'No', 'Sí' ],
        closeOnClickOutside: false,
        closeOnEsc: false
    })
    .then(function( value ) {
        // Se verifica si fue cliqueado el botón Sí para hacer la petición de cerrar sesión, de lo contrario se continua con la sesión actual.
        if ( value ) {
            $.ajax({
                dataType: 'json',
                url: API + 'logout'
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
        } else {
            sweetAlert( 4, 'Puede continuar con la sesión', null );
        }
    });
}

// Evento para cambiar la contraseña del usuario que ha iniciado sesión.
$( '#Editar_Contraseña' ).submit(function( event ) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    $.ajax({
        type: 'post',
        url: API + 'password',
        data: $( '#Editar_Contraseña' ).serialize(),
        dataType: 'json'
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje de error.
        if ( response.status ) {
            // Se limpian los campos del formulario.
            $( '#Editar_Contraseña' )[0].reset();
            // Se cierra la caja de dialogo (modal) que contiene el formulario para cambiar contraseña, ubicado en el archivo de las plantillas.
            $( '#CambiarContraseña' ).modal( 'close' );
            sweetAlert( 1, response.message, null );
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