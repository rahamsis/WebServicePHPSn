<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './MovimientoADO.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petición GET
    
    //$search = $_GET['search'];
    $result = MovimientoADO::CancelarMovimientoById($_GET["idMovimiento"]);
    if($result === "deleted"){
        print json_encode(array(
            "estado" => 1,
            "mensaje" => "Cancelado correctamente el movimiento."
        ));
    }else if($result === "exists"){
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "El movimiento ya está cancelado."
        ));
    }else{
        print json_encode(array(
            "estado" => 3,
            "mensaje" => $result
        ));
    }   
    exit();
}
