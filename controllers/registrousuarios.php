<?php
session_start();
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
require_once('../models/usuarios_model.php');

if(isset($_SESSION['loggedin'])){
	$conexion->checklogged($_SESSION,3);
	$formulario=formulario_registro_usuario($_SESSION['permiso']);
	}
else{ $formulario=formulario_registro_usuario(3); }

if(isset($_POST['email']) && isset($_POST['nombre']) && isset($_POST['pas']) && isset($_POST['cpas'])){
	if(isset($_POST['permiso'])){ $permiso = $_POST['permiso'];}
	else{ $permiso=2;}
	$mensaje=registrar_usuario($conexion,$_POST['email'],$_POST['nombre'],$_POST['pas'],$_POST['cpas'],$permiso);
	}

require_once('../views/registrousuarios_view.php');
$conexion->desconectra();
?>
