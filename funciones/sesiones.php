<?php 
function usuario_autenticado (){
    if(!revisar_usaurio()){
        header('Location:login.php');
        exit();
    }
}

function revisar_usaurio(){
    return isset($_SESSION['usuario']);
}
session_start();
usuario_autenticado();


?>