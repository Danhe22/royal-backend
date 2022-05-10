<?php
include 'cors.php';
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class auth extends conexion{

    public function login($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if(!isset($datos['id']) || !isset($datos["pass"])){
            return $_respuestas -> error_400();
        }else{
            $id = $datos['id'];
            $pass = $datos['pass'];
            $pass = parent::encriptar($pass);
            $datos = $this-> obtenerDatosUsuario($id);
            if($datos){
               if($pass == $datos[0]["pass"]){
                    $verificar = $this->insertarToken($datos[0]['id']);
                    if($verificar){
                        $result = $_respuestas->response;
                        $result["result"] = array(
                            "token" => $verificar,
                            "nombre" => $datos[0]['nombres']. " ". $datos[0]['apellidos'],
                            "rol" => $datos[0]['rol']
                        );
                        return $result;
                    }else{
                        return $_respuestas->error_500("Error interno, no hemos podido guardar");
                    }
                    
               }else{
                return $_respuestas->error_200("Contraseña incorrecta");
               }
            }else{
                return $_respuestas->error_200("Usuario $id no registrado");
            }
        }
    }

    private function obtenerDatosUsuario($id){
        $query = "SELECT id,nombres, apellidos, pass, rol FROM users WHERE id = '$id'";
        $datos = parent::obtenerDatos($query);
        if(isset($datos[0]["nombres"])){
            
            return $datos;
        }else{
            return 0;
        }
    }

    private function insertarToken($id){
        $val = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
        $date = date("y-m-d H:i");
        $query = "INSERT INTO tokens (id, Token, Fecha) VALUES ('$id', '$token', '$date')";
        $verificar = parent:: nonQuery($query);
        if($verificar){
            return $token;
        }else{
            return 0;
        }
    }


}