<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Registro</title>
	</head>
	<body>
		<h1>Registro de usuarios al sistema</h1>
		<?php
			if(isset($mensaje)){
				switch($mensaje){
					case 0:
						if(isset($_SESSION['loggedin']) && $_SESSION['permiso']==0){
							header('Location: usuarios.php');
							exit;
							break;
							}
						else{
							echo "<h3>Registro exitoso!</h3><br>";
							break;
							}
					case 1:
						echo "<h3>Usuario registrado!</h3><br> $formulario";
						break;
					case 2:
						echo "<h3>Error al confirmar contraseña!</h3><br> $formulario";
						break;
					case 3:
						echo "<h3>Password inválido!</h3><br> $formulario";
						break;
					}
				}
			else{ echo $formulario; }
			if(isset($_SESSION['permiso']) && $_SESSION['permiso']==0){echo "<a href=\"usuarios.php\">Ir a pagina de usuarios</a><br>";}
			if(isset($_SESSION['loggedin'])){
    			echo "<a href='../views/inicio.php'> Inicio </a><br>";
    			echo "<a href=\"logout.php\">cerrar sesión</a>";
    			}
			else{ echo "<a href='../index.html'>Iniciar sesión</a>"; }
		?>
	</body>
</html>
