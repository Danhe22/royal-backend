<?php
include 'cors.php';
require_once 'clases/respuestas.class.php';
require_once 'clases/registros.class.php';

$_respuestas = new respuestas;
$_registros = new registros;


if($_SERVER['REQUEST_METHOD'] == "GET"){

        $listaPagos = $_registros->listaPagos();
        header("Content-Type: application/json");
        echo json_encode($listaPagos);
        http_response_code(200);
    // }else if(isset($_GET['id'])){
    //     $pacienteid = $_GET['id'];
    //     $datosPaciente = $_pacientes->obtenerPaciente($pacienteid);
    //     header("Content-Type: application/json");
    //     echo json_encode($datosPaciente);
    //     http_response_code(200);
    // }
    
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    
    //enviamos los datos al manejador
    $datosArray = $_registros->post($postBody);
    //delvovemos una respuesta 
     header('Content-Type: application/json');
     if(isset($datosArray["result"]["error_id"])){
         $responseCode = $datosArray["result"]["error_id"];
         http_response_code($responseCode);
     }else{
         http_response_code(200);
     }
     echo json_encode($datosArray);
    
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos datos al manejador
    $datosArray = $_registros->put($postBody);
      //delvovemos una respuesta 
   header('Content-Type: application/json');
   if(isset($datosArray["result"]["error_id"])){
       $responseCode = $datosArray["result"]["error_id"];
       http_response_code($responseCode);
   }else{
       http_response_code(200);
   }
   echo json_encode($datosArray);

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $headers = getallheaders();
    if(isset($headers["token"]) && isset($headers["userId"])){
        //recibimos los datos enviados por el header
        $send = [
            "token" => $headers["token"],
            "userId" =>$headers["userId"]
        ];
        $postBody = json_encode($send);
    }else{
        //recibimos los datos enviados
        $postBody = file_get_contents("php://input");
    }
    
    //enviamos datos al manejador
    $datosArray = $_registros->delete($postBody);
    //delvovemos una respuesta 
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);
   

}else{
header('Content-Type: application/json');
$datosArray = $_respuestas->error_405();
echo json_encode($datosArray);
}