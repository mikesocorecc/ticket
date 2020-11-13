<?php
include_once 'funciones/sesiones.php';
if($_SESSION['namerol'] !== "Administrador"){
  header('Location:login.php');
}
include_once 'funciones/bd-conexion.php';
include_once 'templates/header.php';
include_once 'templates/navbar.php';
include_once 'templates/sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header ">
    <h1>Tickets cancelados</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Tickets cancelados</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">  
    <div class="row ">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Listado de tikcets cancelados</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">

          <table id="registrados" class="table table-bordered table-striped">
                <thead>
              <tr>
                  <th>Ver info</th>
                  <th>Sitio</th>                  
                  <th>nombre contacto</th>
                  <th>Telefono</th>
                  <th>N° Tickets</th>
                  <th>Asignado</th>            
                  <th>Empresa</th>
                  <th>estado</th>                
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
              <?php
                try {
                
                  $stmt = $conn->prepare("SELECT cancelado .*, asignaciones .*, requerimientos.nombre as namerequerimiento,  tickets .*, clientes.empresa, usuarios.nombre as nameusuario, usuarios.apellidos  FROM cancelado JOIN asignaciones ON cancelado.asignacionid = asignaciones.idasignacion JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario WHERE estadocancelado = 1 " );
                  $stmt->execute();
                } catch (Exception $e) {
                  // capturamos el error
                  $error = $e->getMessage();
                  echo $error;
                }
                while ($ticket = $stmt->fetch()) {   ?>
                  <tr>
                        <td><a class="btn btn-default btn-xs" href="ticket-info.php?id=<?= $ticket['idcancelado'].'&tipo=incidencia';?>">Ver <span class="glyphicon glyphicon-arrow-right"></span></a></td>
                        <td><?php echo $ticket['sitio'] ?></td>                                               
                        <td><?php echo $ticket['nombrecontacto'] ?></td>                                               
                        <td><?php echo $ticket['telefono'] ?></td>                                               
                        <td><?php echo $ticket['ticketid'] ?></td>                                               
                        <td><?php echo $ticket['nameusuario'].' '.$ticket['apellidos'] ?></td>                                                                       
                        <td><span class="text-danger"><?= $ticket['empresa'] ?></span></td>                                               
                       <td><span class="dtr-data">'<span class="label label-danger">Con incidencias</span></span></td>
                        <td>
                        <a  href="reasignar-ticket.php?id=<?php echo $ticket['asignacionid'].'&idcancel='.$ticket['idcancelado']; ?>" class="btn btn-primary btn-sm">Reasignar  <i class="fas fa-people-arrows"></i></a>
                        <a href="atender-ticket.php?id=<?php echo $ticket['asignacionid'].'&idticket='.$ticket['ticketid']; ?>" class="btn btn-success btn-sm">Finalizar <i class="fa fa-check"></i>
 
                        </td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
          </div><!-- /.box-body -->

        </div> <!-- /.box-body -->

      </div>
      <!--col-xs  -->

    </div> <!-- /.row -->



</div><!-- /.content-wrapper -->

<?php
include_once 'templates/footer.php'; 
?>