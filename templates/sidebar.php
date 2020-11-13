<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel  h-100 ">
        <div class="pull-left image">
          <!-- <img src="dist/img/logo.png" class="img-circle " alt="User Image" style=""> -->
          <img src="dist/img/perfil-mike.jpg" class="img-circle" alt="User Image">
        </div>
        
        <div class=" info ">
          <p class=""> <?= $_SESSION['nombre'].' '.$_SESSION['apellido']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> 

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

        <li class="header text-success">Menu de administracion</li>
        <li class="">
              <a href="index.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
        </li>
        <?php if($_SESSION['namerol'] == "Tecnico") { ?>   
       <li class="">
          <a href="mistickets.php"> <i class="fas fa-ticket-alt"></i> Mis Tickets</a>    
        </li> 
        <?php } ?>
<!-- --------------------------------------------------------------------------------- -->
<?php if($_SESSION['namerol'] == "Administrador") { ?> 
       <li class="treeview">
          <a href="#">
              <i class="fas fa-ticket-alt"> </i> <span>&nbsp; Tickets</span>
              <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
             </span>
             <!-- <i class="fas fa-ticket-alt"></i><span>Tickets</span>           -->
          </a>
          <ul class="treeview-menu">
            <li><a href="nuevo-ticket.php"><i class="fa fa-list-ul"></i>Crear ticket</a></li>
            <li><a href="ticket-registrados.php"><i class="fa fa-list-ul"></i>Tickets registrados</a></li>
            <li><a href="asignados.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tickets asignados</a></li>
            <li><a href="cancelados.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tickets con incidencias</a></li>
            <li><a href="atendidos.php"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tickets atendidos</a></li>
          </ul>
        </li>

        <li class="">
               <a href="areas.php"><i class="fa fa-th-list"></i><span>Areas</span></a>
        </li>

        <li class="">
          <a href="requerimientos.php">
            <i class="fa fa-address-card"></i>
            <span>Tipos de Requerimientos</span>                 
          </a>      
        </li>
        
       <li class="">
          <a href="problemas.php"><i class="fas fa-exclamation-triangle"></i><span>Problemas</span></a>    
        </li> 
        
       <li class="">
          <a href="reportes.php"><i class="fa fa-book"></i> <span>Reportes</span></a>    
        </li> 
        <li class="">
            <a href="clientes.php"><i class="fa fa-child"></i><span>Clientes</span></a>
        </li>
        <li class="">
              <a href="usuarios.php"><i class="fa fa-user"></i> <span>Usuarios</span></a>
        </li>
        <li class="">
              <a href="configuracion.php"><i class="fas fa-wrench"></i> <span>Configuracion</span></a>
        </li>
    
        <?php }  ?> 
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

