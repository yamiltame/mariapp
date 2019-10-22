<?php
require_once('conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();

$conexion->checklogged($_SESSION,4);
echo "<h3>Bienvenid@ ".$_SESSION['nombre']."</h3>";

if($_SESSION['permiso']==0){
	echo "eres admin <br>";
	echo "<a href='usuarios.php'>Usuarios</a><br>";
	echo "<a href='productos.php'>Productos</a><br>";
	echo "<a href='logout.php'>cerrar sesión</a>";
	}

else{
	echo "No eres admin<br>";
	echo "<a href='catalogo.php'>ver catalogo</a><br>";
	echo "<a href='edit-profile.php'>Editar perfil</a><br>";
	echo "<a href='logout.php'>cerrar sesión</a>";
	}
?>

