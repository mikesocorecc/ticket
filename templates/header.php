
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php 
        include_once 'funciones/bd-conexion.php'; 
        $stmt = $conn->prepare('SELECT * FROM config ');        
        $stmt->execute();                                                                            
        $config = $stmt->fetch();
  ?>
  <link rel="icon" type="image/png" href="dist/img/favicon/<?= $config['favicon'];  ?>" />
  <title><?=  $config['nombresitio'] ?> | Administración</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <!-- Daterangerpicker -->
  <link rel="stylesheet" href="dist/css/daterangepicker.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" integrity="sha512-gp+RQIipEa1X7Sq1vYXnuOW96C4704yI1n0YB9T/KqdvqaEgL6nAuTSrKufUX3VBONq/TPuKiXGLVgBKicZ0KA==" crossorigin="anonymous" /> -->
  <!-- DataTables -->
  <link rel="stylesheet" href="dist/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="dist/css/responsive.bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="dist/css/sweetalert2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/skins/_all-skins.min.css" integrity="sha512-D231SkmJ+61oWzyBS0Htmce/w1NLwUVtMSA05ceaprOG4ZAszxnScjexIQwdAr4bZ4NRNdSHH1qXwu1GwEVnvA==" crossorigin="anonymous" />
  <!-- <link rel="stylesheet" href="dist/css/_all-skins.min.css"> -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- miestilo -->
  <link rel="stylesheet" href="dist/css/admin.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>