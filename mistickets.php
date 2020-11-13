<?php
include_once 'funciones/sesiones.php';

include_once 'funciones/bd-conexion.php';
include_once 'templates/header.php';
include_once 'templates/navbar.php';
include_once 'templates/sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header ">
    <h1>Tickets</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Mis tickets asignados</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row ">    
      <div class="col-xs-12">
        <!-- Custom Tabs -->
      
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="" style="border: 1px solid blue; border-radius: 5px;" ><a href="#tab_1" data-toggle="tab"><strong class="title">Asignados</strong></a></li>
            <li style="border: 1px solid rgb(255, 238, 0);   ; border-radius: 5px;" ><a href="#tab_2"  data-toggle="tab"> <strong class="text-danger">Incidencias</strong> </a></li>
            <li style="border: 1px solid green; border-radius: 5px;" ><a href="#tab_3"  data-toggle="tab"><strong class="text-success">Atendidos</strong></a></li>
            <li class="dropdown">
              <ul class="dropdown-menu">
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                <li role="presentation" class="divider"></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
              </ul>
            </li>
            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
          </ul>
          <div class="tab-content">

            <div class="tab-pane active" id="tab_1">
              <!-- REGISTROS DE ASIGNADOS -->
              <br>
              <strong class="h3 text-primary" > Mis tickets asignados</strong>           
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Ver info</th>
                    <th>nombre contacto</th>
                    <th>Telefono</th>
                    <th>Sitio</th>
                    <th>Direccion</th>
                    <th>N° Tickets</th>
                    <th>Asunto</th>
                    <th>Empresa</th>
                    <th>estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                try {
                  $usuario = $_SESSION['usuario'];
                  //crearemos la consulta para llenar la tabla                  
                  $stmt = $conn->prepare("SELECT asignaciones .*, requerimientos.nombre as namerequerimiento, requerimientos.fechahora, tickets.sitio, tickets.descripcion, tickets.estado, tickets.sn, tickets.nombrecontacto, tickets.telefono, tickets.direccion, tickets.horariocontacto, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea, usuarios.usuario, usuarios.nombre, usuarios.apellidos FROM asignaciones JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario WHERE usuarios.usuario = :bp_usuario AND estadoasignacion = 1 " );                                         
                  $stmt->bindValue(":bp_usuario", $usuario, PDO::PARAM_STR);  
                  $stmt->execute();   
                } catch (Exception $e) {
                  // capturamos el error
                  $error = $e->getMessage();
                  echo $error;
                }
                while ($ticket = $stmt->fetch()) {   ?>
                  <tr>
                    <td><a class="btn btn-default btn-xs"  href="ticket-info.php?id=<?=  $ticket['idasignacion'].'&tipo=asignado'; ?>">Ver <span class="glyphicon glyphicon-arrow-right"></span></a></td>
                    <td><?php echo $ticket['nombrecontacto'] ?></td>
                    <td><?php echo $ticket['telefono'] ?></td>
                    <td><?php echo $ticket['sitio'] ?></td>
                    <td><?php echo $ticket['direccion'] ?></td>
                    <td><?php echo $ticket['ticketid'] ?></td>
                    <td><?php echo $ticket['nameproblema'] ?></td>
                    <td><span class="text-danger"><?= $ticket['empresa'] ?></span></td>
                    <td><span
                        class="dtr-data"><?= ($ticket['estado'] = 1) ? '<span class="label label-primary">Asignado</span>' :  ''; ?></span>
                    </td>
                    <td>
                      <a href="atender-ticket.php?id=<?php echo $ticket['idasignacion'].'&idticket='.$ticket['ticketid']; ?>"
                        class="btn btn-success btn-sm">Finalizar <i class="fa fa-check"></i></a>
                      <a href="incidencias.php?id=<?php echo $ticket['idasignacion'].'&idticket='.$ticket['ticketid']; ?>"
                        class="btn btn-warning btn-sm">Incidencia<i class="fas fa-bell-slash"></i></a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
              <!-- REGISTROS DE Incidencias -->
              <br>
              <strong class="h3 text-danger" > Mis tickets con incidencias</strong>     
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Ver info</th>
                    <th>nombre contacto</th>
                    <th>Telefono</th>
                    <th>Sitio</th>
                    <th>Direccion</th>
                    <th>N° Tickets</th>
                    <th>Asunto</th>
                    <th>Empresa</th>
                    <th>estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                try {
                  $user = $_SESSION['usuario'];
                  //crearemos la consulta para llenar la tabla                  
                  $stmt2 = $conn->prepare("SELECT asignaciones .*, requerimientos.nombre as namerequerimiento, requerimientos.fechahora, tickets.sitio, tickets.descripcion, tickets.estado, tickets.sn, tickets.nombrecontacto, tickets.telefono, tickets.direccion, tickets.horariocontacto, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea, usuarios.usuario, usuarios.nombre, usuarios.apellidos FROM asignaciones JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario WHERE usuarios.usuario = :usuario AND estadoasignacion = 2 " );                                         
                  $stmt2->bindValue(":usuario", $user, PDO::PARAM_STR);  
                  $stmt2->execute(); 
                } catch (Exception $e) {
                  // capturamos el error
                  $error = $e->getMessage();
                  echo $error;
                }
                while ($ticket = $stmt2->fetch()) { 
                  $idcancel = $ticket['idasignacion'];   
                  $stmt3 = $conn->prepare("SELECT * FROM `cancelado` WHERE cancelado.asignacionid =  :asignacionid " );                                         
                  $stmt3->bindValue(":asignacionid", $idcancel, PDO::PARAM_INT );  
                  $stmt3->execute(); 
                  $cancelado = $stmt3->fetch();
                  ?>
                
                  <tr>
                    <td><a class="btn btn-default btn-xs"
                        href="ticket-info.php?id=<?=  $cancelado['idcancelado'].'&tipo=incidencia'; ?>">Ver <span
                          class="glyphicon glyphicon-arrow-right"></span></a></td>
                    <td><?php echo $ticket['nombrecontacto'] ?></td>
                    <td><?php echo $ticket['telefono'] ?></td>
                    <td><?php echo $ticket['sitio'] ?></td>
                    <td><?php echo $ticket['direccion'] ?></td>
                    <td><?php echo $ticket['ticketid'] ?></td>
                    <td><?php echo $ticket['nameproblema'] ?></td>
                    <td><span class="text-danger"><?= $ticket['empresa'] ?></span></td>
                    <td><span
                        class="dtr-data"><?= ($ticket['estado'] = 1) ? '<span class="label label-primary">Asignado</span>' :  ''; ?></span>
                    </td>
                    <td>
                      <a href="atender-ticket.php?id=<?php echo $ticket['idasignacion'].'&idticket='.$ticket['ticketid']; ?>"
                        class="btn btn-success btn-sm">Finalizar <i class="fa fa-check"></i></a>                    
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_3">
              <!-- REGISTROS DE Atendidos -->
              <br>
              <strong class="h3 text-success" > Mis tickets con atendidos</strong>   
              <table id="atendidos" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Ver info</th>
                    <th>nombre contacto</th>
                    <th>Telefono</th>
                    <th>Sitio</th>
                    <th>Direccion</th>
                    <th>N° Tickets</th>
                    <th>Asunto</th>
                    <th>Empresa</th>
                    <th>estado</th>
                   
                  </tr>
                </thead>
                <tbody>
                  <?php
                try {
                  $usuario = $_SESSION['usuario'];
                  //crearemos la consulta para llenar la tabla                   
                  $stmt4 = $conn->prepare("SELECT asignaciones .*, requerimientos.nombre as namerequerimiento, requerimientos.fechahora, tickets.sitio, tickets.descripcion, tickets.estado, tickets.sn, tickets.nombrecontacto, tickets.telefono, tickets.direccion, tickets.horariocontacto, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea, usuarios.usuario, usuarios.nombre, usuarios.apellidos FROM asignaciones JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario WHERE usuarios.usuario = :bpr_usuario AND estadoasignacion = 3" );                                         
                  $stmt4->bindValue(":bpr_usuario", $usuario, PDO::PARAM_STR);  
                  $stmt4->execute();   
                } catch (Exception $e) {
                  // capturamos el error
                  $error = $e->getMessage();
                  echo $error;
                }
                while ($ticket = $stmt4->fetch()) { 
                  $idasignacion = $ticket['idasignacion'];
                  $stmt5 = $conn->prepare("SELECT * FROM `finallizado` WHERE finallizado.asignacionid = :bp_asignacionid ");                                         
                  $stmt5->bindValue(":bp_asignacionid", $idasignacion, PDO::PARAM_INT);  
                  $stmt5->execute();  
                  $finalizado = $stmt5->fetch();
                    ?>
                  <tr>
                    <td><a class="btn btn-default btn-xs"  href="ticket-info.php?id=<?=  $finalizado['idfinallizado'].'&tipo=finalizado'; ?>">Ver <span class="glyphicon glyphicon-arrow-right"></span></a></td>
                    <td><?php echo $ticket['nombrecontacto'] ?></td>
                    <td><?php echo $ticket['telefono'] ?></td>
                    <td><?php echo $ticket['sitio'] ?></td>
                    <td><?php echo $ticket['direccion'] ?></td>
                    <td><?php echo $ticket['ticketid'] ?></td>
                    <td><?php echo $ticket['nameproblema'] ?></td>
                    <td><span class="text-danger"><?= $ticket['empresa'] ?></span></td>
                    <td><span
                        class="dtr-data"><?= ($ticket['estado'] = 1) ? '<span class="label label-success">Atendido</span>' :  ''; ?></span>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
      </div>
      <!-- /.col -->

    </div> <!-- /.row -->



</div><!-- /.content-wrapper -->

<?php
include_once 'templates/footer.php'; 
?>