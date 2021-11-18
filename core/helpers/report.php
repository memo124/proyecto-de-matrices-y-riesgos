<?php
//aca están las rutas de archivos que usara archivo de la clase Report
require('../../libraries/fpdf181/fpdf.php');
require('../../core/helpers/conexion.php');
require('../../core/helpers/validator.php');
//Se indica la zona horaria con la que se trabajará mientras se ejecute el reporte.
ini_set('date.timezone', 'America/El_Salvador');
//Acá se crea una variable de sesión o se reanuda la anterior para trabajar con dichas variables
session_start();
/*
*   Creación de la clase Report heredada de la clase FPDF 
    que definie la plantilla de los reportes del sitio privado.
*/
class Report extends FPDF
{
    //Creación de la propiedad para contener el título del reporte.
    private $title = null;

    /*Método que inicia el reporte con el encabezado en el documento,
    recibe por parámetros el título del reporte*/
    public function reportHeader($title)
    {
        /*Si el usuario no es SuperAdministrador o Administrador, no podra generar el reporte*/
        if($_SESSION['LEVEL'] == 'S' || $_SESSION['LEVEL'] == 'A'){
            /*Se evalua si el usuario inició sesión para generar 
            el comprobante de compras, sino se redirecciona a Menu.php*/
            if ( isset($_SESSION['ROWID']) ) {
                //Se coloca el título del documento a la propiedad de la clase Reporte.
                $this->title = $title;
                //Se indica el título del documento (true = utf-8).
                $this->SetTitle($this->title, true);
                //Se indica la medida de los márgenes del documento (izquierdo, superior y derecho).
                $this->setMargins(15, 15, 15);
                /*Se agrega una nueva página al documento con orientación vertical y formato carta,
                y se invoca al método Header().*/
                $this->AddPage('P', 'letter');
                /*Se establece el alias para el número total de páginas
                que se mostrará en el pie del documento.*/
                $this->AliasNbPages();
            } else {
                /*Se redirecciona a la página Menu.php, si el usuario 
                no inició sesión para generar el reporte*/
                header('location: ../../views/Matrices.php');
            }
        }else{
            exit('<b><h1>Quien pvtas te dijo que podes ver reportes, tenes que ser SuperAdministrador o Administrador sino vayase a la memo .l.</h1></b>');
        }
    }

    /*Método que configura el diseño e imprime el encabezado del reporte*/
    public function header()
    {
        /*Se imprime un rectángulo en el encabezado del documento, pasando por parámetros
        la ubicación en el eje X, la ubicación en el eje Y, el ancho y el alto*/
        $this->Rect( 15 , 15 , 186, 30);
        /*Se imprime una imagen en el encabezado del documento, pasando por parámetros
        la ruta de la imagen, la ubicación en el eje X, la ubicación en el eje Y,
        el ancho y el alto*/
       $this->Image('../../resources/img/Procaps_logo.png', 17, 15, 70);
        //Se determina la ubicación del título.
        $this->Cell(20);
        /*Se determina la fuente a usar*/
        $this->SetFont('Arial', 'B', 15);
        /*Se imprime la celda que contiene el título del documento*/
        $this->Cell(166, 10, utf8_decode($this->title), 0, 1, 'C');
         //Se determina la ubicación de la fecha y hora del servidor.
        $this->Cell(20);
        /*Se determina la fuente a usar*/
        $this->SetFont('Arial', '', 10);
        /*Se imprime la celda que contiene la fecha y la hora*/
        $this->Cell(166, 10, 'Reporte generado por: '.$_SESSION['USER_ID'], 0, 1, 'C');
        $this->Cell(20);
        $this->Cell(166, 10, 'Fecha/Hora: '.date('d-m-Y H:i:s'), 0, 1, 'C');
        // Se añade un salto de línea para mostrar la información principal del documento.
        $this->Ln(10);
    }

    /*Se sobrescribe el método de la librería FPDF para configurar el pie del documento y
    Se invoca automáticamente en el método Output()*/
    public function footer()
    {
        /*Se determina el color a usar para el rectángulo impreso en el
        pie del documento*/
        $this->SetFillColor(244,91,91);
        //Se indica la posición del número de página (a 15 milimetros del final).
        $this->SetY(-15);
        /*Se imprime un rectángulo en el pie del documento, pasando por parámetros
        la ubicación en el eje X, la ubicación en el eje Y, el ancho, el alto
        y el tipo de relleno*/
        $this->Rect( 0 , 264.5 , 216, 15, 'F');
        /*Se determina la fuente a usar*/
        $this->SetFont('Arial', 'I', 8);
        //Se imprime la celda que contiene el número de página
        $this->Cell(0, 10, utf8_decode('Página ').$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}
?>
