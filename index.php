<?php
include_once 'funciones/sesiones.php';
include_once 'funciones/misfunciones.php'; 
include_once 'funciones/bd-conexion.php'; 
include_once 'templates/header.php'; 
include_once 'templates/navbar.php'; 
include_once 'templates/sidebar.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Informacion sobre los tickets</small>
        </h1>

    </section>


    <!-- Main content -->
    <section class="content">
        <h2 class="page-header">Resumen de tickets</h2>
        <div class="row">

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a <?= ($_SESSION['namerol'] != 'Tecnico') ? 'href="ticket-registrados.php"' : ' href="mistickets.php" ' ?>><span class="info-box-icon bg-aqua"><i class="fa fa-glass"></i></span></a>
                    <div class="info-box-content">
                        <?php          
                            $usuario = $_SESSION['usuario'];
                            if($_SESSION['namerol'] != 'Tecnico'){
                                $sql = "SELECT COUNT(idticket) AS totalticket FROM tickets WHERE estado = 1 ";                              
                                // $stmt = $conn->prepare($sql);       
                                 
                            }else{                   
                            $sql = "SELECT asignaciones .*, requerimientos.nombre as namerequerimiento, requerimientos.fechahora, tickets.sitio, tickets.descripcion, tickets.estado, tickets.sn, tickets.nombrecontacto, tickets.telefono, tickets.direccion, tickets.horariocontacto, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea, usuarios.usuario, usuarios.nombre, usuarios.apellidos, COUNT(idasignacion) AS totalticket FROM asignaciones JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario WHERE usuarios.usuario = '$usuario' AND estadoasignacion = 1  ";
                            //   $stmt = $conn->prepare($sql);       
                            }  
                            $stmt = $conn->prepare($sql);      
                            $stmt->execute(); 
                            $ticket =  $stmt->fetch();                                  

                            if($_SESSION['namerol'] != 'Tecnico'){
                            echo '<span class="info-box-text">Registrados</span>';
                            }else {
                                echo '<span class="info-box-text" >Asignados</span>';
                            }
                        ?>
                      <span class="info-box-number"><?= $ticket['totalticket']; ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a <?= ($_SESSION['namerol'] != 'Tecnico') ? 'href="asignados.php"' : 'href="mistickets.php"'  ?>><span class="info-box-icon bg-green"><i class="fa fa-rocket"></i></span> </a>
                    <div class="info-box-content">
                        <?php  
                            $usuario = $_SESSION['usuario'];
                            if($_SESSION['namerol'] != 'Tecnico'){
                                $sql = "SELECT COUNT(idticket) AS totalticket FROM tickets WHERE estado = 2  ";
                            }else{                                     
                            $sql = "SELECT asignaciones .*, requerimientos.nombre as namerequerimiento, requerimientos.fechahora, tickets.sitio, tickets.descripcion, tickets.estado, tickets.sn, tickets.nombrecontacto, tickets.telefono, tickets.direccion, tickets.horariocontacto, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea, usuarios.usuario, usuarios.nombre, usuarios.apellidos,  COUNT(idasignacion) AS totalticket FROM asignaciones JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario WHERE usuarios.usuario = '$usuario' AND estadoasignacion = 2   ";
                            }        
                            $stmt = $conn->prepare($sql); 
                            $stmt->execute(); 
                            $ticket = $stmt->fetch();
                        ?>
                        <span class="info-box-text"><?= ($_SESSION['namerol'] != 'Tecnico') ? 'Asignados' : 'Incidencias'  ?></span>
                        <span class="info-box-number"><?= $ticket['totalticket']; ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <?php          
            if($_SESSION['namerol'] != 'Tecnico'){    
            $sql = "SELECT COUNT(idcancelado) AS totalticket FROM cancelado ";
            $stmt = $conn->prepare($sql); 
            $stmt->execute();             
            $ticket = $stmt->fetch();            
                ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="cancelados.php">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-ban"></i></span>
                    </a>
                    <div class="info-box-content">

                        <span class="info-box-text">Con Incidencía</span>
                        <span class="info-box-number"><?= $ticket['totalticket']; ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div> <!-- /.col -->
            <?php } ?>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a <?= ($_SESSION['namerol'] != 'Tecnico') ? 'href="atendidos.php"' : 'href="mistickets.php"'  ?>>
                        <span class="info-box-icon bg-red"><i class="fa fa-flask"></i></span>
                    </a>
                    <div class="info-box-content">
                        <?php  
                            $usuario = $_SESSION['usuario'];
                            if($_SESSION['namerol'] != 'Tecnico'){
                                $sql = "SELECT COUNT(idfinallizado) AS totalticket FROM finallizado";
                            }else{                                     
                                $sql = "SELECT asignaciones .*, requerimientos.nombre as namerequerimiento, requerimientos.fechahora, tickets.sitio, tickets.descripcion, tickets.estado, tickets.sn, tickets.nombrecontacto, tickets.telefono, tickets.direccion, tickets.horariocontacto, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea, usuarios.usuario, usuarios.nombre, usuarios.apellidos, COUNT(idasignacion) AS totalticket FROM asignaciones JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario WHERE usuarios.usuario = '$usuario' AND estadoasignacion = 3 ";
                            }    
                            $stmt = $conn->prepare($sql); 
                            $stmt->execute();                                                          
                            $ticket = $stmt->fetch(); 
                            ?>
                        <span class="info-box-text">Atendidos</span>
                        <span class="info-box-number"><?= $ticket['totalticket']; ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->
        </div><!-- /.row -->


        <div class="row">
            <!-- Left col -->
            <div class="col-md-12">


                <!-- TABLE: LATEST ORDERS -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tickets Recientes</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin table-bordered">
                                <thead class="table_header">
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Empresa</th>
                                        <th>Requerimientos</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        try {
                                        //crearemos la consulta para llenar la tabla
                                        if($_SESSION['namerol'] != 'Tecnico'){
                                            $sql = "SELECT asignaciones .*, tickets.idticket, tickets.nombrecontacto, tickets.estado, clientes.empresa, requerimientos.nombre as namerequerimiento FROM asignaciones JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento LIMIT 10 ";
                                        }else{
                                            $sql = "SELECT asignaciones .*, tickets.idticket, tickets.nombrecontacto, tickets.estado, clientes.empresa, requerimientos.nombre as namerequerimiento, usuarios.usuario FROM asignaciones JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario WHERE usuarios.usuario = '$usuario' LIMIT 10 ";
                                        }     
                                        $stmt = $conn->prepare($sql); 
                                        $stmt->execute();                                                          
                                                                                                                              
                                        } catch (Exception $e) {
                                        // capturamos el error
                                        $error = $e->getMessage();
                                        echo $error;
                                        }
                                        while ( $ticket = $stmt->fetch()) {   ?>

                                    <tr>
                                        <td>
                                           
                                            <?php
                                              $asignacionid = $ticket['idasignacion'];                                              
                                              switch ($ticket['estado']) {
                                                case 1: ?>                                                  
                                                    <a href="ticket-info.php?id=<?= $ticket['ticketid'].'&tipo=registrado';  ?>"><?php echo $ticket['ticketid'] ?></a>
                                            <?php   break;
                                                case 2: ?>                                                  
                                                    <a href="ticket-info.php?id=<?= $ticket['idasignacion'].'&tipo=asignado';  ?>"><?php echo $ticket['ticketid'] ?></a>                                                                                                        
                                                    <?php         break; ?>
                                               <?php  case 3: ?>
                                                <?php                                                    
                                                     //   $sql3 = "SELECT * FROM cancelado WHERE asignacionid = $asignacionid ";
                                                        $stmt2 = $conn->prepare("SELECT * FROM cancelado WHERE asignacionid = :asignacionid " );                                                                                                        
                                                        $stmt2->bindValue(":asignacionid", $asignacionid, PDO::PARAM_INT);                                                                                                                 
                                                        $cancelado = $stmt2->fetch();                                                
                                                    ?>
                                                    <a href="ticket-info.php?id=<?= $cancelado['idcancelado'].'&tipo=incidencia';  ?>"><?php echo $ticket['ticketid'] ?></a>                                                    
                                            <?php    break; ?>
                                              <?php  case 4: ?>
                                                        <?php    

                                                        $stmt3 = $conn->prepare("SELECT * FROM finallizado WHERE asignacionid = :asignacionid " );                                         
                                                        $stmt3->bindValue(":asignacionid", $asignacionid, PDO::PARAM_INT );  
                                                        $stmt3->execute();             
                                                        $finalizado = $stmt3->fetch();                                                
                                                    ?>
                                                    <a href="ticket-info.php?id=<?= $finalizado['idfinallizado'].'&tipo=finalizado';  ?>"><?php echo $ticket['ticketid'] ?></a>
                                                <?php   break;
                                                                                                    
                                            }
                                             ?>
                                            
                                                
                                        </td>
                                        <td><?php echo $ticket['nombrecontacto'] ?></td>
                                        <td><?php echo $ticket['empresa'] ?></td>

                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20">
                                                <?php echo $ticket['namerequerimiento'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                                switch ($ticket['estado']) {
                                                    case 1:
                                                        echo'<span class="label label-warning">Registrado</span>';                                                        
                                                        break;
                                                    case 2:
                                                        echo'<span class="label label-primary">Asignado</span>';                                                        
                                                        break;
                                                    case 3:
                                                        echo'<span class="label label-danger">Incidencias</span>';                                                        
                                                        break;
                                                    case 4:
                                                        echo'<span class="label label-success">Atendido</span>';                                                        
                                                        break;
                                                                                                        
                                                }                                                                                                  
                                                 ?>
                                        </td>
                                    </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php

include_once 'templates/footer.php'; //incluimos el footer  en esta parte xq aqui estava el footer
?>