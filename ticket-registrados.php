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
    <h1>Tickets Registrados</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Tickets registrados</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default pull-right " style="margin-bottom: 15px;"  href="nuevo-ticket.php"><i class="fa fa-plus"></i> Nuevo</a>
    <div class="row ">
      <div class="col-xs-12">
        <div class="box">
   
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
                  <th>Asunto</th>
                  <th>Empresa</th>
                  <th>estado</th>                
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
              <?php
                try {
                  //crearemos la consulta para llenar la tabla
                  // $sql = "SELECT tickets .*, problemas.nombre as problemanombre, areas.nombre as areanombre, clientes.empresa FROM tickets JOIN problemas ON problemas.idproblema = tickets.problemaid JOIN areas ON tickets.areaid = areas.idarea JOIN clientes ON tickets.clienteid = clientes.idcliente where estado = 1 ";
                  // $resultado = $conn->query($sql);
                  $stmt = $conn->prepare("SELECT tickets .*, problemas.nombre as problemanombre, areas.nombre as areanombre, clientes.empresa FROM tickets JOIN problemas ON problemas.idproblema = tickets.problemaid JOIN areas ON tickets.areaid = areas.idarea JOIN clientes ON tickets.clienteid = clientes.idcliente where estado = 1 ");        
                  $stmt->execute();  
                } catch (Exception $e) {
                  // capturamos el error
                  $error = $e->getMessage();
                  echo $error;
                }
                while ($ticket = $stmt->fetch()) {   ?>
                  <tr>
                        <td><a class="btn btn-default btn-xs" href="ticket-info.php?id=<?= $ticket['idticket'].'&tipo=registrado'; ?>">Ver <span class="glyphicon glyphicon-arrow-right"></span></a></td>
                        <td><?php echo $ticket['sitio'] ?></td>                                               
                        <td><?php echo $ticket['nombrecontacto'] ?></td>                                               
                        <td><?php echo $ticket['telefono'] ?></td>                                               
                        <td><?php echo $ticket['idticket'] ?></td>                                               
                        <td><?php echo $ticket['problemanombre'] ?></td>                                               
                        <td><span class="text-danger"><?= $ticket['empresa'] ?></span></td>                                               
                       <td><span class="dtr-data"><?= ($ticket['estado'] = 1) ? '<span class="label label-warning">Registrado</span>' :  ''; ?></span></td>
                        <td>      
                        <div class="btn-group">
                          <button type="button" class="btn btn-default">Acción</button>
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu">
                              <li><a href="asignar-ticket.php?id=<?php echo $ticket['idticket'] ?>" > Asignar &nbsp;&nbsp;<i class="fas fa-people-arrows"></i></a></li>
                              <li><a href="editar-ticket.php?id=<?php echo $ticket['idticket'] ?>" >Editar <i class="fas fa-pencil-alt"></i></a> </li>
                              <li><a data-id="<?php echo $ticket['idticket'] ?>"  data-tipo="ticket" class="borrar_registro"> Borrar &nbsp;&nbsp;<i class="fa fa-trash"></i></i></a>                      </li>
                          </ul>
                       </div>                                  
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