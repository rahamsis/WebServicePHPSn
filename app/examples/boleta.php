<?php

error_reporting(0);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';

$util = Util::getInstance();

require_once '../sunat/database/DataBaseConexion.php';
require("../sunat/ventas/VentasADO.php");

$idventa = $_GET['idventa'];

$detalleventa = VentasADO::ListarDetalleVentPorId($idventa);

$cliente = $detalleventa[2];
$venta = $detalleventa[3];

// Cliente
$client = new Client();
$client->setTipoDoc($cliente->IdAuxiliar)
        ->setNumDoc($cliente->NumeroDocumento)
        ->setRznSocial($cliente->Informacion);

// Venta
$invoice = new Invoice();
$invoice
        ->setUblVersion('2.1')
        ->setTipoOperacion('0101')
        ->setTipoDoc($venta->TipoComprobante)
        ->setSerie($venta->Serie)
        ->setCorrelativo($venta->Numeracion)
        ->setFechaEmision(new DateTime($venta->FechaVenta . "T" . $venta->HoraVenta))
        ->setTipoMoneda($venta->TipoMoneda)
        ->setCompany($util->shared->getCompany())
        ->setClient($client)
        ->setMtoOperGravadas(round($detalleventa[0]['totalsinimpuesto'], 2, PHP_ROUND_HALF_UP)) //5.10
        ->setMtoIGV(round($detalleventa[0]['totalimpuesto'], 2, PHP_ROUND_HALF_UP)) //0.92
        ->setTotalImpuestos(round($detalleventa[0]['totalimpuesto'], 2, PHP_ROUND_HALF_UP)) //0.92
        ->setValorVenta(round($detalleventa[0]['totalsinimpuesto'], 2, PHP_ROUND_HALF_UP)) //5.10
        ->setSubTotal(round($detalleventa[0]['totalconimpuesto'], 2, PHP_ROUND_HALF_UP)) //6
        ->setMtoImpVenta(round($detalleventa[0]['totalconimpuesto'], 2, PHP_ROUND_HALF_UP)) //6
;

$detail = [];

foreach ($detalleventa[0]['detalle'] as $key => $value) {

        $cantidad = $value['Cantidad'];
        $impuesto = $value['ValorImpuesto'];
        $precioBruto = $value['PrecioVenta'];

        $impuestoGenerado = $precioBruto * ($impuesto / 100.00);
        $impuestoTotal = $impuestoGenerado * $cantidad;
        $importeBrutoTotal = $precioBruto * $cantidad;
        $importeNeto = $precioBruto + $impuestoGenerado;
        $importeNetoTotal = $importeBrutoTotal + $impuestoTotal;

        $item1 = new SaleDetail();
        $item1->setCodProducto($value['ClaveSat'])
                ->setUnidad($value['CodigoUnidad'])
                ->setCantidad(round($cantidad, 2, PHP_ROUND_HALF_UP)) //2
                ->setDescripcion($value['NombreMarca'])
                ->setMtoBaseIgv($importeBrutoTotal) //18 50*2
                ->setPorcentajeIgv(round($impuesto, 0, PHP_ROUND_HALF_UP)) //18
                ->setIgv($impuestoTotal) //18 9*2
                ->setTipAfeIgv('10')
                ->setTotalImpuestos($impuestoTotal) //18 9*2
                ->setMtoValorVenta($importeBrutoTotal) //100 = 50*2
                ->setMtoValorUnitario(round($precioBruto, 2, PHP_ROUND_HALF_UP)) //50
                ->setMtoPrecioUnitario($importeNeto); //59
        array_push($detail, $item1);
}

$legend = new Legend();
$legend->setCode('1000')
        ->setValue($util->ConvertirNumerosLetras(round($detalleventa[0]['totalconimpuesto'], 2, PHP_ROUND_HALF_UP), $venta->NombreMoneda));

$invoice->setDetails($detail)
        ->setLegends([$legend]);

// Envio a SUNAT.
//FE_BETA
//FE_PRODUCCION
$point = SunatEndpoints::FE_PRODUCCION;
$see = $util->getSee($point);
$res = $see->send($invoice);
$util->writeXml($invoice, $see->getFactory()->getLastXml());
$hash = $util->getHashCode($invoice);

if ($res->isSuccess()) {
        $cdr = $res->getCdrResponse();
        $util->writeCdr($invoice, $res->getCdrZip());        
        // $util->showResponse($invoice, $cdr);
        if ($cdr->isAccepted()) {
                VentasADO::CambiarEstadoSunatVenta($idventa, $cdr->getCode(), $cdr->getDescription());
                echo json_encode(array(
                        "state" => $res->isSuccess(),
                        "accept" => $cdr->isAccepted(),
                        "id" => $cdr->getId(),
                        "code" => $cdr->getCode(),
                        "description" => $cdr->getDescription()
                ));
        } else {
                VentasADO::CambiarEstadoSunatVenta($idventa, $cdr->getCode(), $cdr->getDescription());
                echo json_encode(array(
                        "state" => $res->isSuccess(),
                        "accept" => $cdr->isAccepted(),
                        "id" => $cdr->getId(),
                        "code" => $cdr->getCode(),
                        "description" => $cdr->getDescription(),
                        "hashcode"=>$pdf
                ));
        }
        exit();
} else {
    
        if ($res->getError()->getCode() === "1033") {
                VentasADO::CambiarEstadoSunatVenta($idventa, "0", $res->getError()->getMessage());
                echo json_encode(array(
                        "state" => false,
                        "code" => $res->getError()->getCode(),
                        "description" => $res->getError()->getMessage()
                ));
        } else {
                echo json_encode(array(
                        "state" => false,
                        "code" => $res->getError()->getCode(),
                        "description" => $res->getError()->getMessage()
                ));
        }

        exit();
        //echo $util->getErrorResponse($res->getError());
}
