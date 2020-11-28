<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require './VentasADO.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] == "venta") {
        $opcion = $_GET['opcion'];
        $busqueda = $_GET['busqueda'];
        $fechaInicial = $_GET['fechaInicial'];
        $fechaFinal = $_GET['fechaFinal'];
        $empleado = $_GET['empleado'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $ventas = VentasADO::ListVentas($opcion, $busqueda, $fechaInicial, $fechaFinal, 0, 0, $empleado, $posicionPagina, $filasPorPagina, '');
        if (is_array($ventas)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $ventas[0],
                "total" => $ventas[1],
                "suma" => $ventas[2]
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => "debtr.."
            ));
        }
        exit();
    } else if ($_GET["type"] == "allventa") {
        $idVenta = $_GET['idVenta'];
        $detallle = VentasADO::ListVentaDetalle($idVenta);
        if (is_array($detallle)) {
            print json_encode(array(
                "estado" => 1,
                "venta" => $detallle[0],
                "ventadetalle" => $detallle[1]
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $detallle
            ));
        }
    }
}