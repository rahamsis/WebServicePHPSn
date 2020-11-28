<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './VentasADO.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $data = VentasADO::ListarDiagramaLinea("");

    print json_encode(array(
        "estado" => 1,
        "data" => $data,
    ));

    exit();
}