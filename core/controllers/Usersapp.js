// Método que se ejecutará está listo el documento.
$(document).ready(function(){ 
  readRows( API_USERAPP );
});
  /* Constantes que sirve para establecer la comunicación con la API a utilizar.*/
  const API_USERAPP = '../../core/api/Usersapp.php?action=';

  // Función que sirve para rellenar la tabla de la página.
  function fillTable(dataset)
  {   
    //se crea una variable que almacenará las filas a agregar al cuerpo de la tabla   
    let content = '';
    // Se recorren los registros (dataset) con el uso del objeto (row).
    dataset.forEach(function(row) 
    {
      // Se crean y concatenan las filas de la tabla con los datos enviados por la API
      content += `
            <tr>
                <td>${row.rowid}</td>
                <td>${row.user_id}</td>
                <td>${row.level}</td>
                <td>${row.correo}</td>
                <td>${row.estado}</td>
                <td>
                  <a href="#" onclick="AbrirVentanaModificarUA(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light cyan blue-text tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                  <a href="#" onclick="openDeleteDialog(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light red red-text tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                </td>
            </tr>
        `;  
      //se envia la variable que contiene las filas al cuerpo de la tabla
      $('#cuerpotablaUA').html(content);
      //se inicia el componente Tooltip que contienen los botones de actualizar y eliminar
      $( '.tooltipped' ).tooltip();
    });
  }

  // Evento que sirve para agregar o actualizar un dato.
  $('#save-form-1').submit(function(event){
    //se evita que se recargue la página cuando se envie el formulario.
    event.preventDefault();
    // Se llama a la función que agrega o actualiza un dato y se puede encontrar en el archivo components.js
    /*Se evalua si el campo oculto del formulario tiene un valor, si tiene un valor se actualizara un dato 
    sino se agregara un dato*/
    if($('#rowid').val())
    {
      saveRow(API_USERAPP,'update',this,'save-modal-1');
    }
    else
    {
      saveRow(API_USERAPP,'create',this,'save-modal-1');
    }
  });

//Función que prepara el formulario cuando se quiera actualizar un dato.
     function AbrirVentanaModificarUA( id )
     {
       //Se limpian todos los campos del formulario.
       $( '#save-form-1' )[0].reset();
       //Se abre la ventana modal qur sirve para modificar un dato.
       $( '#save-modal-1' ).modal( 'open' );
       //Se le asigna un titulo a la ventana modal.
       $( '#modal-title-1' ).text( 'Modificar usuario' );
       //Se deshabilita el campo de contraseña
       $( '#txt_password' ).prop( 'disabled', true );
       $( '#txt_password2' ).prop( 'disabled', true );
      //Se crea la consulta AJAX para actualizar un dato
       $.ajax({
        dataType: 'json',
        url: API_USERAPP + 'get',
        data: { rowid : id },
        type: 'post'
        })
        .done(function( response ) {
          /*Se evalua si la API respondio como se esperaba, sino se muestra un mensaje de error*/
          if ( response.status ) {
            //Se inician los campos del formulario con los datos del registro elegido a actualizar
              $( '#rowid' ).val( id );
              $( '#txt_usuario' ).val( response.dataset.user_id );
              $( '#txt_nivel' ).val( response.dataset.level );
              $( '#txt_correo' ).val( response.dataset.correo );
              $( '#txt_estado' ).val( response.dataset.estado );
              M.updateTextFields();
          } else {
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

     // Función que prepara el formulario cuando se quiera agregar un dato
     function AbrirVentanaCrearUA()
  {
      $( '#save-form-1' )[0].reset();
      $( '#save-modal-1' ).modal( 'open' );
      $( '#modal-title-1' ).text( 'Agregar usuario' );
      $( '#txt_password' ).prop( 'disabled', false );
      $( '#txt_password2' ).prop( 'disabled', false );
  }

  // Función para establecer el dato que se quiera eliminar, recibiendo por parametro el ID
    function openDeleteDialog( id )
  {
     // Se declara e inicia un objeto que será igual al parametro recibido.
    let identifier = { user_id: id };
    confirmDelete( API_USERAPP, identifier );
  }


  
// Evento que sirve para mostrar los resultados de una búsqueda.
$( '#searchuser' ).submit(function( event ) {
  //se evita recargar la página cuando se envia el formulario
  event.preventDefault();
  /*Se llama a la función que realiza las busquedas,
  recibe por parametros la API y el formulario y se ubica en el archivo components.js*/
  searchRows( API_USERAPP, this );
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
      url: API_USERAPP + 'search',
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
    readRows( API_USERAPP );
  }
})