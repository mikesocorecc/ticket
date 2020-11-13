<?php 
include_once 'funciones/bd-conexion.php';
require 'dist/lib/vendor/autoload.php';
use Dompdf\Dompdf;

$daterange = $_GET['daterange']; 
$fechas = explode("|", $daterange);
$fecha_inicio = $fechas[0]." "."00:00:00";
$fecha_fin = $fechas[1]." "."23:59:59";

if($_GET['categoria'] != 0){
    $categoria = $_GET['categoria']; 
  //$sql = "SELECT tickets .*, clientes.empresa, problemas.nombre as nameproblema FROM tickets JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN problemas ON tickets.problemaid = problemas.idproblema WHERE tickets.fecharegistro BETWEEN '$fecha_inicio' AND '$fecha_fin' AND estado = '$categoria'  ";
  $stmt = $conn->prepare("SELECT tickets .*, clientes.empresa, problemas.nombre as nameproblema FROM tickets JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN problemas ON tickets.problemaid = problemas.idproblema WHERE tickets.fecharegistro BETWEEN :fecha_inicio AND :fecha_fin AND estado = :categoria  ");                                         
  $stmt->bindValue(":fecha_inicio", $fecha_inicio, PDO::PARAM_STR);
  $stmt->bindValue(":fecha_fin", $fecha_fin, PDO::PARAM_STR);
  $stmt->bindValue(":categoria", $categoria, PDO::PARAM_INT);
}else{
  //$sql = "SELECT tickets .*, clientes.empresa, problemas.nombre as nameproblema FROM tickets JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN problemas ON tickets.problemaid = problemas.idproblema WHERE tickets.fecharegistro BETWEEN '$fecha_inicio' AND '$fecha_fin'  ";
  $stmt = $conn->prepare("SELECT tickets .*, clientes.empresa, problemas.nombre as nameproblema FROM tickets JOIN clientes ON tickets.clienteid = clientes.idcliente JOIN problemas ON tickets.problemaid = problemas.idproblema WHERE tickets.fecharegistro BETWEEN :fecha_inicio AND :fecha_fin ");                                         
  $stmt->bindValue(":fecha_inicio", $fecha_inicio, PDO::PARAM_STR);
  $stmt->bindValue(":fecha_fin", $fecha_fin, PDO::PARAM_STR);
} 
// $resultado = $stmt->query($sql);  
 $stmt->execute();  
ob_start();
require "reportepdf.php";
$html = ob_get_clean();
$pdf = new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper("A4", "landingpage");
$pdf->render();
$pdf->stream("document.pdf",array("Attachment"=>0));
?>
