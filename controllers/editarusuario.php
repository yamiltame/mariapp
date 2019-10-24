<?php
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,0);
require_once('../models/usuarios_model.php');

if(isset($_POST['opcion'])){ $id=$_POST['opcion'];}

if(isset($_POST['borrar'])){
	$sql="delete from Usuarios where id=".$_POST['borrar'];
	$conexion->query($sql);
	header('Location: ../controllers/usuarios.php');
    exit;
	}

else if(isset($_POST['id'])){
	$sql="update Usuarios set nombre='".$_POST['nombre']."', email='".$_POST['email']."', permiso=".$_POST['permiso']." where id=".$_POST['id'];
	$conexion->query($sql);
	header('Location: ../controllers/usuarios.php');
    exit;
	}

else{
	$formulario=formulario_editar_usuario($conexion,$id);
	require_once('../views/editarusuario_view.php');
	}
?>
