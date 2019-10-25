<?php
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,0);
require_once('../models/productos_model.php');
$formulario=formulario_registro_producto();
if(isset($_POST['descripcion'])){
	$mensaje=registrar_producto($conexion,$_POST['descripcion'],$_POST['precio'],$_POST['categoria']);
	}
require_once('../views/registroproductos_view.php');

?>
