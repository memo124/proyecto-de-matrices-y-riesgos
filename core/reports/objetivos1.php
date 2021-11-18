<?php
//aca están las rutas de archivos que usara el reporte
require('../helpers/report2.php');
require('../models/kt_objetivos_calidad.php');

//Se evalua si la variable objetivo_id tiene un valor
if( isset($_GET['objetivo_id']) ) {
    // Se instancia a la clase Reporte para crear el reporte
    $pdf = new Reporte;
    // Se inicia el reporte con la parte superior (Header)del documento.
    $pdf->reportHeader('Indicadores según objetivo');
    /*Se instancia a la clase ObjetivosCalidad para poder trabajar con los datos
    a mostrar en el reporte*/
    $ObjetivosCalidad = new ObjetivosCalidad;
    /*Se evalua si al método que recibe el id del proceso guardado en la 
    variable objetivo_id, se le asigno correctamente.*/
    if ( $ObjetivosCalidad->setObjetivoCalidad( $_GET['objetivo_id'] ) ) {
        /*Se evalua si hay registros (datos del cliente y del pedido en general)
        para mostrar, sino se redirecciona a otra página.*/
        if ( $rowProceso = $ObjetivosCalidad->getObjetivo() ) {
            //print_r( $rowComprobante );
            /*Se determina la fuente a usar*/
            $pdf->SetFont('Times', 'B', 12);
            /*Se determina el color a usar para la celda del encabezado
            que contendrá el proceso seleccionado*/
            $pdf->SetFillColor(175);
            /*Se imprime una celda que contendrá el proceso seleccionado*/
            $pdf->Cell(0, 10, utf8_decode($rowProceso['palabra_clave']), 1, 1, 'C', 1);
            //Se realiza un salto de línea en el reporte de usuarios según ObjetivosCalidad.
            $pdf->Ln(10);
            /*Se evalua si al método que recibe el id del proceso guardado en la 
            variable objetivo_id, se le asigno correctamente.*/
            if ( $ObjetivosCalidad->setObjetivoCalidad( $_GET['objetivo_id'] ) ) {
                /*Se evalua si hay registros (procesos)
                para mostrar, sino se redirecciona a otra página.*/
                if ( $dataRoles = $ObjetivosCalidad->darProcesos($_GET['objetivo_id']) ) {
                    foreach ( $dataRoles as $rowRoles ) {
                        /*Se determina el color a usar para la celda del encabezado
                        que contendrá el proceso*/
                        $pdf->SetFillColor(175);
                        /*Se determina la fuente a usar*/
                        $pdf->SetFont('Times', 'B', 12);
                        /*Se imprime una celda que contendrá el proceso*/
                        $pdf->Cell(0, 10, utf8_decode('Proceso: '.$rowRoles['descripcion']), 1, 1, 'C', 1);
                        /*Se evalua si al método que recibe el id del objetivo, 
                        se le asigno correctamente el parámetro.*/
                        if ( $ObjetivosCalidad->setObjetivoCalidad( $_GET['objetivo_id'] ) ) {
                            /*Se evalua si hay registros (usuarios según su rol)
                            para mostrar, sino se redirecciona a otra página.*/
                            if ( $dataObjetivos = $ObjetivosCalidad->darIndicadoresPorObjetivo($_GET['objetivo_id']) ) {
                                //Se pone una distinción en los colores a usar por el formato RGB
                                $pdf->SetFillColor(244,91,91);
                                /*Se determina la fuente a usar*/
                                $pdf->SetFont('Times', 'B', 11);
                                //Se crea el encabezado que contendrpa el titulo de la información a mostrar
                                $pdf->Cell(22, 10, utf8_decode('Indicador'), 1, 0, 'C', 1);
                                $pdf->Cell(62, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
                                $pdf->Cell(102, 10, utf8_decode('Objetivo específico'), 1, 0, 'C', 1);
                                $pdf->Cell(37.2, 10, utf8_decode(' '), 0, 1, 'C');
                                //Se decide una fuente para los datos que se usaran
                                $pdf->SetFont('Times', '', 11);
                                //Se recorren los registros obtenidos
                                foreach ($dataObjetivos as $rowObjetivos) {
                                    //Se crean las celdas con los registros obtenidos(Indicadores según objetivo)
                                    $pdf->Cell(22, 10, utf8_decode($rowObjetivos['indicador_id']), 1, 0, 'C');
                                    $pdf->Cell(62, 10, utf8_decode($rowObjetivos['nombre']), 1, 0, 'C');
                                    $pdf->Cell(102, 10, utf8_decode($rowObjetivos['objetivo']), 1, 0, 'C');
                                    $pdf->Cell(37.3, 10, utf8_decode(' '), 0, 1, 'C');
                                }
                                //Se realiza un salto de línea en el reporte de usuarios segun ObjetivosCalidad.
                                $pdf->Ln(10);
                            } else {
                                $pdf->Cell(0, 10, utf8_decode('No hay indicadores para este objetivo'), 1, 1);
                            }
                        } else {
                            $pdf->Cell(0, 10, utf8_decode('Ocurrió un problema al insertar el objetivo'), 1, 1);
                        }
                    }
                } else {
                    /*Se imprime la celda que contendrá un mensaje informando que no hay registros*/
                    $pdf->Cell(0, 10, utf8_decode('No hay indicadores'), 1, 1);
                }
            } else {
                /*Se redirecciona a la página donde se encuentra la gestión de los Objetivos de Calidad
                si al método que recibe el id del proceso guardado en la 
                variable objetivo_id, no se le asigno correctamente*/
                header('location: ../../../views/Sitio/ObjetivosCalidad.php');
            }
        } else {
        /*Se redirecciona a la página donde se encuentra la gestión de los ObjetivosCalidad*/
        header('location: ../../../views/Sitio/ObjetivosCalidad.php');
        }
    //Se envía el documento ya configurado hacia el navegador y se invoca al método Footer()
    $pdf->Output();
    } else {
        /*Se redirecciona a la página donde se encuentra la gestión de los ObjetivosCalidad
        si al método que recibe el id del proceso guardado en la 
        variable objetivo_id, no se le asigno correctamente*/
        header('location: ../../../views/Sitio/ObjetivosCalidad.php');
    }
} else {
    /*Se redirecciona a la página donde se encuentra la gestión de los ObjetivosCalidad
    si la variable objetivo_id no tiene un valor.*/
    header('location: ../../../views/Sitio/ObjetivosCalidad.php');
}
?>