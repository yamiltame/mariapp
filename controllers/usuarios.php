<?php
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,0);
require_once('../models/usuarios_model.php');
$tabla_admins=tabla_usuarios($conexion,"where permiso=0");
$tabla_compradores=tabla_usuarios($conexion,"where permiso=1");
$tabla_solicitantes=tabla_usuarios($conexion,"where permiso=2");
require_once('../views/usuarios_view.php');
$conexion->desconectar();
?>

