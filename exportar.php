<?php 
header("Content-Type:  application/xls; charset=utf-16");
header("Content-Disposition: attachment; filename= reporte_tickets.xls");
include_once 'funciones/bd-conexion.php'; 
//Establecemos la zona horaria
date_default_timezone_set('America/Guatemala');

//Funcion que devuelve el tiempo transcurrido
function tiempo_transcurrido($segundos){
    $arrayfecha = array(
        ' año'        => $segundos / 31556926 % 12,
        ' mes'        => $segundos / 604800 % 52,
        ' dia'        => $segundos / 86400 % 7,
        ' hora'        => $segundos / 3600 % 24,
        ' minutos'    => $segundos / 60 % 60,
        ' segundos'    => $segundos % 60
        );      
        foreach($arrayfecha as $llave => $valor){          
            if($valor > 1)$tiempo[] =" ".$valor. $llave;
        }  
        $ret[] = 'Trasncurridos';
        return join('', $tiempo);
    } //fin de la funcion
    
 
    $stmt = $conn->prepare("SELECT `idticket`, `sn`, `nombrecontacto`, `fecharegistro`, `estado`, `clienteid`, clientes.empresa FROM `tickets` JOIN clientes ON tickets.clienteid = clientes.idcliente ORDER BY `clientes`.`empresa` DESC " );                                         
    $stmt->execute();             

?>


<table id="registrados" border="1" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                <thead>
            <tr>
              <th class="border">CODIGO</th>
                <th>NOMBRE CONTACTO</th>
                <th>SN</th>
                <th>ESTADO</th>
                <th>EMPRESA</th>
                <th>FECHA REGISTRO</th>
                <th>FECHA ATENCION</th>
                <th>TIEMPO TRANSCURRIDO</th>              
              </tr>
              </thead>

              <tbody>
                <?php  while ($ticket = $stmt->fetch()) { ?>
                <tr>
                    <td><?php echo utf8_decode($ticket ['idticket']); ?></td>
                    <td><?php echo utf8_decode($ticket ['nombrecontacto']); ?></td>
                    <td><?php echo utf8_decode($ticket ['sn']); ?></td>                 
                    <td>
                        <?php 
                        $estado = $ticket ['estado'];
                        $id = $ticket['idticket'];
                                switch ($estado) {
                                    case 4:
                                  
                                        $stmt2 = $conn->prepare("SELECT * FROM asignaciones WHERE ticketid = :ticketid " );                                         
                                        $stmt2->bindValue(":ticketid", $id, PDO::PARAM_STR);  
                                        $stmt2->execute();             
                                        $resultado2 = $stmt2->fetch();     

                                        $idasignacion = $resultado2['idasignacion'];

                                       
                                        $stmt3 = $conn->prepare("SELECT * FROM finallizado WHERE asignacionid = :asignacionid " );                                         
                                        $stmt3->bindValue(":asignacionid", $idasignacion, PDO::PARAM_INT);  
                                        $stmt3->execute();  
                                        $resultado3 = $stmt3->fetch();  
                                        echo '<strong style="color: green;">finalizado</strong>';               
                                        break;
                                        case 1: 
                                            echo '<strong style="color: rgb(202, 179, 51);">registrado</strong>';
                                        break;
                                        case 2: 
                                            echo '<strong style="color: blue;">asignado</strong>';
                                        break;
                                        case 3:
                                            echo '<strong style="color: red;">incidencia</strong>';
                                        break;
                                };
                            ?>
                        </td>
                        <td><?php echo utf8_decode($ticket['empresa']); ?></td>
                        <td><?php echo utf8_decode($ticket ['fecharegistro']); ?></td>
                         <?php if($estado == 4){ ?>
                          <td><?php echo $resultado3['fechafinalizado']; ?></td>
                        <?php } else{
                            echo "<td> </td>";
                        } ?>
                        <!-- Calculamos el total de horas transcurridas -->
                        <?php if($estado == 4){ ?>
                        <td>
                            <?php 
                                $start_time = strtotime($ticket ['fecharegistro']);  
                                $end_time = strtotime($resultado3['fechafinalizado']);
                                echo tiempo_transcurrido($end_time - $start_time);
                             ?>
                        </td>
                        <?php }else{ ?>
                        <td>
                            <?php
                                $start_time = strtotime($ticket ['fecharegistro']);  
                                $end_time = strtotime(date('Y-m-d H:m:s'));
                                echo tiempo_transcurrido($end_time - $start_time);
                            ?>
                        </td>
                        <?php } ?>
                </tr>
                <?php } ?>
            </tbody>
              </table>
            