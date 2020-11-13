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
            <h1>Problemas</h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="problemas.php"><i class="fa fa-child"></i> Problemas</a></li>
                <li class="active">Editar problema</li>
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
                            <h3 class="box-title">Editar problema</h3>
                        </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php 
                      $id = $_GET['id'];           
        
                       $stmt = $conn->prepare("SELECT   * FROM problemas WHERE idproblema = :idproblema " );                                         
                        $stmt->bindValue(":idproblema", $id, PDO::PARAM_INT );  
                        $stmt->execute();             
                        $problema = $stmt->fetch();                                                       
                   ?>  
                        <form role="form" method="post" name="guardar-registro" id="guardar-registro" action="modelo-problema.php">
                            <div class="box-body">
                                <div class="form-group">
                                  <label for="area">Nombre del Problema</label>
                                  <input type="text" name="problema" class="form-control" id="problema" placeholder="Nombre del Problema" value="<?= $problema['nombre'];?>">
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit"  class="btn btn-success">Actualizar</button>
                                <a href="problemas.php" class="btn btn-primary">Volver</a>
                                <input type="hidden" name="registro" value="actualizar">
                                <input type="hidden" name="id_registro" value="<?= $problema['idproblema'];  ?>">
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