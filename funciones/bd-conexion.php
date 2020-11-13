<?php

// include_once 'config.php'; 
// // Creamos la conexion con la base de datos
// $conn = new mysqli(HOST, USUARIO, PASS, BASEDATOS);
// //que tenga un error con el if
// if($conn->connect_error){
//     //imprimimos el error que venga de conect error
//     echo $error -> $conn->connect_error;
// }

try {

    $usuario = "root";
    $contrasena = "";
     $opciones = [
       PDO::ATTR_CASE => PDO::CASE_NATURAL,
       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //Forma en que Devolvera los resultados
    ];   
 $dsn = "mysql:host=localhost; dbname=bdticket";
 $conn = new PDO($dsn, $usuario, $contrasena, $opciones);
}catch( PDOException $e ) {
    die("Error: ". $e->getMessage()." ".$e->getCode());    
}





?>