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
<section class="content-header">
            <h1>Areas</h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="areas.php"><i class="fa fa-child"></i> Areas</a></li>
                <li class="active">Editar area</li>
            </ol>
        </section>
<section class="content">

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-xs-12 col-md-6">
                <div id="result"></div>
                    <!-- general form elements -->
                    <div class="box box-success">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Editar Area</h3>
                        </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php 
                      $id = $_GET['id'];                        
                      $stmt = $conn->prepare('SELECT * FROM areas WHERE idarea = :idarea');                     
                      $stmt->bindValue(":idarea", $id, PDO::PARAM_INT);
                      $stmt->execute();                          
                      $area = $stmt->fetch();                               
                    ?>
                        <form role="form" method="post" name="guardar-registro" id="guardar-registro" action="modelo-area.php">
                            <div class="box-body">
                                <div class="form-group">
                                  <label for="area">Nombre del Area</label>
                                  <input type="text" name="area" class="form-control" id="area" placeholder="Nombre del Area" value="<?= $area['nombre']; ?>" required>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit"  class="btn btn-success">Actualizar</button>   
                                <a href="areas.php" class="btn btn-primary">Volver</a>                        
                                <input type="hidden" name="registro" value="actualizar">
                                <input type="hidden" name="id_registro" value="<?= $area['idarea'];  ?>">
                            </div>
                        </form>
                    </div>
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section>
        </div><!-- /.content-wrapper -->
<?php
include_once 'templates/footer.php'; //incluimos el footer  en esta parte xq aqui estava el footer
?>