<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title> Usuarios </title>
	</head>
	<body>
		<div><h3><?php echo $users; ?></h3></div>
		<div>
			<form action='usuarios.php' method='post'>
				<input type=text name='buscar' placeholder='buscar...'>
				<input type=hidden name='usertype' value=<?php echo $usertype?>>
				<input type=submit value='Buscar'>
			</form>
		</div>
		<div><table><tr>
			<td> <form action='usuarios.php' method='post'><input type=hidden name='usertype' value=0><input type=submit value='Administradores'></form></td>
			<td> <form action='usuarios.php' method='post'><input type=hidden name='usertype' value=1><input type=submit value='Compradores'></form></td>
			<td> <form action='usuarios.php' method='post'><input type=hidden name='usertype' value=2><input type=submit value='Solicitantes'></form></td>
			<td> <form action='usuarios.php' method='post'><input type=submit value='Todos'></form></td>
		</tr></table></div>
		<?php echo $busqueda; ?>
		<div><?php echo $tabla; ?></div>
		<div><?php echo $empaginamiento; ?></div>
		<a href='../views/inicio.php'>Inicio</a> <br>
		<a href='../controllers/registrousuarios.php'>Registrar nuevo usuario</a> <br>
		<a href='../controllers/logout.php'>Cerrar sesión</a> <br>
	</body>
</html>
