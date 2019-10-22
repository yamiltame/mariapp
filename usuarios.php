<html>
<h1>Usuarios</h1>
<?php
require_once('conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();

$conexion->checklogged($_SESSION,0);

$sql="select * from Usuarios";
$result=$conexion->query($sql);

$campos= array("id","nombre","email","permiso");
$titulos= array("Nombre","Email","Permiso","---");
$tabla="<table border><tr>";
$sql="select ";
$tabla.="</tr>";
foreach ($campos as $c){ $sql.=$c.",";}
foreach ($titulos as $t){ $tabla.="<th>".$t."</th>";}
$sql.="'' from Usuarios";
$result=$conexion->query($sql);
while($row=mysqli_fetch_array($result)){
		$tabla.="<tr>";
		$tabla.="<td>".$row['nombre']."</td>"."<td>".$row['email']."</td>";
		if($row['permiso']==0){ $tabla.="<td>Administrador</td>";}
		else if($row['permiso']==1){ $tabla.="<td>Ver y Comprar </td>";}
		else{ $tabla.="<td>Sólo ver".$conexion->make_link('aceptarusuario.php','Aceptar',$row['id'])."</td>";}
		$tabla.="<td>".$conexion->make_link("editarusuario.php","Editar",$row['id'])."</td></tr>";
	}
$tabla.="</table><br>";
echo $tabla;
echo "<a href=\"inicio.php\">Inicio</a> <br>";
echo "<a href=\"registrousuarios.php\">Registrar nuevo usuario</a> <br>";
?>

</html>
