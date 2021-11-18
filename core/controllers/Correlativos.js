// Constantes para establecer las rutas y parámetros de comunicación con la API.
const API_CORRELATIVOS = '../../core/api/Correlativos.php?action=';
const API_PROCESOS = '../../core/api/Procesos.php?action=read';

// Método que se ejecuta cuando el documento está listo.
$( document ).ready(function() {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows( API_CORRELATIVOS );
});

// Función para llenar la tabla con los datos enviados por readRows().
function fillTable( dataset )
{
    let content = '';
    // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
    dataset.forEach(function( row ) {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        content += `
            <tr>
                <td>${row.correlativo_id}</td>
                <td>${row.descripcion}</td>
                <td>${row.ultimo_num_utilizado}</td>
                <td
                    <a href="#" onclick="openDeleteDialog(${row.correlativo_id})" class="red-text tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                </td>
            </tr>
        `;
    });
    // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
    $( '#cuerpotablacorrelativo' ).html( content );
    // Se inicializa el componente Material Box asignado a las imagenes para que funcione el efecto Lightbox.
    $( '.materialboxed' ).materialbox();
    // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
    $( '.tooltipped' ).tooltip();
}

// Evento para mostrar los resultados de una búsqueda.
$( '#searchuser' ).submit(function( event ) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se llama a la función que realiza la búsqueda. Se encuentra en el archivo components.js
    searchRows( API_CORRELATIVOS, this );
}); 

// Función que prepara formulario para insertar un registro.
function AbrirVentanaCrearcorrelativo()
{
    $( '#save-form-1' )[0].reset();
    $( '#save-modal-1' ).modal( 'open' );
    $( '#modal-title-1' ).text( 'Agregar correlativo' );
    fillSelect( API_PROCESOS, 'cb_proceso', null );
}

  //funcion para enviar un evento.
  $('#save-form-1').submit(function(event){
    event.preventDefault();
    //Filtro para realizar un mantenimiento entre actualizar o crear.
      saveRow(API_CORRELATIVOS,'create',this,'save-modal-1');
  });
//metodo para abrir un dialogo y realizar el proceso de elimina
  function openDeleteDialog( id )
  {
    let identifier = { rowid : id };
    confirmDelete( API_CORRELATIVOS, identifier );
  }