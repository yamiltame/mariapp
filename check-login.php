<?php
require_once('conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
if(isset($_POST['email']) && isset($_POST['password'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	$result = $conexion->query("SELECT password,nombre,permiso FROM Usuarios WHERE email = '$email'");
	$row = mysqli_fetch_assoc($result);
	$hash = $row['password'];
	$type= $row['permiso'];
	if (password_verify($_POST['password'], $hash)){
		$_SESSION['loggedin'] = true;
		$_SESSION['nombre'] = $row['nombre'];
		$_SESSION['start'] = time();
		$_SESSION['expire'] = $_SESSION['start'] + (20 * 60);
		$_SESSION['permiso'] = $type;
		$_SESSION['email']=$email;
		header('Location: inicio.php');
		exit();
		}
	else{
		echo "<div class='alert alert-danger mt-4' role='alert'>Email o contraseña incorrectos!!
                <p><a href='login.html'><strong>iniciar sesión</strong></a></p></div>";
		}
	}
else{
	header('Location: inicio.php');
	exit();
	}
?>

