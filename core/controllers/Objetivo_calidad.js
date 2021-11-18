

$(document).ready(function(){ 
  readRows( API_OBJETIVOS_CALIDAD );
});

  const API_OBJETIVOS_CALIDAD = '../../core/api/Objetivos_calidad.php?action=';

  //llenar tabla automaticamente.
  function fillTable(dataset)
  {      
    let content = '';
    dataset.forEach(function(row) 
    {
      content += `
            <tr>
                <td>${row.rowid}</td>
                <td>${row.objetivocalidad_id}</td>
                <td>${row.descripcion}</td>
                <td>${row.palabra_clave}</td>
                <td>
                <a href="#" onclick="AbrirVentanaModificarOC(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light cyan blue-text tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                <a href="#" onclick="openDeleteDialog(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light red red-text tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                <a href="../../core/reports/objetivos1.php?objetivo_id=${row.objetivocalidad_id}"  target="_blank" class="z-depth-3 btn-floating btn-medium waves-effect waves-light blue-grey blue-text tooltipped" data-tooltip="Reporte de indicadores de este objetivo de calidad"><i class="material-icons">assignment</i></a>
                <a href="#" onclick="abrirModalReporte( ${row.objetivocalidad_id} )" class="z-depth-3 btn-floating btn-medium waves-effect waves-light blue-grey blue-text tooltipped" data-tooltip="Gráfico de indicadores por proceso de este objetivo"><i class="material-icons">pie_chart</i></a>
              </td>
            </tr>
        `;  
      $('#cuerpotablaOC').html(content);
      $( '.materialboxed' ).materialbox();
      $( '.tooltipped' ).tooltip();
    });
  }

  //crear objetivo calidad.
  $('#save-form-1').submit(function(event){
    event.preventDefault();
    if($('#txtRowid').val())
    {
      saveRow(API_OBJETIVOS_CALIDAD,'update',this,'save-modal-1');
    }
    else
    {
      saveRow(API_OBJETIVOS_CALIDAD,'create',this,'save-modal-1');
    }
  });

  /*Método que invocará al método que genera un gráfico si el parámetro cumple con las condiciones
  de los filtros*/
  function abrirModalReporte( id_objetivo )
   {
       if ( id_objetivo != '' && isNaN(id_objetivo) == false && 
            isFinite(id_objetivo) == true && id_objetivo > 0 ) {
          //Creación de la consulta AJAX
        $.ajax({
            dataType: 'json',
            url: API_OBJETIVOS_CALIDAD + 'graficoIndicadores',
            data: { objetivocalidad_id : id_objetivo },
            type: 'post'
          })
        .done(function( response ) {
          /* Se evalua si la API respondió correctamente y retorno datos, sino se 
          mostrara un mensaje de error.*/
          if ( response.status ) {
              //Se crean los arreglos para guardar los datos que requiere el gráfico.
              let proceso = [];
              let cantidad = [];
              // Se recorre el conjunto de registros (dataset) por cada fila a través del objeto row.
              response.dataset.forEach(function( row ) {
                //Se envian los datos a los arreglos
                proceso.push( row.descripcion );
                cantidad.push( row.cantidadindicadores );
                $( '#grafico-title' ).text( 'Objetivo: '+row.palabra_clave );
              });
              //Se invoca al método que crea una gráfica. Se ubica en el archivo components.js
              generarGrafico( 2 ,'grafico1', cantidad, proceso, 'Proceso', 'Indicadores por proceso, según objetivo' );
          } else {
              /*Se elimina el canvas del documento si no respondió correctamente la API y no retorno datos*/
              $( '#grafico1' ).remove();
              sweetAlert( 2, response.exception, null );
            }
        })
      .fail(function( jqXHR ) {
          // Se evalua si la API respondió para mostrar la respuesta, sino se presenta el estado de la consulta AJAX.
          if ( jqXHR.status == 200 ) {
              console.log( jqXHR.responseText );
          } else {
              console.log( jqXHR.status + ' ' + jqXHR.statusText );
          }
      });
       } else {
          sweetAlert( 2, 'Jodete tramposo .l.', null );
       }
   }

  //mostrar cuadros de dialogos
     function AbrirVentanaModificarOC( id )
     {
       $( '#save-form-1' )[0].reset();
       $( '#save-modal-1' ).modal( 'open' );
       $( '#modal-title-1' ).text( 'Modificar objetivo de calidad' );
       
       $.ajax({
        dataType: 'json',
        url: API_OBJETIVOS_CALIDAD + 'get',
        data: { rowid : id },
        type: 'post'
        })
        .done(function( response ) {
          if ( response.status ) {
              $( '#txtRowid' ).val( response.dataset.rowid);
              $( '#txtObjetivoCalidad' ).val( response.dataset.objetivocalidad_id );
              $( '#txtDescripcion' ).val( response.dataset.descripcion );
              $( '#txtPalabraClave' ).val( response.dataset.palabra_clave );
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

     function AbrirVentanaCrearOC()
  {
      $( '#save-form-1' )[0].reset();
      $( '#save-modal-1' ).modal( 'open' );
      $( '#modal-title-1' ).text( 'Agregar objetivo de calidad' );
  }

    function openDeleteDialog( id )
  {
    let identifier = { rowid: id };
    confirmDelete( API_OBJETIVOS_CALIDAD, identifier );
  }


  // Evento que sirve para mostrar los resultados de una búsqueda.
$( '#searchuser' ).submit(function( event ) {
  //se evita recargar la página cuando se envia el formulario
  event.preventDefault();
  /*Se llama a la función que realiza las busquedas,
  recibe por parametros la API y el formulario y se ubica en el archivo components.js*/
  searchRows( API_OBJETIVOS_CALIDAD, this );
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
      url: API_OBJETIVOS_CALIDAD + 'search',
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
    readRows( API_OBJETIVOS_CALIDAD );
  }
})





