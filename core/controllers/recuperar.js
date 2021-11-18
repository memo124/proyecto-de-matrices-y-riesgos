// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_USUARIOS = '../../core/api/Usersapp.php?action=';

var Paso1 = document.getElementById('divpaso1'),
    Paso2 = document.getElementById('divpaso2'),
    Paso3 = document.getElementById('divpaso3'),
    usuario = '',
    contra = '',
    codigo = 0;

// Evento para validar el usuario al momento de iniciar sesión.
$( '#Paso1' ).submit(function( event ) {
  // Se evita recargar la página web después de enviar el formulario.
  event.preventDefault();
  $.ajax({
      type: 'post',
      url: API_USUARIOS + 'primerpaso',
      data: $( '#Paso1' ).serialize(),
      dataType: 'json'
  })
  .done(function( response ) {
      // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje de error.
      if ( response.status ) {
          Paso1.style.display = 'none';
          Paso2.style.display = 'inline-block';
          usuario = response.dataset.user_id;
          contra = response.dataset.password;
          codigo = response.code;
          console.log(codigo);
          console.log(contra);
          console.log(usuario);
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

// Evento para validar el usuario al momento de iniciar sesión.
$( '#Paso2' ).submit(function( event ) {
    var codigo1 = document.getElementById('txt_codigo').value,
        codigo2 = document.getElementById('txt_codigo2').value;
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    $.ajax({
        type: 'post',
        url: API_USUARIOS + 'segundopaso',
        data: { txt_codigo : codigo1 , txt_codigo2 : codigo2 , micodigo : codigo },
        dataType: 'json'
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje de error.
        if ( response.status ) {
            Paso2.style.display = 'none';
            Paso3.style.display = 'inline-block';
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

  $( '#Paso3' ).submit(function( event ) {
    var contra1 = document.getElementById('txt_contraseña_usuario').value,
        contra2 = document.getElementById('txt_contraseña_usuario2').value;
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    $.ajax({
        type: 'post',
        url: API_USUARIOS + 'tercerpaso',
        data: { contra1 : contra1 , contra2 : contra2 , contra : contra, usuario : usuario },
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