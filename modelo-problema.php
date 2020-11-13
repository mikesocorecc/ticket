<?php

include_once 'funciones/seguridad.php';
include_once 'funciones/bd-conexion.php';
//Eliminar
if ($_POST['registro'] == 'eliminar') {
    //capturamos el id que es enviado por ajax
    $id_borrar = $_POST['id'];
    try {
        $stmt = $conn->prepare("DELETE FROM problemas WHERE idproblema = :idproblema ");                                                 
        $stmt->bindValue(":idproblema", $id_borrar, PDO::PARAM_INT);
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
$problema = filtrado($_POST['problema']);
$pagina = 'problemas.php';
//Crear registro
if ($_POST['registro'] == 'nuevo') {   
   
    if (!empty($problema) ) {
        try {
            // $stmt = $conn->prepare("INSERT INTO problemas (nombre) VALUES (?) ");
            // $stmt->bind_param("s", $problema);
            // $stmt->execute();
            $stmt = $conn->prepare("INSERT INTO problemas (nombre) VALUES (:nombre)  ");                                         
            $stmt->bindValue(":nombre", $problema, PDO::PARAM_STR);
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
    if (!empty($problema) ) {
        try {  
            // $stmt = $conn->prepare('UPDATE problemas SET nombre = ?, editado = NOW() WHERE idproblema = ? ');
            // $stmt->bind_param("si", $problema, $id_registro);
            // $stmt->execute();
            $stmt = $conn->prepare("UPDATE problemas SET nombre = :nombre, editado = NOW() WHERE idproblema = :idproblema ");                                         
            $stmt->bindValue(":nombre", $problema, PDO::PARAM_STR);
            $stmt->bindValue(":idproblema", $id_registro, PDO::PARAM_INT);
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


