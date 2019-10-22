<?php
require_once('conexion.php');
$conexion = new mySQL();
$conexion->conectar();
$formulario=<<<EOT
<form action="ingresousuarios.php" method='post'>
        Email:<br>
        <input type="text" name="email"><br>
	Password:<br>
	<input type="password" name="pass"><br>
        <input type="submit" value="ingresar"><br>
</form>
EOT;
if(isset($_POST['matricula'])){
	$temp=$_POST['matricula'];
	$form=$conexion->delete_form($temp,"materias.php","solicitudes","matricula");
	$users=$conexion->query_count('alumnos',"where matricula='".$_POST['matricula']."'");
	if($users==1){
		$match=$conexion->query_count('alumnos',"where password='".$_POST['pass']."' and matricula='".$_POST['matricula']."'");
		if($match==1){
			$condicion="where materias.clave in (select solicitudes.clave from solicitudes where matricula='".$temp."')";
                        $materias=$conexion->query_table(array("Name"),"materias",$condicion);
			echo "MATERIAS SOLICITADAS<br>";
			echo "-------------------------------------<br>";
                        echo $materias;
			echo "SELECCIONAR<br>";
			echo $conexion->query_form("","materias.php",$temp);
			echo "ELIMINAR<br>";
			echo $form;
			echo $conexion->make_link("horariosalumnos.php","Elegir horas disponibles",$temp);
			}
		else{
			echo "Password incorrecto";
			echo $formulario;
			}
		}
	else{
		echo "usuario invalido, repetido o no registrado";
		echo $formulario;
		echo "<a href=\"registroalumnos.php\">Ir a pagina de registro</a>";
		}
	}
else{
	echo "Ingreso ALUMNOS";
	echo $formulario;
	echo "<a href=\"registroalumnos.php\">Nuevo Registro</a>";
	}

?>

