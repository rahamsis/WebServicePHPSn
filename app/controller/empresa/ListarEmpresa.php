<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require './EmpresaADO.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $data = EmpresaADO::ObtenerEmpresa();

    if(is_null($data)){
        print json_encode(array(
            "estado" => 2,
            "message" => "Error en cargar los datos"
        ));
    }else{
        print json_encode(array(
            "estado" => 1,
            "result" => $data,
        ));
    }
    exit();
}