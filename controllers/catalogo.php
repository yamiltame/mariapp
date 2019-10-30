<?php
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,2);
$cantidadmostrar=3;
$compag=(!isset($_GET['pag'])) ? 1: $_GET['pag'];
$orden=(isset($_GET['orden'])) ? $_GET['orden']: "";
$last=(isset($_GET['last'])) ? $_GET['last']: 0;
$buscar= (isset($_POST['buscar'])) ? $_POST['buscar']: ((isset($_GET['buscar'])) ? $_GET['buscar']: "");
require_once('../models/productos_model.php');
$usertype=$_SESSION['permiso'];
$cond="";
$cond="where (descripcion like '%$buscar%' or categoria like '%$buscar%')";
$cond.= ($orden!="") ? (($last==0) ? " order by $orden asc " : " order by $orden desc ") : " order by id desc ";
$tabla=tabla_productos($conexion,$cond." limit ".(($compag-1)*$cantidadmostrar).",".$cantidadmostrar,$orden,$last,$usertype,$compag,$buscar);
$empaginamiento=empaginamiento_productos($conexion,"select id from Productos ".$cond,$compag,$cantidadmostrar,array("buscar" => $buscar,"last" => $last, "orden" => $orden));
$busqueda= ($buscar!="") ? "<div><i>Resultados para '".$buscar."'</i></div>" : "";
require_once('../views/catalogo_view.php');
$conexion->desconectar();
?>

