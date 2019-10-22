<?php
require_once('conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['permiso']==0){
$formulario=<<<EOT
		<form action="registrousuarios.php" method='post'>
        	Nombre:<br>
        	<input type="text" name="nombre" required><br>
        	Email:<br>
        	<input type="text" name="email" required><br>
			Password:<br>
        	<input type="password" name="pas" required><br>
			Confirmar Password:<br>
        	<input type="password" name="cpas" required><br>
			Permiso:<br>
			<select name='permiso'>
				<option value=0>Administrador</option>
				<option value=1>Ver y comprar</option>
				<option value=2>Sólo ver</option>
			</select>
			<input type="submit" value="registrar"><br>
		</form>
EOT;
	}
else{
$formulario=<<<EOT
	<form action="registrousuarios.php" method='post'>
        	Nombre:<br>
        	<input type="text" name="nombre" required><br>
        	Email:<br>
        	<input type="text" name="email" required><br>
			Password:<br>
        	<input type="password" name="pas" required><br>
			Confirmar Password:<br>
        	<input type="password" name="cpas" required><br>
			<input type="submit" value="registrar"><br>
		</form>
EOT;
}

if(isset($_POST['email'])){
	$user=$conexion->query_count("Usuarios","where email='".$_POST['email']."'");
	if($_POST['pas']!=""){
		if($_POST['pas']==$_POST['cpas']){
			if($user==0){
				$passhash=password_hash($_POST['pas'], PASSWORD_DEFAULT);
				if(isset($_POST['permiso'])){
					$registro="insert into Usuarios values(null,'".$_POST['nombre']."','".$_POST['email']."','$passhash',".$_POST['permiso'].")";
					}
				else{
					$registro="insert into Usuarios values(null,'".$_POST['nombre']."','".$_POST['email']."','$passhash',default)";
					}
				$conexion->query($registro);
				echo "Registro exitoso<br>";
			}
			else{
				echo "<h3>usuario registrado</h3>";
				echo $formulario;
			}
		}
		else{
			echo "<h3>Error al confirmar password</h3>";
			echo $formulario;
		}
	}
	else{
		echo "<h3>Password invalido</h3>";
		echo $formulario;
	}
}

else{
	echo "<h3>Registro de Usuarios al sistema</h3>";
	echo $formulario;
}

if(isset($_SESSION['permiso']) && $_SESSION['permiso']==0){echo "<a href=\"usuarios.php\">Ir a pagina de usuarios</a><br>";}
if(isset($_SESSION['loggedin'])){
	echo "<a href='inicio.php'> Inicio </a><br>";
	echo "<a href=\"logout.php\">cerrar sesión</a>";
	}
?>
