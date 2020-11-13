
    <?php 
    try {
        include_once 'funciones/seguridad.php';                                
        include_once 'funciones/bd-conexion.php';      
        $daterange = $_GET['daterange'];         
        $fechas = explode("|", $daterange);
        $fecha_inicio = filtrado($fechas[0]." "."00:00:00");
        $fecha_fin = filtrado($fechas[1]." "."23:59:59");
        if($_GET['category'] != 0){    
            $category = $_GET['category'];     
            //$sql = " SELECT tickets .*, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea FROM tickets JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea WHERE fecharegistro BETWEEN '$fecha_inicio' AND '$fecha_fin'  AND estado = '$category' " ;                            
            $stmt = $conn->prepare("SELECT tickets .*, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea FROM tickets JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea WHERE fecharegistro BETWEEN :fecha_inicio AND :fecha_fin  AND estado = :category ");                                         
            $stmt->bindValue(":fecha_inicio", $fecha_inicio, PDO::PARAM_STR);
            $stmt->bindValue(":fecha_fin", $fecha_fin, PDO::PARAM_STR);
            $stmt->bindValue(":category", $category, PDO::PARAM_INT);  
        } else{           
          //  $sql = " SELECT tickets .*, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea FROM tickets JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea WHERE fecharegistro BETWEEN '$fecha_inicio' AND '$fecha_fin' " ;                            
            $stmt = $conn->prepare("SELECT tickets .*, problemas.nombre as nameproblema, clientes.empresa, areas.nombre as namearea FROM tickets JOIN problemas ON tickets.problemaid = problemas.idproblema JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN areas ON tickets.areaid = areas.idarea WHERE fecharegistro BETWEEN :fecha_inicio AND :fecha_fin ");                                         
            $stmt->bindValue(":fecha_inicio", $fecha_inicio, PDO::PARAM_STR);
            $stmt->bindValue(":fecha_fin", $fecha_fin, PDO::PARAM_STR);     
        }                               
        
    } catch (Exception $e) {
    // capturamos el error
    $error = $e->getMessage();
    echo $error;
    }           
    // $resultado = $conn->query($sql); 
     $stmt->execute(); 

    if($stmt->rowCount() == 0){ ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
         <strong>Aviso!</strong> No hay datos para mostrar en estas fechas
        </div>
    <?php } else{ ?>

<table id="registrados" class="table table-bordered table-striped">
    <thead class="table_header bg-success">
        <tr>
            <th class="column-title" >Fecha </th>
            <th class="column-title" >Codigo </th>
            <th class="column-title"  >Informacion contacto </th>
            <th class="column-title" >Empresa </th>
            <th class="column-title" >Estado </th>
        </tr>
    </thead>
    <tbody >
    <?php     
        while ($ticket = $stmt->fetch()) {   ?>
            <tr>
                <td>
                    <?php 
                        $fecha = $ticket['fecharegistro'];
                        $fechanueva = date('Y/m/d', strtotime($fecha));
                        echo $fechanueva;
                    ?>
                </td>
                <td><?php echo $ticket['idticket'] ?></td>
                <td><?php echo $ticket['nombrecontacto'] ?></td>
                <td><?php echo $ticket['empresa'] ?></td>
                <td>
                    <?php 
                        switch ($ticket['estado']) {
                            case 1: 
                                echo '<span class="label label-warning">Registrado</span>'                   ;
                                break;
                            case 2:      
                                echo '<span class="label label-primary">Asignado</span>';           
                                break;
                            case 3:                    
                                echo '<span class="label label-danger">Incidencia</span>';           
                                break;
                            case 4:   
                                echo '<span class="label label-success">Atendido</span>';                            
                                break;                            
                        }
                    ?>
                </td>  
            </tr>
        <?php } }?>
    </tbody>
</table>