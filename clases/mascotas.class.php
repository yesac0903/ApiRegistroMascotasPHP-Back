<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";


class mascotas extends conexion{
	 private $table = "pet";
	 private $namePet = "";
	 private $idPet = "";
	 private $status = "";
	 private $categoryPet = "";
	 private $tags = "";
	 private $photoUrls = "";
	 private $token="";



	 public function listaMascotas($pagina = 1){
        $inicio  = 0 ;
        $cantidad = 50;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina - 1)) +1 ;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT idPet,namePet,tags,categoryPet,status FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

     public function obtenerMascotaId($id){
        $query = "SELECT * FROM " . $this->table . " WHERE idPet = '$id'";
        return parent::obtenerDatos($query);

    }

    public function obtenerMascotaStatus($status){
        $query = "SELECT * FROM " . $this->table . " WHERE status = '$status'";
        return parent::obtenerDatos($query);

    }


     public function post($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

       if(!isset($datos['token'])){
                return $_respuestas->error_401();
            }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){

                if(!isset($datos['namePet']) || !isset($datos['categoryPet']) || !isset($datos['status']) ||      !isset($datos['tags'])){
                    return $_respuestas->error_400();
                }else{
                    $this->namePet = $datos['namePet'];
                    $this->categoryPet = $datos['categoryPet'];
                    $this->status = $datos['status'];
                    $this->tags = $datos['tags'];
                    if(isset($datos['photoUrls'])) { $this->photoUrls = $datos['photoUrls']; }
                    

                    $resp = $this->insertarMascota();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "idPet" => $resp
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }
                }else{
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
      
        }
      } 
        private function insertarMascota(){
        $query = "INSERT INTO " . $this->table . " (namePet,photoUrls,tags,categoryPet,status)
        values
        ('" . $this->namePet . "','" . $this->photoUrls . "','" . $this->tags . "','"  . $this->categoryPet . "','" . $this->status . "')"; 
        print_r($query);
        $resp = parent::nonQueryId($query);
        if($resp){
             return $resp;
        }else{
            return 0;
             }

       }
 public function put($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

       if(!isset($datos['token'])){
                return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){

                if(!isset($datos['idPet'])){
                    return $_respuestas->error_400();
                }else{
                    $this->idPet = $datos['idPet'];
                    if(isset($datos['namePet'])) { $this->namePet = $datos['namePet']; }
                    if(isset($datos['photoUrls'])) { $this->photoUrls = $datos['photoUrls']; }
                    if(isset($datos['categoryPet'])) { $this->categoryPet = $datos['categoryPet']; }
                    if(isset($datos['status'])) { $this->status = $datos['status']; }
                    if(isset($datos['tags'])) { $this->tags = $datos['tags']; }
                    

                    $resp = $this->modificarMascota();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "idPet" => $resp
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }

            }else{
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
        }
      }


        private function modificarMascota(){
        $query = "UPDATE " . $this->table . " SET namePet ='" . $this->namePet . "',photoUrls = '" . $this->photoUrls . "', categoryPet = '" . $this->categoryPet . "', status = '" .
        $this->status . "', tags = '" . $this->tags. "' WHERE idPet = '" . $this->idPet . "'"; 
        print_r($query);
        $resp = parent::nonQuery($query);
        if($resp >= 1){
             return $resp;
        }else{
            return 0;
        }
    }
    public function delete($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['token'])){
            return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){

                if(!isset($datos['idPet'])){
                    return $_respuestas->error_400();
                }else{
                    $this->idPet = $datos['idPet'];
                    $resp = $this->eliminarMascota();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "idPet" => $this->idPet);
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }

            }else{
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
        }



     
    }


    private function eliminarMascota(){
        $query = "DELETE FROM " . $this->table . " WHERE idPet = '" . $this->idPet . "'";
        $resp = parent::nonQuery($query);
        print_r($query);
        if($resp >= 1 ){
            return $resp;
        }else{
            return 0;
        }
    }

     private function buscarToken(){
        $query = "SELECT  TokenId,UsuarioId,Estado from usuarios_token WHERE Token = '" . $this->token . "' AND Estado = 'Activo'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }


    private function actualizarToken($tokenid){
        $date = date("Y-m-d H:i");
        $query = "UPDATE usuarios_token SET Fecha = '$date' WHERE TokenId = '$tokenid' ";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }



}

?>