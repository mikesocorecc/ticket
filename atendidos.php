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
    <h1>Tickets atendidos</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Tickets atendidos</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">  
    <div class="row ">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Listado de tikcets atendidos</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">

          <table id="registrados" class="table table-bordered table-striped">
                <thead>
              <tr>
                  <th>Ver info</th>
                  <th>nombre contacto</th>
                  <th>SN</th>                  
                  <th>Sitio</th>
                  <th>Telefono</th>
                  <th>N° Tickets</th>
                  <th>Asunto</th>            
                  <th>Empresa</th>
                  <th>estado</th>                
       
                </tr>
              </thead>
              <tbody>
              <?php
                try {
                  //crearemos la consulta para llenar la tabla                  
                  $stmt = $conn->prepare("SELECT finallizado .*, asignaciones .*, tickets .*, problemas.nombre as nameproblema, clientes.empresa FROM finallizado JOIN asignaciones ON finallizado.asignacionid = asignaciones.idasignacion JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente  " );
                  $stmt->execute();                                             
                } catch (Exception $e) {
                  // capturamos el error
                  $error = $e->getMessage();
                  echo $error;
                }
                while ($ticket = $stmt->fetch()) {   ?>
                  <tr>
                        <td><a class="btn btn-default btn-xs" href="ticket-info.php?id=<?= $ticket['idfinallizado'].'&tipo=finalizado'; ?>">Ver <span class="glyphicon glyphicon-arrow-right"></span></a></td>
                        <td><?php echo $ticket['nombrecontacto'] ?></td>                                               
                        <td><?php echo $ticket['sn'] ?></td>                                               
                        <td><?php echo $ticket['sitio'] ?></td>                                               
                        <td><?php echo $ticket['telefono'] ?></td>                                               
                        <td><?php echo $ticket['ticketid'] ?></td>                                               
                        <td><?php echo $ticket['nameproblema'] ?></td>                                                                       
                        <td><span class="text-danger"><?= $ticket['empresa'] ?></span></td>                                               
                       <td><span class="dtr-data"><span class="label label-success">Atendidos</span></span></td>              
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