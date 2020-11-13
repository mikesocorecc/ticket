<?php
include_once 'funciones/sesiones.php';
// if($_SESSION['namerol'] !== "Administrador"){
//   header('Location:login.php');
// }
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
                <li class="active">Editar Usuario</li>
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
                            <h3 class="box-title">Editar  Usuario</h3>
                         
                        </div>
                    <!-- /.box-header -->
                    <?php             
                        $id = $_GET['id'];           
                  
                        $stmt = $conn->prepare("SELECT   * FROM usuarios WHERE idusuario = :idusuario " );                                         
                        $stmt->bindValue(":idusuario", $id, PDO::PARAM_INT);  
                        $stmt->execute();             
                        $usuario = $stmt->fetch();                                                         
                     ?>
                    <!-- form start -->
                        <form  method="POST" name="editar-registro"  id="guardar-registro" action="modelo-usuario.php">
                            <div class="box-body">
                                <div class="form-group">
                                  <label for="usuario">Usuario: </label>
                                  <input type="text" name="usuario" class="form-control" placeholder="Nombre" required  value="<?= $usuario['usuario'];  ?>" >
                                </div>
                                <div class="form-group">
                                  <label for="nombre">Nombre: </label>
                                  <input type="text" name="nombre" class="form-control" placeholder="Nombre" required value="<?= $usuario['nombre'];  ?> ">
                                </div>
                                <div class="form-group">
                                  <label for="apellidos">Apellidos: </label>
                                  <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Apellidos" required value="<?= $usuario['apellidos'];  ?> ">
                                </div>
                                <div class="form-group">
                                  <label for="email">E-mail: </label>
                                  <input type="email" name="email" class="form-control" id="email" placeholder="Correo Electrónico" required value="<?= $usuario['email'];  ?> " >
                                </div>
                                <div class="form-group">
                                  <label for="password">Contraseña: </label>
                                  <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña"   >
                                </div>                                                         
                                <div class="form-group">
                                    <label>Rol</label>
                                  <select class="form-control" name="rol" <?= $usuario['rolid'];  ?>>                                      
                                        <?php                                                                                              
                                            $stmt2 = $conn->prepare("SELECT idrol, nombre FROM roles" );
                                            $stmt2->execute();                                         
                                            while ($roles = $stmt2->fetch()) { ?>
                                                <?php if($roles['idrol'] == $usuario['rolid'] ){ ?>                                              
                                                  <option value="<?= $roles['idrol']; ?>" selected><?= $roles['nombre']; ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $roles['idrol']; ?>" ><?= $roles['nombre']; ?></option>
                                           <?php } }  ?>                    
                                    </select>
                                </div>                       
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit"  class="btn btn-success">Actualizar</button>
                                <a href="usuarios.php" class="btn btn-primary">Volver</a>
                                <input type="hidden" name="id_registro" value="<?= $usuario['idusuario'];  ?>">
                                <input type="hidden" name="registro" value="actualizar">
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