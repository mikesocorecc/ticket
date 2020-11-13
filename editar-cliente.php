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
            <h1>Clientes</h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="clientes.php"><i class="fa fa-child"></i> Clientes</a></li>
                <li class="active">Editar cliente</li>
            </ol>
        </section>
<section class="content">

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-xs-12 col-md-6">
                <div id="result"></div>
                    <!-- general form elements -->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Editar Cliente</h3>
                         
                        </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php 
                      $id = $_GET['id'];                                                                       
                      $stmt = $conn->prepare("SELECT   * FROM clientes WHERE idcliente = :idcliente");  
                      $stmt->bindValue(":idcliente", $id, PDO::PARAM_INT );  
                      $stmt->execute();             
                      $cliente = $stmt->fetch(); 
                   ?>  
                        <form role="form" method="post" name="guardar-registro"  id="guardar-registro" action="modelo-cliente.php">
                            <div class="box-body">
                                <div class="form-group">
                                  <label for="usuario">Empresa: </label>
                                  <input type="text" name="empresa" class="form-control" placeholder="Nombre"  value="<?= $cliente['empresa'];  ?>" required>
                                </div>
                                <div class="form-group">
                                  <label for="nombre">Encargado: </label>
                                  <input type="text" name="encargado" class="form-control"  placeholder="Nombre"  value="<?= $cliente['encargado'];  ?>" required>
                                </div>                             
                                <div class="form-group">
                                  <label for="email">E-mail: </label>
                                  <input type="email" name="email" class="form-control"  placeholder="Correo Electrónico" value="<?= $cliente['email'];  ?>" required>
                                </div>
                                <div class="form-group">
                                  <label for="password">RUC: </label>
                                  <input type="text" name="ruc" class="form-control"  placeholder="RUC" value="<?= $cliente['ruc'];  ?>" required>
                                </div>                               
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" id="save_data" class="btn btn-success">Actualizar</button>
                                  <a href="clientes.php" class="btn btn-primary">Volver</a>
                                <input type="hidden" name="registro" value="actualizar">
                                <input type="hidden" name="id_registro" value="<?= $cliente['idcliente'];  ?>">
                            </div>
                        </form>
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section>
        </div><!-- /.content-wrapper -->
<?php
include_once 'templates/footer.php'; //incluimos el footer  en esta parte xq aqui estava el footer
?>