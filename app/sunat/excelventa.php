<?php

set_time_limit(300); //evita el error 20 segundos de peticion
session_start();

require __DIR__ . "/lib/phpspreadsheet/vendor/autoload.php";
require_once __DIR__ . '/database/DataBaseConexion.php';
include __DIR__ . "/ventas/VentasADO.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

$ventas = VentasADO::GetReporteGenetalVentas($_GET["txtFechaInicial"], $_GET["txtFechaFinal"], 0, "", "");


$documento = new Spreadsheet();
$documento
    ->getProperties()
    ->setCreator("Creado por SysSoftIntegra")
    ->setTitle('Reporte general')
    ->setSubject('Reporte')
    ->setDescription('Reporte general de ventas de la fecha '.$_GET["txtFechaInicial"].' al '.$_GET["txtFechaFinal"])
    ->setKeywords('Reporte Venta General')
    ->setCategory('Ventas');

$documento->getActiveSheet()->setTitle("Venta general");

$documento->getActiveSheet()->getStyle('A1:J1')->applyFromArray(array(
    'borders' => array(
        'outline' => array(
            'borderStyle' => Border::BORDER_THIN,
            'color' => array('argb' => '000000'),
        ),
    ),
    'fill' => array(
        'fillType' => Fill::FILL_SOLID,
        'startColor' => array('argb' => '006ac1')
    ),
    'font'  => array(
        'bold'  =>  true,
        'color' => array('argb' => 'ffffff')
    ),
    'alignment' => array(
        'horizontal' => Alignment::HORIZONTAL_CENTER
    )
));

$documento->setActiveSheetIndex(0)->mergeCells('A1:J1');
$documento->setActiveSheetIndex(0)
    ->setCellValue("A1", "REPORTE GENERAL DE VENTAS DE ".$_SESSION["NombreComercial"]);

$documento->getActiveSheet()->getStyle('H2:J2')->applyFromArray(array(
    'borders' => array(
        'outline' => array(
            'borderStyle' => Border::BORDER_THIN,
            'color' => array('argb' => '000000'),
        ),
    ),
    'fill' => array(
        'fillType' => Fill::FILL_SOLID,
        'startColor' => array('rgb' => '808080')
    ),
    'font'  => array(
        'bold'  =>  true,
        'color' => array('argb' => 'ffffff')
    ),
    'alignment' => array(
        'horizontal' => Alignment::HORIZONTAL_CENTER
    )
));
$documento->setActiveSheetIndex(0)
    ->setCellValue("H2", "FECHA")
    ->setCellValue("I2", $_GET["txtFechaInicial"])
    ->setCellValue("J2", $_GET["txtFechaFinal"]);

$documento->getActiveSheet()->getStyle('A3:J3')->applyFromArray(array(
    'fill' => array(
        'type' => Fill::FILL_SOLID,
        'color' => array('rgb' => 'E5E4E2')
    ),
    'font'  => array(
        'bold'  =>  true
    ),
    'alignment' => array(
        'horizontal' => Alignment::HORIZONTAL_CENTER
    )
));

$documento->setActiveSheetIndex(0)
    ->setCellValue("A3", "N°")
    ->setCellValue("B3", "FECHA")
    ->setCellValue("C3", "TIPO DOCUMENTO")
    ->setCellValue("D3", "NÚMERO DOCUMENTO")
    ->setCellValue("E3", "DATOS CLIENTE")
    ->setCellValue("F3", "TIPO COMPROBANTE")
    ->setCellValue("G3", "SERIE")
    ->setCellValue("H3", "NUMERACIÓN")
    ->setCellValue("I3", "ESTADO")
    ->setCellValue("J3", "TOTAL");

$cel = 4;
foreach ($ventas as $key => $value) {
    $documento->getActiveSheet()->getStyle('A' . $cel . ':I' . $cel . '')->applyFromArray(array(
        'fill' => array(
            'type' => Fill::FILL_SOLID,
            'color' => array('rgb' => 'E5E4E2')
        ),
        'font'  => array(
            'bold'  =>  false
        ),
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_LEFT
        )
    ));

    $documento->getActiveSheet()->getStyle("J" . $cel)->getNumberFormat()->setFormatCode('0.00');

    $documento->setActiveSheetIndex(0)
        ->setCellValue("A" . $cel,  strval($value["Id"]))
        ->setCellValue("B" . $cel, strval($value["FechaVenta"]))
        ->setCellValue("C" . $cel, strval($value["TipoDocumento"]))
        ->setCellValue("D" . $cel, strval($value["NumeroDocumento"]))
        ->setCellValue("E" . $cel, strval($value["Cliente"]))
        ->setCellValue("F" . $cel, strval($value["Nombre"]))
        ->setCellValue("G" . $cel, strval($value["Serie"]))
        ->setCellValue("H" . $cel, strval($value["Numeracion"]))
        ->setCellValue("I" . $cel, strval($value["EstadoName"]))
        ->setCellValue("J" . $cel, strval($value["Total"]));
    $cel++;
}

//Ancho de las columnas
$documento->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$documento->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$documento->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$documento->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$documento->getActiveSheet()->getColumnDimension('E')->setWidth(25);
$documento->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$documento->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$documento->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$documento->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$documento->getActiveSheet()->getColumnDimension('J')->setWidth(15);

$nombreDelDocumento = $_SESSION["NombreComercial"]." Venta General.xlsx";
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $nombreDelDocumento);
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

ob_end_clean();
$writer = IOFactory::createWriter($documento, 'Xlsx');
$writer->save('php://output');
exit;
