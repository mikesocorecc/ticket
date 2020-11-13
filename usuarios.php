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
  <!-- Content Header (Page header) -->
  <!-- <section class="content-header">
    <h1>Listado de personas registradas<small></small></h1>
  </section> -->
  <section class="content-header ">
    <h1>Usuarios</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Usuarios</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default pull-right " style="margin-bottom: 15px;" href="crear-usuario.php"><i class="fa fa-plus"></i> Nuevo</a>
    <div class="row ">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Registro de usuarios</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">

          <table id="registrados" class="table table-bordered table-striped">
                <thead>
              <tr>
                  <th>Nombre</th>
                  <th>Usuario</th>
                  <th>Correo electronico</th>
                  <th>Activo</th>
                  <th>Tipo usuario</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
              <?php
                try {
                  //crearemos la consulta para llenar la tabla
                  $sql = "SELECT usuarios .*, roles.nombre as nombrerol FROM usuarios JOIN roles ON usuarios.rolid = roles.idrol;";
                  $stmt = $conn->prepare($sql);        
                  $stmt->execute();                    
                } catch (Exception $e) {
                  // capturamos el error
                  $error = $e->getMessage();
                  echo $error;
                }
                while ($usuario = $stmt->fetch()) {   ?>
                  <tr>
                    <td><?php echo $usuario['nombre'] ?></td>
                    <td><?php echo $usuario['usuario'] ?></td>
                    <td><?php echo $usuario['email'] ?></td>
                    <td><span class="dtr-data"><?= ($usuario['estado'] = 1) ? '<span class="label label-success">Activo</span>' :  '<span class="label label-danger">Inactivo</span>'; ?></span></td>
                    <td><?php echo $usuario['nombrerol'] ?></td>
                    <td>
                      <a href="editar-usuario.php?id=<?php echo $usuario['idusuario'] ?>" class="btn btn-primary btn-sm">Editar <i class="fas fa-pencil-alt"></i></a> 
                      <a href="#" data-id="<?php echo $usuario['idusuario'] ?>" data-tipo="usuario" class=" btn btn-danger btn-sm  borrar_registro">Borrar <i class="fa fa-trash"></i></a>

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
include_once 'templates/footer.php'; //incluimos el footer  en esta parte xq aqui estava el footer
?>