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
                <li><a href="Usuarios.php"><i class="fa fa-child"></i> Clientes</a></li>
                <li class="active">Nuevo cliente</li>
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
                            <h3 class="box-title">Nuevo Clientes</h3>
                         
                        </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                        <form role="form" method="post" name="guardar-registro"  id="guardar-registro" action="modelo-cliente.php">
                            <div class="box-body">
                                <div class="form-group">
                                  <label for="usuario">Empresa: </label>
                                  <input type="text" name="empresa" class="form-control" placeholder="Nombre" required>
                                </div>
                                <div class="form-group">
                                  <label for="nombre">Encargado: </label>
                                  <input type="text" name="encargado" class="form-control"  placeholder="Nombre" required>
                                </div>                             
                                <div class="form-group">
                                  <label for="email">E-mail: </label>
                                  <input type="email" name="email" class="form-control"  placeholder="Correo Electrónico" required>
                                </div>
                                <div class="form-group">
                                  <label for="password">RUC: </label>
                                  <input type="text" name="ruc" class="form-control"  placeholder="RUC"  required>
                                </div>                               
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" id="save_data" class="btn btn-success">Agregar</button>
                                <a href="clientes.php" class="btn btn-primary">Volver</a>
                                <input type="hidden" name="registro" value="nuevo">
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