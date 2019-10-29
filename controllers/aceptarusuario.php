<?php
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
$location="usuarios.php?";
$location.= (isset($_GET['last'])) ? "last=".$_GET['last']."&" : "";
$location.= (isset($_GET['orden'])) ? "orden=".$_GET['orden']."&" : "";
$location.= (isset($_GET['usertype'])) ? "usertype=".$_GET['usertype']."&" : "";
$location.= (isset($_GET['pag'])) ? "pag=".$_GET['pag']."&" : "";
if(isset($_POST['opcion'])){
	$sql="update Usuarios set permiso=1 where id=".$_POST['opcion'];
	$conexion->query($sql);
	$site="Location: ".$location;
	header($site);
    exit;
	}
$conexion->desconectar();
?> 
