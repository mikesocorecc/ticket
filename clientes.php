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
    <h1>Clientes</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Clientes</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default pull-right " style="margin-bottom: 15px;"  href="crear-cliente.php"><i class="fa fa-plus"></i> Nuevo</a>
    <div class="row ">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Registro de clientes</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
          <table id="registrados" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#ID</th>
                  <th>EMPRESA</th>
                  <th>Encargado</th>
                  <th>Email</th>
                  <th>RUC</th>
                  <th>Fecha / Hora</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                try {
                  //crearemos la consulta para llenar la tabla
                  $sql = "SELECT * FROM  clientes ";
                  $stmt = $conn->prepare($sql);        
                  $stmt->execute();   
                  
                } catch (Exception $e) {
                  // capturamos el error
                  $error = $e->getMessage();
                  echo $error;
                }                
               while($cliente = $stmt->fetch()){   ?>
                      <tr>
                          <td><?php echo $cliente['idcliente'] ?></td> 
                          <td><?php echo $cliente['empresa'] ?></td>
                          <td><?php echo $cliente['encargado'] ?></td>
                          <td><?php echo $cliente['email'] ?></td>
                          <td><?php echo $cliente['ruc'] ?></td>
                          <td><?php echo $cliente['fecha'] ?></td>                          
                            <td>
                              <div class="text-center">   
                                  <a href="editar-cliente.php?id=<?php echo $cliente['idcliente'] ?>"  class="btn btn-social-icon btn-tumblr"> <i class="fas fa-pencil-alt"></i></a>                                 
                                  <a href="#" data-id="<?php echo $cliente['idcliente']?>" data-tipo="cliente"  class="btn btn-social-icon btn-twitter borrar_registro" class="btn btn-danger btn-xs "> <i class="fa fa-trash"></i></a>                                                                              
                                  <?php 
                                      $idcliente =  $cliente['idcliente'];
                                      //crearemos la consulta para llenar la tabla
                                      $sql2 = "SELECT * FROM `tickets` WHERE tickets.clienteid = $idcliente ";
                                      $stmt2 = $conn->prepare($sql2);        
                                      $stmt2->execute(); 
                                    
                                      if($stmt2->rowCount() != 0){  ?>                                    
                                        <a href="descargarxls.php?id=<?php echo $cliente['idcliente']?>" data-id="<?php echo $cliente['idcliente']?>"   class="btn btn-social-icon btn-tumblr"> <i class="fas fa-file-excel"></i></a>                                
                                      <?php } ?> 
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
include_once 'templates/footer.php'; //incluimos el footer  en esta parte xq aqui estava el footer
?>