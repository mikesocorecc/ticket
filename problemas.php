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
    <h1>Problemas</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Problemas</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default pull-right " style="margin-bottom: 15px;"  href="nuevo-problema.php"><i class="fa fa-plus"></i> Nuevo</a>
    <div class="row ">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Registro de problemas</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">

          <table id="registrados" class="table table-bordered table-striped">
                <thead>
              <tr>
                  <th>#ID</th>
                  <th>Nombre</th>                        
                  <th></th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
              <?php
                try {
                  //crearemos la consulta para llenar la tabla
                  $sql = "SELECT * FROM problemas ";
                  $stmt = $conn->prepare($sql);        
                  $stmt->execute();   
              
                } catch (Exception $e) {
                  // capturamos el error
                  $error = $e->getMessage();
                  echo $error;
                }
                while ($problema =  $stmt->fetch()) {   ?>
                  <tr>
                        <td><?php echo $problema['idproblema'] ?></td>
                        <td><?php echo $problema['nombre'] ?></td>                                               
                        <td></td>                                      
                        <td>
                        <a href="editar-problema.php?id=<?php echo $problema['idproblema'] ?>" class="btn btn-primary btn-sm">Editar <i class="fas fa-pencil-alt"></i></a>
                        <a href="#" data-id="<?php echo $problema['idproblema'] ?>" data-tipo="problema" class="btn btn-danger btn-sm borrar_registro">Borrar <i class="fa fa-trash"></i></a>
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