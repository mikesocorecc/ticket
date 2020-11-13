<?php

include_once 'funciones/seguridad.php';
include_once 'funciones/bd-conexion.php';
//Eliminar registro
if ($_POST['registro'] == 'eliminar') {
    //capturamos el id que es enviado por ajax
    $id_borrar = $_POST['id'];
    try {
        // $stmt = $conn->prepare('DELETE FROM `tickets` WHERE `idticket` = ? ');
        // $stmt->bind_param("s", $id_borrar);
        $stmt = $conn->prepare("DELETE FROM tickets WHERE idticket = :idticket  ");                                         
        $stmt->bindValue(":idticket", $id_borrar, PDO::PARAM_STR);
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

$idticket = filtrado($_POST['idticket']);
$sitio = filtrado($_POST['sitio']);
$sn = filtrado($_POST['sn']);
$ncontacto = filtrado($_POST['ncontacto']);
$telefono = filtrado($_POST['telefono']);
$direccion = filtrado($_POST['direccion']);
$hcontacto = filtrado($_POST['hcontact']);
$empresa = filtrado($_POST['cliente']);
$problema = filtrado($_POST['problema']);
$area = filtrado($_POST['area']);
$descripcion = filtrado($_POST['descripcion']);
$terminos = filtrado($_POST['terminos']);
$pagina = 'ticket-registrados.php';
$fecha = date("dmYHis");

//Crear registro
if($_POST['registro'] == 'nuevo'  ){   
    if (!empty($idticket) && !empty($sitio) &&  !empty($hcontacto) &&  !empty($area) &&  !empty($problema) &&  !empty($descripcion) &&  !empty($terminos) ) {
    //indicamos donde se creara el directorio
    $directorio = "dist/img/imgticket/";    
    if(!is_dir($directorio)){        
        mkdir($directorio, 0755, true);
    } 
    if($_FILES['archivo_imagen']['size'] > 2000000){
        $respuesta = array(
            'respuesta' => 'limitsize'
        ); 

      die(json_encode($respuesta));      
    }
    $nombre_img = $fecha.$_FILES['archivo_imagen']['name'];
    //comprobamos que el archivo esta en la ubicacion temporal, si lo esta entonces movemos los archivos de la ubicacion temporal a la ubicacion que le indiquemos
    if(move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio.$nombre_img )){            
        $imagen_url = $nombre_img;  
    } else{
        // en caso contrario mostraremos el ultimo error
        $respuesta = array(
            'respuesta' => error_get_last()
        );
    }
    try {
        //validamos si objeto $_files en size sea mayor a cero, si es mayor a cero es por que se deseara insertar imagen
        if ($_FILES['archivo_imagen']['size'] > 0) {
        //    $stmt = $conn->prepare("INSERT INTO `tickets` (`idticket`, `sitio`, `sn`, `nombrecontacto`, `telefono`, `direccion`, `horariocontacto`, `problemaid`, `clienteid`, `areaid`, `descripcion`, `archivo`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ) " );        
        //    $stmt->bind_param("sssssssiiiss", $idticket, $sitio, $sn, $ncontacto, $telefono , $direccion , $hcontacto, $problema, $empresa, $area, $descripcion, $imagen_url );
        $stmt = $conn->prepare("INSERT INTO `tickets` (`idticket`, `sitio`, `sn`, `nombrecontacto`, `telefono`, `direccion`, `horariocontacto`, `problemaid`, `clienteid`, `areaid`, `descripcion`, `archivo`) VALUES (:idticket, :sitio, :sn, :nombrecontacto, :telefono, :direccion, :horariocontacto, :problemaid, :clienteid, :areaid, :descripcion, :archivo ) ");                                         
        $stmt->bindValue(":idticket", $idticket, PDO::PARAM_STR);
        $stmt->bindValue(":sitio", $sitio, PDO::PARAM_STR);
        $stmt->bindValue(":sn", $sn, PDO::PARAM_STR);  
        $stmt->bindValue(":nombrecontacto", $ncontacto, PDO::PARAM_STR);  
        $stmt->bindValue(":telefono", $telefono, PDO::PARAM_STR);  
        $stmt->bindValue(":direccion", $direccion, PDO::PARAM_STR);  
        $stmt->bindValue(":horariocontacto", $hcontacto, PDO::PARAM_STR); 
        $stmt->bindValue(":problemaid", $problema, PDO::PARAM_INT); 
        $stmt->bindValue(":clienteid", $empresa, PDO::PARAM_INT); 
        $stmt->bindValue(":areaid", $area, PDO::PARAM_INT); 
        $stmt->bindValue(":descripcion", $descripcion, PDO::PARAM_STR); 
        $stmt->bindValue(":archivo", $imagen_url, PDO::PARAM_STR); 
       } else {        
        //    $stmt = $conn->prepare("INSERT INTO `tickets` (`idticket`, `sitio`, `sn`, `nombrecontacto`, `telefono`, `direccion`, `horariocontacto`, `problemaid`, `clienteid`, `areaid`, `descripcion`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ) " );        
        //    $stmt->bind_param("sssssssiiis", $idticket, $sitio, $sn, $ncontacto, $telefono , $direccion , $hcontacto, $problema, $empresa, $area, $descripcion );
        $stmt = $conn->prepare("INSERT INTO `tickets` (`idticket`, `sitio`, `sn`, `nombrecontacto`, `telefono`, `direccion`, `horariocontacto`, `problemaid`, `clienteid`, `areaid`, `descripcion`) VALUES (:idticket, :sitio, :sn, :nombrecontacto, :telefono, :direccion, :horariocontacto, :problemaid, :clienteid, :areaid, :descripcion ) ");                                         
        $stmt->bindValue(":idticket", $idticket, PDO::PARAM_STR);
        $stmt->bindValue(":sitio", $sitio, PDO::PARAM_STR);
        $stmt->bindValue(":sn", $sn, PDO::PARAM_STR);  
        $stmt->bindValue(":nombrecontacto", $ncontacto, PDO::PARAM_STR);  
        $stmt->bindValue(":telefono", $telefono, PDO::PARAM_STR);  
        $stmt->bindValue(":direccion", $direccion, PDO::PARAM_STR);  
        $stmt->bindValue(":horariocontacto", $hcontacto, PDO::PARAM_STR); 
        $stmt->bindValue(":problemaid", $problema, PDO::PARAM_INT); 
        $stmt->bindValue(":clienteid", $empresa, PDO::PARAM_INT); 
        $stmt->bindValue(":areaid", $area, PDO::PARAM_INT); 
        $stmt->bindValue(":descripcion", $descripcion, PDO::PARAM_STR); 
       }       
        //    $stmt->execute();               
       if($stmt->execute()){        
          $respuesta = array(
              'respuesta' => 'exito', 
              'redireccion' => $pagina
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

//Editar registro
if($_POST['registro'] == 'actualizar' ){

    $idregistro = filtrado($_POST['id_registro']);
    //Comprobamos que los input no esten vacios
    if (!empty($idticket) && !empty($sitio) &&  !empty($hcontacto) &&  !empty($area) &&  !empty($problema) &&  !empty($descripcion) &&  !empty($terminos) ) {
        //indicamos donde se creara el directorio
        $directorio = "dist/img/imgticket/";    
        if(!is_dir($directorio)){        
            mkdir($directorio, 0755, true);
        } 

        try {
            //validamos si objeto $_files en size sea mayor a cero, si es mayor a cero es por que se deseara insertar imagen
            if ($_FILES['archivo_imagen']['size'] > 0) {
                     //Validamos el tamaño del archivo a subir
                     if($_FILES['archivo_imagen']['size'] > 2000000){
                        $respuesta = array(
                            'respuesta' => 'limitsize'
                        );     
                      die(json_encode($respuesta));      
                    }

                //Eliminamos el archivo actual para actualizarlo por el nuevo
                // $sql = "SELECT archivo FROM tickets WHERE idticket = $idregistro ";
                // $resultado = $conn->query($sql)->fetch_assoc();
                $stmt = $conn->prepare("SELECT archivo FROM tickets WHERE idticket = :idticket  ");                                         
                $stmt->bindValue(":idticket", $idregistro, PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetch();
                $archivo = $resultado['archivo'];              
                $existe  = file_exists($directorio.$archivo);
                if($existe){
                    unlink($directorio.$archivo);
                }         

                $nombre_img = $fecha.$_FILES['archivo_imagen']['name'];
                //comprobamos que el archivo esta en la ubicacion temporal, si lo esta entonces movemos los archivos de la ubicacion temporal a la ubicacion que le indiquemos
                if(move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio.$nombre_img )){            
                    $imagen_url = $nombre_img;
                } else{
                    // en caso contrario mostraremos el ultimo error
                    $respuesta = array(
                        'respuesta' => error_get_last()
                    );
                } 
                //Preparamos la consulta
            //    $stmt = $conn->prepare("UPDATE `tickets` SET `idticket`= ? ,`sitio`= ?,`sn`=  ?, `nombrecontacto`= ?,`telefono`= ?,`direccion`= ?,`horariocontacto`= ?, `problemaid`= ?, `clienteid`= ?, `areaid`= ?, `descripcion`= ?, `archivo`= ?, editado = NOW() WHERE  idticket = ? " );                       
            //    $stmt->bind_param("sssssssiiisss", $idticket, $sitio, $sn, $ncontacto, $telefono , $direccion , $hcontacto, $problema, $empresa, $area, $descripcion, $imagen_url, $idregistro );
                    $stmt = $conn->prepare("UPDATE tickets SET idticket= :idticket, sitio= :sitio, sn =  :sn, nombrecontacto = :nombrecontacto, telefono= :telefono, direccion= :direccion, horariocontacto = :horariocontacto, problemaid= :problemaid, clienteid= :clienteid, areaid= :areaid, descripcion= :descripcion, archivo= :archivo, editado = NOW() WHERE  idticket = :idticket " );                                         
                    $stmt->bindValue(":idticket", $idticket, PDO::PARAM_STR);
                    $stmt->bindValue(":sitio", $sitio, PDO::PARAM_STR);
                    $stmt->bindValue(":sn", $sn, PDO::PARAM_STR);  
                    $stmt->bindValue(":nombrecontacto", $ncontacto, PDO::PARAM_STR);  
                    $stmt->bindValue(":telefono", $telefono, PDO::PARAM_STR);  
                    $stmt->bindValue(":direccion", $direccion, PDO::PARAM_STR);  
                    $stmt->bindValue(":horariocontacto", $hcontacto, PDO::PARAM_STR); 
                    $stmt->bindValue(":problemaid", $problema, PDO::PARAM_INT); 
                    $stmt->bindValue(":clienteid", $empresa, PDO::PARAM_INT); 
                    $stmt->bindValue(":areaid", $area, PDO::PARAM_INT); 
                    $stmt->bindValue(":descripcion", $descripcion, PDO::PARAM_STR); 
                    $stmt->bindValue(":archivo", $imagen_url, PDO::PARAM_STR); 
           } else {        
            //    $stmt = $conn->prepare("UPDATE `tickets` SET `idticket`= ? ,`sitio`= ?,`sn`=  ?, `nombrecontacto`= ?,`telefono`= ?,`direccion`= ?,`horariocontacto`= ?, `problemaid`= ?, `clienteid`= ?, `areaid`= ?, `descripcion`= ?, editado = NOW() WHERE  idticket = ? " );                       
            //    $stmt->bind_param("sssssssiiiss", $idticket, $sitio, $sn, $ncontacto, $telefono , $direccion , $hcontacto, $problema, $empresa, $area, $descripcion, $idregistro  );
            $stmt = $conn->prepare("UPDATE tickets SET idticket= :idticket, sitio= :sitio, sn =  :sn, nombrecontacto = :nombrecontacto, telefono= :telefono, direccion= :direccion, horariocontacto = :horariocontacto, problemaid= :problemaid, clienteid= :clienteid, areaid= :areaid, descripcion= :descripcion, editado = NOW() WHERE  idticket = :idticket " );                                         
            $stmt->bindValue(":idticket", $idticket, PDO::PARAM_STR);
            $stmt->bindValue(":sitio", $sitio, PDO::PARAM_STR);
            $stmt->bindValue(":sn", $sn, PDO::PARAM_STR);  
            $stmt->bindValue(":nombrecontacto", $ncontacto, PDO::PARAM_STR);  
            $stmt->bindValue(":telefono", $telefono, PDO::PARAM_STR);  
            $stmt->bindValue(":direccion", $direccion, PDO::PARAM_STR);  
            $stmt->bindValue(":horariocontacto", $hcontacto, PDO::PARAM_STR); 
            $stmt->bindValue(":problemaid", $problema, PDO::PARAM_INT); 
            $stmt->bindValue(":clienteid", $empresa, PDO::PARAM_INT); 
            $stmt->bindValue(":areaid", $area, PDO::PARAM_INT); 
            $stmt->bindValue(":descripcion", $descripcion, PDO::PARAM_STR); 
           }       
            //    $stmt->execute();               
           if($stmt->execute()){        
              $respuesta = array(
                  'respuesta' => 'exito', 
                  'redireccion' => $pagina
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

