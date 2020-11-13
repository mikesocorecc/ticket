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
    <section class="content-header ">
        <h1>Reportes</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Reportes</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row ">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Registro de Tickets</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form print -->
                        <form class="form-horizontal" role="form" id="reportes" action="modelo-reportes.php">
                            <div class="form-group row">
                                    <!-- <input type="hidden" class="form-control" id="name_user" value="Jose"> -->
                                    <!-- Calendario -->
                                    <div class="col-md-3 pull-left">                              
                                            <!-- <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" id="reservation" value="">
                                           </div>                                    -->
                                           <input type="text" class="form-control" id="daterange" name="daterange" value="" readonly="" onchange="cargar(1);">
                                    </div>
                                    <!-- Filtrar por categoria -->
                                    <div class="col-md-3 pull-left">
                                        <select class="form-control" id="categoria" name="category"onclick='cargar(1);'>
                                            <option selected="" value="0">-- Imprimir por Categoria --</option>
                                            <option value="1">Registrado</option>
                                            <option value="2">Asignado</option>
                                            <option value="3">Con Incidencia</option>
                                            <option value="4">Atendido</option>
                                        </select>
                                    </div>
                                    <!-- Boton buscar -->
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-default" onclick="load(1);">
                                            <span class="glyphicon glyphicon-search"></span> Buscar</button>
                                        <span id="loader"></span>
                                    </div>
                                    <!-- Botones imprimir y descargar XLS -->
                                    <div class="col-md-3">
                                        <!-- Btn imprimir LS -->
                                        <button id="imprimir" type="submit" class="btn btn-default pull-right">
                                            <span class="glyphicon glyphicon-print"></span> Imprimir
                                        </button>

                                        <a style="margin-right: 3px" target="_blank" href="exportar.php"
                                            class="btn btn-default pull-right">
                                            <span class="fa fa-file-excel-o"></span> Descargar
                                        </a>
                                    </div>
                            </div>
                        </form>
                        <!-- end form print -->

                        <div class="table-responsive">
                            <!-- ajax -->                           
                            <div class="outer_div">
                          
                             </div> <!--Carga los datos ajax -->
                            <!-- /ajax -->
                        </div>
                    </div>
                </div> <!-- /.box-body -->
            </div>
            <!--col-xs  -->
        </div> <!-- /.row -->
</div><!-- /.content-wrapper -->

<?php
include_once 'templates/footer.php'; 
?>