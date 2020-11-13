<?php
include_once 'funciones/seguridad.php';
include_once 'funciones/bd-conexion.php';


//Asignar un ticket
if($_POST['registro'] == 'asignar' ){  
    $requerimientoid = filtrado($_POST['requerimientoid']);
    $tecnicoid = filtrado($_POST['tecnicoid']);
    $tickedid = filtrado($_POST['tickedid']);
    $pagina = 'ticket-registrados.php';
    
try {    
    // $stmt = $conn->prepare("INSERT INTO `asignaciones` (requerimientoid, `ticketid`, `usuarioid`) VALUES (?, ?, ? ) " );        
    // $stmt->bind_param("isi", $requerimientoid, $tickedid, $tecnicoid);
    // $stmt->execute();               
    $stmt = $conn->prepare("INSERT INTO asignaciones (requerimientoid, ticketid, usuarioid) VALUES (:requerimientoid, :ticketid, :usuarioid ) "); 
    $stmt->bindValue(":requerimientoid", $requerimientoid, PDO::PARAM_INT);  
    $stmt->bindValue(":ticketid", $tickedid, PDO::PARAM_STR);  
    $stmt->bindValue(":usuarioid", $tecnicoid, PDO::PARAM_INT);  
    if ($stmt->execute()) {
        //Si el ticket si asigno le cambiamos el estado a 2
        // $stmt = $conn->prepare("UPDATE `tickets` SET `estado` = '2' WHERE `tickets`.`idticket` =  ? ");                      
        // $stmt->bind_param("s", $tickedid);
        $stmt2 = $conn->prepare("UPDATE tickets SET estado = '2' WHERE tickets.idticket =  :idticket ");         
        $stmt2->bindValue(":idticket", $tickedid, PDO::PARAM_STR);          
        $stmt2->execute();
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
   die(json_encode($respuesta));
}


//Funcion para cancelar un ticket
if($_POST['registro'] == 'incidencia'  ){  
$pagina2 = 'index.php';
$incidencia = filtrado($_POST['incidencia']);
$idasignacion = filtrado($_POST['idasignacion']);
$idticket = filtrado($_POST['idticket']); 
try {

    if(!empty($incidencia)){             
        $stmt = $conn->prepare("INSERT INTO `cancelado` (motivo, `asignacionid` ) VALUES (:motivo, :asignacionid ) "); 
        $stmt->bindValue(":motivo", $incidencia, PDO::PARAM_STR);  
        $stmt->bindValue(":asignacionid", $idasignacion, PDO::PARAM_INT);  
        if($stmt->execute()){                 
            // Actualiza el estado de la asignacion      
            $stmt2 = $conn->prepare("UPDATE `asignaciones` SET `estadoasignacion` =  '2'  WHERE `asignaciones`.`idasignacion` =  :idasignacion ");                                         
            $stmt2->bindValue(":idasignacion", $idasignacion, PDO::PARAM_INT);   
            $stmt2->execute();
            // Actualiza el estado del ticekt     
            $stmt3 = $conn->prepare("UPDATE `tickets` SET `estado` =  '3'  WHERE `tickets`.`idticket` =  :idticket ");                                         
            $stmt3->bindValue(":idticket", $idticket, PDO::PARAM_STR);   
            $stmt3->execute();
           $respuesta = array(
               'respuesta' => 'exito', 
               'redireccion' => $pagina2
           );
           die(json_encode($respuesta));
        } else{
            //caso contrario imprimiremos el error y mostraremos este mensaje
            $respuesta = array(
                'respuesta' => 'error'
            ); 
        }
          $stmt = null;
          $conn = null;
    }else{
        $respuesta = array(
            'respuesta' => 'error'
        );
        die(json_encode($respuesta));
    }
} catch (Exception $e) {
    $respuesta = array(
        'respuesta' => 'error'
    );
}

die(json_encode($respuesta));
}

//Funcion para finalizar un ticket
if($_POST['registro'] == 'finalizacion'  ){  
    $comentario = filtrado($_POST['comentario']);
    $idasignacion = filtrado($_POST['idasignacion']);
    $idticket = filtrado($_POST['idticket']);
    $pagina3 = "index.php";
    if(!empty($comentario) && !empty($idasignacion)){
        try {        
            $stmt = $conn->prepare("INSERT INTO `finallizado` ( `descripcionfin`, `asignacionid`)VALUES (:descripcionfin, :asignacionid ) "); 
            $stmt->bindValue(":descripcionfin", $comentario, PDO::PARAM_STR);  
            $stmt->bindValue(":asignacionid", $idasignacion, PDO::PARAM_INT); 
            if($stmt->execute()){                 
                //Actaliza el estado del ticket
                $stmt = $conn->prepare("UPDATE `tickets` SET `estado` = '4' WHERE `tickets`.`idticket` = :idticket "); 
                $stmt->bindValue(":idticket", $idticket, PDO::PARAM_STR);               
                $stmt->execute();
                // Actualiza el estado de la asignacion
                $stmt = $conn->prepare("UPDATE `asignaciones` SET `estadoasignacion` = '3' WHERE `asignaciones`.`idasignacion`  = :idasignacion "); 
                $stmt->bindValue(":idasignacion", $idasignacion, PDO::PARAM_INT);               
                $stmt->execute();
               $respuesta = array(
                   'respuesta' => 'exito', 
                   'redireccion' => $pagina3
               );
               die(json_encode($respuesta));
            }  
            else{
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

//Metodo para reasignar un ticket a un tecnico
if($_POST['registro'] == 'reasignar' && $_POST['idcancelado'] !== 'vacio'  ){  
    $tecnicoid = filtrado($_POST['tecnicoid']);
    $idasignacion = filtrado($_POST['idasignacion']);
    $pagina4 = "asignados.php";
    try {
        $stmt = $conn->prepare("UPDATE `asignaciones` SET `usuarioid` = :usuarioid WHERE `asignaciones`.`idasignacion` = :idasignacion  "); 
        $stmt->bindValue(":usuarioid", $tecnicoid, PDO::PARAM_INT);  
        $stmt->bindValue(":idasignacion", $idasignacion, PDO::PARAM_INT); 
        if($stmt->execute()){                   
           $respuesta = array(
               'respuesta' => 'exito', 
               'redireccion' => $pagina4
           );
           die(json_encode($respuesta));
        }else{
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
    die(json_encode($respuesta));
}

//MEtodo para reasignar un ticket y moverlo a la seccion de asignados
if($_POST['registro'] == 'reasignar'  ){  
    $tecnicoid = filtrado($_POST['tecnicoid']);
    $idasignacion = filtrado($_POST['idasignacion']);
    $idcancelado = filtrado($_POST['idcancelado']);
    $pagina4 = "asignados.php";
    try {
        $stmt = $conn->prepare("UPDATE `asignaciones` SET `usuarioid` = :usuarioid WHERE `asignaciones`.`idasignacion` = :idasignacion  "); 
        $stmt->bindValue(":usuarioid", $tecnicoid, PDO::PARAM_INT);  
        $stmt->bindValue(":idasignacion", $idasignacion, PDO::PARAM_INT); 
        if($stmt->execute()){
            //Cuando ya se haya actualizado eliminamos el registro de la tabla cancelados                   
            $stmt = $conn->prepare("DELETE FROM `cancelado` WHERE `cancelado`.`idcancelado`= :idcancelado  "); 
            $stmt->bindValue(":idcancelado", $idcancelado, PDO::PARAM_INT);  
             $stmt->execute();  
            $respuesta = array(
                'respuesta' => 'exito', 
                'redireccion' => $pagina4
            );
            die(json_encode($respuesta));
         }else{
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
    die(json_encode($respuesta));
}