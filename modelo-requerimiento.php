<?php

include_once 'funciones/seguridad.php';
include_once 'funciones/bd-conexion.php';

$pagina = 'requerimientos.php';
//Crear registro
if ($_POST['registro'] == 'nuevo') { 
    $requerimiento = filtrado($_POST['requerimiento']);
    if(!empty($requerimiento)){
        try {
            $stmt = $conn->prepare("INSERT INTO requerimientos (nombre) VALUES (:nombre)  ");                                         
            $stmt->bindValue(":nombre", $requerimiento, PDO::PARAM_STR); 
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
    } else{
        $respuesta = array(
            'respuesta' => 'error',
        );
    }

    die(json_encode($respuesta));
}

//Actualizar
if ($_POST['registro'] == 'actualizar') {
    $requerimiento = filtrado($_POST['requerimiento']);
    $id_registro = filtrado($_POST['id_registro']);
    if(!empty($requerimiento)){
        try {
            // $stmt = $conn->prepare('UPDATE requerimientos SET nombre = ?, editado = NOW() WHERE idrequerimiento = ? ');
            // $stmt->bind_param("si", $requerimiento, $id_registro);
            // $stmt->execute();
            $stmt = $conn->prepare("UPDATE requerimientos SET nombre = :nombre, editado = NOW() WHERE idrequerimiento = :idrequerimiento ");                                         
            $stmt->bindValue(":nombre", $requerimiento, PDO::PARAM_STR); 
            $stmt->bindValue(":idrequerimiento", $id_registro, PDO::PARAM_INT); 
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
            'respuesta' => 'Error'
        );  
    }

    die(json_encode($respuesta));
}

//Eliminar
if ($_POST['registro'] == 'eliminar') {
 
    //capturamos el id que es enviado por ajax
    $id_borrar = $_POST['id'];
    try {
        // $stmt = $conn->prepare('DELETE FROM requerimientos WHERE idrequerimiento = ? ');
        // $stmt->bind_param("i", $id_borrar);
        // $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM requerimientos WHERE idrequerimiento = :idrequerimiento ");                                         
        $stmt->bindValue(":idrequerimiento", $id_borrar, PDO::PARAM_INT); 
        if ($stmt->execute()) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_eliminado' => $id_borrar
            );
            
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $stmt = null;
        $conn = null;
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }


    die(json_encode($respuesta));
}
