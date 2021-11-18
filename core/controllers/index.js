/* Constantes que sirve para establecer la comunicación con la API a utilizar.*/
const API_USERSAPP = '../../core/api/Usersapp.php?action=';
var usuario = '',
    intentos = 0,
    usuarios = [];

// Evento que sirve para la validacion del usuario cuando se iniciará sesión.
$( '#Iniciar_Sesion' ).submit(function( event ) {
        //se evita que se recargue la página cuando se envie el formulario.
    event.preventDefault();
    $.ajax({
        type: 'post',
        url: API_USERSAPP + 'login',
        data: $( '#Iniciar_Sesion' ).serialize(),
        dataType: 'json'
    })
    .done(function( response ) {
        /*Se evalua si la API respondio como se esperaba, sino se muestra un mensaje de error*/
        if ( response.status ) {
            /*Si fue exitosa la consulta se enviará el mensaje de autentificación correcta
            y se enviará a la página principal (Matrices.php)*/
            sweetAlert( 1, response.message, 'index2.php' );
        } else {
            $( '#txt_usuario' ).val('');
            $( '#txt_contraseña' ).val('');
            if (response.cagad4 == 1) {
            /*Si no fue exitosa la consulta se enviará el mensaje de error*/
            sweetAlert( 2, response.exception, null );
            usuarios.push(response.c4gon);
            usuario = response.c4gon;
                for (let index = 0; index < usuarios.length; index++) {
                    if( usuarios[index] == usuario ){
                        intentos++;
                        if ( intentos > 3 ) {
                            banearP3ndejo( usuario );
                            intentos = 0;
                        } 
                    } 
                }
            intentos = 0;
            } else {
             /*Si no fue exitosa la consulta se enviará el mensaje de error*/
            sweetAlert( 2, response.exception, null );   
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
});

// Evento que sirve para la validacion del usuario cuando se iniciará sesión.
$( '#Iniciar_Sesion2' ).submit(function( event ) {
    //se evita que se recargue la página cuando se envie el formulario.
event.preventDefault();
$.ajax({
    type: 'post',
    url: API_USERSAPP + 'loginwe',
    data: $( '#Iniciar_Sesion2' ).serialize(),
    dataType: 'json'
})
.done(function( response ) {
    /*Se evalua si la API respondio como se esperaba, sino se muestra un mensaje de error*/
    if ( response.status ) {
        /*Si fue exitosa la consulta se enviará el mensaje de autentificación correcta
        y se enviará a la página principal (Matrices.php)*/
        sweetAlert( 1, response.message, 'Matrices.php' );
    } else {
        $( '#txt_usuario' ).val('');
        $( '#txt_correo' ).val('');
        if (response.cagad4 == 1) {
            usuario = response.c4gon;
            intentos++;
                if ( intentos > 3 ) {
                    banearP3ndejo2( usuario );
                    intentos = 0;
                } else {
                    /*Si no fue exitosa la consulta se enviará el mensaje de error*/
                    sweetAlert( 2, response.exception, null );
                }
        } else if(response.cagad4 == 2) {
            usuario = response.c4gon;
            intentos++;
                if ( intentos > 3 ) {
                    banearP3ndejo2( usuario );
                    intentos = 0;
                } else{
                    /*Si no fue exitosa la consulta se enviará el mensaje de error*/
                    sweetAlert( 2, response.exception, null );
                }  
        } else if(response.cagad4 == 3){
            /*Si no fue exitosa la consulta se enviará el mensaje de error*/
            sweetAlert( 2, response.exception, 'index.php' );
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
});


function banearP3ndejo( usuario ){
    $.ajax({
        type: 'post',
        url: API_USERSAPP + 'banearP3ndejo',
        data: { usuario : usuario },
        dataType: 'json'
    })
    .done(function( response ) {
        /*Se evalua si la API respondio como se esperaba, sino se muestra un mensaje de error*/
        if ( response.status ) {
            /*Si fue exitosa la consulta se enviará el mensaje de autentificación correcta
            y se enviará a la página principal (Matrices.php)*/
            sweetAlert( 2, response.message, null);
            /*location.href = '/Matrices/ExpoTecnica/views/Sitio/index.php';*/
        } else {
            /*Si no fue exitosa la consulta se enviará el mensaje de error*/
            sweetAlert( 2, response.exception, null );
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

function banearP3ndejo2( usuario ){
    $.ajax({
        type: 'post',
        url: API_USERSAPP + 'banearP3ndejo',
        data: { usuario : usuario },
        dataType: 'json'
    })
    .done(function( response ) {
        /*Se evalua si la API respondio como se esperaba, sino se muestra un mensaje de error*/
        if ( response.status ) {
            /*Si fue exitosa la consulta se enviará el mensaje de autentificación correcta
            y se enviará a la página principal (Matrices.php)*/
            sweetAlert( 2, response.message, 'index.php');
            /*location.href = '/Matrices/ExpoTecnica/views/Sitio/index.php';*/
        } else {
            /*Si no fue exitosa la consulta se enviará el mensaje de error*/
            sweetAlert( 2, response.exception, 'index.php' );
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