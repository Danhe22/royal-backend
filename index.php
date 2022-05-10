<?php

require_once "clases/conexion/conexion.php";

$conexion = new conexion;

// $fecha_actual = date("d-m-Y");
// //sumo 1 mes
// echo date("d-m-Y",strtotime($fecha_actual."+ 90 day"));

// echo ceil(13000/2000); 
$saldo =65000;
$dias= 0;
while($saldo/30000 >=1){
    $saldo-=30000;
    $dias+=1;


}

$dias*=30;

$dias += ceil($saldo/2000);
echo " ";
echo $dias;

