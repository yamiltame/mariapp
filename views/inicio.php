<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Inicio</title>
	</head>
	<body>
			<?php
			session_start();
			require_once('../db/conexion.php');
			$conexion = new mySQL();
			$conexion->conectar();
			$conexion->checklogged($_SESSION,4);
			$conexion->desconectar();
			echo "<h3>Bienvenid@ ".$_SESSION['nombre']."</h3>";
			if($_SESSION['permiso']==0){
				echo "eres admin <br>";
				echo "<a href='../controllers/usuarios.php'>Usuarios</a><br>";
				echo "<a href='../controllers/productos.php'>Productos</a><br>";
				echo "<a href='../controllers/logout.php'>cerrar sesión</a>";
				}

			else{
				echo "No eres admin<br>";
				echo "<a href='../controllers/catalogo.php'>ver catalogo</a><br>";
				echo "<a href='../controllers/edit-profile.php'>Editar perfil</a><br>";
				echo "<a href='../controllers/logout.php'>cerrar sesión</a>";
				}
			?>
		</body>
</html>

