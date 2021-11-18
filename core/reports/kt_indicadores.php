<?php
//Direcciones para realizar el reporte
require('../helpers/report.php');
require('../models/kt_indicadores.php');
require('../models/kt_procesos.php');
// Se declara la variable para comenzar una estancia
$pdf = new Report;
// Comienza a ejecutarse el encabezado del reporte
$pdf->reportHeader('Indicadores segun el proceso');

$proceso = new Procesos;
if ($dataProceso = $proceso->readProceso()) {
    foreach ($dataProceso as $rowProceso) {
        $pdf->SetFillColor(175);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, utf8_decode('Indicadores de procesos: '.$rowProceso['descripcion']), 1, 1, 'C', 1);
        $indicadores = new Indicadores;
        if ($indicadores->setProceso($rowProceso['rowid'])) {
            if ($dataCliente = $indicadores->readProcesosIndicadores()) {
                // Se pone una distincion de colores por el formato RGB
                $pdf->SetFillColor(244,91,91);
                // Se establece la fuente para el nombre de la categoría.
                $pdf->SetFont('Times', 'B', 11);
                // Se comienzan a crear las celdas y los encabezados
                $pdf->Cell(40, 10, utf8_decode('Palabra clave'), 1, 0, 'C', 1);
                $pdf->Cell(110, 10, utf8_decode('Objetivo especifico'), 1, 0, 'C', 1);
                $pdf->Cell(17, 10, utf8_decode('Valor.A'), 1, 0, 'C', 1);
                $pdf->Cell(19, 10, utf8_decode('Valor.P'), 1, 0, 'C', 1);
                $pdf->Cell(37.3, 10, utf8_decode(' '), 0, 1, 'C');
                // Se decide una fuente para los datos que se usaran
                $pdf->SetFont('Times', '', 11);
                // Los datos de data se recorren a la variable de row
                foreach ($dataCliente as $rowCliente) {
                    // Se crean las celdas con los datos asignados
                    $pdf->Cell(40, 10, $rowCliente['palabra_clave'], 1, 0);
                    $pdf->Cell(110, 10, $rowCliente['objetivoes'], 1, 0);
                    $pdf->Cell(17, 10, $rowCliente['valor_actualidad'], 1, 0);
                    $pdf->Cell(19, 10, $rowCliente['valor_potencialidad'], 1, 0);
                $pdf->Cell(37.3, 10, utf8_decode(' '), 0, 1, 'C');

                }
            } else {
                $pdf->Cell(0, 10, utf8_decode('No hay procesos en este indicador'), 1, 1);
            }
        } else {
            $pdf->Cell(0, 10, utf8_decode('Ocurrió un error en un estado de ciente'), 1, 1);
        }
    }
} else {
    $pdf->Cell(0, 10, utf8_decode('No hay estado de cliente para mostrar'), 1, 1);
}
// Se realiza un envio del documento al navegador y se invoca al metodo footer
$pdf->Output();
?>
