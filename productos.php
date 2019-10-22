<html>
<h1>Productos</h1>
<?php
require_once('conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();

$conexion->checklogged($_SESSION,0);

$sql="select * from Productos";
$result=$conexion->query($sql);

$campos= array("id","descripcion","precio","categoria");
$titulos= array("Descripcion","Precio","Categoria","---");
$tabla="<table border><tr>";
$sql="select ";
$tabla.="</tr>";
foreach ($campos as $c){ $sql.=$c.",";}
foreach ($titulos as $t){ $tabla.="<th>".$t."</th>";}
$sql.="'' from Productos";
$result=$conexion->query($sql);
while($row=mysqli_fetch_array($result)){
		$tabla.="<tr>";
		$tabla.="<td>".$row['descripcion']."</td><td>".$row['precio']."</td><td>".$row['categoria']."</td>";
		$tabla.="<td>".$conexion->make_link("editarproducto.php","Editar",$row['id'])."</td></tr>";
	}
$tabla.="</table><br>";
echo $tabla;
echo "<a href=\"inicio.php\">Inicio</a> <br>";
echo "<a href=\"registroproductos.php\">Registrar nuevo producto</a> <br>";
?>

</html>
