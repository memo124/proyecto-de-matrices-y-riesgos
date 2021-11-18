<?php
//aca están las rutas de archivos que usara el reporte
require('../helpers/report2.php');
require('../models/Kt_indicadores.php');

//Se evalua si la variable proceso_id tiene un valor
if( isset($_GET['proceso_id']) ) {
    // Se instancia a la clase Reporte para crear el reporte
    $pdf = new Reporte;
    // Se inicia el reporte con la parte superior (Header)del documento.
    $pdf->reportHeader('Indicadores según proceso');
    /*Se instancia a la clase Indicadores para poder trabajar con los datos
    a mostrar en el reporte*/
    $indicadores = new Indicadores;
    /*Se evalua si al método que recibe el id del proceso guardado en la 
    variable proceso_id, se le asigno correctamente.*/
    if ( $indicadores->setProceso( $_GET['proceso_id'] ) ) {
        /*Se evalua si hay registros (indicadores) para mostrar,
        sino se redirecciona a otra página.*/
        if ( $rowProceso = $indicadores->getProceso2($_GET['proceso_id']) ) {
            //print_r( $rowComprobante );
            /*Se determina la fuente a usar*/
            $pdf->SetFont('Times', 'B', 12);
            /*Se determina el color a usar para la celda del encabezado
            que contendrá el proceso seleccionado*/
            $pdf->SetFillColor(175);
            /*Se imprime una celda que contendrá el proceso seleccionado*/
            $pdf->Cell(0, 10, utf8_decode($rowProceso['descripcion']), 1, 1, 'C', 1);
            //Se realiza un salto de línea en el reporte de usuarios según indicadores.
            $pdf->Ln(10);

            $pdf->Cell(46.5, 10, utf8_decode('Indicador'), 1, 0, 'C', 1);
            $pdf->Cell(46.5, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
            $pdf->Cell(46.5, 10, utf8_decode('Palabra clave'), 1, 0, 'C', 1);
            $pdf->Cell(46.5, 10, utf8_decode('Objetivo específico'), 1, 0, 'C', 1);
            $pdf->Cell(26, 10, utf8_decode(' '), 0, 1, 'C');
            /*Se evalua si al método que recibe el id del proceso guardado en la 
            variable proceso_id, se le asigno correctamente.*/
            if ( $indicadores->setProceso( $_GET['proceso_id'] ) ) {
                /*Se evalua si hay registros (usuarios)
                para mostrar, sino se redirecciona a otra página.*/
                if ( $dataindicadores = $indicadores->darIndicadores($_GET['proceso_id']) ) {
                    foreach ( $dataindicadores as $rowindicadores ) {
                        //Se imprimen las celdas con los registros obtenidos
                        $pdf->Cell(46.5, 10, utf8_decode($rowindicadores['indicador_id']), 1, 0, 'C');
                        $pdf->Cell(46.5, 10, utf8_decode($rowindicadores['nombre']), 1, 0, 'C');
                        $pdf->Cell(46.5, 10, utf8_decode($rowindicadores['palabra_clave']), 1, 0, 'C');
                        $pdf->Cell(46.5, 10, utf8_decode($rowindicadores['objetivo']), 1, 0, 'C');
                        $pdf->Cell(26, 10, utf8_decode(' '), 0, 1, 'C');
                    }
                } else {
                    /*Se imprime la celda que contendrá un mensaje informando que no hay indicadores 
                    para el proceso seleccionado*/
                    $pdf->Cell(0, 10, utf8_decode('No hay indicadores para este proceso'), 1, 1);
                }
            } else {
                /*Se redirecciona a la página donde se encuentra la gestión de los indicadores
                si al método que recibe el id de la factura guardado en la 
                variable proceso_id, no se le asigno correctamente*/
                header('location: ../../../views/Sitio/indicadores.php');
            }
        } else {
        /*Se redirecciona a la página donde se encuentra la gestión de los indicadores*/
        header('location: ../../../views/Sitio/indicadores.php');
        }
    //Se envía el documento ya configurado hacia el navegador y se invoca al método Footer()
    $pdf->Output();
    } else {
        /*Se redirecciona a la página donde se encuentra la gestión de los indicadores
        si al método que recibe el id del proceso guardado en la 
        variable proceso_id, no se le asigno correctamente*/
        header('location: ../../../views/Sitio/indicadores.php');
    }
} else {
    /*Se redirecciona a la página donde se encuentra la gestión de los indicadores
    si la variable proceso_id no tiene un valor.*/
    header('location: ../../../views/Sitio/indicadores.php');
}
?>