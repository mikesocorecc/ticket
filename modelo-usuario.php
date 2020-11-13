<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once 'funciones/seguridad.php';
include_once 'funciones/bd-conexion.php';
//Eliminar
if ($_POST['registro'] == 'eliminar') {
    //capturamos el id que es enviado por ajax
    $id_borrar = $_POST['id'];
    try {
        // $stmt = $conn->prepare('DELETE FROM usuarios WHERE idusuario = ? ');
        // $stmt->bind_param("i", $id_borrar);
        // $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE idusuario = :idusuario ");                                         
        $stmt->bindValue(":idusuario", $id_borrar, PDO::PARAM_INT);
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


$usuario = filtrado($_POST['usuario']);
$nombre = filtrado($_POST['nombre']);
$apellidos = filtrado($_POST['apellidos']);
$email = filtrado($_POST['email']);
$password = filtrado($_POST['password']);
$rol = filtrado($_POST['rol']);
$pagina = 'usuarios.php';
if ($_POST['registro'] == 'nuevo') {
    //validamos los campos
    if (!empty($usuario) && !empty($nombre) &&  !empty($apellidos) &&  !empty($password) &&  !empty($rol) &&  !empty($email)) {
        //Asheamos las opc del passw
        $opciones = array(
            'cost' => 12
        );
        //hasshemos la pasword
        $password_hashed = password_hash($password, PASSWORD_BCRYPT, $opciones); // (contraseña, tipo de encriptacion, opciones)
        try {
            // $stmt = $conn->prepare("INSERT INTO usuarios (usuario, nombre, apellidos, email, password, rolid) VALUES (?, ?, ?, ?, ?, ? ) ");
            // $stmt->bind_param("sssssi", $usuario, $nombre, $apellidos, $email, $password_hashed, $rol);
            // $stmt->execute();
            $stmt = $conn->prepare("INSERT INTO usuarios (usuario, nombre, apellidos, email, password, rolid) VALUES (:usuario, :nombre, :apellidos, :email, :password, :rolid) " );                                         
            $stmt->bindValue(":usuario", $usuario, PDO::PARAM_STR);
            $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindValue(":apellidos", $apellidos, PDO::PARAM_STR);
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);
            $stmt->bindValue(":password", $password_hashed, PDO::PARAM_STR);
            $stmt->bindValue(":rolid", $rol, PDO::PARAM_INT);     
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
    } else {
        $respuesta = array(
            'respuesta' => 'error',
        );
    }
    die(json_encode($respuesta));
}

//Actualizar
if ($_POST['registro'] == 'actualizar') {
    $id_registro = filtrado($_POST['id_registro']);
    if (!empty($usuario) && !empty($nombre) &&  !empty($apellidos) &&  !empty($email) &&  !empty($rol)) {
        try {
            //comprobamos si el capo del password esta vacio o no
            if (empty($_POST['password'])) {
                // $stmt = $conn->prepare('UPDATE usuarios SET usuario = ?, nombre = ?, apellidos = ?, email = ?, rolid = ?, editado = NOW() WHERE idusuario = ? ');
                // $stmt->bind_param("ssssii", $usuario, $nombre, $apellidos, $email, $rol, $id_registro);
                $stmt = $conn->prepare("UPDATE usuarios SET usuario = :usuario, nombre = :nombre, apellidos = :apellidos, email = :email, rolid = :rolid, editado = NOW() WHERE idusuario = :idusuario " );                                         
                $stmt->bindValue(":usuario", $usuario, PDO::PARAM_STR);
                $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                $stmt->bindValue(":apellidos", $apellidos, PDO::PARAM_STR);
                $stmt->bindValue(":email", $email, PDO::PARAM_STR);
                $stmt->bindValue(":rolid", $rol, PDO::PARAM_INT);   
                $stmt->bindValue(":idusuario", $id_registro, PDO::PARAM_INT);   
            } else {
                $opciones = array(
                    'cost' => 12
                );
                // Encriptamos la password
                $password_hashed = password_hash($password, PASSWORD_BCRYPT, $opciones);
                // $stmt = $conn->prepare('UPDATE usuarios SET usuario = ?, nombre = ?, apellidos = ?, email = ?, password = ?, rolid = ?, editado = NOW()  WHERE idusuario = ? ');
                // $stmt->bind_param("sssssii", $usuario, $nombre, $apellidos, $email,    $password_hashed, $rol, $id_registro);
                $stmt = $conn->prepare("UPDATE usuarios SET usuario = :usuario, nombre = :nombre, apellidos = :apellidos, email = :email, password = :password, rolid = :rolid, editado = NOW() WHERE idusuario = :idusuario " );                                         
                $stmt->bindValue(":usuario", $usuario, PDO::PARAM_STR);
                $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                $stmt->bindValue(":apellidos", $apellidos, PDO::PARAM_STR);
                $stmt->bindValue(":email", $email, PDO::PARAM_STR);
                $stmt->bindValue(":password", $password_hashed, PDO::PARAM_STR);
                $stmt->bindValue(":rolid", $rol, PDO::PARAM_INT);   
                $stmt->bindValue(":idusuario", $id_registro, PDO::PARAM_INT);
            }
            // $stmt->execute();
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
    } else {
        $respuesta = array(
            'respuesta' => 'Error'
        );
    }
    //regresamos una respuesta
    die(json_encode($respuesta));
}


