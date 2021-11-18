// Método que se ejecutará está listo el documento.
$(document).ready(function(){ 
  readRows( API_MATRICES );
  grafico1();
  grafico2();
  grafico3();
  grafico4();
  grafico5();
  graficoCantidadU();
});
  /* Constantes que sirve para establecer la comunicación con la API a utilizar.*/
  const API_MATRICES = '../../core/api/Matrices.php?action=';
  const API_USUARIOSCROSS = '../../core/api/Usuarioscross.php?action=';

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
                <td>
                  <a href="#" onclick="AbrirVentanaModificarUA(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light cyan blue-text tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                  <a href="#" onclick="openDeleteDialog(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light red red-text tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                </td>
                <td>${row.matriz_id}</td>
                <td>${row.descripcionm}</td>
                <td>${row.palabra_clave}</td>
                <td>${row.proceso}</td>
                <td>${row.indicador}</td>
                <td>${row.requisito_identificado}</td>
                <td>${row.clasificacion_matriz}</td>
                <td>${row.ro_num}</td>
                <td>${row.edicion_num}</td>
                <td>${row.status}</td>
                <td>${row.entrada}</td>
                <td>${row.salida}</td>
                <td>${row.oportunidad}</td>
                <td>${row.riesgo}</td>
                <td>${row.etapa}</td>
                <td>${row.mercado_e_imagen}</td>
                <td>${row.afectacion_recursos}</td>
                <td>${row.cumplimiento_requisitos}</td>
                <td>${row.medio_ambiente}</td>
                <td>${row.responsabilidad_social}</td>
                <td>${row.seguridad}</td>
                <td>${row.consecuencia}</td>
                <td>${row.controles_existentes}</td>
                <td>${row.eficacia}</td>
                <td>${row.causa}</td>
                <td>${row.factibilidad}</td>
                <td>${row.impactos}</td>
                <td>${row.resultado}</td>
                <td>${row.nivel}</td>
                <td>${row.decisiones}</td>
                <td>${row.probablidad}</td>
            </tr>
        `;  
      //se envia la variable que contiene las filas al cuerpo de la tabla
      $('#cuerpotablaM').html(content);
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
      saveRow(API_MATRICES,'update',this,'save-modal-1');
    }
    else
    {
      saveRow(API_MATRICES,'create',this,'save-modal-1');
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
      //Se crea la consulta AJAX para actualizar un dato
       $.ajax({
        dataType: 'json',
        url: API_MATRICES + 'get',
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
  }

  // Función para establecer el dato que se quiera eliminar, recibiendo por parametro el ID
    function openDeleteDialog( id )
  {
     // Se declara e inicia un objeto que será igual al parametro recibido.
    let identifier = { user_id: id };
    confirmDelete( API_MATRICES, identifier );
  }


  
// Evento que sirve para mostrar los resultados de una búsqueda.
$( '#searchuser' ).submit(function( event ) {
  //se evita recargar la página cuando se envia el formulario
  event.preventDefault();
  /*Se llama a la función que realiza las busquedas,
  recibe por parametros la API y el formulario y se ubica en el archivo components.js*/
  searchRows( API_MATRICES, this );
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
      url: API_MATRICES + 'search',
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
    readRows( API_MATRICES );
  }
})

// Función para graficar la cantidad de productos por categoría.
function graficoCantidadU()
{
    $.ajax({
        dataType: 'json',
        url: API_USUARIOSCROSS + 'cantidadUsuariosRol',
        data: null
    })
    .done(function( response ) {
        if ( response.status ) {
            let rol = [];
            let cantidad = [];
            response.dataset.forEach(function( row ) {
                rol.push( row.rol);
                cantidad.push( row.cantidad );
            });
            console.log(response.dataset);
            barGraph( 'chart', rol, cantidad, 'Cantidad de usuarios por rol', 'Cantidad de productos por categoría' );
        } else {
            $( '#chart' ).remove();
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

/*Método que invocará al método quees
  de los filtros*/
  function grafico1(  )
  {
         //Creación de la consulta AJAX
       $.ajax({
           dataType: 'json',
           url: API_MATRICES + 'graficoUsuarios',
           data: null
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
             });
             //Se invoca al método que crea una gráfica. Se ubica en el archivo components.js
             generarGrafico( 0 ,'grafico1', rol, cantidad_usuarios, 'Rol', 'Usuarios según rol' );
         } else {
             /*Se elimina el canvas del documento si no respondió correctamente la API y no retorno datos*/
             $( '#grafico1' ).remove();
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
  }

 /*Método que invocará al método que genera un gráfico si el parámetro cumple con las condiciones
 de los filtros*/
  function grafico2(  )
  {
         //Creación de la consulta AJAX
       $.ajax({
           dataType: 'json',
           url: API_MATRICES + 'graficoCorrelativos',
           data: null
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
             });
             //Se invoca al método que crea una gráfica. Se ubica en el archivo components.js
             generarGrafico( 2 ,'grafico2', cantidad, correlativo, 'Último número utilizado', 'Correlativos según número' );
         } else {
             /*Se elimina el canvas del documento si no respondió correctamente la API y no retorno datos*/
             $( '#grafico2' ).remove();
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
  }

  /*Método que invocará al método que genera un gráfico si el parámetro cumple con las condiciones
 de los filtros*/
  function grafico3(  )
  {
         //Creación de la consulta AJAX
       $.ajax({
           dataType: 'json',
           url: API_MATRICES + 'graficoIndicadores',
           data: null
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
             generarGrafico( 1 ,'grafico3', cantidad, indicadores, 'Cantidad', 'Indicadores por proceso' );
         } else {
             /*Se elimina el canvas del documento si no respondió correctamente la API y no retorno datos*/
             $( '#grafico3' ).remove();
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
  }


  /*Método que invocará al método que genera un gráfico si el parámetro cumple con las condiciones
 de los filtros*/
 function grafico4(  )
 {
        //Creación de la consulta AJAX
      $.ajax({
          dataType: 'json',
          url: API_MATRICES + 'graficoPI',
          data: null
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
            generarGrafico( 2 ,'grafico4', cantidad, parte, 'Cantidad', 'Partes interesadas por proceso' );
        } else {
            /*Se elimina el canvas del documento si no respondió correctamente la API y no retorno datos*/
            $( '#grafico4' ).remove();
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
 }

 /*Método que invocará al método que genera un gráfico*/
  function grafico5( )
   {
          //Creación de la consulta AJAX
        $.ajax({
            dataType: 'json',
            url: API_MATRICES + 'graficoIndicadores2',
            data: null
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
              });
              //Se invoca al método que crea una gráfica. Se ubica en el archivo components.js
              generarGrafico( 2 ,'grafico5', cantidad, proceso, 'Proceso', 'Indicadores por proceso' );
          } else {
              /*Se elimina el canvas del documento si no respondió correctamente la API y no retorno datos*/
              $( '#grafico5' ).remove();
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
   }