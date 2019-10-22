<?php
require_once('conexion.php');
$conexion = new mySQL();
$conexion->conectar();
if(isset($_POST['opcion'])){
	$sql="update Usuarios set permiso=1 where id=".$_POST['opcion'];
	$conexion->query($sql);
	header('Location: usuarios.php');
    exit;
	}
?> 
