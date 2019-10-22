<?php
require_once('conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,0);


if(isset($_POST['opcion'])){ $id=$_POST['opcion'];}
else{$id=$_POST['id'];}

if(isset($_POST['borrar'])){
	$sql="delete from Usuarios where id=".$_POST['borrar'];
	$conexion->query($sql);
	header('Location: usuarios.php');
    exit;
	}

else if(isset($_POST['id'])){
	$sql="update Usuarios set nombre='".$_POST['nombre']."', email='".$_POST['email']."', permiso=".$_POST['permiso']." where id=".$_POST['id'];
	$conexion->query($sql);
	header('Location: usuarios.php');
    exit;
	}
 
$sql="select * from Usuarios where id=".$id;
$result=$conexion->query($sql);
$row=mysqli_fetch_array($result);
$formulario="Editar usuario <br><form action='editarusuario.php' method='post'>
	<input type='hidden' name='id' value=".$id.">
	Nombre:<br>
	<input type='text' name='nombre' value=".$row['nombre']."><br>
	Email:<br><input type='text' name='email' value=".$row['email']."><br>
	Permiso:<br><select name='permiso'>";
if($row['permiso']==0){
	$formulario.="<option value=0 selected>Administrador</option>
		<option value=1>Ver y comprar</option>
		<option value=2>sólo ver</option></select>
		<input type='submit' value='editar'></form>";
	}
if($row['permiso']==1){
	$formulario.="<option value=0>Administrador</option>
		<option value=1 selected>Ver y comprar</option>
		<option value=2>sólo ver</option></select>
		<input type='submit' value='editar'></form>";
	}
if($row['permiso']==2){
	$formulario.="<option value=0>Administrador</option>
		<option value=1>Ver y comprar</option>
		<option value=2 selected>sólo ver</option></select>
		<input type='submit' value='editar'></form>";
	}

echo $formulario;
echo "<form action='editarusuario.php' method=post><input type=hidden name=borrar value=".$row['id']."><input type='submit' value='borrar'></form>";
echo "<a href=\"inicio.php\">Inicio</a> <br>";
echo "<a href=\"usuarios.php\">usuarios</a> <br>";
