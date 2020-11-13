<?php
    //desactivo las noticias
    error_reporting(E_ALL ^ E_NOTICE);
include_once 'funciones/seguridad.php';
include_once 'funciones/bd-conexion.php';

//Eliminar
if ($_POST['registro'] == 'eliminar') {
    //capturamos el id que es enviado por ajax
    $id_borrar = $_POST['id'];
    try {
        // $stmt = $conn->prepare('DELETE FROM clientes WHERE idcliente = ? ');
        // $stmt->bind_param("i", $id_borrar);
        $stmt = $conn->prepare("DELETE FROM clientes WHERE idcliente =  :idcliente ");                                         
        $stmt->bindValue(":idcliente", $id_borrar, PDO::PARAM_INT);
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
        //$stmt->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }
    die(json_encode($respuesta));
}

$empresa = filtrado($_POST['empresa']);
$encargado = filtrado($_POST['encargado']);
$email = filtrado($_POST['email']);
$ruc = filtrado($_POST['ruc']);
$pagina = 'clientes.php';
if ($_POST['registro'] == 'nuevo') {   
    if (!empty($empresa) && !empty($encargado) &&  !empty($email) &&  !empty($ruc) ) {
        try {
            // $stmt = $conn->prepare("INSERT INTO clientes (empresa, encargado, email, ruc) VALUES (?, ?, ?, ?) ");
            // $stmt->bind_param("ssss", $empresa, $encargado, $email, $ruc);
            // $stmt->execute();
            $stmt = $conn->prepare("INSERT INTO `clientes` (empresa, encargado, email, ruc ) VALUES (:empresa, :encargado, :email, :ruc ) ");                                         
            $stmt->bindValue(":empresa", $empresa, PDO::PARAM_STR);   
            $stmt->bindValue(":encargado", $encargado, PDO::PARAM_STR);   
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);   
            $stmt->bindValue(":ruc", $ruc, PDO::PARAM_STR);   
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
    if (!empty($empresa) && !empty($encargado) &&  !empty($email) &&  !empty($ruc) ) {
        try {      
            $stmt = $conn->prepare("UPDATE `clientes` SET `empresa` =  :empresa, encargado = :encargado, email = :email, ruc = :ruc, editado = NOW()   WHERE idcliente =  :idcliente ");                                         
            $stmt->bindValue(":empresa", $empresa, PDO::PARAM_STR);   
            $stmt->bindValue(":encargado", $encargado, PDO::PARAM_STR);   
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);   
            $stmt->bindValue(":ruc", $ruc, PDO::PARAM_STR);   
            $stmt->bindValue(":idcliente", $id_registro, PDO::PARAM_INT);              
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


