// Método que se ejecutará está listo el documento.
$( document ).ready(function() {
    /*Se llama al método que verifica si hay usuarios ingresados antes de iniciar sesión y se
    ubica en el archivo cuenta.js*/
    checkUsuarios();
});

/*Método que verifica si hay usuarios registrados antes de iniciar sesión*/
function checkUsuarios()
{
    $.ajax({
        dataType: 'json',
        url: API + 'ridal'
    })
    .done(function( response ) {
        /*Acá se obtiene la ruta del documento en el servidor web*/
        let current = window.location.pathname;
        console.log(current);
        /*Se evalua si la página actual es registrarse.php, sino sería index.php*/
        if ( current == '/Matrices/ExpoTecnica/views/Sitio/Registrarse.php' ) {
            // Si hay al menos un usuario registrado se enviará a iniciar la sesión, sino se enviará a registrar el primer usuario.
            if ( response.status ) {
                sweetAlert( 3, response.message, 'Index.php' );
                /*Si en algun dado caso el profe dice que quitemos el mensaje, 
                descomentar la linea que está abajo para que te mande al login*/
                /*location.href = '/Matrices/ExpoTecnica/views/Sitio/Index.php';*/
            } else {
                sweetAlert( 4, 'Debe crear un usuario para comenzar', null );
            }
        } else {
            // Si hay al menos un usuario registrado se enviará a iniciar la sesión, sino se enviará a registrar el primer usuario.
            if ( response.status ) {
                sweetAlert( 4, 'Debe autentificarse para ingresar', null );
            } else {
                sweetAlert( 3, response.exception, 'Registrarse.php' );
            }
        }
    })
    .fail(function( jqXHR ) {
        /*Se evalua si la API respondio y se muestra el resultado de la respuesta,
         sino se muestra el resultado por consola*/
        if ( jqXHR.status == 200 ) {
            console.log( jqXHR.responseText );
        } else {
            console.log( jqXHR.status + ' ' + jqXHR.statusText );
        }
    });
}

var valor_usuario = '';

function setUsuario( usuario ){
    valor_usuario = usuario;
}

function getUsuario(){
    return valor_usuario;
}