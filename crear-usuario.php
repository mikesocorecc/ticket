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
            <h1>Usuarios</h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="Usuarios.php"><i class="fa fa-child"></i> Usuarios</a></li>
                <li class="active">Nuevo Usuario</li>
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
                            <h3 class="box-title">Nuevo Usuario</h3>                         
                        </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                        <form  method="POST" name="guardar-registro"  id="guardar-registro" action="modelo-usuario.php">
                            <div class="box-body">
                                <div class="form-group">
                                  <label for="usuario">Usuario: </label>
                                  <input type="text" name="usuario" class="form-control" placeholder="Nombre" required  >
                                </div>
                                <div class="form-group">
                                  <label for="nombre">Nombre: </label>
                                  <input type="text" name="nombre" class="form-control" placeholder="Nombre" >
                                </div>
                                <div class="form-group">
                                  <label for="apellidos">Apellidos: </label>
                                  <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Apellidos" required>
                                </div>
                                <div class="form-group">
                                  <label for="email">E-mail: </label>
                                  <input type="email" name="email" class="form-control" id="email" placeholder="Correo Electrónico" required >
                                </div>
                                <div class="form-group">
                                  <label for="password">Contraseña: </label>
                                  <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña"  required>
                                </div>
                                <div class="form-group">
                                    <label>Rol</label>
                                  <select class="form-control" name="rol" <?= $usuario['rolid'];  ?> >
                                                  <option value="0"selected disabled>--SELECCIONE UN ROL</option>
                                        <?php                                          
                                                                                  
                                            $stmt = $conn->prepare(" SELECT idrol, nombre FROM roles " );                                         
                                            $stmt->execute();
                                            while ($roles = $stmt->fetch()) { ?>                                                                                                                                                                                         
                                              <option value="<?= $roles['idrol']; ?>" ><?= $roles['nombre']; ?></option>
                                           <?php }  ?>                    
                                    </select>
                                </div>  
                   
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit"  class="btn btn-success">Agregar</button>
                                <a href="usuarios.php" class="btn btn-primary">Volver</a>
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