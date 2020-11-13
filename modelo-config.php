<?php

include_once 'funciones/seguridad.php';
include_once 'funciones/bd-conexion.php';
$namesitio = filtrado($_POST['namesitio']);
$correo = filtrado($_POST['correo']);
$urlbase = filtrado($_POST['urlbase']);
$fecha = date("dmYHis");
//Editar registro
if($_POST['registro'] == 'update'  ){                
    if (!empty($namesitio) &&  !empty($correo) &&  !empty($urlbase)  ) {
            try {
                //validamos si objeto $_files en size sea mayor a cero, si es mayor a cero es por que se deseara insertar imagen
                if ($_FILES['archivo_imagen']['size'] > 0) {
                        //indicamos donde se creara el directorio
                        $directorio = "dist/img/favicon/";    
                        if(!is_dir($directorio)){        
                            mkdir($directorio, 0755, true);
                        } 
                        //Eliminamos el archivo actual                 
                        $ficheros1  = scandir($directorio);
                        if(!unlink($directorio.$ficheros1['2'])){
                            $respuesta = array(
                                'respuesta' => 'error'
                            );
                            die(json_encode($respuesta));
                        }
                        //cambiamos el nombre del archivo
                        $info = pathinfo($_FILES['archivo_imagen']['name']);
                        $ext = $info['extension']; // get the extension of the file
                        $newname = $fecha.'.'.$ext; 
                        //comprobamos que el archivo esta en la ubicacion temporal
                        if(move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio.$newname)){            
                            $imagen_url = $newname;                
                        } else{
                            // en caso contrario mostraremos el ultimo error
                            $respuesta = array(
                                'respuesta' => error_get_last()
                            );
                        }
                        // $stmt = $conn->prepare("UPDATE `config` SET `nombresitio`= ?, `email`= ?,`urlbase`= ?,`favicon`= ?, editado = NOW() " );                        
                        // $stmt->bind_param("ssss", $namesitio, $correo, $urlbase, $imagen_url );
                        $stmt = $conn->prepare("UPDATE `config` SET `nombresitio`= .nombresitio, `email`= :email, `urlbase`= :urlbase, `favicon`= :favicon, editado = NOW() ");                                         
                        $stmt->bindValue(":nombresitio", $namesitio, PDO::PARAM_STR);
                        $stmt->bindValue(":email", $correo, PDO::PARAM_STR);
                        $stmt->bindValue(":urlbase", $urlbase, PDO::PARAM_STR);
                        $stmt->bindValue(":favicon", $imagen_url, PDO::PARAM_STR);
               } else {         
                // $stmt = $conn->prepare("UPDATE `config` SET `nombresitio`= ?, `email`= ?,`urlbase`= ?, editado = NOW() " );                        
                // $stmt->bind_param("sss", $namesitio, $correo, $urlbase );    
                $stmt = $conn->prepare("UPDATE `config` SET `nombresitio`= :nombresitio, `email`= :email, `urlbase`= :urlbase, editado = NOW() ");                                         
                $stmt->bindValue(":nombresitio", $namesitio, PDO::PARAM_STR);
                $stmt->bindValue(":email", $correo, PDO::PARAM_STR);
                $stmt->bindValue(":urlbase", $urlbase, PDO::PARAM_STR);       
            }       
                // $stmt->execute();                 
            if($stmt->execute()){        
                $respuesta = array(
                    'respuesta' => 'exito', 
                    'redireccion' => 'index.php'
                );
            } else{
                //caso contrario imprimiremos el error y mostraremos este mensaje
                $respuesta = array(
                    'respuesta' => 'error'
                ); 
            }
            $stmt = null;
            $conn = null;
        } catch (Exception $e) {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }

    }else{
        $respuesta = array(
            'respuesta' => 'error'
        ); 
    }
    die(json_encode($respuesta));
}

