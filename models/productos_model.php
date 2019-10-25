<?php

	function tabla_productos($conexion){
		$sql="select * from Productos";
		$result=$conexion->query($sql);
		$campos= array("id","descripcion","precio","categoria");
		$titulos= array("Seleccionar","Descripcion","Precio","Categoria","---");
		$tabla="<form id='multiples' action='editarproducto.php' method=post><input type='hidden' name='multiple' form='multiples' value=0></form><table border><tr>";
		$sql="select ";
		$tabla.="</tr>";
		foreach ($campos as $c){ $sql.=$c.",";}
		foreach ($titulos as $t){ $tabla.="<th>".$t."</th>";}
		$sql.="'' from Productos";
		$result=$conexion->query($sql);
		while($row=mysqli_fetch_array($result)){
    		    $tabla.="<tr>";
        		$tabla.="<td><input type='checkbox' name='".$row['id']."' form='multiples' value=".$row['id']."></td><td>".$row['descripcion']."</td><td>".$row['precio']."</td><td>".$row['categoria']."</td>";
        		$tabla.="<td>".$conexion->make_link("editarproducto.php","Editar",$row['id'])."</td></tr>";
    			}
		$tabla.="<input type='submit' form='multiples' value='Editar selección'></table><br>";
		return $tabla;
		}

	function formulario_registro_producto(){
		$formulario="<form action='registroproductos.php' method='post'>
            Descripcion:<br>
            <input type='text' name='descripcion' required><br>
            Precio:<br>
            <input type='number' step='0.01' name='precio' required><br>
            Categoria:<br>
            <input type='text' name='categoria' required><br>
            <input type='submit' value='registrar'><br>
        </form>";
		return $formulario;
		}

	function registrar_producto($conexion,$desc,$precio,$cate){
	    $producto=$conexion->query_count("Productos","where descripcion='$desc'");
	    if($producto==0){
	        $registro="insert into Productos values(null,'$desc',$precio,'$cate')";
	        $conexion->query($registro);
			$mensaje=0;
			//exito
	        }
	    else{
			$mensaje=1;
	        }
		return $mensaje;
		}

	function formulario_editar_producto($conexion,$id){
		$sql="select * from Productos where id=".$id;
		$result=$conexion->query($sql);
		$row=mysqli_fetch_array($result);
		$formulario="<form action='editarproducto.php' method='post'>
    		<input type='hidden' name='id' value=".$id.">
    		Descripcion:<br>
    		<input type='text' name='descripcion' value=".$row['descripcion']."><br>
    		Precio:<br><input type='number' step='0.01' name='precio' value=".$row['precio']."><br>
    		Categoría:<br>
    		<input type='text' name='categoria' value=".$row['categoria']."><br>
    		<input type='submit' value='editar'></form>";
		$formulario.="<form action='editarproducto.php' method=post><input type=hidden name=borrar value=$id><input type='submit' value='borrar'></form>";

		return $formulario;
		}

	function formulario_multiples_productos($IDS){
		$formulario="Editar productos <br><form action='editarproducto.php' method='post'>";
		foreach($IDS as $id){
			$formulario.="<input type='hidden' name=$id value=$id>";
			}
		$formulario.="<input type='hidden' name='multiple' value=1>";
		$formulario.="Categoría:<br><input type='text' name='categoria'><br><input type='submit' value='editar'></form>";
		$formulario.="<form action='editarproducto.php' method='post'>";
		foreach($IDS as $id){
			$formulario.="<input type='hidden' name=$id value=$id>";
			}
		$formulario.="<input type='hidden' name='multiple' value=2><input type='submit' value='borrar'></form>";
		return $formulario;
		}

	function get_ids($post,&$IDS){
		foreach($post as $P => $i){
        	if(is_numeric($P)){
            	$IDS[]=$i;
            	}
			}
		}

	function editar_producto($conexion,$desc,$precio,$cate,$id){
		$sql="update Productos set descripcion='$desc', precio=$precio, categoria='$cate' where id=$id";
	    $conexion->query($sql);
		}

	function editar_seleccion($conexion,$IDS){
		$sql="update Productos set categoria='".$_POST['categoria']."' where id in (";
		if(is_array($IDS)){
	        foreach($IDS as $i){ $sql.="$i,"; }
	        $sql.="0)";
			}
		else{ $sql.="$IDS)"; }
        $conexion->query($sql);
		}

	function borrar_seleccion($conexion,$IDS){
        $sql="delete from Productos where id in (";
		if(is_array($IDS)){
	        foreach($IDS as $i){ echo $i."<br>"; $sql.="$i,"; }
	        $sql.="0)";
			}
		else{ $sql.="$IDS)"; }
		echo $sql."<br>";
        $conexion->query($sql);
		}
?>
