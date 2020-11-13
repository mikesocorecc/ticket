<?php
include_once 'funciones/sesiones.php';
include_once 'funciones/bd-conexion.php'; 
include_once 'templates/header.php'; 
include_once 'templates/navbar.php'; 
include_once 'templates/sidebar.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content-header">
            <h1>Finalizar Ticket</h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="problemas.php"><i class="fa fa-child"></i> tickets</a></li>
                <li class="active">Finalizar Ticket</li>
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
                            <h3 class="box-title">Finalizar Ticket</h3>
                        </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                        <form role="form" method="post" name="guardar-registro" id="guardar-registro" action="modelo-asignar.php">
                            <div class="box-body">
                                <div class="form-group">
                                  <label for="area">Comentario:</label>
                                  <input type="text" name="comentario" class="form-control" id="" placeholder="Comentario">
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit"  class="btn btn-success">Finalizar</button>
                                <input type="hidden" name="idasignacion" value="<?= $_GET['id']; ?>">
                                <input type="hidden" name="idticket" value="<?= $_GET['idticket']; ?>">
                                <input type="hidden" name="registro" value="finalizacion">
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