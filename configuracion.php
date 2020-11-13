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
            <h1>Configuración</h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="Usuarios.php"><i class="fa fa-child"></i> Configuración</a></li>     
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
                            <h3 class="box-title">Nueva Area</h3>
                        </div>
                    <!-- /.box-header -->
                    <?php 
                            include_once 'funciones/bd-conexion.php'; 
                            $sql = "SELECT * FROM config  ";
                            $stmt = $conn->prepare($sql);        
                            $stmt->execute();
                           $config = $stmt->fetch();
                    ?>
                    <!-- form start -->
                        <form role="form" method="post" name="guardar-registro-archivo" id="guardar-registro-archivo" action="modelo-config.php" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                  <label for="area">Nombre del Sitio Web</label>
                                  <input type="text" name="namesitio" class="form-control" id="area" placeholder="Nombre del Sitio Web" value="<?= $config['nombresitio']  ?>">
                                </div>
                                <div class="form-group">
                                  <label for="area">Correo Electronico</label>
                                  <input type="text" name="correo" class="form-control" id="area" placeholder="Correo Electronico" value="<?= $config['email']  ?>">
                                </div>
                                <div class="form-group">
                                  <label for="area">URL Base</label>
                                  <input type="text" name="urlbase" class="form-control" id="area" placeholder="URL Base" value="<?= $config['urlbase']  ?>">
                                </div>
                                <div class="form-group">                                  
                                  <label class="col-sm-3 col-md-3 control-label">Seleccione una imagen</label>
                                <div class="col-sm-9">
                                    <input type="file" name="archivo_imagen" >                                    
                                </div>                        
                                </div>
                                <div class="col-sm-9 ">
                                    <img src="<?php echo ($config['favicon'] != 'logo.png') ? 'dist/img/favicon/'.$config['favicon'] : '' ?>"
                                     alt="" style="width: 160px; height: 110px; margin-top: 20px;">
                                </div>
                            </div>
                            
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit"  class="btn btn-success">Actualizar</button>
                                <a href="index.php" class="btn btn-primary">Volver</a>
                                <input type="hidden" name="registro" value="update">
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