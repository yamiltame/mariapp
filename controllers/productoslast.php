<?php
require_once('../db/conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,0);
require_once('../models/productos_model.php');
$tabla_productos=tabla_productos($conexion);
require_once('../views/productos_view.php');
$conexion->desconectar();
?>
