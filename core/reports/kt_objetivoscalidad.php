<?php
//Direcciones para realizar el reporte
require('../helpers/report.php');
require('../models/kt_indicadores.php');
require('../models/kt_objetivos_calidad.php');
// Se declara la variable para comenzar una estancia
$pdf = new Report;
// Comienza a ejecutarse el encabezado del reporte
$pdf->reportHeader('Indicadores segun el objetivo de calidad');

$proceso = new ObjetivosCalidad;
if ($dataProceso = $proceso->readObjetivoCalidad()) {
    foreach ($dataProceso as $rowProceso) {
    // Se pone una distincion de colores por el formato RGB    
        $pdf->SetFillColor(175);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, utf8_decode('Indicadores de objetivo de calidad: '.$rowProceso['palabra_clave']), 1, 1, 'C', 1);
        $indicadores = new Indicadores;
        if ($indicadores->setId($rowProceso['rowid'])) {
            if ($dataCliente = $indicadores->readObjetivoIndicadores()) {
                // Se pone una distincion de colores por el formato RGB
                $pdf->SetFillColor(244,91,91);
                // Se establece la fuente para el nombre de la categoría.
                $pdf->SetFont('Times', 'B', 11);
                // Se comienzan a crear las celdas y los encabezados
                $pdf->Cell(40, 10, utf8_decode('Frecuencia'), 1, 0, 'C', 1);
                $pdf->Cell(110, 10, utf8_decode('Objetivo especifico'), 1, 0, 'C', 1);
                $pdf->Cell(17, 10, utf8_decode('Valor.A'), 1, 0, 'C', 1);
                $pdf->Cell(19, 10, utf8_decode('Valor.P'), 1, 0, 'C', 1);
                $pdf->Cell(37.3, 10, utf8_decode(' '), 0, 1, 'C');
                // Se decide una fuente para los datos que se usaran
                $pdf->SetFont('Times', '', 11);
                // Los datos de data se recorren a la variable de row
                foreach ($dataCliente as $rowCliente) {
                    // Se crean las celdas con los datos asignados
                    $pdf->Cell(40, 10, $rowCliente['frecuencia_medicion'], 1, 0);
                    $pdf->Cell(110, 10, $rowCliente['objetivoes'], 1, 0);
                    $pdf->Cell(17, 10, $rowCliente['valor_actualidad'], 1, 0);
                    $pdf->Cell(19, 10, $rowCliente['valor_potencialidad'], 1, 0);
                $pdf->Cell(37.3, 10, utf8_decode(' '), 0, 1, 'C');

                }
            } else {
                $pdf->Cell(0, 10, utf8_decode('No hay objetivos en este indicador'), 1, 1);
            }
        } else {
            $pdf->Cell(0, 10, utf8_decode('Ocurrió un error en un objetivos'), 1, 1);
        }
    }
} else {
    $pdf->Cell(0, 10, utf8_decode('No hay objetivos para mostrar'), 1, 1);
}
// Se realiza un envio del documento al navegador y se invoca al metodo footer
$pdf->Output();
?>
