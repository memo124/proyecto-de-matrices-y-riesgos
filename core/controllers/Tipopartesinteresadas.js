window.onload = ($(document).ready(function(){
    $('#textarea_descripcionTPI').val('New Text');
    M.textareaAutoResize($('#textarea_descripcionTPI'));
    $('#textarea_descripcionTPI2').val('New Text');
    M.textareaAutoResize($('#textarea_descripcionTPI2'));
    M.updateTextFields();


function llenartablaTPI(){      
    var tabla, html;
    tabla = $('#cuerpotablaTPI');
        for(var i = 1; i<=10; i++){
                    if(i % 2 ==0){                       
                        html = '<tr style="background: #e57373; color:white;">';
                        html += '<td>'+i+'</td>';
                        html += '<td>viejo lin</td>';
                        html += '<td>viejo lin</td>';
                        html += '<td><a onclick="AbrirVentanaModificarTPI()" class="btn-floating btn-medium waves-effect waves-light cyan tooltipped" data-position="bottom" data-tooltip="Modificar"><i class="material-icons">edit</i></a><a onclick="ventanaborrarTPI()" href="#!" class="btn-floating btn-medium waves-effect waves-light red tooltipped" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">delete</i></a></td>';
                        html += '</tr>';
                        tabla.append(html);
                            }else{
                        html = '<tr style="background: #bdbdbd; color: white;">';
                        html += '<td>'+i+'</td>';
                        html += '<td>viejo lin</td>';
                        html += '<td>viejo lin</td>';
                        html += '<td><a onclick="AbrirVentanaModificarTPI()" class="btn-floating btn-medium waves-effect waves-light cyan tooltipped" data-position="bottom" data-tooltip="Modificar"><i class="material-icons">edit</i></a><a onclick="ventanaborrarTPI()" href="#!" class="btn-floating btn-medium waves-effect waves-light red tooltipped" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">delete</i></a></td>';
                        html += '</tr>';
                        tabla.append(html);
                            }
                            
        }
    }

    llenartablaTPI();
}));

function ventanaborrarTPI(){
    Swal.fire({
         title: '¿Desea borrar este tipo de parte interesada?',
         icon: 'warning',
         text:'No se podrán recuperar los datos sí se elimina.',
         showCancelButton: true,
         confirmButtonColor: '#212121',
         cancelButtonColor: '#f44336',
         cancelButtonText:'Cancelar.',
         confirmButtonText: 'Si, borrar.',
         showClass:{
           popup: 'animated fadeInRight'
         },
         hideClass: {
             popup: 'animated hinge'
         }
         }).then((result) => {
           if (result.value) {
             const Toast = Swal.mixin({
               toast: true,
               position: 'top-end',
               showConfirmButton: false,
               timer: 2500,
               timerProgressBar: true,
               onOpen: (toast) => {
                 toast.addEventListener('mouseenter', Swal.stopTimer)
                 toast.addEventListener('mouseleave', Swal.resumeTimer)
               }
             })
             Toast.fire({
               icon: 'success',
               title: 'Tipo de parte interesada eliminada'
             })
           }
         })
   };
   
   function AbrirVentanaCrearTPI()
   {
       $( '#save-form-1' )[0].reset();
       $( '#save-modal-1' ).modal( 'open' );
       $( '#modal-title-1' ).text( 'Agregar tipo de parte interesada' );
   }
   
   function AbrirVentanaModificarTPI()
   {
     $( '#save-form-2' )[0].reset();
     $( '#save-modal-2' ).modal( 'open' );
     $( '#modal-title-2' ).text( 'Modificar tipo de parte interesada' );
   }
   
   
   
   //para cuando este la parte de create se lanzará un toast confirmandolo
   function confirmacionagregarTPI(){
     const Toast2 = Swal.mixin({
       toast: true,
       position: 'top-end',
       showConfirmButton: false,
       timer:  2500,
       timerProgressBar: true,
       onOpen: (toast) => {
         toast.addEventListener('mouseenter', Swal.stopTimer)
         toast.addEventListener('mouseleave', Swal.resumeTimer)
       }
     })
     Toast2.fire({
       icon: 'success',
       title: 'Tipo de parte interesada agregada'
     })
   }
   
   function confirmacionmodificarTPI(){
     const Toast3 = Swal.mixin({
       toast: true,
       position: 'top-end',
       showConfirmButton: false,
       timer:  2500,
       timerProgressBar: true,
       onOpen: (toast) => {
         toast.addEventListener('mouseenter', Swal.stopTimer)
         toast.addEventListener('mouseleave', Swal.resumeTimer)
       }
     })
     Toast3.fire({
       icon: 'success',
       title: 'Tipo de parte interesada modificada'
     })
     }

