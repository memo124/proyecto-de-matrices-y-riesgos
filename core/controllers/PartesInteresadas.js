$(document).ready(function(){ 
  readRows( API_PARTES );
});

  const API_PARTES = '../../core/api/PartesInteresadas.php?action=';
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
                <td>${row.parte_interesada_id}</td>
                <td>${row.descripcion}</td>
                <td>${row.descrip}</td>
                <td>${row.requisito_identificado}</td>
                <td>${row.last_user}</td>
                <td>
                  <a href="#" onclick="AbrirVentanaModificarPI(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light cyan blue-text tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                  <a href="#" onclick="openDeleteDialog(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light red red-text tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                </td>
            </tr>
        `;  
      $('#cuerpotablaPI').html(content);
      $('.tooltipped' ).tooltip();
    });
  }

  //crear usuario.
$('#partesinteresadas').submit(function(event){
  var proceso = document.getElementById('cb_proceso'),
        index_proceso = proceso.selectedIndex,
        opcion_proceso1 = proceso.options[index_proceso],
        opcionproceso = opcion_proceso1.text,
        valor_parte = document.getElementById('txt_parte_interesada').value,
        valor_descripcion = document.getElementById('textarea_descripcion').value,
        valor_requisito = document.getElementById('textarea_requisito').value,
        valor_user = document.getElementById('txt_lastuser').value,
        valor_id = document.getElementById('id_parte').value;
        event.preventDefault();
  if ( $('#id_parte').val() ) {
    $.ajax({
      type: 'post',
      url: API_PARTES + 'update',
      data: { id_parte : valor_id , partes : valor_parte , proceso : opcionproceso , descripcion : valor_descripcion , requisitos : valor_requisito , user : valor_user } ,
      dataType: 'json'
    })
    .done(function( response ) {
      if ( response.status ) {
          readRows( API_PARTES );
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
      url: API_PARTES + 'create',
      data: { partes : valor_parte , proceso : opcionproceso , descripcion : valor_descripcion , requisitos : valor_requisito , user : valor_user } ,
      dataType: 'json'
    })
    .done(function( response ) {
        if ( response.status ) {
            readRows( API_PARTES );
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
   
   function AbrirVentanaCrearPI()
   {
       $( '#partesinteresadas' )[0].reset();
       $( '#save-modal-2' ).modal( 'open' );
       $( '#modal-title-1' ).text( 'Agregar parte interesada' );
       fillSelect( API_PROCESOS, 'cb_proceso', null );
   }
   
   function AbrirVentanaModificarPI( id )
   {
    $( '#partesinteresadas' )[0].reset();
    $( '#save-modal-2' ).modal( 'open' );
    $( '#modal-title-1' ).text( 'Modificar Parte interesada' );

    $.ajax({
    dataType: 'json',
    url: API_PARTES + 'get',
    data: { id_parte : id },
    type: 'post'
    })
    .done(function( response ) {
      if ( response.status ) {
          $( '#id_parte' ).val( response.dataset.rowid );
          $( '#txt_parte_interesada' ).val( response.dataset.parte_interesada_id );
          $( '#textarea_descripcion' ).val( response.dataset.descripcion );
          $( '#textarea_requisito' ).val( response.dataset.requisito_identificado );
          $( '#txt_lastuser' ).val( response.dataset.last_user );
          fillSelect( API_PROCESOS, 'cb_proceso', response.dataset.proceso_id );
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

  function openDeleteDialog( id )
  {
    let identifier = { id_parte : id };
    confirmDelete(API_PARTES, identifier);
  }
   
// Evento que sirve para mostrar los resultados de una búsqueda.
$( '#searchuser' ).submit(function( event ) {
  //se evita recargar la página cuando se envia el formulario
  event.preventDefault();
  /*Se llama a la función que realiza las busquedas,
  recibe por parametros la API y el formulario y se ubica en el archivo components.js*/
  searchRows( API_PARTES, this );
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
      url: API_PARTES + 'search',
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
    readRows( API_PARTES );
  }
})