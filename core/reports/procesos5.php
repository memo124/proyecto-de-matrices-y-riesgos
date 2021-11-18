<?php
//aca están las rutas de archivos que usara el reporte
require('../helpers/report2.php');
require('../models/Kt_PartesInteresadas.php');

//Se evalua si la variable proceso_id tiene un valor
if( isset($_GET['proceso_id']) ) {
    // Se instancia a la clase Reporte para crear el reporte
    $pdf = new Reporte;
    // Se inicia el reporte con la parte superior (Header)del documento.
    $pdf->reportHeader('Partes interesadas según proceso');
    /*Se instancia a la clase PartesIn para poder trabajar con los datos
    a mostrar en el reporte*/
    $partesIn = new PartesIn;
    /*Se evalua si al método que recibe el id del proceso guardado en la 
    variable proceso_id, se le asigno correctamente.*/
    if ( $partesIn->setProceso( $_GET['proceso_id'] ) ) {
        /*Se evalua si hay registros (indicadores) para mostrar,
        sino se redirecciona a otra página.*/
        if ( $rowProceso = $partesIn->getProceso($_GET['proceso_id']) ) {
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

            $pdf->Cell(62, 10, utf8_decode('Parte interesada'), 1, 0, 'C', 1);
            $pdf->Cell(62, 10, utf8_decode('Descripción'), 1, 0, 'C', 1);
            $pdf->Cell(62, 10, utf8_decode('Requisito identificado'), 1, 0, 'C', 1);
            $pdf->Cell(26, 10, utf8_decode(' '), 0, 1, 'C');
            /*Se evalua si al método que recibe el id del proceso guardado en la 
            variable proceso_id, se le asigno correctamente.*/
            if ( $partesIn->setProceso( $_GET['proceso_id'] ) ) {
                /*Se evalua si hay registros (partes interesadas)
                para mostrar, sino se redirecciona a otra página.*/
                if ( $dataPI = $partesIn->darPartesInteresadas($_GET['proceso_id']) ) {
                    foreach ( $dataPI as $rowPI ) {
                        //Se imprimen las celdas con los registros obtenidos
                        $pdf->Cell(62, 10, utf8_decode($rowPI['parte_interesada_id']), 1, 0, 'C');
                        $pdf->Cell(62, 10, utf8_decode($rowPI['descripcion']), 1, 0, 'C');
                        $pdf->Cell(62, 10, utf8_decode($rowPI['requisito_identificado']), 1, 0, 'C');
                        $pdf->Cell(26, 10, utf8_decode(' '), 0, 1, 'C');
                    }
                } else {
                    /*Se imprime la celda que contendrá un mensaje informando que no partes interesadas
                    del proceso seleccionado*/
                    $pdf->Cell(0, 10, utf8_decode('No hay partes interesadas para este proceso'), 1, 1);
                }
            } else {
                /*Se redirecciona a la página donde se encuentra la gestión de las partes interesadas
                si al método que recibe el id del proceso en la 
                variable proceso_id, no se le asigno correctamente*/
                header('location: ../../../views/Sitio/indicadores.php');
            }
        } else {
        /*Se redirecciona a la página donde se encuentra la gestión de las partes interesadas*/
        header('location: ../../../views/Sitio/indicadores.php');
        }
    //Se envía el documento ya configurado hacia el navegador y se invoca al método Footer()
    $pdf->Output();
    } else {
        /*Se redirecciona a la página donde se encuentra la gestión de las partes interesadas
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