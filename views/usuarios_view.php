<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title> Usuarios </title>
	</head>
	<body>
		<h1>Usuarios</h1>
		<table>
			<tr>
				<th>Administradores</th>
				<th>Compradores</th>
				<th>Solicitantes</th>
			</tr>
			<tr>
				<td><?php echo $tabla_admins; ?></td>
				<td><?php echo $tabla_compradores; ?></td>
				<td><?php echo $tabla_solicitantes; ?></td>
			</tr>
		</table>
		<a href='../views/inicio.php'>Inicio</a> <br>
		<a href='../controllers/registrousuarios.php'>Registrar nuevo usuario</a> <br>
		<a href='../controllers/logout.php'>Cerrar sesión</a> <br>
	</body>
</html>
