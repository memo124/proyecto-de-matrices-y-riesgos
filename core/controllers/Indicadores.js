$(document).ready(function(){ 
  readRows( API_INDICADORES );
});

  const API_INDICADORES = '../../core/api/Indicadores.php?action=';
  const API_PROCESOS = '../../core/api/Procesos.php?action=readwe';
  const API_OBJETIVOS = '../../core/api/Objetivos_calidad.php?action=readwe';

  //llenar tabla automaticamente.
  function fillTable(dataset)
  {      
    let content = '';
    dataset.forEach(function(row) 
    {
      content += `
            <tr>
                <td>${row.rowid}</td>
                <td>${row.indicador_id}</td>
                <td>${row.nombre}</td>
                <td>${row.descripcion}</td>
                <td>${row.palabra_clave}</td>
                <td>${row.objetivoes}</td>
                <td>${row.formula}</td>
                <td>${row.valor_actualidad}%</td>
                <td>${row.valor_potencialidad}%</td>
                <td>${row.meta}%</td>
                <td>${row.frecuencia_medicion}</td>
                <td>${row.responsable_medicion}</td>
                <td>${row.responsible_seguimiento}</td>
                <td>${row.fuente}</td>
                <td>
                  <a href="#" onclick="AbrirVentanaModificarUC(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light cyan blue-text tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                  <a href="#" onclick="openDeleteDialog(${row.rowid})" class="z-depth-3 btn-floating btn-medium waves-effect waves-light red red-text tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                </td>
            </tr>
        `;  
      $('#cuerpotablaIn').html(content);
      $( '.tooltipped' ).tooltip();
    });
  }

  //crear usuario.
  $('#form_indicadores').submit(function(event){
    var proceso = document.getElementById('cb_proceso'),
        objetivo = document.getElementById('cb_objetivo'),
        valor_idindicador = document.getElementById('id_indicador').value,
        valor_id = document.getElementById('txtIndicador').value,
        valor_nombre = document.getElementById('txtnombre').value,
        valor_objetivoes = document.getElementById('txtObjetivoEspecifico').value,
        valor_formula = document.getElementById('txtFormulaCalculo').value,
        valor_actual = document.getElementById('txtValorActualidad').value,
        valor_potencial = document.getElementById('txtValorPotencialidad').value,
        valor_meta = document.getElementById('txtMeta').value,
        valor_frecuencia = document.getElementById('txtFrecuenciaMedicion').value,
        valor_responsable = document.getElementById('txtResponsableMedicion').value,
        valor_responsible = document.getElementById('txtResponsableSeguimiento').value,
        valor_fuente = document.getElementById('txtFuenteInformacion').value,
        index_proceso = proceso.selectedIndex,
        index_objetivo = objetivo.selectedIndex,
        opcion_proceso1 = proceso.options[index_proceso],
        opcion_objetivo1 = objetivo.options[index_objetivo],
        opcionproceso = opcion_proceso1.text,
        opcionobjetivo = opcion_objetivo1.text;
    event.preventDefault();
    if ( $('#id_indicador').val()) {
      $.ajax({
        type: 'post',
        url: API_INDICADORES + 'update',
        data: { id_indicador : valor_idindicador  ,proceso : opcionproceso , txtindicador : valor_id , txtnombre : valor_nombre , objetivocalidad : opcionobjetivo , 
         objetivoespecifico : valor_objetivoes , formula : valor_formula , valoractual : valor_actual , 
        valorpotencia : valor_potencial , meta : valor_meta , frecuencia : valor_frecuencia , 
        responsable : valor_responsable , responsible : valor_responsible , fuente : valor_fuente } ,
        dataType: 'json'
    })
    .done(function( response ) {
        if ( response.status ) {
            readRows( API_INDICADORES );
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
        url: API_INDICADORES + 'create',
        data: { proceso : opcionproceso , txtindicador : valor_id , txtnombre : valor_nombre , objetivocalidad : opcionobjetivo , 
         objetivoespecifico : valor_objetivoes , formula : valor_formula , valoractual : valor_actual , 
        valorpotencia : valor_potencial , meta : valor_meta , frecuencia : valor_frecuencia , 
        responsable : valor_responsable , responsible : valor_responsible , fuente : valor_fuente } ,
        dataType: 'json'
    })
    .done(function( response ) {
        if ( response.status ) {
            readRows( API_INDICADORES );
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
       $( '#form_indicadores' )[0].reset();
       $( '#save-modal-2' ).modal( 'open' );
       $( '#modal-title-2' ).text( 'Modificar indicador' );
        document.getElementById('id_indicador').value = id;
       $.ajax({
        dataType: 'json',
        url: API_INDICADORES + 'get',
        data: { id_indicador : id },
        type: 'post'
        })
        .done(function( response ) {
          if ( response.status ) {
              fillSelect( API_OBJETIVOS, 'cb_objetivo', response.dataset.objetivocalidad_id );
              fillSelect( API_PROCESOS, 'cb_proceso', response.dataset.proceso_id );
              $( '#txtIndicador' ).val( response.dataset.indicador_id );
              $( '#txtnombre' ).val( response.dataset.nombre );
              $( '#txtObjetivoEspecifico' ).val( response.dataset.objetivoes );
              $( '#txtFormulaCalculo' ).val( response.dataset.formula );
              $( '#txtValorActualidad' ).val( response.dataset.valor_actualidad );
              $( '#txtValorPotencialidad' ).val( response.dataset.valor_potencialidad );
              $( '#txtMeta' ).val( response.dataset.meta );
              $( '#txtFrecuenciaMedicion' ).val( response.dataset.frecuencia_medicion );
              $( '#txtResponsableMedicion' ).val( response.dataset.responsable_medicion );
              $( '#txtResponsableSeguimiento' ).val( response.dataset.responsible_seguimiento );
              $( '#txtFuenteInformacion' ).val( response.dataset.fuente );
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

     function AbrirVentanaCrearIn()
  {
      $( '#form_indicadores' )[0].reset();
      $( '#save-modal-2' ).modal( 'open' );
      $( '#modal-title-2' ).text( 'Agregar indicador' );
      fillSelect( API_PROCESOS, 'cb_proceso', null );
      fillSelect( API_OBJETIVOS, 'cb_objetivo', null );
  }


    function openDeleteDialog( id )
  {
    let identifier = { id_indicador : id };
    confirmDelete( API_INDICADORES, identifier );
  }

// Evento que sirve para mostrar los resultados de una búsqueda.
$( '#searchuser' ).submit(function( event ) {
  //se evita recargar la página cuando se envia el formulario
  event.preventDefault();
  /*Se llama a la función que realiza las busquedas,
  recibe por parametros la API y el formulario y se ubica en el archivo components.js*/
  searchRows( API_INDICADORES, this );
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
      url: API_INDICADORES + 'search',
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
        }
        else{
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
    readRows( API_INDICADORES );
  }
})
