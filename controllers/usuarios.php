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
$tabla=tabla_usuarios($conexion,$cond."limit ".(($compag-1)*$cantidadmostrar).",".$cantidadmostrar,$orden,$last,$usertype,$compag);
switch($usertype){
	case 0: $users="Administradores"; break;
	case 1: $users="Compradores"; break;
	case 2: $users="Solicitantes"; break;
	default: $users="Usuarios"; break;
	}
$registros=$conexion->query("select * from Usuarios ".$cond);
$paginas=ceil($registros->num_rows/$cantidadmostrar);
$increment=(($compag +1) <= $paginas) ? ($compag +1): $paginas;
$decrement=(($compag -1) < 1) ? 1: ($compag-1);
$desde=$compag - 4;
$hasta=$compag +5;
$desde=($desde<1)? 1 : $desde;
$hasta=($hasta>$paginas)? $paginas : $hasta;
if($buscar==""){
	$empaginamiento="<ul><a href='usuarios.php?pag=$decrement&usertype=$usertype&orden=$orden&last=$last'>atrás</a>";
	for($i=$desde;$i<=$hasta;$i++){
		if($i==$compag){ $empaginamiento.="<a href='?pag=$i&usertype=$usertype&orden=$orden&last=$last'><b>($i)</b></a>";}
		else{ $empaginamiento.="<a href='?pag=$i&usertype=$usertype&orden=$orden'>($i)</a>";}
    	}
	$empaginamiento.="<a href='?pag=$increment&usertype=$usertype&orden=$orden&last=$last'>Siguiente</a></ul>";
	}
else{
	$empaginamiento="<ul><a href='usuarios.php?pag=$decrement&usertype=$usertype&buscar=$buscar&orden=$orden&last=$last'>atrás</a>";
	for($i=$desde;$i<=$hasta;$i++){
		if($i==$compag){ $empaginamiento.="<a href='?pag=$i&usertype=$usertype&buscar=$buscar&orden=$orden&last=$last'><b>($i)</b></a>";}
		else{ $empaginamiento.="<a href='?pag=$i&usertype=$usertype&buscar=$buscar&orden=$orden&last=$last'>($i)</a>";}
    	}
	$empaginamiento.="<a href='?pag=$increment&usertype=$usertype&buscar=$buscar&orden=$orden&last=$last'>Siguiente</a></ul>";
	}
require_once('../views/usuarios_view.php');
$conexion->desconectar();
?>

