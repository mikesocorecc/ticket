<?php

include_once 'funciones/seguridad.php';
include_once 'funciones/bd-conexion.php';

//Eliminar
if ($_POST['registro'] == 'eliminar') {
    //capturamos el id que es enviado por ajax
    $id_borrar = $_POST['id'];
    try {     
        $stmt = $conn->prepare("DELETE FROM areas WHERE idarea = :idarea "); 
        $stmt->bindValue(":idarea", $id_borrar, PDO::PARAM_INT);  
        if ($stmt->execute()) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_eliminado' => $id_borrar
            );
            
             die(json_encode($respuesta));
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        //$stmt->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }


    die(json_encode($respuesta));
}


$pagina = 'areas.php';
$area = filtrado($_POST['area']);
if ($_POST['registro'] == 'nuevo') {   
    if (!empty($area) ) {
        try {        
            $stmt = $conn->prepare("INSERT INTO areas (nombre) VALUES (:nombre)  ");                                         
            $stmt->bindValue(":nombre", $area, PDO::PARAM_STR);               
            if ($stmt->execute()) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'redireccion' => $pagina
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error',
                );
                die(json_encode($respuesta));
            }
            $stmt = null;
            $conn = null;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }else{
        $respuesta = array(
            'respuesta' => 'error',
        );
    }

    die(json_encode($respuesta));
}

//Actualizar
if ($_POST['registro'] == 'actualizar') {
    $id_registro = filtrado($_POST['id_registro']);
    if (!empty($area) ) {
        try {         
            $stmt = $conn->prepare("UPDATE `areas` SET `nombre` = :nombre, `editado` = NOW() WHERE `areas`.`idarea` =  :idarea ");                                         
            $stmt->bindValue(":nombre", $area, PDO::PARAM_STR);              
            $stmt->bindValue(":idarea", $id_registro, PDO::PARAM_INT);              
            if ($stmt->execute()) {
                $respuesta = array(
                    'respuesta' => 'exito',
                    'redireccion' => $pagina
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'Error'
                );
            }
            $stmt = null;
            $conn = null;
        } catch (Exception $e) {
            $respuesta = array(
                'respuesta' => $e->getMessage()
            );
        }
    }else{
        $respuesta = array(
            'respuesta' => 'error',
        );
    }

    die(json_encode($respuesta));
}


