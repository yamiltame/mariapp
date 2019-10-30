<?php
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,0);
$cantidadmostrar=5;
$compag=(!isset($_GET['pag'])) ? 1: $_GET['pag'];
$orden=(isset($_GET['orden'])) ? $_GET['orden']: "";
$last=(isset($_GET['last'])) ? $_GET['last']: 0;
require_once('../models/usuarios_model.php');
$cond="";
$usertype=(isset($_POST['usertype'])) ? $_POST['usertype']: ((isset($_GET['usertype'])) ? $_GET['usertype'] : 3);
$buscar= (isset($_POST['buscar'])) ? $_POST['buscar']: ((isset($_GET['buscar'])) ? $_GET['buscar']: "");
$cond="where (nombre like '%$buscar%' or email like '%$buscar%')";
$cond.= ($usertype==3) ? "": " and permiso=$usertype";
$cond.= ($orden!="") ? (($last==0) ? " order by $orden asc " : " order by $orden desc ") : " order by id desc ";
$tabla=tabla_usuarios($conexion,$cond."limit ".(($compag-1)*$cantidadmostrar).",".$cantidadmostrar,$orden,$last,$usertype,$compag,$buscar);
switch($usertype){
	case 0: $users="Administradores"; break;
	case 1: $users="Compradores"; break;
	case 2: $users="Solicitantes"; break;
	default: $users="Usuarios"; break;
	}
$empaginamiento=empaginamiento_usuarios($conexion,"select id from Usuarios ".$cond,$compag,$cantidadmostrar,array("usertype"=>$usertype,"orden"=>$orden,"last"=>$last,"buscar"=>$buscar));
$busqueda= ($buscar!="") ? "<div><i>Resultados para '".$buscar."'</i></div>" : "";
require_once('../views/usuarios_view.php');
$conexion->desconectar();
?>

