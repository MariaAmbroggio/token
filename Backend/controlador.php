<?php


function createToken(){
$userame = $_POST['username'];
$respuesta = (new tokenDao())->createToken($userame);
echo json_encode($respuesta);
}





function verifyToken(){
    $respuesta = (new tokenDao())->verifyToken();
    echo json_encode($respuesta);
    }