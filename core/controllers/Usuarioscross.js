$(document).ready(function(){ 
  readRows( API_USERCROSS );
});

  const API_USERCROSS = '../../core/api/Usuarioscross.php?action=';
  const API_USERSAPP = '../../core/api/Usersapp.php?action=readwe';
  const API_PROCESOS = '../../core/api/Procesos.php?action=readwe';

  //llenar tabla automaticamente.
  function fillTable(dataset)
  {      
    let content = '';
    dataset.forEach(function(row) 
    {
      content += `
            <tr>
                <td>${row.rowid}</td>
                <td>${row.user_id}</td>
                <td>${row.descripcion}</td>
                <td>${row.rol}</td>
                <td>
                  <a href="#" onclick="AbrirVentanaModificarUC(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light cyan blue-text tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                  <a href="#" onclick="openDeleteDialog(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light red red-text tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                </td>
            </tr>
        `;  
      $('#cuerpotablaUC').html(content);
      $( '.tooltipped' ).tooltip();
    });
  }

  //crear usuario.
  $('#Cargo').submit(function(event){
    var usuario = document.getElementById('cb_usuario'),
          proceso = document.getElementById('cb_proceso'),
          index_usuario = usuario.selectedIndex,
          index_proceso = proceso.selectedIndex,
          opcion_usuario1 = usuario.options[index_usuario],
          opcion_proceso1 = proceso.options[index_proceso],
          opcionusuario = opcion_usuario1.text,
          opcionproceso = opcion_proceso1.text,
          valor_rol = document.getElementById('txt_rol').value,
          /*alert(""+opcion_usuario+"    "+opcion_proceso+"");*/
          valor_id = document.getElementById('id_cargo').value;
    event.preventDefault();
    if ( $('#id_cargo').val()) {
      $.ajax({
        type: 'post',
        url: API_USERCROSS + 'update',
        data: { id_cargo : valor_id , usuario : opcionusuario , proceso : opcionproceso , rol : valor_rol } ,
        dataType: 'json'
    })
    .done(function( response ) {
        if ( response.status ) {
            readRows( API_USERCROSS );
            sweetAlert( 1, response.message, null );
        } else {
            sweetAlert( 2, response.exception, null );
        }
    })
    .fail(function( jqXHR ) {
        // Se verifica si la API ha respondido y se muestra el resultado, de lo contrario se presenta el estado de la petición.
        if ( jqXHR.status == 200 ) {
            console.log( jqXHR.responseText );
        } else {
            console.log( jqXHR.status + ' ' + jqXHR.statusText );
        }
    });
    } else {
        $.ajax({
          type: 'post',
          url: API_USERCROSS + 'create',
          data: { usuario : opcionusuario , proceso : opcionproceso , rol : valor_rol } ,
          dataType: 'json'
      })
      .done(function( response ) {
          if ( response.status ) {
              readRows( API_USERCROSS );
              sweetAlert( 1, response.message, null );
          } else {
              sweetAlert( 2, response.exception, null );
          }
      })
      .fail(function( jqXHR ) {
          // Se verifica si la API ha respondido y se muestra el resultado, de lo contrario se presenta el estado de la petición.
          if ( jqXHR.status == 200 ) {
              console.log( jqXHR.responseText );
          } else {
              console.log( jqXHR.status + ' ' + jqXHR.statusText );
          }
      });
    }
  });

  //mostrar cuadros de dialogos
     function AbrirVentanaModificarUC( id )
     {
       $( '#Cargo' )[0].reset();
       $( '#save-modal-1' ).modal( 'open' );
       $( '#modal-title-1' ).text( 'Modificar cargo de usuario' );
        document.getElementById('id_cargo').value = id;
       $.ajax({
        dataType: 'json',
        url: API_USERCROSS + 'get',
        data: { id_cargo : id },
        type: 'post'
        })
        .done(function( response ) {
          if ( response.status ) {
              fillSelect( API_USERSAPP, 'cb_usuario', response.dataset.rowid );
              fillSelect( API_PROCESOS, 'cb_proceso', response.dataset.proceso_id );
              $( '#txt_rol' ).val( response.dataset.rol );
              M.updateTextFields();
          } else {
              sweetAlert( 2, response.exception, null );
          }
    })
    .fail(function( jqXHR ) {
        // Se verifica si la API ha respondido y se muestra el resultado, de lo contrario se presenta el estado de la petición.
        if ( jqXHR.status == 200 ) {
            console.log( jqXHR.responseText );
        } else {
            console.log( jqXHR.status + ' ' + jqXHR.statusText );
        }
    });
     }

     function AbrirVentanaCrearUC()
  {
      $( '#Cargo' )[0].reset();
      $( '#save-modal-1' ).modal( 'open' );
      $( '#modal-title-1' ).text( 'Agregar cargo de usuario' );
      fillSelect( API_USERSAPP, 'cb_usuario', null );
      fillSelect( API_PROCESOS, 'cb_proceso', null );
  }


    function openDeleteDialog( id )
  {
    let identifier = { id_cargo : id };
    confirmDelete( API_USERCROSS, identifier );
  }

// Evento que sirve para mostrar los resultados de una búsqueda.
$( '#searchuser' ).submit(function( event ) {
  //se evita recargar la página cuando se envia el formulario
  event.preventDefault();
  /*Se llama a la función que realiza las busquedas,
  recibe por parametros la API y el formulario y se ubica en el archivo components.js*/
  searchRows( API_USERCROSS, this );
});

/*Se asigna el evento  "ONKEYUP" al campo de buscar del documento, para cuando se escriba una
letra en el campo haga una busqueda en tiempo real*/
$(document).on('keyup','#search', function(){
  /*Se obtiene el valor del campo*/
  var valorcampo = $(this).val();
  /*Se evalua que el campo no esté vació, si no lo está hara una consulta AJAX para hacer una busqueda*/
  if ( valorcampo != '' ) {
    $.ajax({
      dataType: 'json',
      url: API_USERCROSS + 'search',
      data: { search : valorcampo },
      type: 'post'
    })
    .done(function( response ) {
        /*Se evalua si la API respondio como se esperaba, sino se muestra un mensaje de error*/
        if ( response.status ) {
          /*Se llama a la función que llena la tabla con los datos que retorno la API
          ,recibe por parametro los registros*/
          fillTable(response.dataset);
          console.log(response.message+' para '+'"'+valorcampo+'"');
        } else {
          console.log('No se encontraron resultados para "'+valorcampo+'"');
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
  }  /*Si el campo está vacío se llamará a la función que llena la tabla con los datos generales*/ 
    else {
    readRows( API_USERCROSS );
  }
})
