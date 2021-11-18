$(document).ready(function(){ 
  readRows( API_PROCESOS );
});

  const API_PROCESOS = '../../core/api/Procesos.php?action=';

  //llenar tabla automaticamente.
  function fillTable(dataset)
  {      
    let content = '';
    dataset.forEach(function(row) 
    {
      content += `
            <tr>
                <td>${row.rowid}</td>
                <td>${row.proceso_id}</td>
                <td>${row.descripcion}</td>
                <td>
                  <a href="#" onclick="AbrirVentanaModificarPr(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light cyan blue-text tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                  <a href="#" onclick="openDeleteDialog(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light red red-text tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                  <a href="../../core/reports/procesos1.php?proceso_id=${row.proceso_id}"  target="_blank" class="z-depth-3 btn-floating btn-medium waves-effect waves-light blue-grey blue-text tooltipped" data-tooltip="Reporte de usuarios por rol de este proceso"><i class="material-icons">assignment</i></a>
                  <a href="../../core/reports/procesos2.php?proceso_id=${row.proceso_id}"  target="_blank" class="z-depth-3 btn-floating btn-medium waves-effect waves-light blue-grey blue-text tooltipped" data-tooltip="Reporte de usuarios de este proceso"><i class="material-icons">assignment</i></a>
                  <a href="../../core/reports/procesos3.php?proceso_id=${row.proceso_id}"  target="_blank" class="z-depth-3 btn-floating btn-medium waves-effect waves-light blue-grey blue-text tooltipped" data-tooltip="Reporte de correlativos de este proceso"><i class="material-icons">assignment</i></a>
                  <a href="../../core/reports/procesos4.php?proceso_id=${row.proceso_id}"  target="_blank" class="z-depth-3 btn-floating btn-medium waves-effect waves-light blue-grey blue-text tooltipped" data-tooltip="Reporte de indicadores de este proceso"><i class="material-icons">assignment</i></a>
                  <a href="../../core/reports/procesos5.php?proceso_id=${row.proceso_id}"  target="_blank" class="z-depth-3 btn-floating btn-medium waves-effect waves-light blue-grey blue-text tooltipped" data-tooltip="Reporte de partes interesadas de este proceso"><i class="material-icons">assignment</i></a>
                  <a href="#" onclick="abrirModalReporte( ${row.proceso_id} )" class="z-depth-3 btn-floating btn-medium waves-effect waves-light blue-grey blue-text tooltipped" data-tooltip="Gráfico de usuarios de este proceso"><i class="material-icons">equalizer</i></a>
                  <a href="#" onclick="abrirModalReporte2( ${row.proceso_id} )" class="z-depth-3 btn-floating btn-medium waves-effect waves-light blue-grey blue-text tooltipped" data-tooltip="Gráfico de correlativos de este proceso"><i class="material-icons">pie_chart</i></a>
                  <a href="#" onclick="abrirModalReporte3( ${row.proceso_id} )" class="z-depth-3 btn-floating btn-medium waves-effect waves-light blue-grey blue-text tooltipped" data-tooltip="Gráfico de indicadores de este proceso"><i class="material-icons">equalizer</i></a>
                  <a href="#" onclick="abrirModalReporte4( ${row.proceso_id} )" class="z-depth-3 btn-floating btn-medium waves-effect waves-light blue-grey blue-text tooltipped" data-tooltip="Gráfico de partes interesadas de este proceso"><i class="material-icons">pie_chart</i></a>
                </td>
            </tr>
        `;  
      $('#cuerpotablaPr').html(content);
      $('.materialboxed' ).materialbox();
      $('.tooltipped' ).tooltip();
    });
  }

//crear proceso.
$('#save-form-1').submit(function(event){
  event.preventDefault();
  if($('#rowid').val())
  {
    saveRow(API_PROCESOS,'update',this,'save-modal-1');
  }
  else
  {
    saveRow(API_PROCESOS,'create',this,'save-modal-1');
  }
  
});
   
   function AbrirVentanaCrearPr()
   {
       $( '#save-form-1' )[0].reset();
       $( '#save-modal-1' ).modal( 'open' );
       $( '#modal-title-1' ).text( 'Agregar proceso' );
   }

   /*Método que invocará al método que genera un gráfico si el parámetro cumple con las condiciones
  de los filtros*/
   function abrirModalReporte( id_proceso )
   {
       if ( id_proceso != '' && isNaN(id_proceso) == false && 
            isFinite(id_proceso) == true && id_proceso > 0 ) {
          //Creación de la consulta AJAX
        $.ajax({
            dataType: 'json',
            url: API_PROCESOS + 'graficoUsuarios',
            data: { proceso_id : id_proceso },
            type: 'post'
          })
        .done(function( response ) {
          /* Se evalua si la API respondió correctamente y retorno datos, sino se 
          mostrara un mensaje de error.*/
          if ( response.status ) {
              //Se crean los arreglos para guardar los datos que requiere el gráfico.
              let rol = [];
              let cantidad_usuarios = [];
              // Se recorre el conjunto de registros (dataset) por cada fila a través del objeto row.
              response.dataset.forEach(function( row ) {
                //Se envian los datos a los arreglos
                rol.push( row.rol );
                cantidad_usuarios.push( row.usuarios );
                $( '#grafico-title' ).text( 'Proceso: '+row.descrip );
              });
              //Se invoca al método que crea una gráfica. Se ubica en el archivo components.js
              generarGrafico( 0 ,'grafico1', rol, cantidad_usuarios, 'Rol', 'Usuarios de este proceso según rol' );
          } else {
              /*Se elimina el canvas del documento si no respondió correctamente la API y no retorno datos*/
              $( '#grafico1' ).remove();
              sweetAlert( 2 , response.exception , null );
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

  /*Método que invocará al método que genera un gráfico si el parámetro cumple con las condiciones
  de los filtros*/
   function abrirModalReporte2( id_proceso )
   {
       if ( id_proceso != '' && isNaN(id_proceso) == false && 
            isFinite(id_proceso) == true && id_proceso > 0 ) {
          //Creación de la consulta AJAX
        $.ajax({
            dataType: 'json',
            url: API_PROCESOS + 'graficoCorrelativos',
            data: { proceso_id : id_proceso },
            type: 'post'
          })
        .done(function( response ) {
          /* Se evalua si la API respondió correctamente y retorno datos, sino se 
          mostrara un mensaje de error.*/
          if ( response.status ) {
              //Se crean los arreglos para guardar los datos que requiere el gráfico.
              let correlativo = [];
              let cantidad = [];
              // Se recorre el conjunto de registros (dataset) por cada fila a través del objeto row.
              response.dataset.forEach(function( row ) {
                //Se envian los datos a los arreglos
                correlativo.push( row.ultimo_num_utilizado );
                cantidad.push( row.cantidadcorrelativo );
                $( '#grafico-title2' ).text( 'Proceso: '+row.descrip );
              });
              //Se invoca al método que crea una gráfica. Se ubica en el archivo components.js
              generarGrafico( 2 ,'grafico2', cantidad, correlativo, 'Último número utilizado', 'Correlativos según número de este proceso' );
          } else {
              /*Se elimina el canvas del documento si no respondió correctamente la API y no retorno datos*/
              $( '#grafico2' ).remove();
              sweetAlert( 2 , response.exception , null );
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

   /*Método que invocará al método que genera un gráfico si el parámetro cumple con las condiciones
  de los filtros*/
   function abrirModalReporte3( id_proceso )
   {
       if ( id_proceso != '' && isNaN(id_proceso) == false && 
            isFinite(id_proceso) == true && id_proceso > 0 ) {
          //Creación de la consulta AJAX
        $.ajax({
            dataType: 'json',
            url: API_PROCESOS + 'graficoIndicadores',
            data: { proceso_id : id_proceso },
            type: 'post'
          })
        .done(function( response ) {
          /* Se evalua si la API respondió correctamente y retorno datos, sino se 
          mostrara un mensaje de error.*/
          if ( response.status ) {
              //Se crean los arreglos para guardar los datos que requiere el gráfico.
              let indicadores = [];
              let cantidad = [];
              // Se recorre el conjunto de registros (dataset) por cada fila a través del objeto row.
              response.dataset.forEach(function( row ) {
                //Se envian los datos a los arreglos
                indicadores.push( row.descripcion );
                cantidad.push( row.cantidadindicadores );
              });
              //Se invoca al método que crea una gráfica. Se ubica en el archivo components.js
              generarGrafico( 1 ,'grafico3', cantidad, indicadores, 'Cantidad', 'Indicadores de este proceso' );
          } else {
              /*Se elimina el canvas del documento si no respondió correctamente la API y no retorno datos*/
              $( '#grafico3' ).remove();
              sweetAlert( 2 , response.exception , null );
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


   /*Método que invocará al método que genera un gráfico si el parámetro cumple con las condiciones
  de los filtros*/
  function abrirModalReporte4( id_proceso )
  {
      if ( id_proceso != '' && isNaN(id_proceso) == false && 
           isFinite(id_proceso) == true && id_proceso > 0 ) {
         //Creación de la consulta AJAX
       $.ajax({
           dataType: 'json',
           url: API_PROCESOS + 'graficoPI',
           data: { proceso_id : id_proceso },
           type: 'post'
         })
       .done(function( response ) {
         /* Se evalua si la API respondió correctamente y retorno datos, sino se 
         mostrara un mensaje de error.*/
         if ( response.status ) {
             //Se crean los arreglos para guardar los datos que requiere el gráfico.
             let parte = [];
             let cantidad = [];
             // Se recorre el conjunto de registros (dataset) por cada fila a través del objeto row.
             response.dataset.forEach(function( row ) {
               //Se envian los datos a los arreglos
               parte.push( row.descripcion );
               cantidad.push( row.cantidadparte );
             });
             //Se invoca al método que crea una gráfica. Se ubica en el archivo components.js
             generarGrafico( 2 ,'grafico4', cantidad, parte, 'Cantidad', 'Partes interesadas de este proceso' );
         } else {
             /*Se elimina el canvas del documento si no respondió correctamente la API y no retorno datos*/
             $( '#grafico4' ).remove();
             sweetAlert( 2 , response.exception , null );
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
   
   function AbrirVentanaModificarPr( id )
   {
    $( '#save-form-1' )[0].reset();
    $( '#save-modal-1' ).modal( 'open' );
    $( '#modal-title-1' ).text( 'Modificar proceso' );

    $.ajax({
    dataType: 'json',
    url: API_PROCESOS + 'get',
    data: { rowid : id },
    type: 'post'
    })
    .done(function( response ) {
      if ( response.status ) {
          $( '#rowid' ).val( id );
          $( '#txtProcesosID' ).val( response.dataset.proceso_id );
          $( '#txtDescripcion' ).val( response.dataset.descripcion );
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
    let identifier = { rowid: id };
    confirmDelete(API_PROCESOS, identifier);
  }

  // Evento que sirve para mostrar los resultados de una búsqueda.
  $( '#searchuser' ).submit(function( event ) {
    //se evita recargar la página cuando se envia el formulario
    event.preventDefault();
    /*Se llama a la función que realiza las busquedas,
    recibe por parametros la API y el formulario y se ubica en el archivo components.js*/
    searchRows( API_PROCESOS, this );
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
        url: API_PROCESOS + 'search',
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
      readRows( API_PROCESOS );
    }
  })
   