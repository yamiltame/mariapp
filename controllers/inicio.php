<?php
session_start();
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
$conexion->checklogged($_SESSION,4);
$conexion->desconectar();
$saludo="<h3>Bienvenid@ ".$_SESSION['nombre']."</h3>";
if($_SESSION['permiso']==0){ $menu="eres admin <br><a href='usuarios.php'>Usuarios</a><br><a href='productos.php'>Productos</a><br><a href='logout.php'>cerrar sesión</a>";}
else{ $menu="No eres admin<br><a href='catalogo.php'>ver catalogo</a><br><a href='edit-profile.php'>Editar perfil</a><br><a href='logout.php'>cerrar sesión</a>";}
require_once('../views/inicio.php');
?>
