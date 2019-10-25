<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Registro</title>
	</head>
	<body>
		<h1>Registro de productos al sistema</h1>
		<?php
			if(isset($mensaje)){
				switch($mensaje){
					case 0:
						header('Location: productos.php');
						exit;
						break;
					case 1:
						echo "<h3>Producto registrado!</h3>$formulario";
						break;
					}
				}
			else{ echo $formulario;}
			if(isset($_SESSION['permiso']) && $_SESSION['permiso']==0){echo "<a href=\"productos.php\">Productos</a><br>";}
			if(isset($_SESSION['loggedin'])){
    			echo "<a href='inicio.php'> Inicio </a><br>";
    			echo "<a href=\"logout.php\">cerrar sesión</a>";
    			}
		?>
	</body>
</html>
