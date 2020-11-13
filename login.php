<?php   
// iniciamos la sesion
session_start();
$cerrar_sesion = (isset($_GET['cerrar_sesion'])) ? $_GET['cerrar_sesion'] : '';
if($cerrar_sesion){
  session_destroy();
}
    include_once 'templates/header.php';
?>
<body class="hold-transition login-page">
  
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Soporte</b>Ticket</a>
  </div>

  <!-- /.login-logo -->
  <div class="login-box-body">
  <div id="result"></div>  
    <p class="login-box-msg">Inicia una nueva sesion</p>
    <form  method="post" id="login">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="usuario">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <div class="error-usuario"></div>   
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <div class="error-usuario"></div>   
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
            <input type="hidden" name="logear" value="1">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar sesion</button>
        </div>
        <div class="col-xs-12">        
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->

</div>
<!-- /.login-box -->

<?php include_once 'templates/footer.php'; ?>
