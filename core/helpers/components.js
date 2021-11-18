/*
*   Función para obtener todos los registros disponibles en los mantenimientos de tablas (operación read).
*
*   Expects: api (ruta del servidor para obtener los datos).
*
*   Returns: ninguno.
*/
function readRows( api )
{
    $.ajax({
        dataType: 'json',
        url: api + 'read'
    })
    .done(function( response ) {
        if ( ! response.status ) {
            sweetAlert( 4, response.exception, null );
        }
        fillTable( response.dataset );
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

/*
*   Función para obtener los resultados de una búsqueda en los mantenimientos de tablas (operación search).
*
*   Expects: api (ruta del servidor para obtener los datos) y form (formulario de búsqueda).
*
*   Returns: ninguno.
*/
function searchRows( api, form )
{
    $.ajax({
        type: 'post',
        url: api + 'search',
        data: $( '#' + form.id ).serialize(),
        dataType: 'json'
    })
    .done(function( response ) {
        if ( response.status ) {
            fillTable( response.dataset );
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

/*
*   Función para crear o actualizar un registro en los mantenimientos de tablas (operación create y update).
*
*   Expects: api (ruta del servidor para enviar los datos), form (formulario de crear y actualizar) y modalId (identificador del modal).
*
*   Returns: ninguno.
*/
function saveRow( api, action, form, modalId)
{
    let request = null;
    if ( form.enctype == 'multipart/form-data' ) {
        request = $.ajax({
            type: 'post',
            url: api + action,
            data: new FormData( $( '#' + form.id )[0] ),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false
        });
    } else {
        request = $.ajax({
            type: 'post',
            url: api + action,
            data: $( '#' + form.id ).serialize(),
            dataType: 'json'
        });
    }
    request.done(function( response ) {
        if ( response.status ) {
            readRows( api );
            sweetAlert( 1, response.message, null );
            $( '#' + modalId ).modal( 'close' );
        } else {
            sweetAlert( 2, response.exception, null );
        }
    });
    request.fail(function( jqXHR ) {
        // Se verifica si la API ha respondido y se muestra el resultado, de lo contrario se presenta el estado de la petición.
        if ( jqXHR.status == 200 ) {
            console.log( jqXHR.responseText );
        } else {
            console.log( jqXHR.status + ' ' + jqXHR.statusText );
        }
    });
}

/*
*   Función para eliminar un registro seleccionado en los mantenimientos de tablas (operación delete).
*
*   Expects: api (ruta del servidor para enviar los datos) e identifier (datos del registro a eliminar).
*
*   Returns: ninguno.
*/
function confirmDelete( api, identifier )
{
    swal({
        title: 'Advertencia',
        text: '¿Desea eliminar el registro?',
        icon: 'warning',
        buttons: ['Cancelar', 'Aceptar'],
        closeOnClickOutside: false,
        closeOnEsc: false
    })
    .then(function( value ) {
        if ( value ) {
            $.ajax({
                type: 'post',
                url: api + 'delete',
                data: identifier,
                dataType: 'json'
            })
            .done(function( response ) {
                if ( response.status ) {
                    readRows( api );
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
}

/*
*   Función para manejar los mensajes de notificación al usuario.
*
*   Expects: type (tipo de mensaje), text (texto a mostrar) y url (dirección a dirigir al cerrar el mensaje).
*
*   Returns: ninguno.
*/
function sweetAlert( type, text, url )
{
    switch ( type ) {
        case 1:
            title = "Éxito";
            icon = "success";
            break;
        case 2:
            title = "Error";
            icon = "error";
            break;
        case 3:
            title = "Advertencia";
            icon = "warning";
            break;
        case 4:
            title = "Aviso";
            icon = "info";
    }
    if ( url ) {
        swal({
            title: title,
            text: text,
            icon: icon,
            button: 'Aceptar',
            closeOnClickOutside: false,
            closeOnEsc: false
        })
        .then(function() {
            location.href = url
        });
    } else {
        swal({
            title: title,
            text: text,
            icon: icon,
            button: 'Aceptar',
            closeOnClickOutside: false,
            closeOnEsc: false
        });
    }
}

/*
*   Función para cargar las opciones en un select de formulario.
*
*   Expects: api (ruta del servidor para obtener los datos), selectId (identificador del select en el formulario) y selected (valor seleccionado).
*
*   Returns: ninguno.
*/
function fillSelect( api, selectId, selected )
{
    $.ajax({
        dataType: 'json',
        url: api
    })
    .done(function( response ) {
        if ( response.status ) {
            let content = '';
            if ( ! selected ) {
                content += '<option value="0" disabled selected>Seleccione una opción</option>';
            }
            response.dataset.forEach(function( row ) {
                // Se obtiene el valor del primer campo de la sentencia SQL (valor para cada opción).
                value = Object.values( row )[0];
                // Se obtiene el valor del segundo campo de la sentencia SQL (texto para cada opción).
                text = Object.values( row )[1];
                if ( value != selected ) {
                    content += `<option value="${value}">${text}</option>`;
                } else {
                    content += `<option value="${value}" selected>${text}</option>`;
                }
            });
            $( '#' + selectId ).html( content );
        } else {
            $( '#' + selectId ).html( '<option value="">No hay opciones disponibles</option>' );
        }
        // Se inicializa el componente select del formulario.
        $( 'select' ).formSelect();
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


/*Recibe por parámetro el caso(Tipo de gráfico), Id de la etiqueta <canvas></canvas>,
Datos del eje X, Datos del eje Y, la leyenda y el título del gráfico*/
function generarGrafico( caso , canvas, xAxis, yAxis, legend, title )
{
    /*Se crea un arreglo que contendra el color para los datos*/
    let colors = [];
    /*Se utiliza un bucle For, para poder generar números al azar y que se les capturará
    una parte del número generado para reemplazarlo por códigos hexadecimales de colores*/
    for ( i = 0; i < xAxis.length; i++ ) {
        colors.push( '#' + ( Math.random().toString( 16 )).substring( 2, 8 ) );
    }
    /*Se crea una constante para el contexto del gráfico*/
    const context = $( '#' + canvas );
    /*Se crea una variable que almacenará las configuraciones y el diseño dependiento el tipo de gráfico*/

    /*Se evalua el caso(Tipo de gráfico a generar)*/
    var chart = '';
    switch ( caso ) {
        /*Caso cuando se quiera un gráfico de barras verticales*/
        case 0:
            chart = new Chart( context, {
                type: 'bar',
                data: {
                    labels: xAxis,
                    datasets: [{
                        label: legend,
                        data: yAxis,
                        backgroundColor: colors,
                        borderColor: '#000000',
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: title,
                        fontColor: '#ffffff',
                        fontSize: '20',
                        fontFamily: 'Century Gothic'
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 30,
                                fontColor: '#ffffff',
                                fontSize: '20',
                                fontFamily: 'Century Gothic'
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                fontColor: '#ffffff',
                                fontSize: '12',
                                fontFamily: 'Century Gothic'
                            }
                        }]
                    }
                }
            });
            break;
        /*Caso cuando se quiera un gráfico de barras horizontales*/
        case 1:
            chart = new Chart( context, {
                type: 'horizontalBar',
                data: {
                    labels: yAxis,
                    datasets: [{
                        label: legend,
                        data: xAxis,
                        backgroundColor: colors,
                        borderColor: '#000000',
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: title,
                        fontColor: '#ffffff',
                        fontSize: '20',
                        fontFamily: 'Century Gothic'
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 30,
                                fontColor: '#ffffff',
                                fontSize: '20',
                                fontFamily: 'Century Gothic'
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                fontColor: '#ffffff',
                                fontSize: '12',
                                fontFamily: 'Century Gothic'
                            }
                        }]
                    }
                }
            });
            break;
        /*Caso cuando se quiera un gráfico de forma de dona*/
        case 2:
            chart = new Chart( context, {
                type: 'doughnut',
                data: {
                    labels: yAxis,
                    datasets: [{
                        label: legend,
                        data: xAxis,
                        backgroundColor: colors,
                        borderColor: '#000000',
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        labels: {
                            fontColor: '#ffffff'
                        }
                    },
                    title: {
                        display: true,
                        text: title,
                        fontColor: '#ffffff',
                        fontSize: '20',
                        fontFamily: 'Century Gothic'
                    },
                }
            });
            break;
        /*Caso cuando se quiera un gráfico de forma de pastel*/
        case 3:
            chart = new Chart( context, {
                type: 'pie',
                data: {
                    labels: yAxis,
                    datasets: [{
                        label: legend,
                        data: xAxis,
                        backgroundColor: colors,
                        borderColor: '#000000',
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        labels: {
                            fontColor: '#ffffff'
                        }
                    },
                    title: {
                        display: true,
                        text: title,
                        fontColor: '#ffffff',
                        fontSize: '20',
                        fontFamily: 'Century Gothic'
                    },
                }
            });
            break;
        /*Caso cuando se quiera un gráfico de área polar*/
        case 4:
            chart = new Chart( context, {
                type: 'polarArea',
                data: {
                    labels: yAxis,
                    datasets: [{
                        data: xAxis,
                        backgroundColor: colors,
                        borderColor: '#000000',
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                        display:true,
                        labels: {
                            fontColor: '#ffffff'
                        }
                    },
                    title: {
                        display: true,
                        text: title,
                        fontColor: '#ffffff',
                        fontSize: '20',
                        fontFamily: 'Century Gothic'
                    },
                    scale: {
                        angleLines: {
                            display: false,
                            fontColor: '#ffffff',
                            fontSize: '20',
                            fontFamily: 'Century Gothic'
                        },
                        ticks: {
                            display: false,
                            fontColor: '#ffffff'
                        },
                    }
                },
            });
            break;
        default:
            break;
    }
}