<?php
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,0);
$IDS=array();
require_once('../models/productos_model.php');


if(isset($_POST['multiple'])){
	get_ids($_POST,$IDS);
	if($_POST['multiple']==0){
		$formulario=formulario_multiples_productos($IDS);
		}
	else if($_POST['multiple']==1){
		//multiple=1, hacer la edicion
		editar_seleccion($conexion,$IDS);
		header('Location: productos.php');
		exit;
		}
	else{
		echo $_POST['multiple']."<br>";
		borrar_seleccion($conexion,$IDS);
		header('Location: productos.php');
		exit;
		//multiples=2 borrar
		}
	}
else{
	if(isset($_POST['opcion'])){ $id=$_POST['opcion'];}
	else if(isset($_POST['id'])){$id=$_POST['id'];}
	$formulario=formulario_editar_producto($conexion,$id);
	//formulario sencillo
	}

if(isset($_POST['borrar'])){
	borrar_seleccion($conexion,$_POST['borrar']);
	header('Location: productos.php');
    exit;
	}

else if(isset($_POST['id'])){
	editar_producto($conexion,$_POST['descripcion'],$_POST['precio'],$_POST['categoria'],$_POST['id']);
	header('Location: productos.php');
    exit;
	}

require_once('../views/editarproducto_view.php');
$conexion->desconectar();
?>
