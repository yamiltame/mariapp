<?php
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,0);
require_once('../models/productos_model.php');
if(isset($_POST['descripcion'])){
	$formulario="";
	$mensaje=registrar_producto($conexion,$_POST['descripcion'],$_POST['precio'],$_POST['categoria']);
	switch($mensaje){
    	case 0:
			$conexion->desconectar();
        	header('Location: productos.php');
            exit;
            break;
        case 1:
            $texto="<div><h3>Producto registrado!</h3></div>";
			$formulario="<div>".formulario_registro_producto()."</div>";
            break;
        }
	}
else{
	$texto="";
	$formulario="<div>".formulario_registro_producto($conexion)."</div>";
	}

require_once('../views/registroproductos_view.php');
$conexion->desconectar();
?>
