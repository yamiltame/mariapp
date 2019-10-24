<?php
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,0);
require_once('../models/usuarios_model.php');
$tabla_usuarios=tabla_usuarios($conexion);
require_once('../views/usuarios_view.php');
$conexion->desconectar();
?>

