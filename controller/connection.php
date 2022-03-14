<?php
//conennection to data base
// put @ in front of mysqli_connect to avoid warninng if the conexion fails
$connection =  @mysqli_connect('localhost','dani_ifp','ifp','ifpdb','3307');
$connection_error = 'Error en la conexión';
 //if connection is not successful
 if(!$connection){
    die( $connection_error);
 }
 else{
    echo "ÉXITO";
 }
?>