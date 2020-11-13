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
        <h1>Actualizar Asignación</h1>
        <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="problemas.php"><i class="fa fa-child"></i> Tickets</a></li>
            <li class="active">Actualizar Asignación</li>
        </ol>
    </section>
    <section class="content">

        <div class="row">
        <div class="col-md-10">
                    <a href="ticket-registrados.php" class="btn btn-default  pull-right"><i class="glyphicon glyphicon-arrow-left"></i> Regresar</a>
                </div>
            <div class="col-md-3"></div>
            <div class="col-xs-12 col-md-6">
                <div id="result"></div>
                <!-- general form elements -->
                <div class="box box-success">
                   <form role="form" method="POST"  id="guardar-registro" action="modelo-asignar.php">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="asigned_id">Tecnico: </label>
                                    <select name="tecnicoid" class="form-control"  required>
                                             <?php                                          
                                                // $sql = " SELECT idusuario, nombre, apellidos FROM usuarios ";                                            
                                                // $resultado = $conn->query($sql);                                         
                                                $stmt = $conn->prepare(" SELECT idusuario, nombre, apellidos, rolid FROM usuarios  ");        
                                                $stmt->execute();   
                                                while ($user = $stmt->fetch()) { ?>                                                                                                                                                                                     
                                                <option value="<?= $user['idusuario']; ?>" <?=($user['rolid'] == 1 ) ? "disabled class='bg-warning'" : "";?> ><?= $user['nombre'].' '.$user['apellidos']; ?></option>
                                            <?php } ?>                                                                            
                                    </select>                                    
                                </div>
                            </div>
                            
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="hidden" name="idasignacion" value="<?= $_GET['id']; ?>">
                                <input type="hidden" name="idcancelado" value="<?= (isset($_GET['idcancel'])) ? $_GET['idcancel'] : 'vacio'; ?> ">
                                <input type="hidden" name="registro" value="reasignar">
                                <button type="submit"  class="btn btn-success">Asignar</button>
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