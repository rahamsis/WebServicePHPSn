<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
require './SuministrosADO.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    if ($_GET["type"] == "modalproductos") {
        $tipo = $_GET["tipo"];
        $value = $_GET["value"];
        $posicionPagina = $_GET["posicionPagina"];
        $filasPorPagina = $_GET["filasPorPagina"];
        //$search = $_GET['search'];
        $suministros = SuministrosADO::ListarSuministroView($tipo, $value, $posicionPagina, $filasPorPagina);
        if (is_array($suministros)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $suministros[0],
                "total" => $suministros[1]
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $suministros
            ));
        }
        exit();
    } else if ($_GET["type"] === "listaproductos") {
        $opcion = $_GET["opcion"];
        $clave = $_GET["clave"];
        $nombre = $_GET["nombre"];
        $posicionPagina = $_GET["posicionPagina"];
        $filasPorPagina = $_GET["filasPorPagina"];
        $suministros = SuministrosADO::ListarSuministros(intval($opcion), $clave, $nombre, 0, 0, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($suministros)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $suministros[0],
                "total" => $suministros[1]
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "message" => $suministros
            ));
        }
        exit();
    }
}
