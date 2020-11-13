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
            <li class="active">Nuevo ticket</li>
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
                    <form role="form" class="form-horizontal" action="modelo-ticket.php" method="POST" id="guardar-registro-archivo" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Numero ticket </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="idticket" id="idticket" class="form-control" placeholder="Numero del ticekt" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sitio </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="sitio" id="sitio" class="form-control" placeholder="Sitio" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">SN </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="sn" id="sn" class="form-control" placeholder="SN" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Nombre Contacto </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="ncontacto" id="ncontacto" class="form-control"
                                        placeholder="Nombre Contacto" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone2">Telefono </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="telefono" id="telefono" class="form-control"
                                        placeholder="Telefono" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone2">Direccion </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="direccion" id="direccion" class="form-control"
                                        placeholder="Direccion" >
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
                                            // $sql = " SELECT idcliente, empresa FROM clientes ";                                            
                                            // $resultado = $conn->query($sql);  
                                            $stmt = $conn->prepare("SELECT idcliente, empresa FROM clientes");        
                                            $stmt->execute();                                         
                                            while ($cliente = $stmt->fetch()) { ?>                                                                                                                                                                                     
                                            <option value="<?= $cliente['idcliente']; ?>" ><?= $cliente['empresa']; ?></option>
                                            <?php } ?>               
                                </select>
                                </div>                            
                            </div> 
                            <div class="form-group">
                                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Problema<span class="required">*</span></label>
                                 <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class=" chosen-select form-control w-50" name="problema" required>     
                                <option value="0" disabled selected>--SELECCIONE UN PROBLEMA--</option>                                        
                                        <?php                                          
                                            // $sql = " SELECT idproblema, nombre FROM problemas ";                                            
                                            // $resultado = $conn->query($sql); 
                                            $stmt = $conn->prepare("SELECT idproblema, nombre FROM problemas ");        
                                            $stmt->execute();                                            
                                            while ($problema = $stmt->fetch()) { ?>                                                                                                                                                                                     
                                            <option value="<?= $problema['idproblema']; ?>" ><?= $problema['nombre']; ?></option>
                                            <?php }   ?>               
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
                                            $stmt = $conn->prepare("SELECT idarea, nombre FROM areas ");        
                                            $stmt->execute();                                     
                                            while ($area = $stmt->fetch()) { ?>                                                                                                                                                                                     
                                            <option value="<?= $area['idarea']; ?>" ><?= $area['nombre']; ?></option>
                                            <?php }  ?>               
                                </select>
                                </div>                            
                            </div> 
                     
              
                            <div class="form-group">
                                <label for="comment" class="control-label col-md-3 col-sm-3 col-xs-12">Descripción <span  class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea name="descripcion" id="comment" class="form-control col-md-7 col-xs-12" placeholder="Descripción" required></textarea>
                                </div>
                            </div>
                            <br>                       
                            <div class="form-group">
                                <label class="col-sm-3 col-md-3 control-label">Adjunto</label>
                                <div class="col-sm-9">
                                    <input type="file" name="archivo_imagen">
                                    <p class="text-muted">Peso Máximo 2MB</p>
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
                                    <input type="submit" class="btn btn-success btn-submit" name="newticket"  value="Guardar">
                                    <input type="hidden" name="registro" value="nuevo">
                                     <a href="tickets.php" class="btn btn-default btn-reset">Cancelar</a>
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