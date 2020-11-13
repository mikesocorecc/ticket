
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reporte pdf</title>
  <style>            
        table{
        width: 100%;
        border-collapse: collapse;
        }
        th, td{
          padding: 1px;
          border: 1px solid #000;
        }

        th:nth-child(1){
        background-color:#04B486;
        color: white;
          text-align:center;
        }
        tr:nth-child(1){
          background-color:#0b795c;
          color: white;
          text-align:left;
          
        }
        .population{
          background-color:#0b795c;
          color: white;
          text-align:center;
        }
        tr:nth-child(2), tr:nth-child(4), tr:nth-child(6), tr:nth-child(8){
        background-color: #FAFAFA;
        }
        tr:nth-child(3), tr:nth-child(5), tr:nth-child(7), tr:nth-child(9){
        background-color: #E6E6E6;
        }
        .fecha{
          margin-left: 500px;
        }
  </style>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
<div class="empresa">
  <h1 style="color: #0c6379;" >EASYTICKET</h1>
</div>
<div class="tickets" style="margin-left: 250px;">
<h2>Reporte de Tickets</h2>
</div>
<h3 class="fecha">Fecha: <?php echo date("d-m-y"); ?> </h3>
  <table>
    <tr>
             <th>FECHA</th>
            <th>CODIGO</th>
            <th>EMPRESA</th>
            <th >NOMBRE</th>
            <th>ESTADO</th>
            <th>PROBLEMA</th>
    </tr>
  
        <?php  while ($ticket = $stmt->fetch()) { ?>
            <tr>
            <td scope="row"><?= $ticket['fecharegistro'] ?></td>
            <td><?= $ticket['idticket'] ?></td>
            <td><?= $ticket['empresa'] ?></td>
            <td ><?= $ticket['nombrecontacto'] ?></td>
            <td><?php 
            switch ($ticket['estado']) {
              case 1:                
                echo "Registrado";
                break;                        
              case 2:             
                echo "Asignado";   
                break;                        
              case 3:             
                echo "Incidencia";   
                break;                        
              case 4:  
                echo "Finalizado";              
                break;                        
            }
             ?></td>
            <td><?= $ticket['nameproblema'] ?></td>
            </tr>
            <?php } ?>    
  </table>
  
</body>
</html>


