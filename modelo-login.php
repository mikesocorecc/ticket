<?php 
include_once 'funciones/seguridad.php';
include_once 'funciones/bd-conexion.php';
    if(isset($_POST['logear'])){        
        $usuario = filtrado($_POST['usuario']);
        $password = filtrado($_POST['password']);
        if(empty($usuario) || empty($password)){
            $respuesta = array(
                'respuesta' => 'vacios'
            );
            die(json_encode($respuesta));
        }
        try {
            $stmt = $conn->prepare("SELECT usuarios.idusuario, usuarios.usuario, usuarios.nombre, usuarios.apellidos, usuarios.email, usuarios.password, usuarios.rolid, roles.nombre as namerol  FROM usuarios JOIN roles ON usuarios.rolid = roles.idrol WHERE usuario =  :usuario " );         
            $stmt->bindValue(":usuario", $usuario, PDO::PARAM_STR);                  
            $stmt->execute();                                   
            if($stmt->rowCount() == 1){
                $user = $stmt->fetch();   
                $passworduser = $user['password'];          
                    // verificamos si suser la password
                    if(password_verify($password, $passworduser)){
                        //iniciamos la sesion              
                        session_start();
                        // Asiganamos nombres a los campos de la sesion que nos retornara los valores de la consulta                                                                
                        $_SESSION['idusuario'] = $user['idusuario'];
                        $_SESSION['usuario'] = $user['usuario'];
                        $_SESSION['nombre'] = $user['nombre'];
                        $_SESSION['apellido'] = $user['apellidos'];
                        $_SESSION['rolid'] = $user['rolid'];
                        $_SESSION['namerol'] = $user['namerol'];   
                        $respuesta = array(
                            'respuesta' => 'exitoso'
                        );
                        die(json_encode($respuesta));
                    }else{
                        $respuesta = array(
                            'respuesta' => 'error'
                        );  
                        die(json_encode($respuesta));
                    }    
            }
            //cerrar la conexion
            $stmt = null;
            $conn = null;
        } catch (Exception $e) {
            echo "error : ".$e->getMessage();
        }
        die(json_encode($respuesta));
    }


?>