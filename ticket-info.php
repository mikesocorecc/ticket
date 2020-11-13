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
        <h1>Informacion del ticket</h1>
        <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="problemas.php" class="active"><i class="fa fa-child"></i> Detallado del ticket</a></li>            
        </ol>
    </section>
        <?php 
        $id = $_GET['id'];    
        $tipo = $_GET['tipo'];
        
        if(isset($id) && $tipo == 'registrado' ){                        
            //   $stmt = $conn->prepare('SELECT tickets .*, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea FROM tickets JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea WHERE idticket = ? ');
            //   $stmt->bind_param("s", $id);    
              $stmt = $conn->prepare("SELECT tickets .*, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea FROM tickets JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea WHERE idticket = :idticket ");        
              $stmt->bindValue(":idticket", $id, PDO::PARAM_STR);               
            }else if(isset($id) && $tipo == 'asignado'){
            //   $stmt = $conn->prepare('SELECT asignaciones .*, requerimientos.nombre as namerequerimiento, requerimientos.fechahora, tickets.sitio, tickets.descripcion, tickets.estado, tickets.sn, tickets.nombrecontacto, tickets.telefono, tickets.direccion, tickets.horariocontacto, tickets.archivo, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea, usuarios.usuario, usuarios.nombre, usuarios.apellidos FROM asignaciones JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario WHERE estadoasignacion = 1 AND  idasignacion = ? ');
            //   $stmt->bind_param("i", $id);  
              $stmt = $conn->prepare("SELECT asignaciones .*, requerimientos.nombre as namerequerimiento, requerimientos.fechahora, tickets.sitio, tickets.descripcion, tickets.estado, tickets.sn, tickets.nombrecontacto, tickets.telefono, tickets.direccion, tickets.horariocontacto, tickets.archivo, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea, usuarios.usuario, usuarios.nombre, usuarios.apellidos FROM asignaciones JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario WHERE estadoasignacion = 1 AND  idasignacion =  :idasignacion ");        
              $stmt->bindValue(":idasignacion", $id, PDO::PARAM_INT); 
        } else if(isset($id) && $tipo == 'incidencia'){
            // $stmt = $conn->prepare('SELECT cancelado .*, asignaciones .*, requerimientos.nombre as namerequerimiento, tickets .*, clientes.empresa, usuarios.nombre as nameusuario, usuarios.apellidos, problemas.nombre as nameproblema FROM cancelado JOIN asignaciones ON cancelado.asignacionid = asignaciones.idasignacion JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario JOIN problemas ON tickets.problemaid = problemas.idproblema WHERE estadocancelado = 1  AND  idcancelado = ? ');
            // $stmt->bind_param("i", $id);
            $stmt = $conn->prepare("SELECT cancelado .*, asignaciones .*, requerimientos.nombre as namerequerimiento, tickets .*, clientes.empresa, usuarios.nombre as nameusuario, usuarios.apellidos, problemas.nombre as nameproblema FROM cancelado JOIN asignaciones ON cancelado.asignacionid = asignaciones.idasignacion JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario JOIN problemas ON tickets.problemaid = problemas.idproblema WHERE estadocancelado = 1  AND  idcancelado =  :idcancelado ");        
            $stmt->bindValue(":idcancelado", $id, PDO::PARAM_INT); 
        } elseif(isset($id) && $tipo == 'finalizado'){
            // $stmt = $conn->prepare('SELECT finallizado .*, asignaciones .*, tickets .*, problemas.nombre as nameproblema, clientes.empresa, usuarios.nombre as nameusuario, usuarios.apellidos, requerimientos.nombre as namerequerimiento FROM finallizado JOIN asignaciones ON finallizado.asignacionid = asignaciones.idasignacion JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento WHERE idfinallizado = ?  ');
            // $stmt->bind_param("i", $id);
            $stmt = $conn->prepare("SELECT finallizado .*, asignaciones .*, tickets .*, problemas.nombre as nameproblema, clientes.empresa, usuarios.nombre as nameusuario, usuarios.apellidos, requerimientos.nombre as namerequerimiento FROM finallizado JOIN asignaciones ON finallizado.asignacionid = asignaciones.idasignacion JOIN tickets ON asignaciones.ticketid = tickets.idticket JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN usuarios ON asignaciones.usuarioid = usuarios.idusuario JOIN requerimientos ON asignaciones.requerimientoid = requerimientos.idrequerimiento WHERE idfinallizado =  :idfinallizado ");        
            $stmt->bindValue(":idfinallizado", $id, PDO::PARAM_INT); 
        }
              $stmt->execute();                                                                            
            //   $ticket = $stmt->get_result()->fetch_assoc(); 
              $ticket = $stmt->fetch(); 
        ?>
    <section class="content">   
        <br>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="panel panel-danger col-md-3">
                <div class="panel-heading">
                    <h3 class="panel-title">REGISTRADO</h3>
                </div>
                <div class="panel-body">Contacto : <?= $ticket['nombrecontacto'] ?> </div>
            </div>
            <div class="col-md-2"></div>
            <div class="panel panel-danger col-md-3">
                <div class="panel-heading">
                    <h3 class="panel-title">ASIGNADO</h3>
                </div>
                <div class="panel-body">
                 Asignado a:  <?php  
                 if($_GET['tipo'] == 'asignado'){                
                    echo $ticket['nombre'].' '.$ticket['apellidos'].' El : '.$ticket['fechahora'];
                 }elseif($_GET['tipo'] == 'incidencia' || $_GET['tipo'] == 'finalizado'  ){
                    echo $ticket['nameusuario'].' '.$ticket['apellidos'].' El : '.$ticket['fechaasignado'];
                 }
                 
                 ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="panel panel-danger col-md-3">
                <div class="panel-heading">
                    <h3 class="panel-title">SISTEMA</h3>
                </div>
                <div class="panel-body">
                    <?php 
                    if($_GET['tipo'] == 'incidencia'){
                        echo $ticket['motivo'];
                     }else{
                         echo "Sin actividad";
                     }
                    ?>
                    
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="panel panel-success col-md-3">
                <div class="panel-heading">
                    <h3 class="panel-title">ATENDIDO</h3>
                </div>
                <div class="panel-body">
                    Atendido el dia: <?php if($_GET['tipo'] == "incidencia" ){
                        echo $ticket['fechacancelado'];
                    } elseif($_GET['tipo'] == "finalizado"){
                        echo $ticket['fechafinalizado'];
                    }
                    ?>
                 </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="box box-success">
                    <!-- form start -->
                    <form role="form" class="form-horizontal" action="action/addticket.php" method="POST"
                        enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Problema:
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control col-md-7 col-xs-12" value="<?= $ticket['nameproblema'] ?>"
                                        readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre de contacto:
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control col-md-7 col-xs-12" value="<?= $ticket['nombrecontacto'] ?>"
                                        readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Telefono del contacto:
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control col-md-7 col-xs-12" value="<?= $ticket['telefono'] ?>"
                                        readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">SN del contacto:
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control col-md-7 col-xs-12" value="<?= $ticket['sn'] ?>"
                                        readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Canal de Entrada:
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control col-md-7 col-xs-12" value="Ticket"
                                        readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Version y Modulo:
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control col-md-7 col-xs-12" value="2.0" readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Descripción:
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control col-md-7 col-xs-12"
                                        readonly=""><?= $ticket['descripcion'] ?></textarea>
                                </div>
                            </div>
                            <h2>ASIGNACIÓN DEL REQUEMIENTOS</h2>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo del Requerimiento
                                    Reportado:
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php 
                                    if($_GET['tipo'] == "asignado" || $_GET['tipo'] == "incidencia" || $_GET['tipo'] == "finalizado" ){
                                        echo '<input type="text" class="form-control col-md-7 col-xs-12" value="'.$ticket['namerequerimiento'].'" readonly="">';    
                                    } else{
                                        echo '<input type="text" class="form-control col-md-7 col-xs-12" value="" readonly="">';
                                    }
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Analista Designado:
                                    
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php if($_GET['tipo'] == "registrado"){
                                        echo '<input type="text" class="form-control col-md-7 col-xs-12" value="Sin asignar" readonly="">';
                                    }elseif($_GET['tipo'] == "asignado" ){                                                                         
                                        echo '<input type="text" class="form-control col-md-7 col-xs-12" value="'.$ticket['nombre'].' '.$ticket['apellidos'].'" readonly="">';
                                    }elseif ($_GET['tipo'] == "incidencia" || $_GET['tipo'] == "finalizado" ) {
                                        echo '<input type="text" class="form-control col-md-7 col-xs-12" value="'.$ticket['nameusuario'].' '.$ticket['apellidos'].'" readonly="">';
                                        
                                    }
                                        ?>
                                    
                                </div>
                            </div>
                            <h2>ATENCIÓN BRINDADA</h2>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo de Atención:
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control col-md-7 col-xs-12" value="SOPORTE"
                                        readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Detalle de la Atención
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">                                    
                                        <?php 
                                        if ($_GET['tipo'] == "finalizado" ) {
                                            echo '<textarea class="alert alert-warning form-control col-md-7 col-xs-12"   readonly="" >'.$ticket['descripcionfin'].'</textarea>';
                                        } else{
                                            echo '<textarea class="form-control col-md-7 col-xs-12" readonly="">';
                                            echo "Sin detalles";
                                            echo '</textarea>';
                                        }
                                         ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Descargar Adjunto:
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php                                     
                                    if($ticket['archivo'] != "vacio"){  

                                        if($_GET['tipo'] == "registrado"){                                                                          
                                        echo '<a target="_blank" class="form-control col-md-7 col-xs-12" href="archivodescarga.php?id='.$ticket['idticket'].'"><i class="fa fa-download"></i>'.$ticket['archivo'].'</a>';    

                                        }elseif($_GET['tipo'] == "asignado" || $_GET['tipo'] == "incidencia" || $_GET['tipo'] == "finalizado"){
                                            echo '<a target="_blank" class="form-control col-md-7 col-xs-12" href="archivodescarga.php?id='.$ticket['ticketid'].'"><i class="fa fa-download"></i>'.$ticket['archivo'].'</a>';    
                                        } 
                                    
                                }else{
                                    echo '<input type="text" class="form-control col-md-7 col-xs-12" value="Sin Archivo Adjunto" readonly="">';
                                }
                                    ?>
                                     
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
            <!--/.col -->
        </div> <!-- /.row -->
        <?php 
        if($_SESSION['namerol'] == 'Tecnico'){ 
             if($_GET['tipo'] != "finalizado" ){            
             ?>
            <div style="text-align: center;">
                <a class="btn btn-success" href="atender-ticket.php?id=<?php echo $ticket['idasignacion'].'&idticket='.$ticket['ticketid']; ?>"><i class="fa fa-check"></i> Finalizar Ticket</a>
                <?php if($_GET['tipo'] != "incidencia" ){ ?>
                <a class="btn btn-danger"href="incidencias.php?id=<?php echo $ticket['idasignacion'].'&idticket='.$ticket['ticketid']; ?>"><i class="fa fa-ban"></i> Agregar Incidencía</a>
                <?php } ?>
            </div>
        <?php } }; ?>
    </section>
</div><!-- /.content-wrapper -->
<?php
include_once 'templates/footer.php'; //incluimos el footer  en esta parte xq aqui estava el footer
?>