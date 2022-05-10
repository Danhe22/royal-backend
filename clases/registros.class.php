<?php
include 'cors.php';
require_once "conexion/conexion.php";
require_once "respuestas.class.php";


class registros extends conexion {

    private $table = "registros";
    private $userId = "";
    private $pago = "";
    private $fechapago = "";
    private $fechafin = "";
    private $token = "";

    public function listaPagos(){
        
        $query = "SELECT userId, pago, fechapago, fechafin FROM " . $this->table;
        $datos = parent::obtenerDatos($query);
        return ($datos);
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

                if(!isset($datos['userId']) || !isset($datos['pago'])){
                    return $_respuestas->error_400();
                }else{
                    $this->userId = $datos['userId'];
                    $this->pago = intval($datos['pago']);
                    $this->fechapago = date("Y-m-d");
                    // $dias = (string)($this-> calcularDias($this->pago));
                    // echo $dias;
                    $this->fechafin = date("Y-m-d",strtotime($this->fechapago. $this->calcularDias($datos['pago'])));
                    
                    $resp = $this->insertarPagos();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "msj" => "Pago registrado exitosamente"
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }

            }else{
                echo $arrayToken;
                return $_respuestas->error_401("El Token que envio es invalido o ha caducado");
            }
        }

       
       

    }

    private function calcularDias($pago){
        $dias=0;
        if($pago >= 30000){
            while($pago/30000 >=1){
                $pago-=30000;
                $dias+=1;
            
            
            }
            
            $dias*=30;
            
            $dias += ceil($pago/2000);

            return $dias. " day";
        }else{
            $dias= ceil($pago/2000);
            return $dias. " day";
        }
    }

   private function insertarPagos(){
        $query = "INSERT INTO " . $this->table . " (`userId`, `pago`, `fechapago`, `fechafin`)
        values
        ('" . $this->userId . "','" . $this->pago . "','" . $this->fechapago ."','" . $this->fechafin ."')"; 
        $resp = parent::nonQueryId($query);
        if($resp){
            
             return $resp;
        }else{
            return 0;
        }
    }




    public function put($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        
        if(!isset($datos['token'])){
            return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){
                if(!isset($datos['userId'])){
                    return $_respuestas->error_400();
                }else{
                    if(isset($datos['userId'])) { $this->userId = $datos['userId'];}
                    if(isset($datos['pago'])) { $this->pago = intval($datos['pago']); }
                    if(isset($datos['fechapago'])) { $this->fechapago = $datos['fechapago'];}
                    $this->fechafin = date("Y-m-d",strtotime($this->fechapago. $this->calcularDias($datos['pago'])));
                    
        
                    $resp = $this->modificarPago();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "msj" => "Pago modificado exitosamente."
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


    private function modificarPago(){
        $query = "UPDATE " . $this->table . " SET userId ='" . $this->userId . "',pago = '" . $this->pago . "', fechapago = '" . $this->fechapago . "', fechafin = '" .
        $this->fechafin .  "' WHERE userId = '" . $this->userId . "'"; 
        $resp = parent::nonQuery($query);
        if($resp>=1){
            
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

                if(!isset($datos['userId'])){
                    return $_respuestas->error_400();
                }else{
                    $this->userId = $datos['userId'];
                    $resp = $this->eliminarPaciente($datos['userId']);
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "msj" => "Pago eliminado exitosamente."
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


    private function eliminarPaciente($id){
        $query = "DELETE FROM " . $this->table . " WHERE userId= '" . $id . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1 ){
            return $resp;
        }else{
            echo $query;
            return 0;
        }
    }




    private function buscarToken(){
        $query = "SELECT  TokenId, id from tokens WHERE Token = '" . $this->token . "'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }


    private function actualizarToken($tokenid){
        $date = date("Y-m-d H:i");
        $query = "UPDATE tokens SET Fecha = '$date' WHERE TokenId = '$tokenid' ";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }

}