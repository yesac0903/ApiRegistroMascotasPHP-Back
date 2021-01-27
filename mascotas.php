<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/mascotas.class.php';

$_respuestas = new respuestas;
$_mascotas = new mascotas;

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["page"])){
        $pagina = $_GET["page"];
        $listaMascotas = $_mascotas->listaMascotas($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaMascotas);
        http_response_code(200);
        }else if(isset($_GET['id'])){
        $idPet = $_GET['id'];
        $datosMascota = $_mascotas->obtenerMascotaId($idPet);
        header("Content-Type: application/json");
        echo json_encode($datosMascota);
        http_response_code(200);
        }else if(isset($_GET['status'])){
        $status = $_GET['status'];
        $datosMascota = $_mascotas->obtenerMascotaStatus($status);
        header("Content-Type: application/json");
        echo json_encode($datosMascota);
        http_response_code(200);
        }

    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");

    //enviamos los datos al manejador
    $datosArray = $_mascotas->post($postBody);
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
      $datosArray = $_mascotas->put($postBody);
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
        if(isset($headers["token"]) && isset($headers["idPet"])){
            //recibimos los datos enviados por el header
            $send = [
                "token" => $headers["token"],
                "idPet" =>$headers["idPet"]
            ];
            $postBody = json_encode($send);
        }else{
            //recibimos los datos enviados
            $postBody = file_get_contents("php://input");
        }
        
        //enviamos datos al manejador
        $datosArray = $_mascotas->delete($postBody);
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




?>