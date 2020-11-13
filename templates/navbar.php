<body class="hold-transition skin-green-light sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>E</b>TK</span>
      <!-- logo for regular state and mobile devices -->
      <?php 
        include_once 'funciones/bd-conexion.php';       
        $stmt = $conn->prepare('SELECT * FROM config '); 
        $stmt->execute();                                                                            
        $config = $stmt->fetch();               
      ?>
      <span class="logo-lg"><?= $config['nombresitio'];  ?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">         
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
              <img src="dist/img/perfil-mike.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">Usuario: <strong> <?= $_SESSION['usuario']; ?></strong></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/perfil-mike.jpg" class="img-circle" alt="User Image">
                <p class=""> <?= $_SESSION['nombre'].' '.$_SESSION['apellido']; ?></p>               
              </li>
           
              <!-- Menu Footer-->
              <li class="user-footer">
              <div class="pull-left">
                  <a href="editar-usuario.php?id=<?php echo $_SESSION['idusuario']; ?>" class="btn btn-default btn-flat">ajustes</a>
                </div>
                <div class="pull-right">
                  <a href="login.php?cerrar_sesion=true" class="btn btn-default btn-flat">Cerrar sesion</a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>