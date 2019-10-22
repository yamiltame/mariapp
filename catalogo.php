<html>
<h1>Catálogo</h1>
<?php
require_once('conexion.php');
$conexion = new mySQL();
$conexion->conectar();
session_start();

$conexion->checklogged($_SESSION,3);

$sql="select * from Productos";
$result=$conexion->query($sql);

$campos= array("id","descripcion","precio","categoria");
if($_SESSION['permiso']<2){
	$titulos= array("Descripcion","Precio","Categoria","---");
	}
else{
	$titulos= array("Descripcion","Precio","Categoria");
	}
$tabla="<table border><tr>";
$sql="select ";
$tabla.="</tr>";
foreach ($campos as $c){ $sql.=$c.",";}
foreach ($titulos as $t){ $tabla.="<th>".$t."</th>";}
$sql.="'' from Productos";
$result=$conexion->query($sql);
while($row=mysqli_fetch_array($result)){
		$tabla.="<tr><td>".$row['descripcion']."</td><td>".$row['precio']."</td><td>".$row['categoria']."</td>";
		if($_SESSION['permiso']<2){
			$tabla.="<td>".$conexion->make_link('#','comprar',$row['id'])."</td>";
			}
		$tabla.="</tr>";
		}
$tabla.="</table><br>";
echo $tabla;
echo "<a href=\"inicio.php\">Inicio</a> <br>";
?>

</html>
