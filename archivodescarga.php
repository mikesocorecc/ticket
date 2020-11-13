<?php 
include_once 'funciones/bd-conexion.php'; 
$idticket = $_GET['id'];
$stmt = $conn->prepare("SELECT archivo FROM  tickets WHERE idticket =  :idticket " );                                         
$stmt->bindValue(":idticket", $idticket, PDO::PARAM_STR);  
$stmt->execute();             
$fila = $stmt->fetch();  
    // $stmt = $conn->prepare("SELECT archivo FROM  tickets WHERE idticket = ? ");
    // $stmt->bind_param("s", $idticket );
    // $stmt->execute();
    // $resultado = $stmt->get_result();
    // $fila = $resultado->fetch_assoc();

$archivo = $fila['archivo'];
//Especificamos el directorio
$directorio = "dist/img/imgticket/";
$descargar =  $directorio.$archivo;

if(!empty($archivo)){
       //Comprobamos si el archivo existe en la ruta
       if(file_exists($descargar)){
         header('Content-Disposition: attachment; filename=' . $archivo);  
         readfile($descargar); 
         exit;
       }else{
         die("El archivo no existe");
       }
    }    


?>