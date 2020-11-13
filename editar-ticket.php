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
        <h1>Ticket</h1>
        <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="problemas.php"><i class="fa fa-child"></i> Ticket</a></li>
            <li class="active">Editar ticket</li>
        </ol>
    </section>
    <section class="content">
        <?php      
            $idticket = $_GET['id'];         
            $stmt = $conn->prepare("SELECT * FROM  tickets WHERE idticket = :idticket " );                                         
            $stmt->bindValue(":idticket", $idticket, PDO::PARAM_STR);  
            $stmt->execute();             
            $ticket = $stmt->fetch();   
            
         ?>
        <div class="row">
        <div class="col-md-10">
                    <a href="ticket-registrados.php" class="btn btn-default  pull-right"><i class="glyphicon glyphicon-arrow-left"></i> Regresar</a>
                </div>
            <div class="col-md-3"></div>
            <div class="col-xs-12 col-md-6">
                <div id="result"></div>
                <!-- general form elements -->
                <div class="box box-success">
                    <form role="form" class="form-horizontal" action="modelo-ticket.php" method="POST" id="guardar-registro-archivo" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Numero ticket </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="idticket" id="idticket" class="form-control" placeholder="Numero del ticekt" value="<?= $ticket['idticket'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sitio </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="sitio" id="sitio" class="form-control" placeholder="Sitio" value="<?= $ticket['sitio'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">SN </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="sn" id="sn" class="form-control" placeholder="SN"  value="<?= $ticket['sn'] ?>"  >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Nombre Contacto </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="ncontacto" id="ncontacto" class="form-control"
                                        placeholder="Nombre Contacto" value="<?= $ticket['nombrecontacto'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone2">Telefono </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="telefono" id="telefono" class="form-control"
                                        placeholder="Telefono"  value="<?= $ticket['telefono'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone2">Direccion </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="direccion" id="direccion" class="form-control"
                                        placeholder="Direccion" value="<?= $ticket['direccion'] ?>">
                                </div>
                            </div>
                       
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Horario de contacto<span class="required">*</span></label> 
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <br>
                                    <p>
                                        <input type="radio" class="flat" name="hcontact" id="gender1" value="08:00am - 01:00pm" checked=""  > 08:00am - 01:00pm
                                        <br>
                                        <input type="radio" class="flat" name="hcontact" id="gender2" value="02:00pm - 06:00pm" > 02:00pm - 06:00pm
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Empresa<span class="required">*</span></label>
                                 <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class=" chosen-select form-control w-50" name="cliente" required>   
                                <option value="0" disabled selected>--SELECCIONE UNA EMPRESA--</option>                                          
                                        <?php                                          
                                          
                                            $stmt2 = $conn->prepare("SELECT idcliente, empresa FROM clientes" );
                                            $stmt2->execute();                                                                                
                                            while ($cliente = $stmt2->fetch()) {
                                                if($cliente['idcliente'] == $ticket['clienteid']){ ?>                                                                                                                                                                                     
                                                    <option value="<?= $cliente['idcliente']; ?>" selected ><?= $cliente['empresa']; ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $cliente['idcliente']; ?>" ><?= $cliente['empresa']; ?></option>
                                            <?php } } ?>               
                                </select>
                                </div>                            
                            </div> 
                            <div class="form-group">
                                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Problema<span class="required">*</span></label>
                                 <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class=" chosen-select form-control w-50" name="problema" required>     
                                <option value="0" disabled selected>--SELECCIONE UN PROBLEMA--</option>                                        
                                        <?php                                          
                                       
                                            $stmt3 = $conn->prepare(" SELECT idproblema, nombre FROM problemas " );
                                            $stmt3->execute();                                          
                                            while ($problema = $stmt3->fetch()) { 
                                                if($problema['idproblema'] == $ticket['problemaid']){ ?>                                                                                                                                                                                     
                                                    <option value="<?= $problema['idproblema']; ?>" selected><?= $problema['nombre']; ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $problema['idproblema']; ?>" ><?= $problema['nombre']; ?></option>
                                            <?php } } ?>               
                                </select>
                                </div>                            
                            </div> 
                            <div class="form-group">
                                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Area<span class="required">*</span></label>
                                 <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class=" chosen-select form-control w-50" name="area" required >  
                                    <option value="0" disabled selected>--SELECCIONE UN AREA--</option>                                    
                                        <?php                                          
                                            // $sql = " SELECT idarea, nombre FROM areas ";                                            
                                            // $resultado = $conn->query($sql); 
                                            $stmt4 = $conn->prepare(" SELECT idarea, nombre FROM areas " );
                                            $stmt4->execute();                                           
                                            while ($area = $stmt4->fetch()) { 
                                                    if($area['idarea'] == $ticket['areaid']){?> 
                                                    <option value="<?= $area['idarea']; ?>" selected ><?= $area['nombre']; ?></option>
                                                    <?php }else{ ?>
                                                    <option value="<?= $area['idarea']; ?>" ><?= $area['nombre']; ?></option>
                                            <?php } } ?>               
                                </select>
                                </div>                            
                            </div> 
                     
              
                            <div class="form-group">
                                <label for="comment" class="control-label col-md-3 col-sm-3 col-xs-12">Descripción <span  class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea name="descripcion" id="comment" class="form-control col-md-7 col-xs-12" placeholder="Descripción" required><?= $ticket['descripcion']  ?></textarea>
                                </div>
                            </div>
                            <br>                       
                            <div class="form-group">
                                <label class="col-sm-3 col-md-3 control-label">Adjunto</label>
                                <div class="col-sm-9">
                                    <input type="file" name="archivo_imagen">
                                    <p class="text-muted">Peso Máximo 2MB</p>
                                    <?php if($ticket['archivo'] == 'vacio'){ 
                                        echo "<strong class='text-warning'>No se a subido ninguna imagen</strong>";
                                    }else{?>
                                    <img src="dist/img/imgticket/<?= $ticket['archivo']?>" alt="" style="width: 60px; height: 60px;">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 col-md-3 control-label"></label>
                                <div class="col-sm-9">
                                    <input type="checkbox" name="terminos" required > Acepto los terminos y condiciónes.
                                </div>

                            </div>
                        </div><!-- /.box body -->
                        <div class="box-footer">
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">                           
                                     <button type="submit"  class="btn btn-success">Actualizar</button>
                                    <a href="ticket-registrados.php" class="btn btn-primary">Volver</a>
                                    <input type="hidden" name="registro" value="actualizar">
                                    <input type="hidden" name="id_registro" value="<?= $ticket['idticket'];  ?>">
                                </div>
                            </div>
                        </div><!-- /.box footer -->
                    </form>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section>
</div><!-- /.content-wrapper -->
<?php
include_once 'templates/footer.php'; //incluimos el footer  en esta parte xq aqui estava el footer
?>