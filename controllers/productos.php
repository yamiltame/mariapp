<?php
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,0);
$cantidadmostrar=3;
$compag=(!isset($_GET['pag'])) ? 1: $_GET['pag'];
require_once('../models/productos_model.php');
$cond="";
$buscar= (isset($_POST['buscar'])) ? $_POST['buscar']: ((isset($_GET['buscar'])) ? $_GET['buscar']: "");
$cond="where (descripcion like '%$buscar%' or categoria like '%$buscar%')";
$tabla=tabla_productos($conexion,$cond." order by id desc limit ".(($compag-1)*$cantidadmostrar).",".$cantidadmostrar);

$registros=$conexion->query("select * from Productos ".$cond);
$paginas=ceil($registros->num_rows/$cantidadmostrar);
$increment=(($compag +1) <= $paginas) ? ($compag +1): $paginas;
$decrement=(($compag -1) < 1) ? 1: ($compag-1);
$desde=$compag - 4;
$hasta=$compag +5;
$desde=($desde<1)? 1 : $desde;
$hasta=($hasta>$paginas)? $paginas : $hasta;
if($buscar==""){
	$empaginamiento="<ul><a href='productos.php?pag=$decrement'>atrás</a>";
	for($i=$desde;$i<=$hasta;$i++){
		if($i==$compag){ $empaginamiento.="<a href='?pag=$i'><b>($i)</b></a>";}
		else{ $empaginamiento.="<a href='?pag=$i'>($i)</a>";}
    	}
	$empaginamiento.="<a href='?pag=$increment'>Siguiente</a></ul>";
	}
else{
	$empaginamiento="<ul><a href='productos.php?pag=$decrement&buscar=$buscar'>atrás</a>";
	for($i=$desde;$i<=$hasta;$i++){
		if($i==$compag){ $empaginamiento.="<a href='?pag=$i&buscar=$buscar'><b>($i)</b></a>";}
		else{ $empaginamiento.="<a href='?pag=$i&usertype=$usertype&buscar=$buscar'>($i)</a>";}
    	}
	$empaginamiento.="<a href='?pag=$increment&buscar=$buscar'>Siguiente</a></ul>";
	}
require_once('../views/productos_view.php');
$conexion->desconectar();
?>

