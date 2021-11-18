<?php
//aca están las rutas de archivos que usara el reporte
require('../helpers/report2.php');
require('../models/Kt_procesos.php');

//Se evalua si la variable proceso_id tiene un valor
if( isset($_GET['proceso_id']) ) {
    // Se instancia a la clase Reporte para crear el reporte
    $pdf = new Reporte;
    // Se inicia el reporte con la parte superior (Header)del documento.
    $pdf->reportHeader('Usuarios según proceso');
    /*Se instancia a la clase Procesos para poder trabajar con los datos
    a mostrar en el reporte*/
    $procesos = new Procesos;
    /*Se evalua si al método que recibe el id del proceso guardado en la 
    variable proceso_id, se le asigno correctamente.*/
    if ( $procesos->setProcesoId2( $_GET['proceso_id'] ) ) {
        /*Se evalua si hay registros para mostrar, sino se redirecciona a otra página.*/
        if ( $rowProceso = $procesos->getProceso2() ) {
            //print_r( $rowComprobante );
            /*Se determina la fuente a usar*/
            $pdf->SetFont('Times', 'B', 12);
            /*Se determina el color a usar para la celda del encabezado
            que contendrá el proceso seleccionado*/
            $pdf->SetFillColor(175);
            /*Se imprime una celda que contendrá el proceso seleccionado*/
            $pdf->Cell(0, 10, utf8_decode($rowProceso['descripcion']), 1, 1, 'C', 1);
            //Se realiza un salto de línea en el reporte de usuarios según procesos.
            $pdf->Ln(10);

            $pdf->Cell(160, 10, utf8_decode('Usuario'), 1, 0, 'C', 1);
            $pdf->Cell(26, 10, utf8_decode('Rol'), 1, 0, 'C', 1);
            $pdf->Cell(26, 10, utf8_decode(' '), 0, 1, 'C');
            /*Se evalua si al método que recibe el id del proceso guardado en la 
            variable proceso_id, se le asigno correctamente.*/
            if ( $procesos->setProcesoId2( $_GET['proceso_id'] ) ) {
                /*Se evalua si hay registros (usuarios)
                para mostrar, sino se redirecciona a otra página.*/
                if ( $dataUsuarios = $procesos->darRoles2($_GET['proceso_id']) ) {
                    foreach ( $dataUsuarios as $rowUsuarios ) {
                        //Se imprimen las celdas con los registros obtenidos
                        $pdf->Cell(160, 10, utf8_decode($rowUsuarios['user_id']), 1, 0, 'C');
                        $pdf->Cell(26, 10, $rowUsuarios['rol'], 1, 0, 'C');
                        $pdf->Cell(26, 10, utf8_decode(' '), 0, 1, 'C');
                    }
                } else {
                    /*Se imprime la celda que contendrá un mensaje informando que no hay productos
                    para el pedido seleccionado*/
                    $pdf->Cell(0, 10, utf8_decode('No hay usuarios para este rol'), 1, 1);
                }
            } else {
                /*Se redirecciona a la página donde se encuentra la gestión de los procesos
                si al método que recibe el id de la factura guardado en la 
                variable proceso_id, no se le asigno correctamente*/
                header('location: ../../../views/Sitio/Procesos.php');
            }
        } else {
        /*Se redirecciona a la página donde se encuentra la gestión de los procesos*/
        header('location: ../../../views/Sitio/Procesos.php');
        }
    //Se envía el documento ya configurado hacia el navegador y se invoca al método Footer()
    $pdf->Output();
    } else {
        /*Se redirecciona a la página donde se encuentra la gestión de los procesos
        si al método que recibe el id del proceso guardado en la 
        variable proceso_id, no se le asigno correctamente*/
        header('location: ../../../views/Sitio/Procesos.php');
    }
} else {
    /*Se redirecciona a la página donde se encuentra la gestión de los procesos
    si la variable proceso_id no tiene un valor.*/
    header('location: ../../../views/Sitio/Procesos.php');
}
?>