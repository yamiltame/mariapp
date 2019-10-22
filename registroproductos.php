<?php
require_once('conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();
$conexion->checklogged($_SESSION,0);

$formulario=<<<EOT
		<form action="registroproductos.php" method='post'>
        	Descripcion:<br>
        	<input type="text" name="descripcion" required><br>
        	Precio:<br>
        	<input type="number" step='0.01' name="precio" required><br>
			Categoria:<br>
        	<input type="text" name="categoria" required><br>
			<input type="submit" value="registrar"><br>
		</form>
EOT;

if(isset($_POST['descripcion'])){
	$producto=$conexion->query_count("Productos","where descripcion='".$_POST['descripcion']."'");
	if($producto==0){
		$registro="insert into Productos values(null,'".$_POST['descripcion']."',".$_POST['precio'].",'".$_POST['categoria']."')";
		$conexion->query($registro);
	    header('Location: productos.php');
	    exit;
		}
	else{
		echo "<h3>¡Producto registrado!</h3>";
		echo $formulario;
		}
	}
else{
	echo "<h3>Registro de Productos al sistema</h3>";
	echo $formulario;
}

if(isset($_SESSION['permiso']) && $_SESSION['permiso']==0){echo "<a href=\"productos.php\">Ir a pagina de productos</a><br>";}
if(isset($_SESSION['loggedin'])){
	echo "<a href='inicio.php'> Inicio </a><br>";
	echo "<a href=\"logout.php\">cerrar sesión</a>";
	}
?>
