<?php

error_reporting(0);
set_time_limit(300); //evita el error 20 segundos de peticion
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Sale\Document;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Summary\SummaryPerception;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';
require_once '../sunat/database/DataBaseConexion.php';
require "../sunat/ventas/VentasADO.php";

$util = Util::getInstance();

$idventa = $_GET['idventa'];
$detalleventa = VentasADO::ObtenerIngresoXML($idventa);
$cliente = $detalleventa[1];
$empresa = $detalleventa[2];
$totales = $detalleventa[3];
try {
    date_default_timezone_set('America/Lima');
    $currentDate = date('Y-m-d');
    // $queryCorrelativoResumen = Database::getInstance()->getDb()->prepare("SELECT dbo.Fc_Correlativo_Resumen_Diario();");
    // $queryCorrelativoResumen->execute();
    // $idCorrelativo = $queryCorrelativoResumen->fetchColumn();

    $company = new Company();
    $company->setRuc($empresa->NumeroDocumento)
        ->setNombreComercial($empresa->NombreComercial)
        ->setRazonSocial($empresa->RazonSocial)
        ->setAddress((new Address())
            ->setUbigueo('120101')
            ->setDistrito('HUANCAYO')
            ->setProvincia('HUANCAYO')
            ->setDepartamento('JUNIN')
            ->setUrbanizacion('')
            ->setCodLocal('0000')
            ->setDireccion($empresa->Domicilio))
        ->setEmail($empresa->Telefono)
        ->setTelephone($empresa->Email);

    $detiail1 = new SummaryDetail();
    $detiail1->setTipoDoc('03')
        ->setSerieNro($cliente->Serie . '-' . $cliente->Numeracion)
        //->setSerieNro('BC01-72')
        ->setEstado('3') //Anulación 3, 1 AÑADIR
        ->setClienteTipo($cliente->TipoDocumento)
        ->setClienteNro($cliente->idDNI)
        ->setTotal(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP))
        ->setMtoOperExoneradas(round($totales['totalsinimpuesto'], 2, PHP_ROUND_HALF_UP))
        ->setMtoIGV(round($totales['totalimpuesto'], 2, PHP_ROUND_HALF_UP));
    // ->setClienteTipo("0")
    // ->setClienteNro("0")
    // ->setTotal(round(1130.00, 2, PHP_ROUND_HALF_UP))
    // ->setMtoOperExoneradas(round(1130.00, 2, PHP_ROUND_HALF_UP))
    // ->setMtoIGV(round(0, 2, PHP_ROUND_HALF_UP));

    $sum = new Summary();
    // Fecha Generacion menor que Fecha Resumen 
    $sum->setFecGeneracion(new DateTime($cliente->FechaPago))
        // $sum->setFecGeneracion(new DateTime("2020-10-26"))
        //COMO AGREGO LA FECH ACTUAL
        ->setFecResumen(new DateTime($currentDate))
        //->setCorrelativo($idCorrelativo)
        ->setCorrelativo('1')
        ->setCompany($company)
        ->setDetails([$detiail1]);

    // Envio a SUNAT.
    $see = $util->getSee(SunatEndpoints::FE_PRODUCCION, $empresa->NumeroDocumento, $empresa->UsuarioSol, $empresa->ClaveSol);

    $res = $see->send($sum);
    $util->writeXml($sum, $see->getFactory()->getLastXml());
    // primer codigo de error el enviar el resumen diario
    // cdogio = 0098 
    // El procesamiento del comprobante aún no ha terminado

    //error de envio ala sunat pero si falla el codigo de error esta
    //codigo = 1032 
    //El comprobante ya esta informado y se encuentra con estado anulado o rechazado - 
    //Detalle: xxx.xxx.xxx value='ticket: 202006023348076 error:
    //El comprobante B001-010674 fue anulado'

    if (!$res->isSuccess()) {
        echo json_encode(array(
            "state" => false,
            "code" => $res->getError()->getCode(),
            "description" => $res->getError()->getMessage()
        ));
    } else {
        $ticket = $res->getTicket();
        $res = $see->getStatus($ticket);
        if (!$res->isSuccess()) {
            //echo $util->getErrorResponse($res->getError());
            Database::getInstance()->getDb()->rollback();
            echo json_encode(array(
                "state" => false,
                "code" => $res->getError()->getCode(),
                "description" => $res->getError()->getMessage()
            ));
        } else {
            $cdr = $res->getCdrResponse();
            $util->writeCdr($sum, $res->getCdrZip());
            // $util->showResponse($sum, $cdr);
            if (!$cdr->isAccepted()) {
                VentasADO::CambiarEstadoSunatResumen($idventa, $cdr->getCode(), $cdr->getDescription(), $hash);
                echo json_encode(array(
                    "state" => $res->isSuccess(),
                    "accept" => $cdr->isAccepted(),
                    "id" => $cdr->getId(),
                    "code" => $cdr->getCode(),
                    "description" => $cdr->getDescription()
                ));
                Database::getInstance()->getDb()->commit();
            } else {
                VentasADO::CambiarEstadoSunatResumen($idventa, $cdr->getCode(), $cdr->getDescription(), $hash);
                echo json_encode(array(
                    "state" => $res->isSuccess(),
                    "accept" => $cdr->isAccepted(),
                    "id" => $cdr->getId(),
                    "code" => $cdr->getCode(),
                    "description" => $cdr->getDescription()
                ));
            }
        }
    }
} catch (Exception $ex) {
    echo json_encode(array(
        "state" => false,
        "code" => -1,
        "description" => $ex->getMessage()
    ));
}

