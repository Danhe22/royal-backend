<?php
include 'cors.php';
require_once "conexion/conexion.php";
require_once "respuestas.class.php";


class usuarios extends conexion {

    private $table = "users";
    private $id = "";
    private $nombres = "";
    private $apellidos = "";
    private $rol = "";
    private $pass = "";
    private $token = "";
//912bc00f049ac8464472020c5cd06759

    public function listaUsuarios(){
        
        $query = "SELECT id, nombres, apellidos, rol FROM " . $this->table.  " WHERE rol= '" . 'user' . "'";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    // public function obtenerPaciente($id){
    //     $query = "SELECT * FROM " . $this->table . " WHERE id = '$id'";
    //     return parent::obtenerDatos($query);

    // }

    public function post($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        

        if(!isset($datos['token'])){
                return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken =   $this->buscarToken();
            if($arrayToken){

                if(!isset($datos['id']) || !isset($datos['name']) || !isset($datos['lastName']) || !isset($datos['rol'])){
                    return $_respuestas->error_400();
                }else{
                    $this->id = $datos['id'];
                    $this->nombres = $datos['name'];
                    $this->apellidos = $datos['lastName'];
                    $this->rol = $datos['rol'];
                    $this->pass = parent::encriptar($datos['id']);
                    $resp = $this->insertarUsuario();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "msj" => $datos['name']. " ha sido registrado exitosamente"
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


    private function insertarUsuario(){
        $query = "INSERT INTO " . $this->table . " (`id`, `nombres`, `apellidos`, `rol`, `pass`)
        values
        ('" . $this->id . "','" . $this->nombres . "','" . $this->apellidos ."','" . $this->rol . "','"  . $this->pass . "')"; 
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
                if(!isset($datos['id'])){
                    return $_respuestas->error_400();
                }else{
                    if(isset($datos['id'])) { $this->id = $datos['id'];}
                    if(isset($datos['name'])) { $this->nombres = $datos['name']; }
                    if(isset($datos['lastName'])) { $this->apellidos = $datos['lastName'];}
                    if(isset($datos['rol'])) { $this->rol = $datos['rol'];}
                    $this->pass = parent::encriptar($datos['id']);
        
                    $resp = $this->modificarUsuario();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "msj" => "Datos modificados exitosamente."
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


    private function modificarUsuario(){
        $query = "UPDATE " . $this->table . " SET id ='" . $this->id . "',nombres = '" . $this->nombres . "', apellidos = '" . $this->apellidos . "', rol = '" .
        $this->rol . "', pass = '" . $this->pass . "' WHERE id = '" . $this->id . "'"; 
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

                if(!isset($datos['id'])){
                    return $_respuestas->error_400();
                }else{
                    $this->pacienteid = $datos['id'];
                    $resp = $this->eliminarPaciente($datos['id']);
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "msj" => "Usuario eliminado exitosamente."
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
        $query = "DELETE FROM " . $this->table . " WHERE id= '" . $id . "'";
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


