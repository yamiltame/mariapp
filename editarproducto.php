<?php
require_once('conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,0);


if(isset($_POST['opcion'])){ $id=$_POST['opcion'];}
else{$id=$_POST['id'];}

if(isset($_POST['borrar'])){
	$sql="delete from Productos where id=".$_POST['borrar'];
	$conexion->query($sql);
	header('Location: productos.php');
    exit;
	}

else if(isset($_POST['id'])){
	$sql="update Productos set descripcion='".$_POST['descripcion']."', precio='".$_POST['precio']."', categoria='".$_POST['categoria']."' where id=".$_POST['id'];
	echo $sql."<br>";
	$conexion->query($sql);
	header('Location: productos.php');
    exit;
	}

$sql="select * from Productos where id=".$id;
$result=$conexion->query($sql);
$row=mysqli_fetch_array($result);
$formulario="Editar producto <br><form action='editarproducto.php' method='post'>
	<input type='hidden' name='id' value=".$id.">
	Descripcion:<br>
	<input type='text' name='descripcion' value=".$row['descripcion']."><br>
	Precio:<br><input type='number' step='0.01' name='precio' value=".$row['precio']."><br>
	Categoría:<br>
	<input type='text' name='categoria' value=".$row['categoria']."><br>
	<input type='submit' value='editar'></form>";

echo $formulario;
echo "<form action='editarproducto.php' method=post><input type=hidden name=borrar value=".$row['id']."><input type='submit' value='borrar'></form>";
echo "<a href=\"index.php\">Inicio</a> <br>";
echo "<a href=\"productos.php\">usuarios</a> <br>";
